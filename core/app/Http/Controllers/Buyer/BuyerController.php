<?php

namespace App\Http\Controllers\Buyer;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\ExtraService;
use App\Models\Job;
use App\Models\JobBid;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\WorkFile;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function home()
    {
        $pageTitle     = 'Buyer Dashboard';
        $authId        = auth()->id();
        $basicTrxQuery = Transaction::where('user_id', $authId);
        $trx           = clone $basicTrxQuery;
        $trxCount      = clone $basicTrxQuery;
        $transactions  = $trx->orderBy('id', 'desc')->limit(10)->get();
        $totalTrxCount = $trxCount->count();

        $totalJobCount          = Job::where('user_id', $authId)->count();
        $totalBookedService     = Booking::paid()->where('service_id', '!=', 0)->where('buyer_id', $authId)->count();
        $totalPurchasedSoftware = Booking::paid()->where('software_id', '!=', 0)->where('buyer_id', $authId)->count();
        $totalHiredEmployee     = JobBid::where('buyer_id', $authId)->where('status', Status::APPROVED)->count();
        $reviews        = Review::where('to_id', $authId)->latest()->with('user')->limit(6)->get();

        return view('Template::buyer.dashboard', compact('pageTitle', 'transactions', 'totalTrxCount', 'totalJobCount', 'totalBookedService', 'totalPurchasedSoftware', 'totalHiredEmployee', 'reviews'));
    }

    public function bookedService(Request $request)
    {
        $pageTitle = 'Booked Services';

        // Start query with buyer's bookings
        $bookedServices = Booking::paid()->where('service_id', '!=', 0)
            ->where('buyer_id', auth()->id())
            ->searchable([
                'order_number',
                $request->type === 'buyer' ? 'buyer:username,email' : 'seller:username,email'
            ])->filter([
                'status',
                'working_status'
            ])
            ->with(['service', 'seller'])
            ->latest();


        // Paginate results
        $bookedServices = $bookedServices->paginate(getPaginate());

        return view('Template::user.service.booking_list', compact('pageTitle', 'bookedServices'));
    }


    public function bookedServiceDetails($orderNumber)
    {
        $pageTitle = 'Booked Service Details';
        $details = Booking::paid()->checkService($orderNumber)->where('buyer_id', auth()->id())->firstOrFail();
        $extraServices = ExtraService::where('service_id', $details->service_id)->find(json_decode($details->extra_services));
        $workFiles = WorkFile::where('booking_id', $details->id)->latest()->with(['sender', 'receiver'])->paginate(getPaginate());

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


    public function serviceCompleted($orderNumber)
    {
        $booking =  Booking::paid()->checkService($orderNumber)->where('buyer_id', auth()->id())->where('status', Status::BOOKING_APPROVED)->where(function ($q) {
            $q->where('working_status', Status::WORKING_INPROGRESS)->orWhere('working_status', Status::WORKING_DELIVERED);
        })->with('seller')->firstOrFail();

        $booking->working_status = Status::WORKING_COMPLETED;
        $booking->updated_at     = now();
        $booking->save();

        $booking->seller->balance += $booking->final_price;
        $booking->seller->earning += $booking->final_price;
        $booking->seller->save();

        userLevel($booking->seller);

        $transaction               = new Transaction();
        $transaction->user_id      = $booking->seller->id;
        $transaction->amount       = $booking->final_price;
        $transaction->post_balance = $booking->seller->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'For completing a service';
        $transaction->trx          = $booking->order_number;
        $transaction->remark       = 'service_completed';
        $transaction->save();

        $notify[] = ['success', 'Service marked as completed successfully'];
        return back()->withNotify($notify);
    }

    public function softwarePurchase(Request $request)
    {
        $pageTitle = 'Software Purchase Log';

        // Start query
        $softwareLog = Booking::paid()
            ->where('software_id', '!=', 0)
            ->where('buyer_id', auth()->id())
            ->with('seller');

        // Apply search filter (Order Number / Seller / Software Name)
        if ($request->filled('search')) {
            $softwareLog->searchable([
                'software:name',
                'order_number',
                'seller:username,email',
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
