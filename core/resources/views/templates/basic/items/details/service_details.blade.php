<div class="kwrk-main-sidebar-block" style="background: transparent;">
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

    <div class="kwork-packages-accordion d-flex flex-column gap-3 kwrk-desktop-only"
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
                                <span class="qty-label"><i class="las la-cubes"></i> @lang('Quantity')</span>
                                <div class="qty-counter">
                                    <button type="button" class="pkgDecrementBtn"><i class="las la-minus"></i></button>
                                    <span class="pkgQuantityDisplay">1</span>
                                    <button type="button" class="pkgIncrementBtn"><i class="las la-plus"></i></button>
                                </div>
                                <input type="hidden" name="service_qty" class="service_qty_hidden" value="1">
                            </div>

                            @auth
                                <button type="submit" class="kwork-order-btn">
                                    @lang('Order for') &nbsp;&#2547;<span
                                        class="finalTotalPriceDisplay">{{ number_format($basicPkg->price ?? 0, 0) }}</span>
                                </button>
                            @else
                                <button type="button" class="kwork-order-btn" data-bs-toggle="modal"
                                    data-bs-target="#signInModal">
                                    @lang('Order for') &nbsp;&#2547;<span
                                        class="finalTotalPriceDisplay">{{ number_format($basicPkg->price ?? 0, 0) }}</span>
                                </button>
                            @endauth
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
                                <span class="qty-label"><i class="las la-cubes"></i> @lang('Quantity')</span>
                                <div class="qty-counter">
                                    <button type="button" class="pkgDecrementBtn"><i class="las la-minus"></i></button>
                                    <span class="pkgQuantityDisplay">1</span>
                                    <button type="button" class="pkgIncrementBtn"><i class="las la-plus"></i></button>
                                </div>
                                <input type="hidden" name="service_qty" class="service_qty_hidden" value="1">
                            </div>

                            @auth
                                <button type="submit" class="kwork-order-btn">
                                    @lang('Order for') &nbsp;&#2547;<span
                                        class="finalTotalPriceDisplay">{{ number_format($standardPkg->price ?? 0, 0) }}</span>
                                </button>
                            @else
                                <button type="button" class="kwork-order-btn" data-bs-toggle="modal"
                                    data-bs-target="#signInModal">
                                    @lang('Order for') &nbsp;&#2547;<span
                                        class="finalTotalPriceDisplay">{{ number_format($standardPkg->price ?? 0, 0) }}</span>
                                </button>
                            @endauth
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
                                <span class="qty-label"><i class="las la-cubes"></i> @lang('Quantity')</span>
                                <div class="qty-counter">
                                    <button type="button" class="pkgDecrementBtn"><i
                                            class="las la-minus"></i></button>
                                    <span class="pkgQuantityDisplay">1</span>
                                    <button type="button" class="pkgIncrementBtn"><i
                                            class="las la-plus"></i></button>
                                </div>
                                <input type="hidden" name="service_qty" class="service_qty_hidden" value="1">
                            </div>

                            @auth
                                <button type="submit" class="kwork-order-btn">
                                    @lang('Order for') &nbsp;&#2547;<span
                                        class="finalTotalPriceDisplay">{{ number_format($premiumPkg->price ?? 0, 0) }}</span>
                                </button>
                            @else
                                <button type="button" class="kwork-order-btn" data-bs-toggle="modal"
                                    data-bs-target="#signInModal">
                                    @lang('Order for') &nbsp;&#2547;<span
                                        class="finalTotalPriceDisplay">{{ number_format($premiumPkg->price ?? 0, 0) }}</span>
                                </button>
                            @endauth
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <div class="kwrk-mobile-package-view">
        <div class="kwrk-mobile-tabs-grid">
            <div class="kwrk-mobile-tab-item active" data-kwrktarget="kwrk-mob-basic">
                <div class="label">@lang('Basic')</div>
                <div class="price">&#2547;{{ number_format($basicPkg->price ?? 0, 0) }}</div>
            </div>
            <div class="kwrk-mobile-tab-item" data-kwrktarget="kwrk-mob-standard">
                <div class="label">@lang('Standard')</div>
                <div class="price">&#2547;{{ number_format($standardPkg->price ?? 0, 0) }}</div>
            </div>
            <div class="kwrk-mobile-tab-item" data-kwrktarget="kwrk-mob-premium">
                <div class="label">@lang('Premium')</div>
                <div class="price">&#2547;{{ number_format($premiumPkg->price ?? 0, 0) }}</div>
            </div>
        </div>

        <div class="kwrk-mobile-tab-content-container">

            @if ($basicPkg)
                <div class="kwrk-mob-panel-block" id="kwrk-mob-basic">
                    <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST"
                        class="m-0 p-0">
                        @csrf
                        <input type="hidden" name="package_type" value="basic">
                        <input type="hidden" name="package_id" value="{{ $basicPkg->id }}">
                        <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                        <h4 class="mob-pkg-title">{{ $basicPkg->package_title ?? 'Basic Package' }}</h4>
                        <p class="mob-pkg-desc">{{ $basicPkg->package_description ?? 'Basic Package' }}</p>

                        <ul class="mob-feature-ul">
                            @foreach ($basicFeatures as $featureName => $isAvailable)
                                <li class="{{ $isAvailable == 'no' ? 'disabled' : '' }}">
                                    <span>{{ $featureName }}</span>
                                    <i
                                        class="las {{ $isAvailable == 'yes' ? 'la-check text-success' : 'la-times text-muted' }}"></i>
                                </li>
                            @endforeach
                            <li class="mob-custom-row">
                                <span>@lang('Delivery')</span>
                                <strong>{{ $basicPkg->delivery_time ?? '1' }} @lang('days')</strong>
                            </li>
                        </ul>

                        <div class="mob-qty-row">
                            <span class="qty-text">@lang('Number of words') <i class="lar la-question-circle"
                                    style="color:#b5b6ba;"></i></span>
                            <input type="number" name="service_qty" class="form-control kwrk-mobile-qty-input"
                                data-price="{{ $basicPkg->price ?? 0 }}" value="1" min="1">
                        </div>

                        <div class="mob-action-buttons">
                            @auth
                                <button type="submit" class="kwork-mob-submit-btn">
                                    @lang('Order for') &#2547;<span
                                        class="kwrk-mob-price-text">{{ number_format($basicPkg->price ?? 0, 0) }}</span>
                                </button>
                            @else
                                <button type="button" class="kwork-mob-submit-btn" data-bs-toggle="modal"
                                    data-bs-target="#signInModal">
                                    @lang('Order for') &#2547;<span
                                        class="kwrk-mob-price-text">{{ number_format($basicPkg->price ?? 0, 0) }}</span>
                                </button>
                            @endauth
                        </div>
                    </form>
                </div>
            @endif

            @if ($standardPkg)
                <div class="kwrk-mob-panel-block" id="kwrk-mob-standard" style="display: none;">
                    <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST"
                        class="m-0 p-0">
                        @csrf
                        <input type="hidden" name="package_type" value="standard">
                        <input type="hidden" name="package_id" value="{{ $standardPkg->id }}">
                        <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                        <h4 class="mob-pkg-title">{{ $standardPkg->package_title ?? 'Standard Package' }}</h4>
                        <p class="mob-pkg-desc">{{ $standardPkg->package_description ?? 'Standard Package' }}</p>

                        <ul class="mob-feature-ul">
                            @foreach ($standardFeatures as $featureName => $isAvailable)
                                <li class="{{ $isAvailable == 'no' ? 'disabled' : '' }}">
                                    <span>{{ $featureName }}</span>
                                    <i
                                        class="las {{ $isAvailable == 'yes' ? 'la-check text-success' : 'la-times text-muted' }}"></i>
                                </li>
                            @endforeach
                            <li class="mob-custom-row">
                                <span>@lang('Delivery')</span>
                                <strong>{{ $standardPkg->delivery_time ?? '3' }} @lang('days')</strong>
                            </li>
                        </ul>

                        <div class="mob-qty-row">
                            <span class="qty-text">@lang('Number of words') <i class="lar la-question-circle"
                                    style="color:#b5b6ba;"></i></span>
                            <input type="number" name="service_qty" class="form-control kwrk-mobile-qty-input"
                                data-price="{{ $standardPkg->price ?? 0 }}" value="1" min="1">
                        </div>

                        <div class="mob-action-buttons">
                            @auth
                                <button type="submit" class="kwork-mob-submit-btn">
                                    @lang('Order for') &#2547;<span
                                        class="kwrk-mob-price-text">{{ number_format($standardPkg->price ?? 0, 0) }}</span>
                                </button>
                            @else
                                <button type="button" class="kwork-mob-submit-btn" data-bs-toggle="modal"
                                    data-bs-target="#signInModal">
                                    @lang('Order for') &#2547;<span
                                        class="kwrk-mob-price-text">{{ number_format($standardPkg->price ?? 0, 0) }}</span>
                                </button>
                            @endauth
                        </div>
                    </form>
                </div>
            @endif

            @if ($premiumPkg)
                <div class="kwrk-mob-panel-block" id="kwrk-mob-premium" style="display: none;">
                    <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST"
                        class="m-0 p-0">
                        @csrf
                        <input type="hidden" name="package_type" value="premium">
                        <input type="hidden" name="package_id" value="{{ $premiumPkg->id }}">
                        <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                        <h4 class="mob-pkg-title">{{ $premiumPkg->package_title ?? 'Premium Package' }}</h4>
                        <p class="mob-pkg-desc">{{ $premiumPkg->package_description ?? 'Premium Package' }}</p>

                        <ul class="mob-feature-ul">
                            @foreach ($premiumFeatures as $featureName => $isAvailable)
                                <li class="{{ $isAvailable == 'no' ? 'disabled' : '' }}">
                                    <span>{{ $featureName }}</span>
                                    <i
                                        class="las {{ $isAvailable == 'yes' ? 'la-check text-success' : 'la-times text-muted' }}"></i>
                                </li>
                            @endforeach
                            <li class="mob-custom-row">
                                <span>@lang('Delivery')</span>
                                <strong>{{ $premiumPkg->delivery_time ?? '5' }} @lang('days')</strong>
                            </li>
                        </ul>

                        <div class="mob-qty-row">
                            <span class="qty-text">@lang('Number of words') <i class="lar la-question-circle"
                                    style="color:#b5b6ba;"></i></span>

                            <!-- Custom - + Qty Container -->
                            <div
                                style="display: flex !important; align-items: center !important; justify-content: flex-start !important; gap: 5px !important; margin-top: 8px !important;">
                                <!-- Minus Button -->
                                <button type="button"
                                    style="width: 35px !important; height: 36px !important; padding: 0 !important; font-size: 18px !important; line-height: 1 !important; border: 1px solid #ccc !important; background-color: #f8f9fa !important; color: #333 !important; border-radius: 4px !important; cursor: pointer !important; display: inline-block !important; user-select: none !important;"
                                    onclick="let input = this.nextElementSibling; if(parseInt(input.value) > 1) { input.value = parseInt(input.value) - 1; input.dispatchEvent(new Event('change')); }">-</button>

                                <!-- Input Field -->
                                <input type="number" name="service_qty" class="kwrk-mobile-qty-input"
                                    data-price="{{ $premiumPkg->price ?? 0 }}" value="1" min="1"
                                    style="width: 65px !important; height: 36px !important; text-align: center !important; font-size: 15px !important; border: 1px solid #ccc !important; border-radius: 4px !important; padding: 0 !important; margin: 0 2px !important; box-sizing: border-box !important; -moz-appearance: textfield !important;" />

                                <!-- Plus Button -->
                                <button type="button"
                                    style="width: 35px !important; height: 36px !important; padding: 0 !important; font-size: 18px !important; line-height: 1 !important; border: 1px solid #ccc !important; background-color: #f8f9fa !important; color: #333 !important; border-radius: 4px !important; cursor: pointer !important; display: inline-block !important; user-select: none !important;"
                                    onclick="let input = this.previousElementSibling; input.value = (parseInt(input.value) || 0) + 1; input.dispatchEvent(new Event('change'));">+</button>
                            </div>
                        </div>

                        <div class="mob-action-buttons">
                            @auth
                                <button type="submit" class="kwork-mob-submit-btn">
                                    @lang('Order for') &#2547;<span
                                        class="kwrk-mob-price-text">{{ number_format($premiumPkg->price ?? 0, 0) }}</span>
                                </button>
                            @else
                                <button type="button" class="kwork-mob-submit-btn" data-bs-toggle="modal"
                                    data-bs-target="#signInModal">
                                    @lang('Order for') &#2547;<span
                                        class="kwrk-mob-price-text">{{ number_format($premiumPkg->price ?? 0, 0) }}</span>
                                </button>
                            @endauth
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }

        function updateMobileFixedBottomPrice() {
            var $activePanel = $('.kwrk-mob-panel-block:visible');

            if ($activePanel.length) {
                var $qtyInput = $activePanel.find('.kwrk-mobile-qty-input');
                var basePrice = parseFloat($qtyInput.data('price')) || 0;
                var qty = parseInt($qtyInput.val()) || 1;

                var totalPrice = basePrice * qty;

                $activePanel.find('.kwrk-mob-price-text').text(formatNumber(totalPrice));

                $('.mobile-fixed-bottom-action .totalPrice').text(formatNumber(totalPrice));
            }
        }

        $('.kwrk-mobile-tab-item').on('click', function() {
            var targetId = $(this).data('kwrktarget');

            $('.kwrk-mobile-tab-item').removeClass('active');
            $(this).addClass('active');

            $('.kwrk-mob-panel-block').hide();
            $('#' + targetId).show();

            updateMobileFixedBottomPrice();
        });

        $(document).on('input change keyup', '.kwrk-mobile-qty-input', function() {
            if ($(this).val() < 1) {
                $(this).val(1);
            }
            updateMobileFixedBottomPrice();
        });

        $(document).on('click', '.js-mobile-fixed-order-trigger', function(e) {
            e.preventDefault();

            var $activeForm = $('.kwrk-mob-panel-block:visible').find('form');

            if ($activeForm.length) {
                $activeForm.submit();
            }
        });

        updateMobileFixedBottomPrice();
    });
</script>

<style>
    .kwork-card-wrapper {
        border: 1px solid #dadbdd;
        border-radius: 6px;
        background: #fff;
        overflow: hidden;
        transition: all 0.2s ease-in-out;
    }

    .kwork-card-header {
        padding: 14px 20px;
        background: #fff;
        cursor: pointer;
        user-select: none;
    }

    .kwork-card-header .currency-symbol {
        font-size: 20px;
        font-weight: 700;
        color: #3c88ee;
    }

    .kwork-card-header .package-name {
        font-size: 15px;
        font-weight: 600;
        color: #2d3748;
    }

    .kwork-card-header .accordion-arrow {
        font-size: 16px;
        color: #a0aec0;
        transition: transform 0.2s;
    }

    .kwork-card-body {
        padding: 0 20px 20px 20px;
        border-top: 1px solid #f0f0f0;
        background: #fafafa;
    }

    .kwork-card-wrapper.active {
        border-color: #3c88ee;
        box-shadow: 0 4px 12px rgba(60, 136, 238, 0.06);
    }

    .kwork-card-wrapper.active .kwork-card-header {
        background: #fafafa;
        border-bottom: none;
    }

    .kwork-card-wrapper.active .accordion-arrow {
        transform: rotate(180deg);
        color: #3c88ee;
    }

    .package-title-badge {
        font-size: 14px;
        font-weight: 600;
        color: #4a5568;
        padding-top: 15px;
    }

    .package-desc {
        font-size: 13.5px;
        color: #62646a;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .delivery-revision-row {
        font-size: 13px;
        color: #74767e;
        font-weight: 600;
    }

    .delivery-revision-row i {
        font-size: 15px;
        color: #999;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
    }

    .feature-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13.5px;
        color: #404145;
        margin-bottom: 8px;
    }

    .feature-list li.disabled {
        color: #b5b6ba;
        text-decoration: line-through;
        opacity: 0.65;
    }

    .feature-list .check-icon {
        color: #3c88ee;
        font-size: 15px;
        font-weight: bold;
    }

    .feature-list .cross-icon {
        color: #b5b6ba;
        font-size: 14px;
    }

    .qty-counter {
        display: flex;
        align-items: center;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        background: #fff;
        height: 30px;
    }

    .qty-counter button {
        border: none;
        background: transparent;
        width: 30px;
        height: 100%;
        color: #718096;
        outline: none;
    }

    .qty-counter .pkgQuantityDisplay {
        width: 30px;
        text-align: center;
        font-weight: 600;
        font-size: 13px;
    }

    .qty-label {
        font-size: 13px;
        font-weight: 600;
        color: #62646a;
    }

    .kwork-order-btn {
        width: 100%;
        background-color: #3c88ee;
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        padding: 12px 20px;
        border-radius: 4px;
        border: none;
        transition: background 0.15s ease;
        outline: none;
    }

    .kwork-order-btn:hover {
        background-color: #2a75d3;
    }

    @media (min-width: 768px) {
        .kwrk-desktop-only {
            display: flex !important;
        }

        .kwrk-mobile-package-view {
            display: none !important;
        }
    }

    @media (max-width: 767.98px) {
        .kwrk-desktop-only {
            display: none !important;
        }

        .kwrk-mobile-package-view {
            display: block !important;
            background: #ffffff !important;
            border: 1px solid #e4e6e9 !important;
            border-radius: 4px !important;
            overflow: hidden !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
            margin-bottom: 20px !important;
        }

        .kwrk-mobile-tabs-grid {
            display: flex !important;
            width: 100% !important;
            background-color: #f7f7f7 !important;
            border-bottom: 1px solid #e4e6e9 !important;
        }

        .kwrk-mobile-tab-item {
            flex: 1 !important;
            text-align: center !important;
            padding: 10px 5px !important;
            cursor: pointer !important;
            color: #74767e !important;
            border-bottom: 3px solid transparent !important;
            transition: all 0.15s ease !important;
        }

        .kwrk-mobile-tab-item .label {
            font-size: 13px !important;
            font-weight: 500 !important;
            margin-bottom: 2px !important;
        }

        .kwrk-mobile-tab-item .price {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #404145 !important;
        }

        .kwrk-mobile-tab-item.active {
            border-bottom-color: #3c88ee !important;
            background-color: #ffffff !important;
        }

        .kwrk-mobile-tab-item.active .price {
            color: #3c88ee !important;
        }

        .kwrk-mobile-tab-content-container {
            padding: 15px !important;
        }

        .mob-pkg-title {
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #404145 !important;
            margin: 0 0 8px 0 !important;
        }

        .mob-pkg-desc {
            font-size: 13px !important;
            color: #74767e !important;
            line-height: 1.4 !important;
            margin-bottom: 15px !important;
        }

        .mob-feature-ul {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 0 15px 0 !important;
        }

        .mob-feature-ul li {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            font-size: 13.5px !important;
            color: #404145 !important;
            padding: 10px 0 !important;
            border-bottom: 1px solid #efeff0 !important;
        }

        .mob-feature-ul li.disabled span {
            color: #b5b6ba !important;
        }

        .mob-feature-ul li i {
            font-size: 16px !important;
            font-weight: bold !important;
        }

        .mob-feature-ul li i.text-success {
            color: #3c88ee !important;
        }

        .mob-feature-ul li i.text-muted {
            color: #cbd5e1 !important;
        }

        .mob-feature-ul li.mob-custom-row {
            border-bottom: none !important;
        }

        .mob-feature-ul li.mob-custom-row strong {
            color: #404145 !important;
            font-weight: 600 !important;
        }

        .mob-qty-row {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            margin-bottom: 15px !important;
            padding: 12px 0 !important;
            border-top: 1px solid #efeff0 !important;
        }

        .mob-qty-row .qty-text {
            font-size: 13.5px !important;
            color: #404145 !important;
        }

        .kwrk-mobile-qty-input {
            width: 80px !important;
            height: 32px !important;
            text-align: center !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            border: 1px solid #b5b6ba !important;
            border-radius: 3px !important;
            padding: 0 !important;
        }

        .kwork-mob-submit-btn {
            width: 100% !important;
            background-color: #3c88ee !important;
            border: 1px solid #3c88ee !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            height: 40px !important;
            border-radius: 4px !important;
            transition: background 0.15s ease !important;
        }
    }
</style>

@push('script')
    <script>
        (function($) {
            "use strict";

            $(document).on('click', '.kwrk-mobile-tab-item', function(e) {
                e.preventDefault();

                $('.kwrk-mobile-tab-item').removeClass('active');
                $(this).addClass('active');

                $('.kwrk-mob-panel-block').hide();

                let kwrkTarget = $(this).attr('data-kwrktarget');
                let activePanel = $('#' + kwrkTarget);
                activePanel.show();

                let inputField = activePanel.find('.kwrk-mobile-qty-input');
                inputField.val(1);
                let basePrice = parseFloat(inputField.data('price')) || 0;
                activePanel.find('.kwrk-mob-price-text').text(basePrice.toLocaleString('en-US'));
            });

            $(document).on('input change', '.kwrk-mobile-qty-input', function() {
                let qty = parseInt($(this).val()) || 1;
                if (qty < 1) {
                    qty = 1;
                    $(this).val(1);
                }

                let basePrice = parseFloat($(this).data('price')) || 0;
                let finalTotal = basePrice * qty;

                $(this).closest('form').find('.kwrk-mob-price-text').text(finalTotal.toLocaleString('en-US'));
            });

            var packagePrices = {
                basic: parseFloat("{{ $basicPkg->price ?? 0 }}"),
                standard: parseFloat("{{ $standardPkg->price ?? 0 }}"),
                premium: parseFloat("{{ $premiumPkg->price ?? 0 }}")
            };

            function calculateCardPrice(wrapper) {
                let pkgType = wrapper.data('package');
                let basePrice = packagePrices[pkgType] || 0;
                let qty = parseInt(wrapper.find('.service_qty_hidden').val()) || 1;
                let finalPrice = basePrice * qty;
                wrapper.find('.finalTotalPriceDisplay').text(finalPrice.toLocaleString('en-US'));
            }

            $(document).on('click', '.kwork-card-header', function(e) {
                if ($(e.target).closest('.order-action-area').length) return;
                let parentCard = $(this).closest('.kwork-card-wrapper');
                if (parentCard.hasClass('active')) return;

                $('.kwork-card-body').slideUp(200);
                $('.kwork-card-wrapper').removeClass('active');

                parentCard.addClass('active');
                parentCard.find('.kwork-card-body').slideDown(200);

                parentCard.find('.service_qty_hidden').val(1);
                parentCard.find('.pkgQuantityDisplay').text('1');
                calculateCardPrice(parentCard);
            });

            $(document).on('click', '.pkgIncrementBtn', function(e) {
                e.preventDefault();
                let parentCard = $(this).closest('.kwork-card-wrapper');
                let qtyInput = parentCard.find('.service_qty_hidden');
                let qtyDisplay = parentCard.find('.pkgQuantityDisplay');
                let currentQty = parseInt(qtyInput.val()) || 1;
                currentQty++;
                qtyInput.val(currentQty);
                qtyDisplay.text(currentQty);
                calculateCardPrice(parentCard);
            });

            $(document).on('click', '.pkgDecrementBtn', function(e) {
                e.preventDefault();
                let parentCard = $(this).closest('.kwork-card-wrapper');
                let qtyInput = parentCard.find('.service_qty_hidden');
                let qtyDisplay = parentCard.find('.pkgQuantityDisplay');
                let currentQty = parseInt(qtyInput.val()) || 1;
                if (currentQty > 1) {
                    currentQty--;
                    qtyInput.val(currentQty);
                    qtyDisplay.text(currentQty);
                    calculateCardPrice(parentCard);
                }
            });

            $('.kwork-card-wrapper.active').each(function() {
                calculateCardPrice($(this));
            });

        })(jQuery);
    </script>
@endpush
