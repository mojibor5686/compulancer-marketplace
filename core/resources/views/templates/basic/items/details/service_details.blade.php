<div class="jss-details-sidebar__block"
    style="border: 1px solid #dadbdd; border-radius: 8px; overflow: hidden; background: #fff;">
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

    <div class="d-flex text-center gig-package-tabs" style="background: #f5f5f5; border-bottom: 1px solid #dadbdd;">
        <button type="button" class="flex-grow-1 py-3 fw-bold pkg-tab-btn active" data-target="basic"
            style="border: none; background: transparent; font-size: 14px; color: #777; transition: all 0.2s;">
            @lang('Basic')
        </button>
        <button type="button" class="flex-grow-1 py-3 fw-bold pkg-tab-btn" data-target="standard"
            style="border: none; background: transparent; font-size: 14px; color: #777; transition: all 0.2s; border-left: 1px solid #dadbdd; border-right: 1px solid #dadbdd;">
            @lang('Standard')
        </button>
        <button type="button" class="flex-grow-1 py-3 fw-bold pkg-tab-btn" data-target="premium"
            style="border: none; background: transparent; font-size: 14px; color: #777; transition: all 0.2s;">
            @lang('Premium')
        </button>
    </div>

    <form id="mainOrderForm" action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST">
        @csrf
        <input type="hidden" name="package_type" id="selectedPackageType" value="basic">
        <input type="hidden" name="package_id" id="selectedPackageId" value="{{ $basicPkg->id ?? '' }}">
        <div class="extra_services_container"></div>

        <div class="widget-card-modern"
            style="padding: 24px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">

            <div class="package-content-block" id="pkg_basic">
                <div class="d-flex justify-content-between align-items-baseline mb-3">
                    <span style="font-size: 28px; font-weight: 700; color: #2d3748;">
                        &#2547;<span class="base-price">{{ number_format($basicPkg->price ?? 0, 0, '.', '') }}</span>
                    </span>
                    <span
                        style="font-size: 14px; font-weight: 600; color: #1dbf73; background: #e8faf0; padding: 4px 10px; border-radius: 4px;">{{ $basicPkg->package_title ?? 'Basic Plan' }}</span>
                </div>
                <p style="font-size: 14px; color: #62646a; line-height: 1.4; margin-bottom: 20px;">
                    {{ $basicPkg->package_description ?? '' }}</p>

                <div class="d-flex align-items-center gap-3 mb-4"
                    style="font-size: 14px; color: #62646a; font-weight: 600;">
                    <div><i class="lar la-clock" style="font-size: 16px; margin-right: 5px;"></i>
                        {{ $basicPkg->delivery_time ?? '1' }}-Day Delivery</div>
                    <div><i class="las la-sync" style="font-size: 16px; margin-right: 5px;"></i> Unlimited Revisions
                    </div>
                </div>

                <ul class="feature-check-list"
                    style="list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 14px; color: #4a5568;">
                    @foreach ($basicFeatures as $featureName => $isAvailable)
                        <li class="d-flex align-items-center gap-2 mb-2.5"
                            style="{{ $isAvailable == 'no' ? 'color: #bcbebf; text-decoration: line-through; opacity: 0.6;' : '' }}">
                            @if ($isAvailable == 'yes')
                                <i class="las la-check" style="color: #1dbf73; font-size: 16px; font-weight: bold;"></i>
                            @else
                                <i class="las la-times" style="color: #bcbebf; font-size: 16px;"></i>
                            @endif
                            <span>{{ $featureName }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="package-content-block d-none" id="pkg_standard">
                <div class="d-flex justify-content-between align-items-baseline mb-3">
                    <span style="font-size: 28px; font-weight: 700; color: #2d3748;">
                        &#2547;<span class="base-price">{{ number_format($standardPkg->price ?? 0, 0, '.', '') }}</span>
                    </span>
                    <span
                        style="font-size: 14px; font-weight: 600; color: #1dbf73; background: #e8faf0; padding: 4px 10px; border-radius: 4px;">{{ $standardPkg->package_title ?? 'Standard Plan' }}</span>
                </div>
                <p style="font-size: 14px; color: #62646a; line-height: 1.4; margin-bottom: 20px;">
                    {{ $standardPkg->package_description ?? '' }}</p>

                <div class="d-flex align-items-center gap-3 mb-4"
                    style="font-size: 14px; color: #62646a; font-weight: 600;">
                    <div><i class="lar la-clock" style="font-size: 16px; margin-right: 5px;"></i>
                        {{ $standardPkg->delivery_time ?? '3' }}-Day Delivery</div>
                    <div><i class="las la-sync" style="font-size: 16px; margin-right: 5px;"></i> Unlimited Revisions
                    </div>
                </div>

                <ul class="feature-check-list"
                    style="list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 14px; color: #4a5568;">
                    @foreach ($standardFeatures as $featureName => $isAvailable)
                        <li class="d-flex align-items-center gap-2 mb-2.5"
                            style="{{ $isAvailable == 'no' ? 'color: #bcbebf; text-decoration: line-through; opacity: 0.6;' : '' }}">
                            @if ($isAvailable == 'yes')
                                <i class="las la-check" style="color: #1dbf73; font-size: 16px; font-weight: bold;"></i>
                            @else
                                <i class="las la-times" style="color: #bcbebf; font-size: 16px;"></i>
                            @endif
                            <span>{{ $featureName }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="package-content-block d-none" id="pkg_premium">
                <div class="d-flex justify-content-between align-items-baseline mb-3">
                    <span style="font-size: 28px; font-weight: 700; color: #2d3748;">
                        &#2547;<span class="base-price">{{ number_format($premiumPkg->price ?? 0, 0, '.', '') }}</span>
                    </span>
                    <span
                        style="font-size: 14px; font-weight: 600; color: #1dbf73; background: #e8faf0; padding: 4px 10px; border-radius: 4px;">{{ $premiumPkg->package_title ?? 'Premium Plan' }}</span>
                </div>
                <p style="font-size: 14px; color: #62646a; line-height: 1.4; margin-bottom: 20px;">
                    {{ $premiumPkg->package_description ?? '' }}</p>

                <div class="d-flex align-items-center gap-3 mb-4"
                    style="font-size: 14px; color: #62646a; font-weight: 600;">
                    <div><i class="lar la-clock" style="font-size: 16px; margin-right: 5px;"></i>
                        {{ $premiumPkg->delivery_time ?? '5' }}-Day Delivery</div>
                    <div><i class="las la-sync" style="font-size: 16px; margin-right: 5px;"></i> Unlimited Revisions
                    </div>
                </div>

                <ul class="feature-check-list"
                    style="list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 14px; color: #4a5568;">
                    @foreach ($premiumFeatures as $featureName => $isAvailable)
                        <li class="d-flex align-items-center gap-2 mb-2.5"
                            style="{{ $isAvailable == 'no' ? 'color: #bcbebf; text-decoration: line-through; opacity: 0.6;' : '' }}">
                            @if ($isAvailable == 'yes')
                                <i class="las la-check" style="color: #1dbf73; font-size: 16px; font-weight: bold;"></i>
                            @else
                                <i class="las la-times" style="color: #bcbebf; font-size: 16px;"></i>
                            @endif
                            <span>{{ $featureName }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <hr style="border-color: #e2e8f0; margin: 20px 0;">

            <div class="d-flex align-items-center justify-content-between mb-4"
                style="font-size: 14px; color: #4a5568;">
                <span class="fw-bold"><i class="las la-cubes" style="color: #718096; font-size: 16px;"></i>
                    @lang('Quantity')</span>
                <div class="quantity-control-modern"
                    style="display: flex; align-items: center; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; background: #f7fafc; height: 32px;">
                    <button type="button" class="pkgDecrementBtn"
                        style="border: none; background: transparent; width: 32px; height: 100%; display: flex; align-items: center; justify-content: center; color: #718096; outline: none;"><i
                            class="las la-minus" style="font-size: 12px;"></i></button>
                    <span class="pkgQuantityDisplay"
                        style="width: 36px; text-align: center; font-weight: 600; color: #2d3748;">1</span>
                    <button type="button" class="pkgIncrementBtn"
                        style="border: none; background: transparent; width: 32px; height: 100%; display: flex; align-items: center; justify-content: center; color: #718096; outline: none;"><i
                            class="las la-plus" style="font-size: 12px;"></i></button>
                    <input type="hidden" name="service_qty" id="service_qty_input" value="1">
                </div>
            </div>

            @if ($extraServices && $extraServices->count() > 0)
                <div class="mb-4">
                    <h6
                        style="font-size: 14px; font-weight: 600; color: #2d3748; margin-bottom: 12px; letter-spacing: 0.3px;">
                        @lang('Upgrade order with extras:')</h6>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @foreach ($extraServices as $key => $extraService)
                            <label class="marketplace-extra-card" for="extra_service_{{ $key }}"
                                style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 6px; cursor: pointer; margin: 0; transition: background 0.2s;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <input class="pkgExtraServicesCheckbox" type="checkbox" name="extra_services[]"
                                        id="extra_service_{{ $key }}"
                                        data-price="{{ number_format($extraService->price, 0, '.', '') }}"
                                        value="{{ $extraService->id }}"
                                        style="width: 18px; height: 18px; accent-color: #1dbf73; cursor: pointer;">
                                    <span
                                        style="font-size: 14px; color: #4a5568; font-weight: 500;">{{ $extraService->name }}</span>
                                </div>
                                <div style="font-size: 14px; font-weight: 600; color: #2d3748;">
                                    &#2547;{{ number_format($extraService->price, 0) }}</div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="w-100 mt-2">
                @auth
                    <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center"
                        style="background-color: #1dbf73; color: #ffffff; font-weight: 700; font-size: 16px; padding: 14px 20px; border-radius: 6px; border: none; transition: background 0.2s; outline: none;">
                        @lang('Order for') &nbsp;&#2547;<span class="finalTotalPriceDisplay">0</span>
                    </button>
                @else
                    <button type="button" class="btn w-100 d-flex align-items-center justify-content-center"
                        data-bs-toggle="modal" data-bs-target="#signInModal"
                        style="background-color: #1dbf73; color: #ffffff; font-weight: 700; font-size: 16px; padding: 14px 20px; border-radius: 6px; border: none; transition: background 0.2s; outline: none;">
                        @lang('Order for') &nbsp;&#2547;<span class="finalTotalPriceDisplay">0</span>
                    </button>
                @endauth
            </div>

        </div>
    </form>
</div>

<style>
    .pkg-tab-btn.active {
        background: #ffffff !important;
        color: #1dbf73 !important;
        border-top: 3px solid #1dbf73 !important;
    }

    .pkg-tab-btn:not(.active):hover {
        background: #eaeaea !important;
        color: #333;
    }

    .marketplace-extra-card:hover {
        background: #fcfcfc;
        border-color: #cbd5e0 !important;
    }
</style>

@push('script')
    <script>
        (function($) {
            "use strict";

            var packageIds = {
                basic: "{{ $basicPkg->id ?? '' }}",
                standard: "{{ $standardPkg->id ?? '' }}",
                premium: "{{ $premiumPkg->id ?? '' }}"
            };

            function calculateTotalOrderPrice() {
                let activeTab = $('#selectedPackageType').val();
                let container = $('#pkg_' + activeTab);

                let basePrice = parseFloat(container.find('.base-price').text().replace(/,/g, '')) || 0;

                let qty = parseInt($('.pkgQuantityDisplay').text()) || 1;

                let extraTotal = 0;
                $('.pkgExtraServicesCheckbox:checked').each(function() {
                    extraTotal += parseFloat($(this).data('price')) || 0;
                });

                let finalPrice = (basePrice * qty) + extraTotal;

                $('.finalTotalPriceDisplay').text(finalPrice.toLocaleString('en-US'));
            }

            $('.pkg-tab-btn').on('click', function() {
                $('.pkg-tab-btn').removeClass('active');
                $(this).addClass('active');

                let targetPkg = $(this).data('target');

                $('#selectedPackageType').val(targetPkg);
                $('#selectedPackageId').val(packageIds[targetPkg]);

                $('.package-content-block').addClass('d-none');
                $('#pkg_' + targetPkg).removeClass('d-none');

                calculateTotalOrderPrice();
            });

            $('.pkgIncrementBtn').on('click', function() {
                let currentQty = parseInt($('.pkgQuantityDisplay').text()) || 1;
                currentQty++;
                $('.pkgQuantityDisplay').text(currentQty);
                $('#service_qty_input').val(currentQty);
                calculateTotalOrderPrice();
            });

            $('.pkgDecrementBtn').on('click', function() {
                let currentQty = parseInt($('.pkgQuantityDisplay').text()) || 1;
                if (currentQty > 1) {
                    currentQty--;
                    $('.pkgQuantityDisplay').text(currentQty);
                    $('#service_qty_input').val(currentQty);
                    calculateTotalOrderPrice();
                }
            });

            $(document).on('change', '.pkgExtraServicesCheckbox', function() {
                calculateTotalOrderPrice();
            });

            calculateTotalOrderPrice();

        })(jQuery);
    </script>
@endpush
