<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\ExtraService;
use App\Models\GatewayCurrency;
use App\Models\Service;
use App\Traits\BookingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceBookingController extends Controller
{
    use BookingOrder;

    public function addBooking(Request $request, $id)
    {
        $request->validate([
            'service_qty'      => 'required|integer|min:1',
            'extra_services'   => 'nullable|array',
            'extra_services.*' => 'integer|exists:extra_services,id',
        ]);


        $service = Service::where('id', $id)->active()->notAuthUser()->checkData()->with('user')->first();

        if (!$service) {
            $notify[] = ['error', 'You are not allowed to make a booking'];
            return back()->withNotify($notify);
        }

        $extraServices     = null;
        $extraServicePrice = 0;

        if ($request->extra_services) {
            $extraServicesCheck = $this->extraServicePriceCalculation($request->extra_services, $service->id);

            if ($extraServicesCheck[0] == 'notFoundOrDisabled') {
                $notify[] = ['error', 'The extra service was not found or has been disabled.'];
                return back()->withNotify($notify);
            }

            $extraServices     = $extraServicesCheck[0];
            $extraServicePrice = $extraServicesCheck[1];
        }

        $quantity     = $request->service_qty;
        $servicePrice = $service->price * $quantity;
        $totalPrice   = $servicePrice + $extraServicePrice;

        session()->forget('orderDetails');
        session()->put('orderDetails', [
            'service'           => $service,
            'discount'          => 0.00,
            'quantity'          => $quantity,
            'totalPrice'        => $totalPrice,
            'grandTotal'        => $totalPrice,
            'orderNumber'       => getTrx(),
            'price'             => $servicePrice,
            'extraServices'     => $extraServices,
            'extraServicePrice' => $extraServicePrice,
            'couponId'          => null
        ]);

        return to_route('user.service.confirm.booking');
    }

    public function confirmBooking()
    {
        $pageTitle    = 'Checkout';
        $orderDetails = session('orderDetails');

        if (!$orderDetails) {
            $notify[] = ['error', 'Order booking not found!'];
            return to_route('home')->withNotify($notify);
        }

        if (count($orderDetails) < Status::SERVICE_ORDER_DETAILS_COUNT && count($orderDetails) > Status::SERVICE_ORDER_DETAILS_COUNT) {
            $notify[] = ['error', 'Order booking not found!'];
            return to_route('home')->withNotify($notify);
        }

        $coupon          = Coupon::active()->count();
        $service         = @$orderDetails['service'];

        if (!$service) {
            $notify[] = ['error', 'Service not found'];
            return to_route('home')->withNotify($notify);
        }

        $extraServicesId = [];
        if (@$orderDetails['extraServices']) {
            $extraServicesId = collect($orderDetails['extraServices'])->pluck('id')->toArray();
        }

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('name')->get();
        return view('Template::service.service_confirm', compact('pageTitle', 'orderDetails', 'coupon', 'gatewayCurrency', 'extraServicesId'));
    }

    public function couponApply(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'coupon_code'      => 'required|max:40',
            'service_id'       => 'required|integer|gt:0',
            'service_qty'      => 'required|integer|gt:0',
            'extra_services.*' => 'nullable|integer|gt:0',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $service = Service::where('id', $request->service_id)
            ->active()
            ->notAuthUser()
            ->checkData()
            ->first();

        if (!$service) {
            return response()->json(['error' => 'The service was not found or is disabled.']);
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

        $extraServicePrice = 0;
        $extraServicesId = json_decode($request->extra_services);

        if ($extraServicesId) {
            $extraServicesCheck = $this->extraServicePriceCalculation($extraServicesId, $service->id);

            if ($extraServicesCheck[0] == 'notFoundOrDisabled') {
                return response()->json(['error' => 'The extra service was not found or is disabled.']);
            }

            $extraServicePrice = $extraServicesCheck[1];
        }

        $totalPrice = ($service->price * $request->service_qty) + $extraServicePrice;
        $grandTotal = $this->discountCalculation($totalPrice, $coupon);

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



    protected function extraServicePriceCalculation($requestedExtraServices, $serviceId)
    {
        $extraServices = ExtraService::whereIn('id', $requestedExtraServices)->where('service_id', $serviceId)->active()->get();
        if ($extraServices->count() != count($requestedExtraServices)) {
            return ['notFoundOrDisabled'];
        }

        return [$extraServices, $extraServices->sum('price')];
    }
}
