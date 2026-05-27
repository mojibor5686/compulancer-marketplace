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


    <div class="kwork-mobile-package-view d-md-none bg-white border rounded">
        <div class="mobile-tabs-grid d-flex border-bottom text-center">
            <div class="mobile-tab-item flex-fill active" data-target="mob-basic">
                <div class="label">@lang('Basic')</div>
                <div class="price">&#2547;{{ number_format($basicPkg->price ?? 0, 0) }}</div>
            </div>
            <div class="mobile-tab-item flex-fill" data-target="mob-standard">
                <div class="label">@lang('Standard')</div>
                <div class="price">&#2547;{{ number_format($standardPkg->price ?? 0, 0) }}</div>
            </div>
            <div class="mobile-tab-item flex-fill" data-target="mob-premium">
                <div class="label">@lang('Premium')</div>
                <div class="price">&#2547;{{ number_format($premiumPkg->price ?? 0, 0) }}</div>
            </div>
        </div>

        <div class="mobile-tab-content-wrapper p-3">
            <div class="mob-panel-block" id="mob-basic">
                <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="package_type" value="basic">
                    <input type="hidden" name="package_id" value="{{ $basicPkg->id ?? '' }}">
                    <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                    <h5 class="package-title font-weight-bold mb-2">@lang('Package Summary')</h5>
                    <p class="text-muted small mb-3">{{ $basicPkg->package_title ?? '' }} -
                        {{ $basicPkg->package_description ?? '' }}</p>

                    <ul class="feature-list-mobile mb-3">
                        @foreach ($basicFeatures as $featureName => $isAvailable)
                            <li
                                class="d-flex align-items-center justify-content-between py-1 border-bottom small {{ $isAvailable == 'no' ? 'text-muted opacity-50' : '' }}">
                                <span>{{ __($featureName) }}</span>
                                <i
                                    class="las {{ $isAvailable == 'yes' ? 'la-check text-success' : 'la-check text-muted opacity-25' }} fs-5"></i>
                            </li>
                        @endforeach
                        <li class="d-flex align-items-center justify-content-between py-1 border-bottom small">
                            <span>@lang('Delivery')</span>
                            <span class="font-weight-bold">{{ $basicPkg->delivery_time ?? '1' }}
                                @lang('days')</span>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small font-weight-bold">@lang('Number of words')</span>
                        <input type="number" name="service_qty" class="form-control mobile-qty-input-box"
                            data-price="{{ $basicPkg->price ?? 0 }}" value="1" min="1"
                            style="width: 75px; height: 32px; text-align: center;">
                    </div>

                    <div class="row gx-2">
                        <div class="col-10">
                            <button type="submit"
                                class="btn btn-success w-100 kwork-mob-submit-btn">@lang('Order for') &#2547;<span
                                    class="mob-price-text">{{ number_format($basicPkg->price ?? 0, 0) }}</span></button>
                        </div>
                        <div class="col-2">
                            <button type="button"
                                class="btn btn-outline-success w-100 p-0 d-flex align-items-center justify-content-center"
                                style="height: 42px;"><i class="las la-shopping-cart fs-5"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mob-panel-block d-none" id="mob-standard">
                <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="package_type" value="standard">
                    <input type="hidden" name="package_id" value="{{ $standardPkg->id ?? '' }}">
                    <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                    <h5 class="package-title font-weight-bold mb-2">@lang('Package Summary')</h5>
                    <p class="text-muted small mb-3">{{ $standardPkg->package_title ?? '' }} -
                        {{ $standardPkg->package_description ?? '' }}</p>

                    <ul class="feature-list-mobile mb-3">
                        @foreach ($standardFeatures as $featureName => $isAvailable)
                            <li
                                class="d-flex align-items-center justify-content-between py-1 border-bottom small {{ $isAvailable == 'no' ? 'text-muted opacity-50' : '' }}">
                                <span>{{ __($featureName) }}</span>
                                <i
                                    class="las {{ $isAvailable == 'yes' ? 'la-check text-success' : 'la-check text-muted opacity-25' }} fs-5"></i>
                            </li>
                        @endforeach
                        <li class="d-flex align-items-center justify-content-between py-1 border-bottom small">
                            <span>@lang('Delivery')</span>
                            <span class="font-weight-bold">{{ $standardPkg->delivery_time ?? '3' }}
                                @lang('days')</span>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small font-weight-bold">@lang('Number of words')</span>
                        <input type="number" name="service_qty" class="form-control mobile-qty-input-box"
                            data-price="{{ $standardPkg->price ?? 0 }}" value="1" min="1"
                            style="width: 75px; height: 32px; text-align: center;">
                    </div>

                    <div class="row gx-2">
                        <div class="col-10">
                            <button type="submit"
                                class="btn btn-success w-100 kwork-mob-submit-btn">@lang('Order for') &#2547;<span
                                    class="mob-price-text">{{ number_format($standardPkg->price ?? 0, 0) }}</span></button>
                        </div>
                        <div class="col-2">
                            <button type="button"
                                class="btn btn-outline-success w-100 p-0 d-flex align-items-center justify-content-center"
                                style="height: 42px;"><i class="las la-shopping-cart fs-5"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mob-panel-block d-none" id="mob-premium">
                <form action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="package_type" value="premium">
                    <input type="hidden" name="package_id" value="{{ $premiumPkg->id ?? '' }}">
                    <input type="hidden" name="service_id" value="{{ $productDetails->id }}">

                    <h5 class="package-title font-weight-bold mb-2">@lang('Package Summary')</h5>
                    <p class="text-muted small mb-3">{{ $premiumPkg->package_title ?? '' }} -
                        {{ $premiumPkg->package_description ?? '' }}</p>

                    <ul class="feature-list-mobile mb-3">
                        @foreach ($premiumFeatures as $featureName => $isAvailable)
                            <li
                                class="d-flex align-items-center justify-content-between py-1 border-bottom small {{ $isAvailable == 'no' ? 'text-muted opacity-50' : '' }}">
                                <span>{{ __($featureName) }}</span>
                                <i
                                    class="las {{ $isAvailable == 'yes' ? 'la-check text-success' : 'la-check text-muted opacity-25' }} fs-5"></i>
                            </li>
                        @endforeach
                        <li class="d-flex align-items-center justify-content-between py-1 border-bottom small">
                            <span>@lang('Delivery')</span>
                            <span class="font-weight-bold">{{ $premiumPkg->delivery_time ?? '5' }}
                                @lang('days')</span>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small font-weight-bold">@lang('Number of words')</span>
                        <input type="number" name="service_qty" class="form-control mobile-qty-input-box"
                            data-price="{{ $premiumPkg->price ?? 0 }}" value="1" min="1"
                            style="width: 75px; height: 32px; text-align: center;">
                    </div>

                    <div class="row gx-2">
                        <div class="col-10">
                            <button type="submit"
                                class="btn btn-success w-100 kwork-mob-submit-btn">@lang('Order for') &#2547;<span
                                    class="mob-price-text">{{ number_format($premiumPkg->price ?? 0, 0) }}</span></button>
                        </div>
                        <div class="col-2">
                            <button type="button"
                                class="btn btn-outline-success w-100 p-0 d-flex align-items-center justify-content-center"
                                style="height: 42px;"><i class="las la-shopping-cart fs-5"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* মোবাইল ট্যাব ডিজাইন */
    .mobile-tabs-grid {
        background-color: #fafafa;
    }

    .mobile-tab-item {
        padding: 10px 5px;
        cursor: pointer;
        color: #8c8c8c;
        border-bottom: 3px solid transparent;
        transition: all 0.2s ease;
    }

    .mobile-tab-item .label {
        font-size: 13px;
        font-weight: 600;
    }

    .mobile-tab-item .price {
        font-size: 15px;
        font-weight: 700;
    }

    .mobile-tab-item.active {
        color: #1dbf73;
        border-bottom-color: #1dbf73;
        background-color: #fff;
    }

    .feature-list-mobile {
        list-style: none;
        padding-left: 0;
    }

    .kwork-mob-submit-btn {
        background-color: #1dbf73 !important;
        border-color: #1dbf73 !important;
        font-weight: 700;
        height: 42px;
    }

    /* ডেস্কটপ সিএসএস এনহান্সমেন্ট */
    .table-qty-input-desktop {
        border: 1px solid #dadbdd;
        height: 34px;
        font-weight: bold;
    }
</style>

@push('script')
    <script>
        (function($) {
            "use strict";

            // ================== মোবাইলের জন্য ট্যাব চেঞ্জার লজিক ==================
            $('.mobile-tab-item').on('click', function() {
                $('.mobile-tab-item').removeClass('active');
                $(this).addClass('active');

                let targetPanel = $(this).data('target');
                $('.mob-panel-block').addClass('d-none');
                $('#' + targetPanel).removeClass('d-none');
            });

            // ================== মোবাইলের প্রাইস ও কোয়ান্টিটি রিয়েলটাইম ক্যালকুলেটর ==================
            $('.mobile-qty-input-box').on('input change', function() {
                let qty = parseInt($(this).val()) || 1;
                if (qty < 1) {
                    qty = 1;
                    $(this).val(1);
                }

                let basePrice = parseFloat($(this).data('price')) || 0;
                let finalTotal = basePrice * qty;

                // সংশ্লিষ্ট প্যানেলের বাটনের ভেতরের টেক্সট আপডেট
                $(this).closest('form').find('.mob-price-text').text(finalTotal.toLocaleString('en-US'));
            });


            // ================== ডেস্কটপ ভিউ ক্যালকুলেটর ও অ্যাকর্ডিয়ন স্লাইড লজিক ==================
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
