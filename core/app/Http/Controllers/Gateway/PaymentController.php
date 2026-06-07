<?php

namespace App\Http\Controllers\Gateway;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\BookingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller {
    use BookingOrder;

    public function deposit() {
        $gatewayCurrency = GatewayCurrency::whereHas( 'method', function ( $gate ) {
            $gate->where( 'status', Status::ENABLE );
        }
    )->with( 'method' )->orderby( 'name' )->get();
    $pageTitle = 'Deposit Methods';
    return view( 'Template::user.payment.deposit', compact( 'gatewayCurrency', 'pageTitle' ) );
}

public function depositInsert( Request $request, $orderNumber = null ) {
    Log::info( '--- Deposit Process Initiated ---', [
        'ip' => $request->ip(),
        'user_id' => auth()->id(),
        'order_number' => $orderNumber,
        'request_data' => $request->all(),
        'session_order_details' => session( 'orderDetails' )
    ] );

    $request->validate( [
        'amount'   => 'required|numeric|gt:0',
        'gateway'  => 'required',
    ] );

    $user = auth()->user();

    $bookingId    = 0;
    $orderDetails = session( 'orderDetails' );
    $successUrl   = $orderNumber ? $this->getOrderRouteName( $orderDetails, deposit: false, successUrl: true, orderNumber: $orderNumber ) : $this->getOrderRouteName( null, deposit: true );
    $failUrl      = $orderNumber ? $this->getOrderRouteName( $orderDetails, deposit: false ) : $this->getOrderRouteName( null, deposit: true );

    $amount = $orderNumber ? ( $orderDetails[ 'grandTotal' ] ?? 0 ) : $request->amount;

    if ( $amount != $request->amount ) {
        Log::warning( 'Deposit Amount Mismatch Detected', [
            'user_id' => $user->id,
            'calculated_amount' => $amount,
            'request_amount' => $request->amount
        ] );
        $notify[] = [ 'error', 'Invalid Request' ];
        return back()->withNotify( $notify );
    }

    if ( $request->gateway == 'wallet' ) {
        Log::info( 'Processing Wallet Payment', [ 'user_id' => $user->id, 'balance' => $user->balance, 'amount' => $amount ] );

        if ( $amount > $user->balance ) {
            Log::warning( 'Wallet Payment Failed: Insufficient Balance', [ 'user_id' => $user->id, 'balance' => $user->balance, 'required' => $amount ] );
            $notify[] = [ 'error', 'You don\'t have enough balance!'];
            return back()->withNotify($notify);
        }

        try {
            Log::info('Attempting to run static::bookingCreate()', ['order_details' => $orderDetails]);
            $bookingCreate = static::bookingCreate($orderDetails);

            if (!$bookingCreate) {
                Log::error('static::bookingCreate() returned FALSE or NULL. Check model logic and DB constraints.', [
                    'user_id' => $user->id,
                    'order_details' => $orderDetails
                ]);
                $notify[] = ['error', 'Failed to initialize booking. Please try again.'];
                return back()->withNotify($notify);
            }

            Log::info('Booking Created Successfully', ['booking_id' => $bookingCreate->id]);

            $booking = static::bookingStatusChange($bookingCreate->id);
            Log::info('Booking Status Changed', ['booking_status_result' => $booking]);

            static::bookingTransactionCreate($booking, $user);
            Log::info('Wallet Transaction Created successfully.');
            
            \App\Http\Controllers\User\ServiceBookingController::sendOrderNotificationMail($orderDetails);
            Log::info('Notification Email Sent for Order.');

            static::clearSessionData();
            Log::info('Wallet Payment Process Completed. Session Cleared.');

        } catch (\Exception $e) {
            Log::error('Wallet Payment Exception Occurred', [
                'user_id' => $user->id,
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString()
            ]);
            $notify[] = ['error', 'Something went wrong'];
            return back()->withNotify($notify);
        }

        return redirect($successUrl);
    }

    if ($request->gateway == 'uddoktapay') {
        
        Log::info('--- UddoktaPay Payment Initiate Start ---', ['user_id' => $user->id, 'amount' => $request->amount]);

        $trx = $orderNumber ? $orderNumber : getTrx();
        
        $deposit                  = new Deposit();
        $deposit->user_id         = $user->id;
        $deposit->order_number    = $orderNumber;
        $deposit->booking_id      = $bookingId;
        $deposit->method_code     = 9999; 
        $deposit->method_currency = 'BDT';
        $deposit->amount          = $request->amount;
        $deposit->charge          = 0;
        $deposit->rate            = 1;
        $deposit->final_amount    = $request->amount;
        $deposit->btc_amount      = 0;
        $deposit->btc_wallet      = "";
        $deposit->trx             = $trx;
        $deposit->success_url     = $successUrl;
        $deposit->failed_url      = $failUrl;
        $deposit->save();

        Log::info('UddoktaPay Local Deposit Record Created', ['deposit_id' => $deposit->id, 'trx' => $trx]);

        $apiKey  = 'x8xuDacICGnVTcD3grPY9T15Jy4Ppgcn285J07jl'; 
        $apiLink = 'https://compulancer.paymently.io/api/checkout';

        $fields = [
            'full_name'    => $user->fullname ?? $user->username,
            'email'        => $user->email,
            'amount'       => $request->amount,
            'metadata'     => [
                'trx' => $trx
            ],
            'redirect_url' => route('user.uddoktapay.callback'),
            'cancel_url'   => $failUrl,
            'webhook_url'  => route('user.uddoktapay.webhook')
        ];

        Log::info('UddoktaPay API Payload Sent:', $fields);

        try {
            $response = Http::withHeaders([
                'RT-UDDOKTAPAY-API-KEY' => $apiKey,
                'accept'                => 'application/json',
                'content-type'          => 'application/json',
            ])->post($apiLink, $fields);

            $result = $response->json();
            Log::info('UddoktaPay API Response Received:', json_decode($response->body(), true) ?? []);

            if (isset($result['status']) && $result['status'] === true) {
                Log::info('UddoktaPay Invoice Generated. Redirecting user...', ['url' => $result['payment_url']]);
                return redirect($result['payment_url']);
            } else {
                $deposit->delete();
                Log::error('UddoktaPay API Error Status Checked', ['message' => $result['message'] ?? 'No message']);
                $notify[] = ['error', $result['message'] ?? 'UddoktaPay Gateway Error'];
                return back()->withNotify($notify);
            }
        } catch (\Exception $e) {
            $deposit->delete();
            Log::critical('UddoktaPay HTTP Request Failed Exception', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine()
            ]);
            $notify[] = ['error', 'Gateway Connection Failed'];
            return back()->withNotify($notify);
        }
    }

    Log::warning('Gateway Not Allowed Requested', ['gateway' => $request->gateway, 'user_id' => $user->id]);
    $notify[] = ['error', 'Gateway not allowed'];
    return back()->withNotify($notify);
}

public function uddoktapayCallback(Request $request)
{
    Log::info('--- UddoktaPay Callback Hit ---', $request->all());

    $invoiceId = $request->get('invoice_id');
    
    if (!$invoiceId) {
        Log::warning('UddoktaPay Callback Missing Invoice ID');
        $notify[] = ['error', 'Invalid callback response'];
        return to_route('home')->withNotify($notify);
    }

    $apiKey     = 'x8xuDacICGnVTcD3grPY9T15Jy4Ppgcn285J07jl';
    $verifyLink = 'https://compulancer.paymently.io/api/verify-payment';

    try {
        $response = Http::withHeaders([
            'RT-UDDOKTAPAY-API-KEY' => $apiKey,
            'accept'                => 'application/json',
            'content-type'          => 'application/json',
        ])->post($verifyLink, ['invoice_id' => $invoiceId]);

        $result = $response->json();
        Log::info('UddoktaPay Verification Response:', json_decode($response->body(), true) ?? []);

        if (isset($result['status']) && $result['status'] === 'COMPLETED') {
            $trx = $result['metadata']['trx'] ?? null;
            $deposit = Deposit::where('trx', $trx)->where('status', Status::PAYMENT_INITIATE)->first();

            if ($deposit) {
                static::userDataUpdate($deposit);
                Log::info('UddoktaPay Callback Payment Success processed inside Controller.', ['trx' => $trx]);
                
                $notify[] = ['success', 'Payment successful'];
                return redirect($deposit->success_url)->withNotify($notify);
            } else {
                Log::warning('UddoktaPay Deposit Record Not Found or Already Processed', ['trx' => $trx]);
            }
        } else {
            Log::warning('UddoktaPay Payment Status Not Completed', ['status' => $result['status'] ?? 'unknown']);
        }
    } catch (\Exception $e) {
        Log::error('UddoktaPay Callback Exception: ' . $e->getMessage());
    }

    $notify[] = ['error', 'Payment failed or unverified'];
    return to_route('home')->withNotify($notify);
}

public function uddoktapayWebhook(Request $request)
{
    Log::info('--- UddoktaPay Webhook Hit ---', [
        'headers' => $request->headers->all(),
        'body'    => $request->all()
    ]);

    $apiKey    = 'x8xuDacICGnVTcD3grPY9T15Jy4Ppgcn285J07jl';
    $headerApi = $request->header('RT-UDDOKTAPAY-API-KEY');

    if ($headerApi === $apiKey && $request->status === 'COMPLETED') {
        $trx = $request->metadata['trx'] ?? null;
        $deposit = Deposit::where('trx', $trx)->where('status', Status::PAYMENT_INITIATE)->first();

        if ($deposit) {
            static::userDataUpdate($deposit);
            Log::info('UddoktaPay Webhook Data Updated Successfully.', ['trx' => $trx]);
            return response()->json(['status' => 'success']);
        } else {
            Log::warning('UddoktaPay Webhook Deposit Not Found or Processed.', ['trx' => $trx]);
        }
    } else {
        Log::error('UddoktaPay Webhook Security Token Mismatch or Status Uncompleted.');
    }
    return response()->json(['status' => 'failed'], 400);
}

public function depositConfirm()
{
    $track   = session()->get('Track');
    $deposit = Deposit::where('trx', $track)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

    if ($deposit->method_code >= 1000) {
        return to_route('user.deposit.manual.confirm');
    }

    $dirName = $deposit->gateway->alias;
    $new     = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

    $data = $new::process($deposit);
    $data = json_decode($data);

    if (isset($data->error)) {
        $notify[] = ['error', $data->message];
        return back()->withNotify($notify);
    }
    if (isset($data->redirect)) {
        return redirect($data->redirect_url);
    }

    if (@$data->session) {
        $deposit->btc_wallet = $data->session->id;
        $deposit->save();
    }

    $pageTitle = $deposit->order_number ? 'Payment Confirm' : 'Deposit Confirm';
    return view("Template::$data->view", compact('data', 'pageTitle', 'deposit'));
}

public static function userDataUpdate($deposit, $isManual = null)
{
    if ($deposit->status == Status::PAYMENT_INITIATE || $deposit->status == Status::PAYMENT_PENDING) {
        $deposit->status = Status::PAYMENT_SUCCESS;
        $deposit->save();

        $user           = User::find($deposit->user_id);
        $user->balance += $deposit->amount;
        $user->save();

        $methodName = $deposit->method_code == 9999 ? 'UddoktaPay' : $deposit->methodName();

        $transaction               = new Transaction();
        $transaction->user_id      = $deposit->user_id;
        $transaction->amount       = $deposit->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = $deposit->charge;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Deposit Via ' . $methodName;
        $transaction->trx          = $deposit->trx;
        $transaction->remark       = 'deposit';
        $transaction->save();

        $referral = User::where('id', $user->ref_by)->first();

        if ($referral && (gs()->referral_commission > 0)) {
            $refAmo             = ($deposit->amount * gs()->referral_commission) / 100;
            $referral->balance += $refAmo;
            $referral->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $referral->id;
            $transaction->amount       = $refAmo;
            $transaction->post_balance = $referral->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Deposit Referral Commission from ' . $user->username;
            $transaction->trx          = getTrx();
            $transaction->remark       = 'referral_commission';
            $transaction->save();

            notify($referral, 'REFERRAL_COMMISSION', [
                'amount'       => getAmount($refAmo),
                'post_balance' => $referral->balance,
                'trx'          => $transaction->trx,
            ]);
        }

        if (!$isManual) {
            $adminNotification            = new AdminNotification();
            $adminNotification->user_id   = $user->id;
            $adminNotification->title     = 'Deposit successful via ' . $methodName;
            $adminNotification->click_url = urlPath('admin.deposit.successful');
            $adminNotification->save();
        }

        notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
            'method_name'     => $methodName,
            'method_currency' => $deposit->method_currency,
            'method_amount'   => showAmount($deposit->final_amount, currencyFormat: false),
            'amount'          => showAmount($deposit->amount, currencyFormat: false),
            'charge'          => showAmount($deposit->charge, currencyFormat: false),
            'rate'            => showAmount($deposit->rate, currencyFormat: false),
            'trx'             => $deposit->trx,
            'post_balance'    => showAmount($user->balance, currencyFormat: false)
        ]);

        if ($deposit->order_number && $deposit->booking_id) {
            $booking = static::bookingStatusChange($deposit->booking_id);
            static::bookingTransactionCreate($booking, $user, $deposit);

            $orderDetails = session('orderDetails');
            if($orderDetails){
                \App\Http\Controllers\User\ServiceBookingController::sendOrderNotificationMail($orderDetails);
            }

            static::clearSessionData();
        }
    }
}

public function manualDepositConfirm()
{
    $track = session()->get('Track');
    $data  = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();
    abort_if(!$data, 404);
    if ($data->method_code > 999) {
        $pageTitle = 'Confirm Deposit';
        $method    = $data->gatewayCurrency();
        $gateway   = $method->method;
        return view('Template::user.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
    }
    abort(404);
}

public function manualDepositUpdate(Request $request)
{
    $track = session()->get('Track');
    $data  = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();
    abort_if(!$data, 404);
    $gatewayCurrency = $data->gatewayCurrency();
    $gateway         = $gatewayCurrency->method;
    $formData        = $gateway->form->form_data;

    $formProcessor  = new FormProcessor();
    $validationRule = $formProcessor->valueValidation($formData);
    $request->validate($validationRule);
    $userData = $formProcessor->processFormData($request, $formData);

    $data->detail = $userData;
    $data->status = Status::PAYMENT_PENDING;
    $data->save();

    $adminNotification            = new AdminNotification();
    $adminNotification->user_id   = $data->user->id;
    $adminNotification->title     = 'Deposit request from ' . $data->user->username;
    $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
    $adminNotification->save();

    if ($data->order_number) {
        $productType = $data->booking->service_id ? 'service' : 'software';
        $productName = $data->booking->service_id ? $data->booking->service->name : $data->booking->software->name;

        notify($data->user, 'PAYMENT_REQUEST', [
            'method_name'     => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount'   => showAmount($data->final_amount, currencyFormat: false),
            'amount'          => showAmount($data->amount, currencyFormat: false),
            'charge'          => showAmount($data->charge, currencyFormat: false),
            'rate'            => showAmount($data->rate, currencyFormat: false),
            'trx'             => $data->trx,
            'product_type'    => $productType,
            'product_name'    => $productName,
        ]);

        $notify[] = ['success', 'Your payment request has been taken'];
        return to_route('user.transactions')->withNotify($notify);
    } else {
        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name'     => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount'   => showAmount($data->final_amount, currencyFormat: false),
            'amount'          => showAmount($data->amount, currencyFormat: false),
            'charge'          => showAmount($data->charge, currencyFormat: false),
            'rate'            => showAmount($data->rate, currencyFormat: false),
            'trx'             => $data->trx
        ]);

        $notify[] = ['success', 'Your deposit request has been taken'];
        return to_route('user.deposit.history')->withNotify($notify);
    }
}

protected function getOrderRouteName($orderDetails = null, $deposit = true, $successUrl = false, $orderNumber = 0)
{
    if ($deposit) {
        return route('user.deposit.history');
    }

    try {
        if (!@$orderDetails) {
            return route('user.home');
        }

        if (array_key_exists('service', $orderDetails)) {
            if ($successUrl && $orderNumber) {
                return route('user.success', $orderNumber);
            }
            return route('user.buyer.booked.services');
        } elseif (array_key_exists('software', $orderDetails)) {
            return route('user.buyer.software.log');
        }
    } catch (\Exception $e) {
        Log::error('Order Route Name Exception: ' . $e->getMessage());
        return route('user.home');
    }

    return route('user.home' );
        }
    }