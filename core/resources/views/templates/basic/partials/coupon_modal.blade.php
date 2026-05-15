<div id="couponAddModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Use Coupon Code')</h5>
                <span class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="mb-2" for="coupon_code">@lang('Coupon Code')</label>
                        <input class="form-control form--control" name="coupon_code" type="text"
                            placeholder="@lang('Enter Coupon Code')" maxlength="40" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn--base w-100 btn--lg coupon-code-apply">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="couponRemoveModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation!')</h5>
                <span class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <h5>@lang('Are you sure to remove coupon?')</h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn--danger text-white btn-sm" data-bs-dismiss="modal"
                    type="button">@lang('No')</button>
                <button class="btn btn--base btn-sm coupon-remove-apply" type="button">@lang('Yes')</button>
            </div>
        </div>
    </div>
</div>

<div id="paymentModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Payment of Your Order')</h5>
                <span class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <form action="{{ route('user.deposit.insert', $orderDetails['orderNumber']) }}" class="deposit-form"
                method="POST">
                @csrf
                <input type="hidden" name="currency">
                <div class="modal-body">
                    <div class="gateway-card">
                        <div class="row justify-content-center gy-sm-4 gy-3">
                            <div class="col-lg-6">
                                <div class="payment-system-list is-scrollable gateway-option-list">
                                    <label for="account_balance" class="payment-item gateway-option">
                                        <div class="payment-item__info">
                                            <span class="payment-item__check"></span>
                                            <span class="payment-item__name">@lang('Account Balance')
                                                ({{ showAmount(auth()->user()->balance) }})</span>
                                        </div>
                                        <div class="payment-item__thumb">
                                            <img class="payment-item__thumb-img"
                                                src="{{ getImage(null, isAvatar: true) }}" alt="@lang('account-balance')">
                                        </div>
                                        <input class="payment-item__radio gateway-input" id="account_balance" hidden
                                            type="radio" name="gateway" value="wallet"
                                            @if (old('gateway')) @checked(old('gateway') == 'wallet') @endif>
                                    </label>

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

                                    @if ($gatewayCurrency->count() > 4)
                                        <button type="button" class="payment-item__btn more-gateway-option">
                                            <p class="payment-item__btn-text">@lang('Show All Payment Options')</p>
                                            <span class="payment-item__btn__icon"><i
                                                    class="fas fa-chevron-down"></i></span>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="payment-system-list p-4 rounded shadow-sm">
                                    <div class="deposit-info mb-4">
                                        <div class="deposit-info__title mb-2">
                                            <p class="text mb-0">@lang('Amount')</p>
                                        </div>
                                        <div class="deposit-info__input">
                                            <div class="deposit-info__input-group input-group">
                                                <span
                                                    class="deposit-info__input-group-text">{{ gs('cur_sym') }}</span>
                                                <input type="text" class="form-control form--control amount"
                                                    name="amount" placeholder="@lang('00.00')"
                                                    value="{{ old('amount') }}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <div class="deposit-info hideInfo mb-4">
                                        <div class="deposit-info__title d-flex align-items-center mb-2">
                                            <p class="text has-icon mb-0 me-2">@lang('Processing Charge')</p>
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
                                    </div>

                                    <div class="deposit-info total-amount py-3 mb-4">
                                        <div class="deposit-info__title mb-2">
                                            <p class="text mb-0">@lang('Total')</p>
                                        </div>
                                        <div class="deposit-info__input">
                                            <p class="text mb-0">
                                                <span class="final-amount">@lang('0.00')</span>
                                                {{ __(gs('cur_text')) }}
                                            </p>
                                        </div>
                                    </div>

                                    <div
                                        class="deposit-info hideInfo gateway-conversion d-none total-amount py-2 mb-3">
                                        <div class="deposit-info__title mb-2">
                                            <p class="text mb-0">@lang('Conversion')</p>
                                        </div>
                                        <div class="deposit-info__input">
                                            <p class="text mb-0"></p>
                                        </div>
                                    </div>

                                    <div
                                        class="deposit-info hideInfo conversion-currency d-none total-amount py-2 mb-3">
                                        <div class="deposit-info__title mb-2">
                                            <p class="text mb-0">@lang('In') <span
                                                    class="gateway-currency"></span></p>
                                        </div>
                                        <div class="deposit-info__input">
                                            <p class="text mb-0">
                                                <span class="in-currency"></span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-none hideInfo crypto-message mb-4">
                                        @lang('Conversion with') <span class="gateway-currency"></span> @lang('and final value will Show on next step')
                                    </div>

                                    <button type="submit" class="btn btn--base btn--sm w-100 h-45 mb-4"
                                        disabled>@lang('Pay Now')</button>

                                    <div class="info-text pt-2">
                                        <p class="text text-muted small">@lang('Ensuring your funds grow safely through our secure deposit process with world-class payment options.')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@push('script')
    <script>
        "use strict";
        (function($) {
            var amount = parseFloat($('.amount').val() || 0);
            calculation();
            var gateway;

            $('.amount').on('input', function(e) {
                amount = parseFloat($(this).val());
                if (!amount) {
                    amount = 0;
                }
                calculation();
            });

            $('.gateway-input').on('change', function(e) {
                gatewayChange();
            });

            function gatewayChange() {
                let gatewayElement = $('.gateway-input:checked');
                let methodCode = gatewayElement.val()
                let gatewayValue = $('.gateway-input:checked').val();

                if (gatewayValue == 'wallet') {
                    @if (auth()->user()->balance < @$plan->price)
                        $(".deposit-form button[type=submit]").attr('disabled', true);
                    @else
                        $(".deposit-form button[type=submit]").removeAttr('disabled');
                    @endif
                    var totalAmount = amount;
                    $('.hideInfo').addClass('d-none')
                    $(".final-amount").text(totalAmount.toFixed(2));
                } else {
                    $('.hideInfo').removeClass('d-none')
                    gateway = gatewayElement.data('gateway');

                    let processingFeeInfo =
                        `${parseFloat(gateway.percent_charge).toFixed(2)}% with ${parseFloat(gateway.fixed_charge).toFixed(2)} {{ __(gs('cur_text')) }} charge for payment gateway processing fees`
                    $(".proccessing-fee-info").attr("data-bs-original-title", processingFeeInfo);
                    calculation();
                }
            }
            gatewayChange();

            $(".more-gateway-option").on("click", function(e) {
                let paymentList = $(".gateway-option-list");
                paymentList.find(".gateway-option").removeClass("d-none");
                $(this).addClass('d-none');
                paymentList.animate({
                    scrollTop: (paymentList.height() - 60)
                }, 'slow');
            });

            function calculation() {
                if (!gateway) return;

                let percentCharge = 0;
                let fixedCharge = 0;
                let totalPercentCharge = 0;

                if (amount) {
                    percentCharge = parseFloat(gateway.percent_charge);
                    fixedCharge = parseFloat(gateway.fixed_charge);
                    totalPercentCharge = parseFloat(amount / 100 * percentCharge);
                }

                let totalCharge = parseFloat(totalPercentCharge + fixedCharge);
                let totalAmount = parseFloat((amount || 0) + totalPercentCharge + fixedCharge);

                $(".final-amount").text(totalAmount.toFixed(2));
                $(".processing-fee").text(totalCharge.toFixed(2));
                $("input[name=currency]").val(gateway.currency);
                $(".gateway-currency").text(gateway.currency);

                if (!amount) {
                    $(".deposit-form button[type=submit]").attr('disabled', true);
                } else {
                    $(".deposit-form button[type=submit]").removeAttr('disabled');
                }

                if (gateway.currency != "{{ gs('cur_text') }}" && gateway.method.crypto != 1) {
                    $('.deposit-form').addClass('adjust-height')
                    $(".gateway-conversion, .conversion-currency").removeClass('d-none');
                    $(".gateway-conversion").find('.deposit-info__input .text').html(
                        `1 {{ __(gs('cur_text')) }} = <span class="rate">${parseFloat(gateway.rate).toFixed(2)}</span> <span class="method_currency">${gateway.currency}</span>`
                    );
                    $('.in-currency').text(parseFloat(totalAmount * gateway.rate).toFixed(gateway.method.crypto == 1 ?
                        8 : 2))
                } else {
                    $(".gateway-conversion, .conversion-currency").addClass('d-none');
                    $('.deposit-form').removeClass('adjust-height')
                }

                if (gateway.method.crypto == 1) {
                    $('.crypto-message').removeClass('d-none');
                } else {
                    $('.crypto-message').addClass('d-none');
                }
            }

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            $('.gateway-input').change();

            $('.checkoutBtn').on('click', function() {
                let modal = $('#paymentModal');
                let orderAmount = parseFloat($(this).attr('data-order_amount'));

                modal.find('[name="amount"]').val(orderAmount).prop('readonly', true);

                amount = orderAmount;
                calculation();

                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
