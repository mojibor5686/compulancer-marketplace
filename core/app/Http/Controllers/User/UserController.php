<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\DeviceToken;
use App\Models\Form;
use App\Models\JobBid;
use App\Models\Service;
use App\Models\Software;
use App\Models\Transaction;
use App\Models\WorkFile;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function home()
    {
        return to_route('user.seller.home');
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . gs('site_name'), $secret);
        $pageTitle = '2FA Security';
        return view('Template::user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = Status::ENABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = Status::DISABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions()
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::whereNotNull("remark")->distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::where('user_id', auth()->id())->searchable(['trx'])->filter(['trx_type', 'remark'])->orderBy('id', 'desc')->paginate(getPaginate());

        return view('Template::user.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == Status::KYC_PENDING) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == Status::KYC_VERIFIED) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act', 'kyc')->first();
        return view('Template::user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        abort_if($user->kv == Status::VERIFIED, 403);
        return view('Template::user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request)
    {
        $form           = Form::where('act', 'kyc')->firstOrFail();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);

        $request->validate($validationRule);

        $user = auth()->user();

        foreach (@$user->kyc_data ?? [] as $kycData) {
            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
            }
        }

        $userData                   = $formProcessor->processFormData($request, $formData);
        $user->kyc_data             = $userData;
        $user->kyc_rejection_reason = null;
        $user->kv                   = Status::KYC_PENDING;
        $user->save();

        $notify[] = ['success', 'KYC data submitted successfully.'];
        return to_route('user.home')->withNotify($notify);
    }


    public function userData()
    {
        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $pageTitle  = 'Complete Profile';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = isset($info['code']) ? implode(',', $info['code']) : '';
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('Template::user.user_data', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $countryData  = (array) json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'username'     => 'required|unique:users|min:6',
            'mobile'       => [
                'required',
                'regex:/^([0-9]*)$/',
                Rule::unique('users')->where('dial_code', $request->mobile_code),
            ],
        ]);

        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only lowercase letters, numbers, and underscores.'];
            $notify[] = ['error', 'No special characters, spaces, or capital letters are allowed in the username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $user->country_code    = $request->country_code;
        $user->mobile          = $request->mobile;
        $user->username        = $request->username;
        $user->address         = $request->address;
        $user->city            = $request->city;
        $user->state           = $request->state;
        $user->zip             = $request->zip;
        $user->country_name    = @$request->country;
        $user->dial_code       = $request->mobile_code;
        $user->profile_complete = Status::YES;
        $user->save();

        return to_route('user.home');
    }



    public function addDeviceToken(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()->all()];
        }

        $deviceToken = DeviceToken::where('token', $request->token)->first();

        if ($deviceToken) {
            return ['success' => true, 'message' => 'Already exists'];
        }

        $deviceToken          = new DeviceToken();
        $deviceToken->user_id = auth()->user()->id;
        $deviceToken->token   = $request->token;
        $deviceToken->is_app  = Status::NO;
        $deviceToken->save();

        return ['success' => true, 'message' => 'Token saved successfully'];
    }

    public function dispute(Request $request, $orderNumberOrBidId)
    {

        $request->validate([
            'dispute_type' => 'required|in:service,job',
            'reason'       => 'required'
        ]);

        $user        = auth()->user();
        $bookingId   = 0;
        $jobBidId    = 0;
        $sendToUser  = null;
        $productType = null;
        $productName = null;

        if ($request->dispute_type == 'service') {
            $data = Booking::paid()->checkService($orderNumberOrBidId)
                ->where(function ($checkUser) use ($user) {
                    $checkUser->where('seller_id', $user->id)
                        ->orWhere('buyer_id', $user->id);
                })
                ->where(function ($q) {
                    $q->where('working_status', Status::WORKING_INPROGRESS)
                        ->orWhere('working_status', Status::WORKING_DELIVERED);
                })
                ->firstOrFail();

            $bookingId = $data->id;
        } elseif ($request->dispute_type == 'job') {
            $data = JobBid::where('id', $orderNumberOrBidId)
                ->where(function ($checkUser) use ($user) {
                    $checkUser->where('user_id', $user->id)
                        ->orWhere('buyer_id', $user->id);
                })
                ->where('status', Status::APPROVED)
                ->where(function ($q) {
                    $q->where('working_status', Status::WORKING_INPROGRESS)
                        ->orWhere('working_status', Status::WORKING_DELIVERED);
                })
                ->firstOrFail();

            $jobBidId = $data->id;
        } else {
            $notify[] = ['error', 'Invalid dispute type.'];
            return back()->withNotify($notify);
        }


        $data->working_status = Status::WORKING_DISPUTED;
        $data->disputer_id    = $user->id;
        $data->reason         = $request->reason;
        $data->updated_at     = now();
        $data->save();

        $chat             = new Chat();
        $chat->booking_id = $bookingId;
        $chat->job_bid_id = $jobBidId;
        $chat->user_id    = $user->id;
        $chat->message    = 'Disputed by ' . $user->username;
        $chat->save();

        if ($bookingId) {
            $sendToUser  = $data->seller_id == $data->disputer_id ? $data->buyer : $data->seller;
            $productType = 'service';
            $productName = $data->service->name;
        }

        if ($jobBidId) {
            $sendToUser  = $data->user_id == $data->disputer_id ? $data->buyer : $data->user;
            $productType = 'job';
            $productName = $data->job->name;
        }

        if ($sendToUser) {
            notify($sendToUser, 'DISPUTED', [
                'disputer_username' => $data->disputer->username,
                'product_type'      => $productType,
                'product_name'      => $productName,
                'reason'            => $request->reason
            ]);
        }

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New dispute created for ' . $productType;
        $adminNotification->click_url = $bookingId ? route('admin.booking.service.details', $bookingId) : route('admin.hiring.job.details', $jobBidId);
        $adminNotification->save();

        $notify[] = ['success', 'Disputed successfully. Wait for the system response'];
        return back()->withNotify($notify);
    }

    public function workFileUpload(Request $request, $orderNumberOrJobId)
    {
        $request->validate([
            'work_type' => 'required|in:service,job',
            'details'   => 'required',
            'file'      => ['required', new FileTypeValidate(['zip'])],
        ]);

        $authId    = auth()->id();
        $bookingId = 0;
        $jobBidId  = 0;
        $fileType = 'work';

        if ($request->work_type == 'service') {
            $data = Booking::paid()->checkService($orderNumberOrJobId)
                ->where('status', Status::APPROVED)
                ->where(function ($user) use ($authId) {
                    $user->where('seller_id', $authId)
                        ->orWhere('buyer_id', $authId);
                })
                ->where(function ($q) {
                    $q->where('working_status', Status::WORKING_INPROGRESS)
                        ->orWhere('working_status', Status::WORKING_DELIVERED);
                })
                ->firstOrFail();


            $bookingId = $data->id;

            if ($data->seller_id == $authId) {
                $senderId   = $data->seller_id;
                $receiverId = $data->buyer_id;
            } else {
                $senderId   = $data->buyer_id;
                $receiverId = $data->seller_id;
                $fileType = 'document';
            }
        } elseif (($request->work_type == 'job')) {

            $data = JobBid::where('id', $orderNumberOrJobId)->where('status', Status::APPROVED)->where(function ($q) use ($authId) {
                $q->where('user_id', $authId)->orWhere('buyer_id', $authId);
            })->firstOrFail();

            if ($data->user_id == $authId) {
                $senderId   = $data->user_id;
                $receiverId = $data->buyer_id;
            } else {
                $senderId   = $data->buyer_id;
                $receiverId = $data->user_id;
                $fileType = 'document';
            }

            $jobBidId = $data->id;
        } else {
            $notify[] = ['error', 'Invalid type of work file submitted'];
            return back()->withNotify($notify);
        }

        if($fileType == 'work') {
            $data->working_status = Status::WORKING_DELIVERED;
            $data->updated_at = now();
            $data->save();
        }

        $workFile              = new WorkFile();
        $workFile->booking_id  = $bookingId;
        $workFile->job_bid_id  = $jobBidId;
        $workFile->sender_id   = $senderId;
        $workFile->receiver_id = $receiverId;
        $workFile->file        = fileUploader($request->file, getFilePath('workFile'));
        $workFile->details     = $request->details;
        $workFile->save();

        // Send email notification
        $emailShortCodes = [
            'sender_username' => auth()->user()->username,
            'product_type' => $request->work_type,
            'product_name' => $request->work_type == 'service' ? $data->service->name : $data->job->name,
            'message' => $request->details
        ];

        $template = 'WORK_DELIVERED';
        $receiver = $data->buyer;

        if($fileType == 'document') {
            $receiver = $data->seller ?: $data->user;
            $emailShortCodes['seller_username'] = $receiver->username;
            $emailShortCodes['buyer_username'] = auth()->user()->username;

            $template = 'UPLOAD_DOCUMENT_FILE';
            $notify[] = ['success', 'Document file submitted successfully'];
        } else {
            $notify[] = ['success', 'Work file submitted successfully'];
        }

        notify($receiver, $template, $emailShortCodes);

        return back()->withNotify($notify);
    }


    public function removeExtraImage($id, $imageName, $type)
    {
        if ($type == 'software') {
            $data = Software::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        } elseif ($type == 'service') {
            $data = Service::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        } else {
            $notify[] = ['success', 'Invalid image removal request'];
            return back()->withNotify($notify);
        }

        $extraImage = [];
        $imageCheck = in_array($imageName, $data->extra_image);

        if (!$imageCheck) {
            $notify[] = ['error', 'Image not found'];
            return back()->withNotify($notify);
        }

        foreach ($data->extra_image as $singleImage) {
            if ($singleImage != $imageName) {
                $extraImage[] = $singleImage;
            }
        }

        $data->extra_image = $extraImage;
        $data->save();

        fileManager()->removeFile(getFilePath('extraImage') . '/' . $imageName);

        $notify[] = ['success', 'Image removed successfully'];
        return back()->withNotify($notify);
    }




    public function downloadAttachment($fileHash)
    {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title     = slug(gs('site_name')) . '-attachments.' . $extension;

        try {
            $mimetype = mime_content_type($filePath);
        } catch (\Exception $e) {
            $notify[] = ['error', 'File does not exist.'];
            return back()->withNotify($notify);
        }

        if (!file_exists($filePath)) {
            $notify[] = ['error', 'The requested file could not be found.'];
            return back()->withNotify($notify);
        }

        header('Content-Disposition: attachment; filename="' . $title . '"');
        header('Content-Type: ' . $mimetype);

        return readfile($filePath);
    }

    public function success($orderNumber)
    {
        $pageTitle = 'Thank You';
        return view('Template::user.success', compact('pageTitle', 'orderNumber'));
    }
}
