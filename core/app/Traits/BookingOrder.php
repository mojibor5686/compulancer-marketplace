<?php

namespace App\Traits;

use App\Constants\Status;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\GatewayCurrency;
use App\Models\Transaction;

trait BookingOrder
{
    protected static function bookingCreate($orderDetails)
    {

        $booking               = new Booking();
        $booking->order_number = $orderDetails['orderNumber'];
        $booking->buyer_id     = auth()->id();
        $booking->price        = $orderDetails['totalPrice'];
        $booking->discount     = $orderDetails['discount'];
        $booking->final_price  = $orderDetails['grandTotal'];
        $booking->coupon_id    = @$orderDetails['couponId'] ?? 0;

        if (count($orderDetails) == Status::SERVICE_ORDER_DETAILS_COUNT) {
            $booking->service_id    = $orderDetails['service']->id;
            $booking->quantity      = $orderDetails['quantity'];
            $booking->service_price = $orderDetails['price'];
            $booking->extra_price   = $orderDetails['extraServicePrice'];
            $booking->seller_id     = $orderDetails['service']->user->id;
            $booking->expired_date  = now()->addDays($orderDetails['service']->delivery_time)->format('Y-m-d');

            if ($orderDetails['extraServices']) {
                $booking->extra_services = $orderDetails['extraServices']->pluck('id');
            }
        } elseif (count($orderDetails) == Status::SOFTWARE_ORDER_DETAILS_COUNT) {
            $booking->software_id = $orderDetails['software']->id;
            $booking->quantity    = 1;
            $booking->seller_id   = $orderDetails['software']->user->id;
        } else {
            return false;
        }

        $booking->save();
        return $booking;
    }

    protected static function bookingTransactionCreate($booking, $user, $deposit = null)
    {
        $user->balance -= $booking->final_price;
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $booking->final_price;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = $deposit ? $deposit->charge : 0;
        $transaction->trx_type     = '-';
        $transaction->details      = $booking->software_id? 'Amount deducted for purchase software: '. $booking->software?->name : 'Amount deducted for booking: '. $booking->service?->name;
        $transaction->trx          = $booking->order_number;
        $transaction->remark       = 'payment';
        $transaction->save();

        if ($booking->software_id) {
            $booking->seller->balance += $booking->final_price;
            $booking->seller->earning += $booking->final_price;
            $booking->seller->save();

            userLevel($booking->seller);

            $transaction               = new Transaction();
            $transaction->user_id      = $booking->seller->id;
            $transaction->amount       = $booking->final_price;
            $transaction->post_balance = $booking->seller->balance;
            $transaction->charge       = $deposit ? $deposit->charge : 0;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Amount Added for selling software: '. $booking->software?->name;;
            $transaction->trx          = $booking->order_number;
            $transaction->remark       = 'software_sold';
            $transaction->save();

            notify($booking->seller, 'SOFTWARE_SOLD', [
                'buyer_username' => $booking->buyer->username,
                'order_number'   => $booking->order_number,
                'software_name'  => $booking->software->name,
                'price'          => showAmount($booking->final_price, currencyFormat: false),
                'post_balance'   => showAmount($booking->seller->balance, currencyFormat: false),
            ]);
        }
    }

    protected static function bookingStatusChange($id)
    {
        $booking = Booking::where('id', $id)->first();

        if ($booking->service_id) {
            $booking->status = Status::BOOKING_PENDING;
        }

        if ($booking->software_id) {
            $booking->status = Status::BOOKING_APPROVED;
            $booking->software->total_sale += 1;
            $booking->software->save();
        }

        $booking->payment_status = Status::BOOKING_PAID;

        if ($booking->coupon_id) {
            $coupon = Coupon::find($booking->coupon_id);
            if ($coupon && $coupon->usage_limit != -1) {
                $coupon->usage_limit -= 1;
                $coupon->save();
            }
        }

        $booking->save();

        return $booking;
    }

    protected function clearCouponDiscount($orderDetails)
    {
        session()->forget('couponDiscount');
        session()->put('orderDetails.discount', 0.00);
        session()->put('orderDetails.grandTotal', session('orderDetails.totalPrice'));
        $orderDetails = session('orderDetails');
        return $orderDetails;
    }

    protected static function clearSessionData()
    {
        session()->forget('orderDetails');
        session()->forget('couponDiscount');
    }

    protected function discountCalculation($totalPrice, $coupon)
    {
        $discount = 0;

        if ($coupon->type == Status::FIXED) {
            $discount = $coupon->value;
        } else {
            $discount = ($totalPrice * $coupon->value) / 100;
        }
        $grandTotal = $totalPrice - $discount;

        if ($grandTotal < 0) {
            return ['negative'];
        }

        return [getAmount($grandTotal, 2), getAmount($discount, 2)];
    }
}
