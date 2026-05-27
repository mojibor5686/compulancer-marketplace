<div class="jss-details-sidebar__block" style="background: transparent;">
    @php
        $basicPkg = $productDetails->packages->where('package_type', 'basic')->first();
        $standardPkg = $productDetails->packages->where('package_type', 'standard')->first();
        $premiumPkg = $productDetails->packages->where('package_type', 'premium')->first();

        $basicFeatures = $basicPkg
            ? (is_array($basicPkg->features)
                ? $basicPkg->features
                : json_decode($basicPkg->features, true))
            : [];
        $standardFeatures = $standardPkg
            ? (is_array($standardPkg->features)
                ? $standardPkg->features
                : json_decode($standardPkg->features, true))
            : [];
        $premiumFeatures = $premiumPkg
            ? (is_array($premiumPkg->features)
                ? $premiumPkg->features
                : json_decode($premiumPkg->features, true))
            : [];

        $basicFeatures = $basicFeatures ?? [];
        $standardFeatures = $standardFeatures ?? [];
        $premiumFeatures = $premiumFeatures ?? [];
    @endphp

    <div class="kwork-packages-accordion d-none d-md-flex flex-column gap-3"
        style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">

        @if ($basicPkg)
            <div class="kwork-card-wrapper active" data-package="basic">
                <div class="kwork-card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <span class="currency-symbol">&#2547;{{ number_format($basicPkg->price ?? 0, 0) }}</span>
                        <span class="package-name">@lang('Basic')</span>
                    </div>
                    <i class="las la-angle-down accordion-arrow"></i>
                </div>
                <div class="kwork-card-body">
                    <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST"
                        class="package-order-form">
                        @csrf
                        <input type="hidden" name="package_type" value="basic">
                        <input type="hidden" name="package_id" value="{{ $basicPkg->id }}">
                        <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                        <div class="package-title-badge mb-2">{{ $basicPkg->package_title ?? 'Basic Plan' }}</div>
                        <p class="package-desc">{{ $basicPkg->package_description ?? '' }}</p>

                        <div class="d-flex align-items-center gap-3 mb-3 delivery-revision-row">
                            <div><i class="lar la-clock"></i> {{ $basicPkg->delivery_time ?? '1' }}-Day Delivery</div>
                            <div><i class="las la-sync"></i> Unlimited Revisions</div>
                        </div>

                        <ul class="feature-list">
                            @foreach ($basicFeatures as $featureName => $isAvailable)
                                <li class="{{ $isAvailable == 'no' ? 'disabled' : '' }}">
                                    <i
                                        class="las {{ $isAvailable == 'yes' ? 'la-check check-icon' : 'la-times cross-icon' }}"></i>
                                    <span>{{ $featureName }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="order-action-area">
                            <div class="quantity-row d-flex align-items-center justify-content-between mb-3">
                                <span class="qty-label"><i class="las la-cubes"></i> @lang('Number of words / Qty')</span>
                                <input type="number" name="service_qty" class="form-control table-qty-input-desktop"
                                    value="1" min="1" style="width: 80px; text-align: center;">
                            </div>
                            <button type="submit" class="kwork-order-btn">
                                @lang('Order for') &nbsp;&#2547;<span
                                    class="finalTotalPriceDisplay">{{ number_format($basicPkg->price ?? 0, 0) }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if ($standardPkg)
            <div class="kwork-card-wrapper" data-package="standard">
                <div class="kwork-card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <span class="currency-symbol">&#2547;{{ number_format($standardPkg->price ?? 0, 0) }}</span>
                        <span class="package-name">@lang('Standard')</span>
                    </div>
                    <i class="las la-angle-down accordion-arrow"></i>
                </div>
                <div class="kwork-card-body" style="display: none;">
                    <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST"
                        class="package-order-form">
                        @csrf
                        <input type="hidden" name="package_type" value="standard">
                        <input type="hidden" name="package_id" value="{{ $standardPkg->id }}">
                        <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                        <div class="package-title-badge mb-2">{{ $standardPkg->package_title ?? 'Standard Plan' }}
                        </div>
                        <p class="package-desc">{{ $standardPkg->package_description ?? '' }}</p>

                        <div class="d-flex align-items-center gap-3 mb-3 delivery-revision-row">
                            <div><i class="lar la-clock"></i> {{ $standardPkg->delivery_time ?? '3' }}-Day Delivery
                            </div>
                            <div><i class="las la-sync"></i> Unlimited Revisions</div>
                        </div>

                        <ul class="feature-list">
                            @foreach ($standardFeatures as $featureName => $isAvailable)
                                <li class="{{ $isAvailable == 'no' ? 'disabled' : '' }}">
                                    <i
                                        class="las {{ $isAvailable == 'yes' ? 'la-check check-icon' : 'la-times cross-icon' }}"></i>
                                    <span>{{ $featureName }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="order-action-area">
                            <div class="quantity-row d-flex align-items-center justify-content-between mb-3">
                                <span class="qty-label"><i class="las la-cubes"></i> @lang('Number of words / Qty')</span>
                                <input type="number" name="service_qty" class="form-control table-qty-input-desktop"
                                    value="1" min="1" style="width: 80px; text-align: center;">
                            </div>
                            <button type="submit" class="kwork-order-btn">
                                @lang('Order for') &nbsp;&#2547;<span
                                    class="finalTotalPriceDisplay">{{ number_format($standardPkg->price ?? 0, 0) }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if ($premiumPkg)
            <div class="kwork-card-wrapper" data-package="premium">
                <div class="kwork-card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <span class="currency-symbol">&#2547;{{ number_format($premiumPkg->price ?? 0, 0) }}</span>
                        <span class="package-name">@lang('Premium')</span>
                    </div>
                    <i class="las la-angle-down accordion-arrow"></i>
                </div>
                <div class="kwork-card-body" style="display: none;">
                    <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST"
                        class="package-order-form">
                        @csrf
                        <input type="hidden" name="package_type" value="premium">
                        <input type="hidden" name="package_id" value="{{ $premiumPkg->id }}">
                        <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                        <div class="package-title-badge mb-2">{{ $premiumPkg->package_title ?? 'Premium Plan' }}</div>
                        <p class="package-desc">{{ $premiumPkg->package_description ?? '' }}</p>

                        <div class="d-flex align-items-center gap-3 mb-3 delivery-revision-row">
                            <div><i class="lar la-clock"></i> {{ $premiumPkg->delivery_time ?? '5' }}-Day Delivery
                            </div>
                            <div><i class="las la-sync"></i> Unlimited Revisions</div>
                        </div>

                        <ul class="feature-list">
                            @foreach ($premiumFeatures as $featureName => $isAvailable)
                                <li class="{{ $isAvailable == 'no' ? 'disabled' : '' }}">
                                    <i
                                        class="las {{ $isAvailable == 'yes' ? 'la-check check-icon' : 'la-times cross-icon' }}"></i>
                                    <span>{{ $featureName }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="order-action-area">
                            <div class="quantity-row d-flex align-items-center justify-content-between mb-3">
                                <span class="qty-label"><i class="las la-cubes"></i> @lang('Number of words / Qty')</span>
                                <input type="number" name="service_qty" class="form-control table-qty-input-desktop"
                                    value="1" min="1" style="width: 80px; text-align: center;">
                            </div>
                            <button type="submit" class="kwork-order-btn">
                                @lang('Order for') &nbsp;&#2547;<span
                                    class="finalTotalPriceDisplay">{{ number_format($premiumPkg->price ?? 0, 0) }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>


    <div class="kwork-mobile-package-view d-md-none">
        <div class="mobile-tabs-grid">
            <div class="mobile-tab-item active" data-target="mob-basic">
                <div class="label">@lang('Basic')</div>
                <div class="price">&#2547;{{ number_format($basicPkg->price ?? 0, 0) }}</div>
            </div>
            <div class="mobile-tab-item" data-target="mob-standard">
                <div class="label">@lang('Standard')</div>
                <div class="price">&#2547;{{ number_format($standardPkg->price ?? 0, 0) }}</div>
            </div>
            <div class="mobile-tab-item" data-target="mob-premium">
                <div class="label">@lang('Premium')</div>
                <div class="price">&#2547;{{ number_format($premiumPkg->price ?? 0, 0) }}</div>
            </div>
        </div>

        <div class="mobile-tab-content-wrapper">
            <div class="mob-panel-block" id="mob-basic">
                <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST"
                    class="m-0 p-0">
                    @csrf
                    <input type="hidden" name="package_type" value="basic">
                    <input type="hidden" name="package_id" value="{{ $basicPkg->id ?? '' }}">
                    <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                    <h4 class="mob-pkg-title">{{ $basicPkg->package_title ?? 'Basic Package' }}</h4>
                    <p class="mob-pkg-desc">{{ $basicPkg->package_description ?? '' }}</p>

                    <div class="mob-delivery-time">
                        <i class="lar la-clock"></i> <span>@lang('Delivery Time'):</span>
                        <strong>{{ $basicPkg->delivery_time ?? '1' }} @lang('Days')</strong>
                    </div>

                    <ul class="mob-feature-ul">
                        @foreach ($basicFeatures as $featureName => $isAvailable)
                            <li class="{{ $isAvailable == 'no' ? 'disabled' : '' }}">
                                <i
                                    class="las {{ $isAvailable == 'yes' ? 'la-check text-success' : 'la-times text-muted' }}"></i>
                                <span>{{ __($featureName) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mob-qty-row">
                        <span class="qty-text">@lang('Number of words / Qty')</span>
                        <input type="number" name="service_qty" class="form-control mobile-qty-input-box"
                            data-price="{{ $basicPkg->price ?? 0 }}" value="1" min="1">
                    </div>

                    <div class="mob-action-buttons">
                        <div class="submit-btn-container">
                            <button type="submit" class="kwork-mob-submit-btn">
                                @lang('Order for') &#2547;<span
                                    class="mob-price-text">{{ number_format($basicPkg->price ?? 0, 0) }}</span>
                            </button>
                        </div>
                        <div class="cart-btn-container">
                            <button type="button" class="mob-cart-icon-btn"><i
                                    class="las la-shopping-cart"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mob-panel-block d-none" id="mob-standard">
                <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST"
                    class="m-0 p-0">
                    @csrf
                    <input type="hidden" name="package_type" value="standard">
                    <input type="hidden" name="package_id" value="{{ $standardPkg->id ?? '' }}">
                    <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                    <h4 class="mob-pkg-title">{{ $standardPkg->package_title ?? 'Standard Package' }}</h4>
                    <p class="mob-pkg-desc">{{ $standardPkg->package_description ?? '' }}</p>

                    <div class="mob-delivery-time">
                        <i class="lar la-clock"></i> <span>@lang('Delivery Time'):</span>
                        <strong>{{ $standardPkg->delivery_time ?? '3' }} @lang('Days')</strong>
                    </div>

                    <ul class="mob-feature-ul">
                        @foreach ($standardFeatures as $featureName => $isAvailable)
                            <li class="{{ $isAvailable == 'no' ? 'disabled' : '' }}">
                                <i
                                    class="las {{ $isAvailable == 'yes' ? 'la-check text-success' : 'la-times text-muted' }}"></i>
                                <span>{{ __($featureName) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mob-qty-row">
                        <span class="qty-text">@lang('Number of words / Qty')</span>
                        <input type="number" name="service_qty" class="form-control mobile-qty-input-box"
                            data-price="{{ $standardPkg->price ?? 0 }}" value="1" min="1">
                    </div>

                    <div class="mob-action-buttons">
                        <div class="submit-btn-container">
                            <button type="submit" class="kwork-mob-submit-btn">
                                @lang('Order for') &#2547;<span
                                    class="mob-price-text">{{ number_format($standardPkg->price ?? 0, 0) }}</span>
                            </button>
                        </div>
                        <div class="cart-btn-container">
                            <button type="button" class="mob-cart-icon-btn"><i
                                    class="las la-shopping-cart"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mob-panel-block d-none" id="mob-premium">
                <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST"
                    class="m-0 p-0">
                    @csrf
                    <input type="hidden" name="package_type" value="premium">
                    <input type="hidden" name="package_id" value="{{ $premiumPkg->id ?? '' }}">
                    <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                    <h4 class="mob-pkg-title">{{ $premiumPkg->package_title ?? 'Premium Package' }}</h4>
                    <p class="mob-pkg-desc">{{ $premiumPkg->package_description ?? '' }}</p>

                    <div class="mob-delivery-time">
                        <i class="lar la-clock"></i> <span>@lang('Delivery Time'):</span>
                        <strong>{{ $premiumPkg->delivery_time ?? '5' }} @lang('Days')</strong>
                    </div>

                    <ul class="mob-feature-ul">
                        @foreach ($premiumFeatures as $featureName => $isAvailable)
                            <li class="{{ $isAvailable == 'no' ? 'disabled' : '' }}">
                                <i
                                    class="las {{ $isAvailable == 'yes' ? 'la-check text-success' : 'la-times text-muted' }}"></i>
                                <span>{{ __($featureName) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mob-qty-row">
                        <span class="qty-text">@lang('Number of words / Qty')</span>
                        <input type="number" name="service_qty" class="form-control mobile-qty-input-box"
                            data-price="{{ $premiumPkg->price ?? 0 }}" value="1" min="1">
                    </div>

                    <div class="mob-action-buttons">
                        <div class="submit-btn-container">
                            <button type="submit" class="kwork-mob-submit-btn">
                                @lang('Order for') &#2547;<span
                                    class="mob-price-text">{{ number_format($premiumPkg->price ?? 0, 0) }}</span>
                            </button>
                        </div>
                        <div class="cart-btn-container">
                            <button type="button" class="mob-cart-icon-btn"><i
                                    class="las la-shopping-cart"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .kwork-mobile-package-view {
        background: #fff !important;
        border: 1px solid #e4e6e9 !important;
        border-radius: 8px !important;
        overflow: hidden !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        margin-bottom: 25px !important;
    }

    .mobile-tabs-grid {
        display: flex !important;
        width: 100% !important;
        background-color: #f7f7f7 !important;
        border-bottom: 1px solid #e4e6e9 !important;
    }

    .mobile-tab-item {
        flex: 1 !important;
        text-align: center !important;
        padding: 12px 5px !important;
        cursor: pointer !important;
        color: #555555 !important;
        border-bottom: 3px solid transparent !important;
        transition: all 0.2s ease !important;
    }

    .mobile-tab-item .label {
        font-size: 13px !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        margin-bottom: 2px !important;
    }

    .mobile-tab-item .price {
        font-size: 16px !important;
        font-weight: 700 !important;
    }

    .mobile-tab-item.active {
        color: #1dbf73 !important;
        border-bottom-color: #1dbf73 !important;
        background-color: #ffffff !important;
    }

    .mobile-tab-content-wrapper {
        padding: 20px 15px !important;
    }

    .mob-pkg-title {
        font-size: 18px !important;
        font-weight: 700 !important;
        color: #222222 !important;
        margin-bottom: 8px !important;
        line-height: 1.3 !important;
    }

    .mob-pkg-desc {
        font-size: 14px !important;
        color: #62646a !important;
        line-height: 1.5 !important;
        margin-bottom: 15px !important;
    }

    .mob-delivery-time {
        font-size: 14px !important;
        color: #404145 !important;
        margin-bottom: 15px !important;
    }

    .mob-delivery-time i {
        color: #74767e !important;
        font-size: 16px !important;
        margin-right: 4px !important;
    }

    .mob-feature-ul {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 0 20px 0 !important;
    }

    .mob-feature-ul li {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        font-size: 14px !important;
        color: #404145 !important;
        padding: 8px 0 !important;
        border-bottom: 1px solid #f4f5f7 !important;
    }

    .mob-feature-ul li.disabled {
        color: #b5b6ba !important;
        opacity: 0.6 !important;
    }

    .mob-feature-ul li i {
        font-size: 16px !important;
        font-weight: bold !important;
    }

    .mob-feature-ul li i.text-success {
        color: #1dbf73 !important;
    }

    .mob-qty-row {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        margin-bottom: 20px !important;
        padding-top: 5px !important;
    }

    .mob-qty-row .qty-text {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #404145 !important;
    }

    .mobile-qty-input-box {
        width: 75px !important;
        height: 34px !important;
        text-align: center !important;
        font-weight: 700 !important;
        border: 1px solid #dadbdd !important;
        border-radius: 4px !important;
    }

    .mob-action-buttons {
        display: flex !important;
        gap: 10px !important;
        width: 100% !important;
    }

    .mob-action-buttons .submit-btn-container {
        flex: 1 !important;
    }

    .kwork-mob-submit-btn {
        width: 100% !important;
        background-color: #1dbf73 !important;
        border: 1px solid #1dbf73 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 16px !important;
        height: 44px !important;
        border-radius: 4px !important;
        transition: all 0.2s ease !important;
    }

    .kwork-mob-submit-btn:hover {
        background-color: #19a463 !important;
    }

    .mob-action-buttons .cart-btn-container {
        width: 48px !important;
    }

    .mob-cart-icon-btn {
        width: 100% !important;
        height: 44px !important;
        background: #ffffff !important;
        border: 1px solid #1dbf73 !important;
        color: #1dbf73 !important;
        border-radius: 4px !important;
        font-size: 20px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* ডেস্কটপ সিএসএস এনহান্সমেন্ট ফিক্স */
    .table-qty-input-desktop {
        border: 1px solid #dadbdd !important;
        height: 34px !important;
        font-weight: bold !important;
    }
</style>

@push('script')
    <script>
        (function($) {
            "use strict";

            // ================== ১. মোবাইলের ট্যাব টগল স্ক্রিপ্ট ==================
            $('.mobile-tab-item').on('click', function() {
                $('.mobile-tab-item').removeClass('active');
                $(this).addClass('active');

                let targetPanel = $(this).data('target');
                $('.mob-panel-block').addClass('d-none');
                $('#' + targetPanel).removeClass('d-none');
            });

            // ================== ২. মোবাইলের লাইভ প্রাইস ক্যালকুলেটর ==================
            $('.mobile-qty-input-box').on('input change', function() {
                let qty = parseInt($(this).val()) || 1;
                if (qty < 1) {
                    qty = 1;
                    $(this).val(1);
                }

                let basePrice = parseFloat($(this).data('price')) || 0;
                let finalTotal = basePrice * qty;

                $(this).closest('form').find('.mob-price-text').text(finalTotal.toLocaleString('en-US'));
            });


            // ================== ৩. ডেস্কটপ অ্যাকর্ডিয়ন ও ক্যালকুলেশন স্ক্রিপ্ট ==================
            var desktopPrices = {
                basic: parseFloat("{{ $basicPkg->price ?? 0 }}"),
                standard: parseFloat("{{ $standardPkg->price ?? 0 }}"),
                premium: parseFloat("{{ $premiumPkg->price ?? 0 }}")
            };

            function updateDesktopPrice(wrapper) {
                let type = wrapper.data('package');
                let base = desktopPrices[type] || 0;
                let qty = parseInt(wrapper.find('.table-qty-input-desktop').val()) || 1;
                wrapper.find('.finalTotalPriceDisplay').text((base * qty).toLocaleString('en-US'));
            }

            $('.table-qty-input-desktop').on('input change', function() {
                updateDesktopPrice($(this).closest('.kwork-card-wrapper'));
            });

            $('.kwork-card-header').on('click', function(e) {
                if ($(e.target).closest('.order-action-area').length) return;
                let parent = $(this).closest('.kwork-card-wrapper');
                if (parent.hasClass('active')) return;

                $('.kwork-card-body').slideUp(200);
                $('.kwork-card-wrapper').removeClass('active');

                parent.addClass('active');
                parent.find('.kwork-card-body').slideDown(200);
                parent.find('.table-qty-input-desktop').val(1);
                updateDesktopPrice(parent);
            });
        })(jQuery);
    </script>
@endpush
