<?php

namespace App\Http\Controllers\Seller;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Chat;
use App\Models\ExtraService;
use App\Models\Feature;
use App\Models\Service;
use App\Models\SubCategory;
use App\Models\Transaction;
use App\Models\WorkFile;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Services';
        $services  = Service::where('user_id', auth()->id())->orderBy('id', 'desc')->with('category')->searchable(['name'])->paginate(getPaginate());
        return view('Template::seller.service.index', compact('pageTitle', 'services'));
    }

    public function basic($id = 0)
    {
        $pageTitle  = 'Basic Information';
        $categories = Category::active()->orderBy('name')->with('subcategories', function ($q) {
            $q->active();
        })->get();
        $service = Service::where('id', $id)->where('user_id', auth()->id())->first();
        return view('Template::seller.service.basic', compact('pageTitle', 'categories', 'service'));
    }
    public function storeBasic(Request $request, $id = 0)
    {
        $validation  = Validator::make($request->all(), [
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|integer|gt:0',
            'sub_category_id' => 'required|integer|gt:0',
            'price'           => 'required|numeric|gt:0',
            'max_order_qty'   => 'required|integer|min:1',
            'delivery_time'   => 'required|integer|min:1',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }

        $category = Category::active()->where('id', $request->category_id)->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => "Category not found!"
            ]);
        }

        $subcategory = Subcategory::active()->where('id', $request->sub_category_id)->first();

        if (!$subcategory) {
            return response()->json([
                'success' => false,
                'message' => "Subcategory not found!"
            ]);
        }

        $user = auth()->user();

        if ($id) {
            $service = Service::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        } else {
            $service          = new Service();
            $service->step    = 1;
            $service->user_id = $user->id;
        }

        if ($id) {
            $this->statusToggle($id);
        }

        $service->name            = $request->name;
        $service->category_id     = $request->category_id;
        $service->sub_category_id = $request->sub_category_id;
        $service->price           = $request->price;
        $service->max_order_qty   = $request->max_order_qty;
        $service->delivery_time   = $request->delivery_time;
        $service->description     = $request->description;
        $service->save();

        return response()->json([
            'success'      => true,
            'redirect_url' => route('user.seller.service.feature', $service->id)
        ]);
    }

    public function feature($id)
    {
        $pageTitle = 'Service Tag & Feature';
        $service   = Service::where('id', $id)->where('user_id', auth()->id())->first();
        if ($service->step < 1) {
            return abort(404);
        }
        $features = Feature::active()->orderBy('id', 'desc')->get();
        return view('Template::seller.service.feature', compact('pageTitle', 'service', 'features'));
    }


    public function storeFeature(Request $request, $id)
    {
        $validation  = Validator::make($request->all(), [
            'tag'        => 'required|array|min:3|max:5',
            'tag.*'      => 'nullable|string',
            'features.*' => 'nullable|integer|gt:0',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }
        $service = Service::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => "Service not found!"
            ]);
        }

        $isUpdate = true;

        if (!$service->tag) {
            $service->step = 2;
            $isUpdate      = false;
        }
        $this->statusToggle($id);

        $service->tag      = $request->tag;
        $service->features = $request->features;
        $service->save();

        return response()->json([
            'success'      => true,
            'is_update'    => $isUpdate,
            'redirect_url' => route('user.seller.service.gallery', $service->id)
        ]);
    }

    public function gallery($id)
    {
        $pageTitle = 'Service Gallery';
        $service   = Service::where('id', $id)->where('user_id', auth()->id())->first();

        if ($service->step < 2) {
            return abort(404);
        }
        return view('Template::seller.service.gallery', compact('pageTitle', 'service'));
    }



    public function storeGallery(Request $request, $id)
    {
        $service = Service::where('id', $id)

            ->where('user_id', auth()->id())
            ->first();

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => "Service not found"
            ]);
        }

        $isRequired = $service->image ? 'nullable' : 'required';
        $validation = Validator::make($request->all(), [
            'image'         => [$isRequired, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'extra_image'   => "nullable|array",
            'extra_image.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'old'           => 'nullable|array',
            'old.*'         => 'nullable|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }

        $isUpdate = true;
        if (!$service->image) {
            $service->step = 3;
            $isUpdate      = false;
        }

        if ($request->hasFile('image')) {
            $service->image = fileUploader($request->image, getFilePath('service'), getFileSize('service'), $service->image);
        }

        $extraImages = $service->extra_image ?? [];



        $oldKeys = $request->input('old', []);


        $extraKeys  = array_keys($extraImages);
        $removeKeys = array_diff($extraKeys, $oldKeys);


        foreach ($removeKeys as $removeKey) {

            if (array_key_exists($removeKey, $extraImages)) {
                fileManager()->removeFile(getFilePath('extraImage') . '/' . $extraImages[$removeKey]);
                unset($extraImages[$removeKey]);
            }
        }



        if ($request->hasFile('extra_image')) {
            foreach ($request->file('extra_image') as $singleImage) {
                $extraImages[] = fileUploader($singleImage, getFilePath('extraImage'), getFileSize('extraImage'));
            }
        }


        $this->statusToggle($id);

        $service->extra_image = array_values($extraImages);
        $service->save();

        return response()->json([
            'success'      => true,
            'is_update'    => $isUpdate,
            'redirect_url' => route('user.seller.service.extra', $service->id)
        ]);
    }



    public function extra($id)
    {
        $pageTitle = 'Extra Service';
        $service   = Service::where('id', $id)->where('user_id', auth()->id())->first();
        if ($service->step < 3) {
            return abort(404);
        }
        $service = Service::where('id', $id)->where('user_id', auth()->id())->with('extraServices')->firstOrFail();
        if ($service->status == Status::CANCELED) {
            $notify[] = ["You can't edit canceled service"];
            return back()->withNotify($notify);
        }

        return view('Template::seller.service.extra', compact('pageTitle', 'service'));
    }


    public function storeExtraService(Request $request, $id)
    {
        $service = Service::where('id', $id)->where('user_id', auth()->id())->with('extraServices')->first();
        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => "Service not found!"
            ]);
        }

        // Validate each extra service if provided
        $validationRules = [
            'extra_service.*.name'  => 'required_with:extra_service|string|max:255',
            'extra_service.*.price' => 'required_with:extra_service|numeric|gt:0',
        ];

        $validationMessages = [
            'extra_service.*.name.required_with' => 'The extra service name field is required',
            'extra_service.*.name.string' => 'The extra service name must be text',
            'extra_service.*.name.max' => 'The extra service name cannot exceed 255 characters',
            'extra_service.*.price.required_with' => 'The extra service price field is required',
            'extra_service.*.price.numeric' => 'The extra service price must be a number',
            'extra_service.*.price.gt' => 'The extra service price must be greater than 0'
        ];

        $validation = Validator::make($request->all(), $validationRules, $validationMessages);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }

        if ($service->step != 4) {
            $service->step = 4;
        }
        $this->statusToggle($id);
        $service->save();

        $extraService = [];

        if ($request->has('extra_service')) {
            foreach ($request->extra_service as $requestExtraService) {
                // Update existing extra service
                if (isset($requestExtraService['id'])) {
                    $eService = ExtraService::where('service_id', $service->id)->where('id', $requestExtraService['id'])->first();
                    if ($eService) {
                        $eService->name  = $requestExtraService['name'];
                        $eService->price = $requestExtraService['price'];
                        $eService->save();
                    }
                } else {
                    $data['name']       = @$requestExtraService['name'];
                    $data['price']      = @$requestExtraService['price'];
                    $data['service_id'] = $service->id;
                    $data['created_at'] = now();
                    $data['updated_at'] = now();
                    $extraService[]     = $data;
                }
            }
        }

        if (!empty($extraService)) {
            ExtraService::insert($extraService);
        }

        return response()->json([
            'success'      => true,
            'redirect_url' => route('user.seller.service.index')
        ]);
    }
    private function statusToggle($id)
    {
        $service = Service::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        if (gs()->post_approval) {
            $service->status = Status::APPROVED;
        } else {
            $service->status = Status::PENDING;
        }
        $service->save();
        return;
    }

    public function extraServiceStatus($serviceId, $extraServiceId)
    {
        $service      = Service::where('id', $serviceId)->where('user_id', auth()->id())->firstOrFail();
        $extraService = ExtraService::where('id', $extraServiceId)->where('service_id', $service->id)->firstOrFail();
        return ExtraService::changeStatus($extraService->id);
    }

    public function bookingList()
    {
        $pageTitle = 'Service Booking List';

        $bookedServices = Booking::paid()->where('seller_id', auth()->id())
            ->where('service_id', '!=', 0)
            ->with('service', 'buyer', 'seller')
            ->searchable(['order_number']) // Enables searching by order number
            ->filter(['status', 'working_status']) // Enables filtering by status and working status
            ->when(request()->user, function ($query) {
                $query->whereHas(request()->routeIs('user.seller.booking.service.list') ? 'buyer' : 'seller', function ($q) {
                    $q->searchable(['username']);
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        return view('Template::user.service.booking_list', compact('pageTitle', 'bookedServices'));
    }



    public function bookingDetails($orderNumber)
    {
        $pageTitle = 'Service Booking Details';
        $details = Booking::paid()->checkService($orderNumber)->where('seller_id', auth()->id())->with('disputer')->firstOrFail();
        $extraServices = ExtraService::where('service_id', $details->service_id)->find(json_decode($details->extra_services));
        $workFiles = WorkFile::where('booking_id', $details->id)->orderBy('id', 'desc')->with(['sender', 'receiver'])->paginate(getPaginate());

        if (request()->ajax()) {
            $lastChatId = request('last_chat_id');
            $chatsQuery = Chat::where('booking_id', $details->id)->with('user')->latest();

            if ($lastChatId) {
                $chatsQuery->where('id', '<', $lastChatId);
            }

            $chats = $chatsQuery->latest()->take(10)->get();

            if ($chats->isEmpty()) {
                return response()->json(['last' => true]);
            }

            $view = view('Template::partials.chat_messages', compact('chats', 'details'))->render();

            return response()->json([
                'success' => true,
                'html' => $view,
            ]);
        }

        $chats = Chat::where('booking_id', $details->id)->with('user')->latest()->take(10)->get();
        $lastChatId = $chats->last()->id ?? null;

        return view('Template::user.service.booking_details', compact('pageTitle', 'details', 'extraServices', 'workFiles', 'chats', 'lastChatId'));
    }


    public function bookingConfirm($orderNumber)
    {
        $booking = Booking::paid()->checkService($orderNumber)->where('seller_id', auth()->id())->where('status', Status::BOOKING_PENDING)->firstOrFail();

        $booking->status         = Status::BOOKING_APPROVED;
        $booking->working_status = Status::WORKING_INPROGRESS;
        $booking->updated_at     = now();
        $booking->save();

        notify($booking->buyer, 'SERVICE_BOOKING_CONFIRMED', [
            'seller_username' => $booking->seller->username,
            'order_number'    => $booking->order_number,
            'service_name'    => $booking->service->name,
            'price'           => showAmount($booking->final_price, currencyFormat: false),
            'delivery_time'   => showDateTime($booking->created_at->addDays($booking->service->delivery_time), ('M, d - Y'))
        ]);

        $notify[] = ['success', 'Booking confirmed successfully'];
        return back()->withNotify($notify);
    }

    public function bookingCancel($orderNumber)
    {
        $booking = Booking::paid()->checkService($orderNumber)->where('seller_id', auth()->id())->where('status', Status::BOOKING_PENDING)->with(['buyer', 'service'])->firstOrFail();

        $booking->status         = Status::BOOKING_CANCELED;
        $booking->working_status = null;
        $booking->updated_at     = now();
        $booking->save();

        $booking->buyer->balance += $booking->final_price;
        $booking->buyer->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $booking->buyer->id;
        $transaction->amount       = $booking->final_price;
        $transaction->post_balance = $booking->buyer->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Added as refund for a cancelled service:' . $booking->service->name;
        $transaction->trx          = $booking->order_number;
        $transaction->remark       = 'booking_refunded';
        $transaction->save();

        notify($booking->buyer, 'SERVICE_BOOKING_CANCELED', [
            'seller_username' => $booking->seller->username,
            'order_number'    => $booking->order_number,
            'service_name'    => $booking->service->name,
            'refund_amount'   => showAmount($booking->final_price, currencyFormat: false),
            'post_balance'    => showAmount($booking->buyer->balance, currencyFormat: false),
        ]);

        $notify[] = ['success', 'Booking canceled and refunded to buyer successfully'];
        return back()->withNotify($notify);
    }
}
