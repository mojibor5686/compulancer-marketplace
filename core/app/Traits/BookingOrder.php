<?php

namespace App\Traits;

use App\Constants\Status;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\GatewayCurrency;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

trait BookingOrder {
    protected static function bookingCreate( $orderDetails ) {

        Log::info( '--- Trait: bookingCreate Started ---', [
            'order_number' => $orderDetails[ 'orderNumber' ] ?? 'N/A',
            'has_service'  => isset( $orderDetails[ 'service' ] ),
            'has_software' => isset( $orderDetails[ 'software' ] ),
            'order_details_keys' => is_array( $orderDetails ) ? array_keys( $orderDetails ) : []
        ] );

        $booking               = new Booking();
        $booking->order_number = $orderDetails[ 'orderNumber' ];
        $booking->buyer_id     = auth()->id();
        $booking->price        = $orderDetails[ 'totalPrice' ];
        $booking->discount     = $orderDetails[ 'discount' ];
        $booking->final_price  = $orderDetails[ 'grandTotal' ];
        $booking->coupon_id    = @$orderDetails[ 'couponId' ] ?? 0;

        if ( isset( $orderDetails[ 'service' ] ) ) {
            Log::info( 'Processing as SERVICE Order Type' );

            $booking->service_id    = $orderDetails[ 'service' ]->id;
            $booking->quantity      = $orderDetails[ 'quantity' ];
            $booking->service_price = $orderDetails[ 'price' ];
            $booking->extra_price   = $orderDetails[ 'extraServicePrice' ] ?? 0;
            $booking->seller_id     = $orderDetails[ 'service' ]->user->id;
            $booking->expired_date  = now()->addDays( $orderDetails[ 'service' ]->delivery_time )->format( 'Y-m-d' );

            if ( isset( $orderDetails[ 'extraServices' ] ) && ( is_array( $orderDetails[ 'extraServices' ] ) || $orderDetails[ 'extraServices' ] instanceof \Illuminate\Support\Collection ) ) {
                $booking->extra_services = method_exists( $orderDetails[ 'extraServices' ], 'pluck' )
                ? $orderDetails[ 'extraServices' ]->pluck( 'id' )
                : $orderDetails[ 'extraServices' ];
            } else {
                $booking->extra_services = null;
                Log::warning( 'No Extra Services found or it is null in order details.', [
                    'extra_services_value' => $orderDetails[ 'extraServices' ] ?? 'Not set'
                ] );
            }

        } elseif ( isset( $orderDetails[ 'software' ] ) ) {
            Log::info( 'Processing as SOFTWARE Order Type' );

            $booking->software_id = $orderDetails[ 'software' ]->id;
            $booking->quantity    = 1;
            $booking->seller_id   = $orderDetails[ 'software' ]->user->id;
        } else {
            Log::error( 'Booking Validation Failed: Neither service nor software key found in order details.', [
                'order_details_keys' => array_keys( $orderDetails )
            ] );
            return false;
        }

        $booking->save();
        Log::info( 'Booking Table Record Saved Successfully', [ 'booking_id' => $booking->id ] );
        return $booking;
    }

    protected static function bookingTransactionCreate( $booking, $user, $deposit = null ) {
        Log::info( '--- Trait: bookingTransactionCreate Started ---', [
            'booking_id' => $booking->id,
            'user_id' => $user->id,
            'initial_balance' => $user->balance,
            'deduct_amount' => $booking->final_price
        ] );

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

        Log::info( 'Buyer Transaction Created', [ 'trx' => $transaction->trx, 'post_balance' => $user->balance ] );

        if ( $booking->software_id ) {
            Log::info( 'Processing Software Seller Earning Credit', [ 'seller_id' => $booking->seller->id ] );

            $booking->seller->balance += $booking->final_price;
            $booking->seller->earning += $booking->final_price;
            $booking->seller->save();

            userLevel( $booking->seller );

            $transaction               = new Transaction();
            $transaction->user_id      = $booking->seller->id;
            $transaction->amount       = $booking->final_price;
            $transaction->post_balance = $booking->seller->balance;
            $transaction->charge       = $deposit ? $deposit->charge : 0;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Amount Added for selling software: '. $booking->software?->name;
            $transaction->trx          = $booking->order_number;
            $transaction->remark       = 'software_sold';
            $transaction->save();

            Log::info( 'Seller Transaction Created', [ 'seller_trx' => $transaction->trx, 'seller_post_balance' => $booking->seller->balance ] );

            notify( $booking->seller, 'SOFTWARE_SOLD', [
                'buyer_username' => $booking->buyer->username,
                'order_number'   => $booking->order_number,
                'software_name'  => $booking->software->name,
                'price'          => showAmount( $booking->final_price, currencyFormat: false ),
                'post_balance'   => showAmount( $booking->seller->balance, currencyFormat: false ),
            ] );
            Log::info( 'Software Sold Notification Triggered for Seller' );
        }
    }

    protected static function bookingStatusChange( $id ) {
        Log::info( '--- Trait: bookingStatusChange Started ---', [ 'booking_id' => $id ] );

        $booking = Booking::where( 'id', $id )->first();

        if ( !$booking ) {
            Log::error( 'bookingStatusChange Failed: Booking record not found for ID: ' . $id );
            return false;
        }

        if ( $booking->service_id ) {
            $booking->status = Status::BOOKING_PENDING;
            Log::info( 'Booking Status updated to PENDING (Service)' );
        }

        if ( $booking->software_id ) {
            $booking->status = Status::BOOKING_APPROVED;
            $booking->software->total_sale += 1;
            $booking->software->save();
            Log::info( 'Booking Status updated to APPROVED (Software) and Sales Count Incremented' );
        }

        $booking->payment_status = Status::BOOKING_PAID;

        if ( $booking->coupon_id ) {
            $coupon = Coupon::find( $booking->coupon_id );
            if ( $coupon && $coupon->usage_limit != -1 ) {
                $coupon->usage_limit -= 1;
                $coupon->save();
                Log::info( 'Coupon Usage Count Decremented', [ 'coupon_id' => $coupon->id, 'new_limit' => $coupon->usage_limit ] );
            }
        }

        $booking->save();
        Log::info( 'Booking Payment Status Updated to PAID' );

        return $booking;
    }

    protected function clearCouponDiscount( $orderDetails ) {
        session()->forget( 'couponDiscount' );
        session()->put( 'orderDetails.discount', 0.00 );
        session()->put( 'orderDetails.grandTotal', session( 'orderDetails.totalPrice' ) );
        $orderDetails = session( 'orderDetails' );
        return $orderDetails;
    }

    protected static function clearSessionData() {
        session()->forget( 'orderDetails' );
        session()->forget( 'couponDiscount' );
    }

    protected function discountCalculation( $totalPrice, $coupon ) {
        $discount = 0;

        if ( $coupon->type == Status::FIXED ) {
            $discount = $coupon->value;
        } else {
            $discount = ( $totalPrice * $coupon->value ) / 100;
        }
        $grandTotal = $totalPrice - $discount;

        if ( $grandTotal < 0 ) {
            return [ 'negative' ];
        }

        return [ getAmount( $grandTotal, 2 ), getAmount( $discount, 2 ) ];
    }
}