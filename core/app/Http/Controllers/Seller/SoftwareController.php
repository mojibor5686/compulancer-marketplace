<?php

namespace App\Http\Controllers\Seller;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Software;
use App\Models\SubCategory;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SoftwareController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Software';
        $softwares = Software::where('user_id', auth()->id())->latest()->with('category')->searchable(['name'])->paginate(getPaginate());
        return view('Template::seller.software.index', compact('pageTitle', 'softwares'));
    }

    public function basic($id = 0)
    {
        $pageTitle  = 'Basic Information';
        $categories = Category::active()->orderBy('name')->with('subcategories', function ($q) {
            $q->active();
        })->get();
        $software = Software::where('id', $id)->where('user_id', auth()->id())->first();
        return view('Template::seller.software.basic', compact('pageTitle', 'categories', 'software'));
    }
    public function storeBasic(Request $request, $id = 0)
    {
        $validation  = Validator::make($request->all(), [
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|integer|gt:0',
            'sub_category_id' => 'required|integer|gt:0',
            'price'           => 'required|numeric|gt:0',
            'demo_url'        => 'required|url',
            'description'     => 'required',
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
            $software = Software::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        } else {
            $software          = new Software();
            $software->step    = 1;
            $software->user_id = $user->id;
        }

        if ($id) {
            $this->statusToggle($id);
        }

        $software->name            = $request->name;
        $software->category_id     = $request->category_id;
        $software->sub_category_id = $request->sub_category_id;
        $software->price           = $request->price;
        $software->demo_url        = $request->demo_url;
        $software->description     = $request->description;
        $software->save();

        return response()->json([
            'success'      => true,
            'redirect_url' => route('user.seller.software.feature', $software->id)
        ]);
    }

    public function feature($id)
    {
        $pageTitle = 'Software Tag & Feature';
        $software  = Software::where('id', $id)->where('user_id', auth()->id())->first();
        if ($software->step < 1) {
            return abort(404);
        }
        $features = Feature::active()->orderBy('id', 'desc')->get();
        return view('Template::seller.software.feature', compact('pageTitle', 'software', 'features'));
    }


    public function storeFeature(Request $request, $id)
    {
        $validation  = Validator::make($request->all(), [
            'tag'            => 'required|array|min:3|max:5',
            'tag.*'          => 'nullable|string',
            'file_include'   => 'required|array|min:3|max:5',
            'file_include.*' => 'nullable|string',
            'features.*'     => 'nullable|integer|gt:0',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }
        $software = Software::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$software) {
            return response()->json([
                'success' => false,
                'message' => "Software not found!"
            ]);
        }

        $isUpdate = true;

        if (!$software->tag) {
            $software->step = 2;
            $isUpdate       = false;
        }

        $this->statusToggle($id);
        $software->tag          = $request->tag;
        $software->file_include = $request->file_include;
        $software->features     = $request->features;
        $software->save();

        return response()->json([
            'success'      => true,
            'is_update'    => $isUpdate,
            'redirect_url' => route('user.seller.software.gallery', $software->id)
        ]);
    }

    public function gallery($id)
    {
        $pageTitle = 'Software Gallery';
        $software  = Software::where('id', $id)->where('user_id', auth()->id())->first();
        if ($software->step < 2) {
            return abort(404);
        }
        return view('Template::seller.software.gallery', compact('pageTitle', 'software'));
    }


    public function storeGallery(Request $request, $id)
    {
        $software = Software::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$software) {
            return response()->json([
                'success' => false,
                'message' => "Software not found"
            ]);
        }
        $isRequired = $software->image ? 'nullable' : 'required';
        $validation = Validator::make($request->all(), [
            'image'         => [$isRequired, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'extra_image'   => "nullable|array",
            'extra_image.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }

        $isUpdate = true;
        if (!$software->image) {
            $software->step = 3;
            $isUpdate       = false;
        }
        if ($request->hasFile('image')) {
            $software->image = fileUploader($request->image, getFilePath('software'), getFileSize('software'), @$software->image);
        }




        $extraImages = $software->extra_image ?? [];




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
            foreach ($request->extra_image as $singleImage) {
                $extraImages[] = fileUploader($singleImage, getFilePath('extraImage'), getFileSize('extraImage'));
            }
        }

        $this->statusToggle($id);

        $software->extra_image = array_values($extraImages);
        $software->save();

        return response()->json([
            'success'      => true,
            'is_update'    => $isUpdate,
            'redirect_url' => route('user.seller.software.document', $software->id)
        ]);
    }

    public function document($id)
    {
        $pageTitle = 'Software Document';
        $software  = Software::where('id', $id)->where('user_id', auth()->id())->first();
        if ($software->step < 3) {
            return abort(404);
        }
        return view('Template::seller.software.document', compact('pageTitle', 'software'));
    }


    public function storeDocument(Request $request, $id)
    {
        $isRequired = $id ? 'nullable' : 'required';
        $validation = Validator::make($request->all(), [
            'document_file' => [$isRequired, new FileTypeValidate(['pdf'])],
            'software_file' => [$isRequired, new FileTypeValidate(['zip'])],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }

        $software = Software::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$software) {
            return response()->json([
                'success' => false,
                'message' => "Software not found"
            ]);
        }

        $isUpdate = true;
        if (!$software->software_file) {
            $software->step = 4;
            $isUpdate       = false;
        }
        if ($request->hasFile('document_file')) {
            $software->document_file = fileUploader($request->document_file, getFilePath('documentFile'), null, @$software->document_file);
        }
        if ($request->hasFile('software_file')) {
            $software->software_file = fileUploader($request->software_file, getFilePath('softwareFile'), null, @$software->software_file);
        }
        $this->statusToggle($id);
        $software->save();

        return response()->json([
            'success'      => true,
            'is_update'    => $isUpdate,
            'redirect_url' => route('user.seller.software.index')
        ]);
    }

    private function statusToggle($id)
    {
        $software = Software::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        if (gs()->post_approval) {
            $software->status = Status::APPROVED;
        } else {
            $software->status = Status::PENDING;
        }
        $software->save();
        return;
    }

    public function salesLog(Request $request)
    {
        $pageTitle = 'Software Sale Logs';

        // Start query
        $softwareLog = Booking::paid()
            ->where('software_id', '!=', 0)
            ->where('seller_id', auth()->id())
            ->with('buyer');

        // Apply search filter (Order Number / Buyer)
        if ($request->filled('search')) {
            $softwareLog->searchable([
                'software:name',
                'order_number',
                'buyer:username,email',
            ]);
        }

        // Apply sorting by price
        if ($request->sort_by === 'price_asc') {
            $softwareLog->orderBy('price', 'asc');
        } elseif ($request->sort_by === 'price_desc') {
            $softwareLog->orderBy('price', 'desc');
        } else {
            $softwareLog->latest();
        }

        // Paginate results
        $softwareLog = $softwareLog->paginate(getPaginate());

        return view('Template::user.software_log', compact('pageTitle', 'softwareLog'));
    }
}
