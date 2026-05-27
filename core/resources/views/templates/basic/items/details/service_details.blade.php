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

    <form id="mainOrderForm" action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST">
        @csrf
        <input type="hidden" name="package_type" id="selectedPackageType" value="basic">
        <input type="hidden" name="package_id" id="selectedPackageId" value="{{ $basicPkg->id ?? '' }}">
        <div class="extra_services_container"></div>
        <input type="hidden" value="{{ $productDetails->id }}" name="service_id">

        <div class="kwork-packages-accordion d-flex flex-column gap-3"
            style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">

            @if ($basicPkg)
                <div class="kwork-card-wrapper active" data-package="basic" data-id="{{ $basicPkg->id }}">
                    <div class="kwork-card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <span class="currency-symbol">&#2547;{{ number_format($basicPkg->price ?? 0, 0) }}</span>
                            <span class="package-name">@lang('Basic')</span>
                        </div>
                        <i class="las la-angle-down accordion-arrow"></i>
                    </div>

                    <div class="kwork-card-body">
                        <div class="package-title-badge mb-2">{{ $basicPkg->package_title ?? 'Basic Plan' }}</div>
                        <p class="package-desc">{{ $basicPkg->package_description ?? '' }}</p>

                        <div class="d-flex align-items-center gap-3 mb-3 delivery-revision-row">
                            <div><i class="lar la-clock"></i> {{ $basicPkg->delivery_time ?? '1' }}-Day Delivery</div>
                            <div><i class="las la-sync"></i> Unlimited Revisions</div>
                        </div>

                        <ul class="feature-list">
                            @foreach ($basicFeatures as $featureName => $isAvailable)
                                <li class="{{ $isAvailable == 'no' ? 'disabled' : '' }}">
                                    @if ($isAvailable == 'yes')
                                        <i class="las la-check check-icon"></i>
                                    @else
                                        <i class="las la-times cross-icon"></i>
                                    @endif
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
                    </div>
                </div>
            @endif

            @if ($standardPkg)
                <div class="kwork-card-wrapper" data-package="standard" data-id="{{ $standardPkg->id }}">
                    <div class="kwork-card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <span
                                class="currency-symbol">&#2547;{{ number_format($standardPkg->price ?? 0, 0) }}</span>
                            <span class="package-name">@lang('Standard')</span>
                        </div>
                        <i class="las la-angle-down accordion-arrow"></i>
                    </div>

                    <div class="kwork-card-body" style="display: none;">
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
                                    @if ($isAvailable == 'yes')
                                        <i class="las la-check check-icon"></i>
                                    @else
                                        <i class="las la-times cross-icon"></i>
                                    @endif
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
                    </div>
                </div>
            @endif

            @if ($premiumPkg)
                <div class="kwork-card-wrapper" data-package="premium" data-id="{{ $premiumPkg->id }}">
                    <div class="kwork-card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <span
                                class="currency-symbol">&#2547;{{ number_format($premiumPkg->price ?? 0, 0) }}</span>
                            <span class="package-name">@lang('Premium')</span>
                        </div>
                        <i class="las la-angle-down accordion-arrow"></i>
                    </div>

                    <div class="kwork-card-body" style="display: none;">
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
                                    @if ($isAvailable == 'yes')
                                        <i class="las la-check check-icon"></i>
                                    @else
                                        <i class="las la-times cross-icon"></i>
                                    @endif
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
                    </div>
                </div>
            @endif

            <input type="hidden" name="service_qty" id="service_qty_input" value="1">

        </div>
    </form>
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

    /* Active Card UI State Update */
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

    /* Inner Typography */
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

    /* Checklist Grid UI */
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

    /* Quantity Panel Box */
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

    /* Global Order Button Clones */
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
        background-color: #3c88ee;
    }

    .marketplace-extra-card:hover {
        background: #fdfdfd;
        border-color: #cbd5e0 !important;
    }
</style>
@push('script')
    <script>
        (function($) {
            "use strict";

            // ১. মেইন ক্যালকুলেটর ফাংশন
            function calculateTotalOrderPrice() {
                // বর্তমানে একটিভ থাকা প্যাকেজ কন্টেইনার ধরা হচ্ছে
                let activeCard = $('.kwork-card-wrapper.active');
                if (activeCard.length === 0) return;

                let activeTab = activeCard.data('package');

                // ডাটাবেজ থেকে রেন্ডার করা প্যাকেজের প্রাইস নেওয়া
                let basePrice = 0;
                if (activeTab === 'basic') basePrice = parseFloat("{{ $basicPkg->price ?? 0 }}") || 0;
                if (activeTab === 'standard') basePrice = parseFloat("{{ $standardPkg->price ?? 0 }}") || 0;
                if (activeTab === 'premium') basePrice = parseFloat("{{ $premiumPkg->price ?? 0 }}") || 0;

                // মেইন গ্লোবাল কোয়ান্টিটি ইনপুট থেকে মান নেওয়া
                let qty = parseInt($('#service_qty_input').val()) || 1;

                // এক্সট্রা সার্ভিস সামেশন (যদি থাকে)
                let extraTotal = 0;
                $('.pkgExtraServicesCheckbox:checked').each(function() {
                    extraTotal += parseFloat($(this).data('price')) || 0;
                });

                // মোট সমীকরণ হিসাব: (প্যাকেজ দাম * কোয়ান্টিটি) + এক্সট্রা সার্ভিস দাম
                let finalPrice = (basePrice * qty) + extraTotal;

                // শুধুমাত্র কারেন্ট ওপেন থাকা কার্ডের ভেতরের বাটনে দাম আপডেট করা
                activeCard.find('.finalTotalPriceDisplay').text(finalPrice.toLocaleString('en-US'));
            }

            // ২. Kwork Accordion Header ক্লিক ইভেন্ট
            $('.kwork-card-header').on('click', function(e) {
                // যদি ভুলবশত কোয়ান্টিটি কাউন্টারে ক্লিক পড়ে তাহলে কোড রানিং অফ থাকবে
                if ($(e.target).closest('.order-action-area').length) return;

                let parentCard = $(this).closest('.kwork-card-wrapper');

                // অলরেডি একটিভ থাকলে ক্লোজ করার প্রয়োজন নেই
                if (parentCard.hasClass('active')) return;

                // বাকি সব প্যানেল স্লাইড আপ করে বন্ধ করা
                $('.kwork-card-body').slideUp(200);
                $('.kwork-card-wrapper').removeClass('active');

                // বর্তমানের সিলেক্টেড প্যানেলটি ওপেন করা
                parentCard.addClass('active');
                parentCard.find('.kwork-card-body').slideDown(200);

                // হিডেন ফর্মে ডাটা অ্যাসাইন করা
                let packageType = parentCard.data('package');
                let packageId = parentCard.data('id');

                $('#selectedPackageType').val(packageType);
                $('#selectedPackageId').val(packageId);

                // নতুন প্যানেল ওপেন করার সাথে সাথে গ্লোবাল কোয়ান্টিটি ইনপুট এবং ঐ কার্ডের ডিসপ্লে ১ এ রিসেট করা
                $('#service_qty_input').val(1);
                $('.pkgQuantityDisplay').text('1');

                // নতুন প্রাইস রি-ক্যালকুলেট করা
                calculateTotalOrderPrice();
            });

            // ৩. কোয়ান্টিটি ইনক্রিমেন্ট (+) বাটন (শুধুমাত্র কারেন্ট একটিভ কার্ডের জন্য)
            $(document).on('click', '.pkgIncrementBtn', function(e) {
                e.preventDefault();
                let activeCard = $(this).closest('.kwork-card-wrapper');
                let displaySpan = activeCard.find('.pkgQuantityDisplay');

                let currentQty = parseInt($('#service_qty_input').val()) || 1;
                currentQty++;

                // হিডেন ইনপুট এবং শুধুমাত্র এই কার্ডের টেক্সট ডিসপ্লে আপডেট
                $('#service_qty_input').val(currentQty);
                displaySpan.text(currentQty);

                calculateTotalOrderPrice();
            });

            // ৪. কোয়ান্টিটি ডিক্রিমেন্ট (-) বাটন (শুধুমাত্র কারেন্ট একটিভ কার্ডের জন্য)
            $(document).on('click', '.pkgDecrementBtn', function(e) {
                e.preventDefault();
                let activeCard = $(this).closest('.kwork-card-wrapper');
                let displaySpan = activeCard.find('.pkgQuantityDisplay');

                let currentQty = parseInt($('#service_qty_input').val()) || 1;
                if (currentQty > 1) {
                    currentQty--;

                    // হিডেন ইনপুট এবং শুধুমাত্র এই কার্ডের টেক্সট ডিসপ্লে আপডেট
                    $('#service_qty_input').val(currentQty);
                    displaySpan.text(currentQty);

                    calculateTotalOrderPrice();
                }
            });

            // ৫. এক্সট্রা সার্ভিস চেকবক্স টগল ইভেন্ট
            $(document).on('change', '.pkgExtraServicesCheckbox', function() {
                calculateTotalOrderPrice();
            });

            // ফার্স্ট টাইম ইনিশিয়াল পেজ লোড রান
            calculateTotalOrderPrice();

        })(jQuery);
    </script>
@endpush
