<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Coupons';
        $coupons   = Coupon::searchable(['name', 'code'])->latest()->paginate(getPaginate());
        return view('admin.coupon', compact('pageTitle', 'coupons'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name'         => 'required|max:40',
            'code'         => 'required|alpha_num|max:40|unique:coupons,code,' . $id,
            'type'         => 'required|in:1,2',
            'value'        => 'required|numeric|gt:0',
            'expiry_type'  => 'required|in:date,lifetime',
            'expiry_date'  => 'required_if:expiry_type,date|nullable|date|after:today',
            'usage_limit'  => 'required|integer|min:-1',
        ], [
            'code.alpha_num' => 'Only alpha numeric value. No space or special character is allowed'
        ]);

        if ($id) {
            $coupon         = Coupon::findOrFail($id);
            $notification   = 'Coupon updated successfully';
        } else {
            $coupon        = new Coupon();
            $notification  = 'Coupon added successfully';
        }

        $coupon->name         = $request->name;
        $coupon->code         = $request->code;
        $coupon->type         = $request->type;
        $coupon->value        = $request->value;
        $coupon->expiry_date  = $request->expiry_type == 'date' ? $request->expiry_date : null;
        $coupon->usage_limit  = $request->usage_limit;
        $coupon->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function changeStatus($id)
    {
        return Coupon::changeStatus($id);
    }
}
