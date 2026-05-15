<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Constants\Status;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\JobBid;
use App\Models\Review;
use App\Models\Service;
use App\Models\Software;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\WorkFile;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function home()
    {
        $pageTitle = 'Seller Dashboard';
        $authId    = auth()->id();

        $transactions          = Transaction::where('user_id', $authId)->orderBy('id', 'desc')->limit(10)->get();
        $totalServiceCount     = Service::where('user_id', $authId)->count();
        $totalSoftwareCount    = Software::where('user_id', $authId)->count();
        $reviews               = Review::where('to_id', $authId)->latest()->with('user')->limit(6)->get();

        $totalSoftwareSales    = Booking::paid()->where('software_id', '!=', 0)->where('seller_id', $authId)->count();
        $totalServiceBooking   = Booking::paid()->where('service_id', '!=', 0)->where('seller_id', $authId)->count();
        $totalWithdrawalAmount = Withdrawal::where('user_id', $authId)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');

        return view('Template::seller.dashboard', compact('pageTitle', 'transactions', 'totalServiceCount', 'totalSoftwareCount', 'totalServiceBooking', 'totalSoftwareSales', 'totalWithdrawalAmount', 'reviews'));
    }

    public function getTransactionChartData(Request $request)
    {
        $userId = auth()->id();
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $transactions = Transaction::where('user_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });

        $dates = [];
        $plusTransactions = [];
        $minusTransactions = [];

        foreach ($transactions as $date => $dailyTransactions) {
            $dates[] = $date;
            $plusTransactions[] = $dailyTransactions->where('trx_type', '+')->sum('amount');
            $minusTransactions[] = $dailyTransactions->where('trx_type', '-')->sum('amount');
        }

        return response()->json([
            'success' => true,
            'dates' => $dates,
            'plusTransactions' => $plusTransactions,
            'minusTransactions' => $minusTransactions
        ]);
    }

    public function jobList(Request $request)
    {
        $pageTitle = 'Job List';

        // Start query
        $biddingList = JobBid::where('user_id', auth()->id())
            ->with(['job', 'buyer']);

        // Apply search filter (Job Name / Buyer / Bidder)
        if ($request->filled('search')) {
            $biddingList->searchable([
                'job:name',
                'buyer:username,email',
            ]);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $biddingList->where('status', $request->status);
        }

        // Filter by Working Status
        if ($request->filled('working_status')) {
            $biddingList->where('working_status', $request->working_status);
        }

        // Paginate results
        $biddingList = $biddingList->latest()->paginate(getPaginate());

        return view('Template::user.job.job_hiring', compact('pageTitle', 'biddingList'));
    }


    public function jobDetails($id)
    {
        $pageTitle = 'Job Details';
        $details = JobBid::where('id', $id)->where('user_id', auth()->id())->with(['job', 'disputer'])->firstOrFail();
        $workFiles = WorkFile::where('job_bid_id', $details->id)->latest()->with(['sender', 'receiver'])->paginate(getPaginate());

        if (request()->ajax()) {
            $lastChatId = request('last_chat_id');
            $chatsQuery = Chat::where('job_bid_id', $details->id)->with('user')->latest();

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

        $chats = Chat::where('job_bid_id', $details->id)->with('user')->latest()->take(10)->get();
        $lastChatId = $chats->last()->id ?? null;

        return view('Template::user.job.details', compact('pageTitle', 'details', 'workFiles', 'chats', 'lastChatId'));
    }
}
