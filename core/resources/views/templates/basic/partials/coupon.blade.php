<div class="coupon-div w-100">
    @if ($orderDetails['couponId'])
        <code class="text--warning coupon-remove" role="button">@lang('Click here to remove coupon')</code>
    @else
        <div class="input-group">
            <input class="form-control form--control coupon-input" type="text" name="coupon_code"
                placeholder="Apply Coupon">
            <button class="btn btn--base coupon-code-apply" type="button">@lang('Apply')</button>
        </div>
        <code class="text--base d-none coupon-message" role="button"></code>
    @endif
</div>
