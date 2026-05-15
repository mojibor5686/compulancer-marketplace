<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\GatewayCurrency;
use App\Models\Software;
use App\Traits\BookingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SoftwareBookingController extends Controller
{
    use BookingOrder;

    public function addBooking($id)
    {
        $software = Software::where('id', $id)->active()->notAuthUser()->checkData()->with('user')->first();

        if (!$software) {
            $notify[] = ['error', 'You are not allowed to make a booking'];
            return back()->withNotify($notify);
        }

        $totalPrice = $software->price;

        session()->forget('orderDetails');
        session()->put('orderDetails', [
            'software'    => $software,
            'discount'    => 0.00,
            'totalPrice'  => $totalPrice,
            'grandTotal'  => $totalPrice,
            'orderNumber' => getTrx(),
            'couponId'    => null
        ]);

        return to_route('user.software.confirm.booking');
    }

    public function confirmBooking()
    {
        $pageTitle    = 'Checkout';
        $orderDetails = session('orderDetails');

        if (!$orderDetails) {
            $notify[] = ['error', 'Order booking not found!'];
            return to_route('home')->withNotify($notify);
        }

        if (count($orderDetails) < Status::SOFTWARE_ORDER_DETAILS_COUNT && count($orderDetails) > Status::SOFTWARE_ORDER_DETAILS_COUNT) {
            $notify[] = ['error', 'Order booking not found!'];
            return to_route('home')->withNotify($notify);
        }

        $coupon = Coupon::active()->count();

        $software = @$orderDetails['software'];

        if (!$software) {
            $notify[] = ['error', 'Software not found'];
            return to_route('home')->withNotify($notify);
        }

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('name')->get();

        return view('Template::software.software_confirm', compact('pageTitle', 'orderDetails', 'software', 'coupon', 'gatewayCurrency'));
    }

    public function couponApply(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'coupon_code' => 'required|max:40',
            'software_id' => 'required|integer|gt:0',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $software = Software::where('id', $request->software_id)
            ->active()
            ->notAuthUser()
            ->checkData()
            ->first();

        if (!$software) {
            return response()->json(['error' => 'The software was not found or is disabled.']);
        }

        $coupon = Coupon::where('code', $request->coupon_code)
            ->active()
            ->first();

        if (!$coupon) {
            return response()->json(['error' => 'The coupon was not found or is disabled.']);
        }

        // Check if coupon is expired
        if ($coupon->expiry_date && $coupon->expiry_date < now()) {
            return response()->json(['error' => 'This coupon has expired.']);
        }

        // Check if coupon has uses left
        if ($coupon->usage_limit != -1 && $coupon->usage_limit <= 0) {
            return response()->json(['error' => 'This coupon has reached its usage limit.']);
        }

        if (session('orderDetails.couponId')) {
            return response()->json(['error' => 'A coupon has already been applied.']);
        }

        $grandTotal = $this->discountCalculation($software->price, $coupon);

        if ($grandTotal[0] == 'negative') {
            return response()->json(['error' => 'The discount cannot be greater than the grand total price.']);
        }

        session()->put('couponDiscount', true);
        session()->put('orderDetails.discount', $grandTotal[1]);
        session()->put('orderDetails.grandTotal', $grandTotal[0]);
        session()->put('orderDetails.couponId', $coupon->id);

        return response()->json([
            'grandTotal' => $grandTotal[0],
            'discount'   => $grandTotal[1],
        ]);
    }

    public function couponRemove()
    {
        $orderDetails = session('orderDetails');

        if (!$orderDetails) {
            return response()->json(['error' => 'No order booking found.']);
        }

        $couponCheck = session('couponDiscount');

        if (!$couponCheck) {
            return response()->json(['error' => 'No coupon has been applied yet.']);
        }

        $orderDetails = $this->clearCouponDiscount($orderDetails);
        session()->put('orderDetails.couponId', null);

        return response()->json([
            'grandTotal' => $orderDetails['grandTotal'],
            'discount'   => $orderDetails['discount'],
        ]);
    }
}
