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

    <div class="kwork-packages-accordion d-flex flex-column gap-3"
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
</div>

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
</style>
@push('script')
    <script>
        (function($) {
            "use strict";

            // প্রতিটি প্যাকেজের স্ট্যাটিক বেইজ প্রাইস অবজেক্ট
            var packagePrices = {
                basic: parseFloat("{{ $basicPkg->price ?? 0 }}"),
                standard: parseFloat("{{ $standardPkg->price ?? 0 }}"),
                premium: parseFloat("{{ $premiumPkg->price ?? 0 }}")
            };

            // ১. সিঙ্গেল কার্ড প্রাইস ক্যালকুলেটর ফাংশন
            function calculateCardPrice(wrapper) {
                let pkgType = wrapper.data('package');
                let basePrice = packagePrices[pkgType] || 0;

                // শুধুমাত্র এই ফর্মের ভেতরের হিডেন ইনপুট থেকে কোয়ান্টিটি নেওয়া
                let qty = parseInt(wrapper.find('.service_qty_hidden').val()) || 1;

                // টোটাল ক্যালকুলেশন
                let finalPrice = basePrice * qty;

                // শুধুমাত্র এই ফর্মের ভেতরের বাটনের প্রাইস টেক্সট আপডেট
                wrapper.find('.finalTotalPriceDisplay').text(finalPrice.toLocaleString('en-US'));
            }

            // ২. Kwork Accordion Header স্লাইড ও টগল ইভেন্ট
            $('.kwork-card-header').on('click', function(e) {
                if ($(e.target).closest('.order-action-area').length) return;

                let parentCard = $(this).closest('.kwork-card-wrapper');
                if (parentCard.hasClass('active')) return;

                // বাকি সব ক্লোজ করা
                $('.kwork-card-body').slideUp(200);
                $('.kwork-card-wrapper').removeClass('active');

                // কারেন্ট প্যানেল ওপেন করা
                parentCard.addClass('active');
                parentCard.find('.kwork-card-body').slideDown(200);

                // ওপেন হওয়ার সময় এই ফর্মের কোয়ান্টিটি ইনপুট ১ এ রিসেট করা
                parentCard.find('.service_qty_hidden').val(1);
                parentCard.find('.pkgQuantityDisplay').text('1');

                calculateCardPrice(parentCard);
            });

            // ৩. প্লাস (+) বাটন ক্লিক ইভেন্ট
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

            // ৪. মাইনাস (-) বাটন ক্লিক ইভেন্ট
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

            // প্রথমবার পেজ লোড হওয়ার সময় একটিভ থাকা বেসিক কার্ডের প্রাইস ইনিশিয়ালাইজ করা
            $('.kwork-card-wrapper.active').each(function() {
                calculateCardPrice($(this));
            });

        })(jQuery);
    </script>
@endpush
