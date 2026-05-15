@extends('Template::layouts.frontend')
@section('content')
    <main class="page-wrapper pt-0">
        <section class="pt-60">
            <div class="container">
                <form action="{{ route('user.deposit.insert', $orderDetails['orderNumber']) }}" class="deposit-form"
                    method="POST">
                    @csrf
                    <input type="hidden" name="currency">
                    <div class="row gy-4 mb-4">
                        <div class="col-lg-8">
                            <div class="widget-card">
                                <div class="widget-card__header">
                                    <h5 class="widget-card__title">
                                        @lang('Choose Payment Gateway')
                                    </h5>
                                </div>
                                <div class="widget-card__body">
                                    <div class="payment-system-list is-scrollable gateway-option-list">
                                        <!-- Wallet Option -->
                                        <label for="account_balance" class="payment-item gateway-option">
                                            <div class="payment-item__info">
                                                <span class="payment-item__check"></span>
                                                <span class="payment-item__name">
                                                    @lang('Account Balance') ({{ showAmount(auth()->user()->balance) }})
                                                </span>
                                            </div>
                                            <div class="payment-item__thumb">
                                                <img class="payment-item__thumb-img"
                                                    src="{{ getImage(null, isAvatar: true) }}" alt="@lang('account-balance')">
                                            </div>
                                            <input class="payment-item__radio gateway-input" id="account_balance" hidden
                                                type="radio" name="gateway" value="wallet"
                                                @if (old('gateway')) @checked(old('gateway') == 'wallet') @endif>
                                        </label>

                                        <!-- Dynamic Payment Gateways -->
                                        @foreach ($gatewayCurrency as $data)
                                            <label for="{{ titleToKey($data->name) }}"
                                                class="payment-item @if ($loop->index > 4) d-none @endif gateway-option">
                                                <div class="payment-item__info">
                                                    <span class="payment-item__check"></span>
                                                    <span class="payment-item__name">{{ __($data->name) }}</span>
                                                </div>
                                                <div class="payment-item__thumb">
                                                    <img class="payment-item__thumb-img"
                                                        src="{{ getImage(getFilePath('gateway') . '/' . $data->method->image) }}"
                                                        alt="@lang('payment-thumb')">
                                                </div>
                                                <input class="payment-item__radio gateway-input"
                                                    id="{{ titleToKey($data->name) }}" hidden
                                                    data-gateway='@json($data)' type="radio"
                                                    name="gateway" value="{{ $data->method_code }}"
                                                    @if (old('gateway')) @checked(old('gateway') == $data->method_code) @else @checked($loop->first) @endif
                                                    data-min-amount="{{ showAmount($data->min_amount) }}"
                                                    data-max-amount="{{ showAmount($data->max_amount) }}">
                                            </label>
                                        @endforeach

                                        <!-- Show More Button -->
                                        @if ($gatewayCurrency->count() > 4)
                                            <button type="button" class="payment-item__btn more-gateway-option">
                                                <p class="payment-item__btn-text">@lang('Show All Payment Options')</p>
                                                <span class="payment-item__btn__icon"><i
                                                        class="fas fa-chevron-down"></i></span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Details Section -->
                        <div class="col-lg-4">
                            <div class="widget-card">
                                <div class="widget-card__header">
                                    <h5 class="widget-card__title">@lang('Order Details')</h5>
                                </div>
                                <div class="widget-card__body">
                                    <ul class="info-list style-two">
                                        <li class="info-list-item">
                                            <span class="info-list-item__label">@lang('Software Price')</span>
                                            <span class="info-list-item__value">
                                                <span id="softwarePrice">{{ showAmount($software->price) }}</span>
                                            </span>
                                        </li>
                                        <li class="info-list-item">
                                            <span class="info-list-item__label">@lang('Total Price')</span>
                                            <span class="info-list-item__value">
                                                {{ showAmount($software->price) }}
                                            </span>
                                        </li>
                                        <li class="info-list-item">
                                            <span class="info-list-item__label">@lang('Discount')</span>
                                            <span class="info-list-item__value">
                                                <span id="discount">{{ showAmount($orderDetails['discount']) }}</span>
                                            </span>
                                        </li>
                                        <li class="info-list-item">
                                            <span class="info-list-item__label">@lang('Grand Total')</span>
                                            <span class="info-list-item__value">
                                                <span id="grandTotal">{{ showAmount($orderDetails['grandTotal']) }}</span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="widget-card__header pt-0 mt-3">
                                    <h5 class="widget-card__title">@lang('Payment Details')</h5>
                                </div>
                                <div class="widget-card__body">
                                    <ul class="info-list style-two">
                                        <li class="info-list-item deposit-info">
                                            <span class="info-list-item__label">@lang('Amount')</span>
                                            <div class="deposit-info__input">
                                                <div class="deposit-info__input-group input-group">
                                                    <span class="deposit-info__input-group-text">{{ gs('cur_sym') }}</span>
                                                    <input type="text" class="form-control form--control amount"
                                                        name="amount" placeholder="@lang('00.00')"
                                                        value="{{ getAmount($orderDetails['grandTotal']) }}"
                                                        autocomplete="off" readonly>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="info-list-item deposit-info hideInfo">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="info-list-item__label">@lang('Processing Charge')</span>
                                                <span data-bs-toggle="tooltip" title="@lang('Processing charge for payment gateways')"
                                                    class="proccessing-fee-info">
                                                    <i class="las la-info-circle"></i>
                                                </span>
                                            </div>
                                            <div class="deposit-info__input">
                                                <p class="text mb-0">
                                                    <span class="processing-fee">@lang('0.00')</span>
                                                    {{ __(gs('cur_text')) }}
                                                </p>
                                            </div>
                                        </li>
                                        <li class="info-list-item deposit-info total-amount">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="info-list-item__label">@lang('Total')</span>
                                            </div>
                                            <div class="deposit-info__input">
                                                <p class="text mb-0">
                                                    <span class="final-amount">@lang('0.00')</span>
                                                    {{ __(gs('cur_text')) }}
                                                </p>
                                            </div>
                                        </li>
                                        @if ($coupon)
                                            <li class="info-list-item flex-column align-items-start">
                                                <span class="info-list-item__label mb-2">@lang('Coupon')</span>
                                                <!-- Include coupon partial -->
                                                @include('Template::partials.coupon')
                                            </li>
                                        @endif
                                    </ul>
                                    <button type="submit" class="btn btn--lg btn--base w-100 mt-3"
                                        disabled>@lang('Pay Now')</button>

                                    <div class="info-text mt-3">
                                        <p class="text text-muted small">
                                            @lang('Ensuring your funds grow safely through our secure deposit process with world-class payment options.')
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </section>

        @include('Template::partials.down_ad')
        @include('Template::partials.coupon_modal')
    </main>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            // Apply coupon
            $(document).on('click', '.coupon-code-apply', function() {
                var couponCode = $('.coupon-input').val();
                if (couponCode) {
                    $.ajax({
                        type: "get",
                        url: "{{ route('user.software.coupon.apply') }}",
                        data: {
                            software_id: "{{ $software->id }}",
                            coupon_code: couponCode
                        },
                        success: function(response) {
                            if (response.grandTotal !== undefined && response.discount !==
                                undefined) {
                                $('.amount').val(parseFloat(response.grandTotal).toFixed(2))
                                    .trigger('input');
                                $('#grandTotal').text(parseFloat(response.grandTotal).toFixed(2));
                                $('#discount').text(parseFloat(response.discount).toFixed(2));
                                $('.coupon-div').html(
                                    `<code class="text--warning coupon-remove" role="button">@lang('Click here to remove coupon')</code>`
                                );
                                notify('success', '@lang('Coupon applied successfully')');
                            } else {
                                notify('error', response.error || '@lang('Failed to apply coupon')');
                            }
                        }
                    });
                } else {
                    notify('error', '@lang('Please enter a coupon code')');
                }
            });

            // Remove coupon
            $(document).on('click', '.coupon-remove', function() {
                $.ajax({
                    type: "get",
                    url: "{{ route('user.software.coupon.remove') }}",
                    success: function(response) {
                        if (response.grandTotal !== undefined && response.discount !== undefined) {
                            $('.amount').val(parseFloat(response.grandTotal).toFixed(2)).trigger(
                                'input');
                            $('#grandTotal').text(parseFloat(response.grandTotal).toFixed(2));
                            $('#discount').text(parseFloat(response.discount).toFixed(2));
                            $('.coupon-div').html(`
                                <div class="input-group">
                                    <input class="form-control form--control coupon-input" type="text" name="coupon_code" placeholder="@lang('Apply Coupon')">
                                    <button class="btn btn--base coupon-code-apply" type="button">@lang('Apply')</button>
                                </div>
                            `);
                            notify('success', '@lang('Coupon removed successfully')');
                        } else {
                            notify('error', response.error || '@lang('Failed to remove coupon')');
                        }
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
