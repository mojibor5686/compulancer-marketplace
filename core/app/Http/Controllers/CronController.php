<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\CurlRequest;
use App\Models\Booking;
use App\Models\CronJob;
use App\Models\CronJobLog;
use App\Models\JobBid;
use App\Models\Transaction;
use Carbon\Carbon;

class CronController extends Controller
{
    public function cron()
    {
        $general            = gs();
        $general->last_cron = now();
        $general->save();

        $crons = CronJob::with('schedule');

        if (request()->alias) {
            $crons->where('alias', request()->alias);
        } else {
            $crons->where('next_run', '<', now())->where('is_running', Status::YES);
        }
        $crons = $crons->get();
        foreach ($crons as $cron) {
            $cronLog              = new CronJobLog();
            $cronLog->cron_job_id = $cron->id;
            $cronLog->start_at    = now();
            if ($cron->is_default) {
                $controller = new $cron->action[0];
                try {
                    $method = $cron->action[1];
                    $controller->$method();
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            } else {
                try {
                    CurlRequest::curlContent($cron->url);
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            }
            $cron->last_run = now();
            $cron->next_run = now()->addSeconds((int) $cron->schedule->interval);
            $cron->save();

            $cronLog->end_at = $cron->last_run;

            $startTime         = Carbon::parse($cronLog->start_at);
            $endTime           = Carbon::parse($cronLog->end_at);
            $diffInSeconds     = $startTime->diffInSeconds($endTime);
            $cronLog->duration = $diffInSeconds;
            $cronLog->save();
        }
        if (request()->target == 'all') {
            $notify[] = ['success', 'Cron executed successfully'];
            return back()->withNotify($notify);
        }
        if (request()->alias) {
            $notify[] = ['success', keyToTitle(request()->alias) . ' executed successfully'];
            return back()->withNotify($notify);
        }
    }



    public function service()
    {

        try {
            $today    = date('Y-m-d');
            $bookings = Booking::where('service_id', '!=', 0)
                ->whereDate('expired_date', $today)
                ->whereNotIn('status', [Status::BOOKING_APPROVED, Status::BOOKING_EXPIRED])
                ->with('buyer')
                ->get();

            $transactions        = [];
            $bookingUpdateStatus = Status::BOOKING_EXPIRED;
            $bookingPaid         = Status::BOOKING_PAID;

            foreach ($bookings as $booking) {

                $booking->status = $bookingUpdateStatus;
                $booking->save();

                if ($booking->payment_status != $bookingPaid) {
                    continue;
                }

                $user           = $booking->buyer;
                $user->balance += $booking->final_price;
                $user->save();

                $transaction['user_id']      = $booking->buyer_id;
                $transaction['amount']       = $booking->final_price;
                $transaction['post_balance'] = $booking->user_balance + $booking->final_price;
                $transaction['trx_type']     = '+';
                $transaction['details']      = 'Booking amount refunded';
                $transaction['trx']          = $booking->order_number;
                $transaction['remark']       = 'service_expired';
                $transaction['created_at']   = now();

                $transactions[]               = $transaction;
            }

            Transaction::insert($transactions);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function job()
    {
        try {
            JobBid::where('status', Status::PENDING)->whereDate('expired_date', date('Y-m-d'))->update(['status' => Status::JOB_EXPIRED, 'working_status' => Status::WORKING_EXPIRED]);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
