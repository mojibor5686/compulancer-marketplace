@extends('Template::layouts.frontend')
@section('content')
    <div class="mobile-fixed-bottom-action d-sm-none">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center gap-2 w-100">
                <a href="#" class="btn btn-chat-mobile d-flex align-items-center justify-content-center gap-2">
                    <i class="far fa-comment-dots"></i>
                    <span>@lang('Chat')</span>
                </a>
                <a href="#" class="btn btn-order-mobile flex-grow-1 text-center">
                    @lang('Order for')
                </a>
            </div>
        </div>
    </div>
    <style>
        .kwork-hero-section {
            display: none
        }

        @media (max-width: 575.98px) {
            body {
                padding-bottom: 75px !important;
            }

            .mobile-fixed-bottom-action {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                background-color: #ffffff;
                box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.08);
                padding: 12px 0;
                z-index: 9999;
            }

            .btn-chat-mobile {
                background-color: #0ba833 !important;
                color: #ffffff !important;
                font-size: 15px;
                font-weight: 600;
                padding: 12px 20px;
                border-radius: 8px;
                border: none;
                text-decoration: none;
                white-space: nowrap;
                transition: opacity 0.2s ease;
            }

            .btn-order-mobile {
                background-color: #007bff !important;
                color: #ffffff !important;
                font-size: 16px;
                font-weight: 600;
                padding: 12px 15px;
                border-radius: 8px;
                border: none;
                text-decoration: none;
                transition: opacity 0.2s ease;
            }

            .btn-chat-mobile:active,
            .btn-order-mobile:active {
                opacity: 0.9;
            }
        }

        @media (min-width: 576px) {
            .mobile-fixed-bottom-action {
                display: none !important;
            }
        }
    </style>
    <main class="page-wrapper">
        <section class="jss-details py-50">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-8 m-0">
                        <div class="jss-details-main bg--white">
                            <div class="kwork-detail-header"
                                style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                <nav class="kwork-breadcrumb d-flex align-items-center gap-2 mb-3 mt-3"
                                    style="font-size: 14px; color: #777777;">
                                    <a href="#"
                                        style="color: #777777; text-decoration: none; transition: color 0.2s;">{{ __(@$productDetails->category->name ?? 'Design') }}</a>
                                    <span style="font-size: 11px; color: #b5b5b5;"><i class="las la-angle-right"></i></span>
                                    <a href="#"
                                        style="color: #777777; text-decoration: none; transition: color 0.2s;">{{ __(@$productDetails->subCategory->name ?? 'Logo Design') }}</a>
                                    <span style="font-size: 11px; color: #b5b5b5;"><i class="las la-angle-right"></i></span>
                                </nav>

                                <div style="border: 1px solid #eee; padding: 10px; border-bottom: none;">
                                    <h1 class="kwork-gig-title mb-1 fs-3 fs-lg-1"
                                        style="font-weight: 700; color: #222222; line-height: 1.25; letter-spacing: -0.5px;">
                                        {{ __($productDetails->title ?? 'I will do unique, modern and professional business logo design') }}
                                    </h1>

                                    @php
                                        $mainAvgRating =
                                            $productDetails->total_review > 0
                                                ? number_format(
                                                    $productDetails->total_rating / $productDetails->total_review,
                                                    1,
                                                )
                                                : '0.0';
                                        $mainStars = round($mainAvgRating);
                                    @endphp

                                    <div class="kwork-gig-meta d-flex align-items-center flex-wrap justify-content-between">
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <div class="d-flex align-items-center gap-2 me-2">
                                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$productDetails->user->image, isAvatar: true) }}"
                                                    class="rounded-circle object-fit-cover" width="28" height="28"
                                                    alt="avatar">
                                                <a href="{{ route('public.profile', @$productDetails->user->username) }}"
                                                    style="font-size: 15px; font-weight: 600; color: #555555; text-decoration: none; transition: color 0.2s; text-transform: capitalize;"
                                                    onmouseover="this.style.color='#0073ec'"
                                                    onmouseout="this.style.color='#555555'">
                                                    {{ __(@$productDetails->user->username ?? 'Mobi_designs') }}
                                                </a>
                                            </div>

                                            <div class="d-flex align-items-center me-2">
                                                <div class="kwork-stars me-1"
                                                    style="color: #ff9800; font-size: 14px; letter-spacing: -1px;">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $mainStars)
                                                            <i class="las la-star"></i>
                                                        @else
                                                            <i class="lar la-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span
                                                    style="font-size: 14px; font-weight: 600; color: #ff4500;">{{ $mainAvgRating }}</span>
                                            </div>

                                            <div style="font-size: 14px; color: #777777;">
                                                <span style="color: #b5b5b5; margin-right: 5px;">•</span>
                                                <a href="#jss-details-tab-3" class="review-link-trigger"
                                                    style="color: #777777; text-decoration: underline;">
                                                    {{ $productDetails->total_review }} @lang('reviews')
                                                </a>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0">
                                            <button
                                                class="btn d-flex align-items-center gap-1 border rounded px-3 py-1.5 bg-white shadow-sm-hover"
                                                style="font-size: 14px; color: #555555; border-color: #e4e8eb !important; height: 36px;">
                                                <span
                                                    style="font-size: 14px; font-weight: 500; color: #222;">{{ $productDetails->favorite ?? 0 }}</span>
                                                <i class="lar la-heart" style="font-size: 16px; margin-left: 2px;"></i>
                                            </button>
                                            <button
                                                class="btn d-flex align-items-center justify-content-center border rounded bg-white shadow-sm-hover"
                                                style="border-color: #e4e8eb !important; width: 36px; height: 36px; color: #a9ae injection;">
                                                <i class="las la-exclamation-triangle"
                                                    style="font-size: 18px; color: #999;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @include('Template::items.details.banner', ['type' => 'service'])

                            <div class="jss-details-main__block two d-lg-none">
                            </div>

                            <div class="jss-details-main__block three">
                                @php
                                    $basicPkg = $productDetails->packages->where('package_type', 'basic')->first();
                                    $standardPkg = $productDetails->packages
                                        ->where('package_type', 'standard')
                                        ->first();
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

                                    $allFeatureNames = array_unique(
                                        array_merge(
                                            array_keys($basicFeatures),
                                            array_keys($standardFeatures),
                                            array_keys($premiumFeatures),
                                        ),
                                    );
                                @endphp

                                <div class="kwork-package-table-section mb-5 d-none d-lg-block">
                                    <h3 class="kwork-section-title mb-3">@lang('Select a Package')</h3>
                                    <div class="table-responsive">
                                        <table class="table kwork-package-compare-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 25%;"></th>
                                                    <th style="width: 25%; text-align: center;">@lang('BASIC')</th>
                                                    <th style="width: 25%; text-align: center;">@lang('STANDARD')</th>
                                                    <th style="width: 25%; text-align: center;">@lang('PREMIUM')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="row-package-summary">
                                                    <td class="feature-label-col">@lang('Package Summary')</td>
                                                    <td>
                                                        <div class="pkg-table-desc">{{ $basicPkg->package_title ?? '' }}
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ $basicPkg->package_description ?? '' }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="pkg-table-desc">{{ $standardPkg->package_title ?? '' }}
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ $standardPkg->package_description ?? '' }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="pkg-table-desc">{{ $premiumPkg->package_title ?? '' }}
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ $premiumPkg->package_description ?? '' }}</small>
                                                    </td>
                                                </tr>

                                                @foreach ($allFeatureNames as $featureName)
                                                    <tr>
                                                        <td class="feature-label-col">{{ __($featureName) }}</td>
                                                        <td class="text-center">
                                                            @if (isset($basicFeatures[$featureName]))
                                                                <i
                                                                    class="las {{ $basicFeatures[$featureName] == 'yes' ? 'la-check text--success' : 'la-minus text-muted' }} fs-18"></i>
                                                            @else
                                                                <i class="las la-minus text-muted fs-18"></i>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($standardFeatures[$featureName]))
                                                                <i
                                                                    class="las {{ $standardFeatures[$featureName] == 'yes' ? 'la-check text--success' : 'la-minus text-muted' }} fs-18"></i>
                                                            @else
                                                                <i class="las la-minus text-muted fs-18"></i>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($premiumFeatures[$featureName]))
                                                                <i
                                                                    class="las {{ $premiumFeatures[$featureName] == 'yes' ? 'la-check text--success' : 'la-minus text-muted' }} fs-18"></i>
                                                            @else
                                                                <i class="las la-minus text-muted fs-18"></i>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <td class="feature-label-col">@lang('Revisions')</td>
                                                    <td class="text-center">@lang('Unlimited')</td>
                                                    <td class="text-center">@lang('Unlimited')</td>
                                                    <td class="text-center">@lang('Unlimited')</td>
                                                </tr>

                                                <tr>
                                                    <td class="feature-label-col">@lang('Delivery')</td>
                                                    <td class="text-center">{{ $basicPkg->delivery_time ?? '1' }}
                                                        @lang('day')</td>
                                                    <td class="text-center">{{ $standardPkg->delivery_time ?? '3' }}
                                                        @lang('days')</td>
                                                    <td class="text-center">{{ $premiumPkg->delivery_time ?? '5' }}
                                                        @lang('days')</td>
                                                </tr>

                                                <tr class="row-quantity-inputs">
                                                    <td class="feature-label-col">@lang('Number of words / Qty')</td>
                                                    <td class="text-center">
                                                        @if ($basicPkg)
                                                            <div class="pkg-table-qty-box">
                                                                <input type="number" class="form-control table-qty-input"
                                                                    data-package="basic" value="1" min="1">
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($standardPkg)
                                                            <div class="pkg-table-qty-box">
                                                                <input type="number" class="form-control table-qty-input"
                                                                    data-package="standard" value="1"
                                                                    min="1">
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($premiumPkg)
                                                            <div class="pkg-table-qty-box">
                                                                <input type="number" class="form-control table-qty-input"
                                                                    data-package="premium" value="1" min="1">
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <tr class="row-action-forms">
                                                    <td class="feature-label-col"></td>

                                                    <td class="text-center">
                                                        @if ($basicPkg)
                                                            <form
                                                                action="{{ route('user.service.add.booking', $productDetails->id) }}"
                                                                method="POST" class="table-package-form">
                                                                @csrf
                                                                <input type="hidden" name="package_type" value="basic">
                                                                <input type="hidden" name="package_id"
                                                                    value="{{ $basicPkg->id }}">
                                                                <input type="hidden" name="service_id"
                                                                    value="{{ $productDetails->id }}">
                                                                <input type="hidden" name="service_qty"
                                                                    class="form-qty-hidden-basic" value="1">

                                                                <div class="pkg-table-price mb-2">&#2547;<span
                                                                        class="total-price-display-basic">{{ number_format($basicPkg->price ?? 0, 0) }}</span>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-success w-100 btn-sm kwork-table-order-btn">@lang('Order')</button>
                                                            </form>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if ($standardPkg)
                                                            <form
                                                                action="{{ route('user.service.add.booking', $productDetails->id) }}"
                                                                method="POST" class="table-package-form">
                                                                @csrf
                                                                <input type="hidden" name="package_type"
                                                                    value="standard">
                                                                <input type="hidden" name="package_id"
                                                                    value="{{ $standardPkg->id }}">
                                                                <input type="hidden" name="service_id"
                                                                    value="{{ $productDetails->id }}">
                                                                <input type="hidden" name="service_qty"
                                                                    class="form-qty-hidden-standard" value="1">

                                                                <div class="pkg-table-price mb-2">&#2547;<span
                                                                        class="total-price-display-standard">{{ number_format($standardPkg->price ?? 0, 0) }}</span>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-success w-100 btn-sm kwork-table-order-btn">@lang('Order')</button>
                                                            </form>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if ($premiumPkg)
                                                            <form
                                                                action="{{ route('user.service.add.booking', $productDetails->id) }}"
                                                                method="POST" class="table-package-form">
                                                                @csrf
                                                                <input type="hidden" name="package_type"
                                                                    value="premium">
                                                                <input type="hidden" name="package_id"
                                                                    value="{{ $premiumPkg->id }}">
                                                                <input type="hidden" name="service_id"
                                                                    value="{{ $productDetails->id }}">
                                                                <input type="hidden" name="service_qty"
                                                                    class="form-qty-hidden-premium" value="1">

                                                                <div class="pkg-table-price mb-2">&#2547;<span
                                                                        class="total-price-display-premium">{{ number_format($premiumPkg->price ?? 0, 0) }}</span>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-success w-100 btn-sm kwork-table-order-btn">@lang('Order')</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="kwork-description-section mb-5">
                                    <h3 class="kwork-section-title mb-3">@lang('Kwork Overview')</h3>
                                    <div class="kwork-real-description-body p-3 bg-white border rounded">
                                        @include('Template::items.details.description', [
                                            'type' => 'service',
                                        ])
                                    </div>
                                </div>

                                <div class="kwork-reviews-section">
                                    <h3 class="kwork-section-title mb-3">@lang('Reviews')</h3>
                                    <div class="kwork-real-reviews-body p-3 bg-white border rounded">
                                        @include('Template::items.details.reviews', ['type' => 'service'])
                                    </div>
                                </div>
                            </div>

                            <style>
                                .kwork-section-title {
                                    font-size: 20px;
                                    font-weight: 700;
                                    color: #2d3748;
                                }

                                .kwork-package-compare-table {
                                    background: #fff;
                                    border: 1px solid #e2e8f0;
                                    border-collapse: collapse;
                                    width: 100%;
                                }

                                .kwork-package-compare-table th {
                                    background: #f7fafc;
                                    color: #4a5568;
                                    font-weight: 700;
                                    padding: 12px;
                                    border: 1px solid #e2e8f0;
                                }

                                .kwork-package-compare-table td {
                                    padding: 12px;
                                    border: 1px solid #e2e8f0;
                                    vertical-align: top;
                                    font-size: 14px;
                                    color: #4a5568;
                                }

                                .kwork-package-compare-table .feature-label-col {
                                    font-weight: 600;
                                    background: #fcfdfd;
                                    color: #404145;
                                }

                                .pkg-table-desc {
                                    font-weight: 600;
                                    color: #2d3748;
                                    margin-bottom: 4px;
                                }

                                .table-qty-input {
                                    width: 90px;
                                    margin: 0 auto;
                                    height: 32px;
                                    text-align: center;
                                    font-weight: 600;
                                }

                                .pkg-table-price {
                                    font-size: 18px;
                                    font-weight: 700;
                                    color: #3c88ee;
                                }

                                .kwork-table-order-btn {
                                    background-color: #3c88ee !important;
                                    border-color: #3c88ee !important;
                                    font-weight: 700;
                                    padding: 6px 20px;
                                }

                                .kwork-table-order-btn:hover {
                                    background-color: #3c88ee !important;
                                }

                                .text--success {
                                    color: #3c88ee;
                                }

                                .fs-18 {
                                    font-size: 18px;
                                }
                            </style>
                        </div>
                    </div>

                    @push('script')
                        <script>
                            (function($) {
                                "use strict";

                                var basePrices = {
                                    basic: parseFloat("{{ $basicPkg->price ?? 0 }}"),
                                    standard: parseFloat("{{ $standardPkg->price ?? 0 }}"),
                                    premium: parseFloat("{{ $premiumPkg->price ?? 0 }}")
                                };

                                $('.table-qty-input').on('input change', function() {
                                    let qty = parseInt($(this).val()) || 1;
                                    if (qty < 1) {
                                        qty = 1;
                                        $(this).val(1);
                                    }

                                    let pkgType = $(this).data('package');
                                    let basePrice = basePrices[pkgType] || 0;
                                    let calculatedTotalPrice = basePrice * qty;

                                    $('.form-qty-hidden-' + pkgType).val(qty);

                                    $('.total-price-display-' + pkgType).text(calculatedTotalPrice.toLocaleString('en-US'));
                                });

                            })(jQuery);
                        </script>
                    @endpush

                    <div class="col-lg-4 d-none d-lg-block details-sidebar" style="margin-top:48px">
                        <div class="jss-details-sidebar">
                            @include('Template::items.details.service_details', [
                                'productDetails' => $productDetails,
                            ])

                            <style>
                                .marketplace-extra-card:hover {
                                    background-color: #f8fafc;
                                    border-color: #cbd5e1 !important;
                                }

                                .marketplace-extra-card:has(input:checked) {
                                    background-color: #f0f7ff;
                                    border-color: #3C88EE !important;
                                }

                                .quantity-control-modern button:hover {
                                    background-color: #edf2f7 !important;
                                    color: #2d3748 !important;
                                }

                                #desktopOrderBtn:hover {
                                    background-color: #2a75dc !important;
                                }
                            </style>

                            @if ($productDetails->user)
                                <div class="jss-details-sidebar_block" style="margin:20px 0;">
                                    <div class="widget-card">
                                        <div class="widget-card__header">
                                            <h5 class="widget-card__title">
                                                @lang('Do you have any special requirements?')
                                            </h5>
                                        </div>
                                        <div class="widget-card__body" data-bs-toggle="modal"
                                            data-bs-target="#contactModal">
                                            <a class="btn btn--lg btn--base w-100" href="#">
                                                @lang('Message Now')
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="jss-details-sidebar__block">
                                @include('Template::partials.short_profile', [
                                    'user' => $productDetails->user,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('Template::partials.contact_modal', ['user' => $productDetails->user])

        @php
            $relatedServices = \App\Models\Service::active()
                ->where('category_id', $productDetails->category_id)
                ->where('id', '!=', $productDetails->id)
                ->with(['user', 'category'])
                ->latest()
                ->take(4)
                ->get();

            $type = 'service';
        @endphp

        @if ($relatedServices->isNotEmpty())
            <section class="related-services-section pb-5 pt-5 bg-light border-top">
                <div class="container">
                    <div class="mb-4">
                        <h4 class="fw-bold text-dark m-0"
                            style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                            @lang('Related Services You May Like')
                        </h4>
                        <p class="text-muted small m-0">@lang('Handpicked services from the same category.')</p>
                    </div>

                    <div class="row g-4 kwrk-custom-grid-container">
                        @foreach ($relatedServices as $product)
                            <div class="kwrk-custom-grid-col m-0" style="margin: 0;">
                                <article class="card jss--card jss--card-{{ $type }}"
                                    style="background: #ffffff !important; border: 1px solid #dadbdd !important; border-radius: 4px !important; box-shadow: none !important; overflow: hidden !important; display: flex !important; flex-direction: column !important; height: 100% !important; font-family: Macan, 'Helvetica Neue', Helvetica, Arial, sans-serif !important; position: relative !important; transition: all 0.2s ease-in-out;">
                                    @php
                                        $avgRatingNumeric =
                                            $product->total_review > 0
                                                ? $product->total_rating / $product->total_review
                                                : 0;

                                        if ($avgRatingNumeric >= 4.0) {
                                            $badgeText = 'TOP RATED';
                                            $badgeColor = '#446ee7';
                                            $badgeBg = '#f4f5f7';
                                        } elseif ($avgRatingNumeric >= 3.0) {
                                            $badgeText = 'LEVEL 2';
                                            $badgeColor = '#1dbf73';
                                            $badgeBg = '#eefbf4';
                                        } elseif ($avgRatingNumeric >= 2.0) {
                                            $badgeText = 'LEVEL 1';
                                            $badgeColor = '#ff7a00';
                                            $badgeBg = '#fff8f2';
                                        } else {
                                            $badgeText = 'NEW SELLER';
                                            $badgeColor = '#74767e';
                                            $badgeBg = '#f5f5f5';
                                        }

                                        $cardAvgRating =
                                            $product->total_review > 0 ? number_format($avgRatingNumeric, 1) : '0.0';
                                        $totalReviews = $product->total_review > 0 ? $product->total_review : 0;
                                    @endphp
                                    <div
                                        style="position: relative !important; display: block !important; width: 100% !important; aspect-ratio: 16 / 10 !important; overflow: hidden !important; background: #f8f9fa !important;">
                                        <a href="{{ route("$type.details", [slug($product->name), $product->id]) }}"
                                            style="display: block !important; width: 100% !important; height: 100% !important;">
                                            <img src="{{ getImage(getFilePath($type) . '/' . $product->image, getFileSize($type)) }}"
                                                alt="{{ $product->name }}"
                                                style="width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important;">
                                        </a>
                                    </div>

                                    <div
                                        style="display: flex !important; flex-direction: column !important; flex-grow: 1 !important; justify-content: space-between !important;">

                                        <div class="px-2 pt-2 pb-1">
                                            <h6
                                                style="font-size: 14px !important; font-weight: 400 !important; line-height: 1.4 !important; margin: 0 !important; min-height: 42px !important; overflow: hidden !important; display: -webkit-box !important; -webkit-line-clamp: 2 !important; -webkit-box-orient: vertical !important; text-transform: capitalize !important;">
                                                <a href="{{ route("$type.details", [slug($product->name), $product->id]) }}"
                                                    style="color: #404145 !important; text-decoration: none !important; display: block !important;"
                                                    onmouseover="this.style.color='#1dbf73'"
                                                    onmouseout="this.style.color='#404145'">
                                                    {{ __($product->name) }}
                                                </a>
                                            </h6>
                                        </div>

                                        <div class="px-2"
                                            style="display: flex !important; justify-content: space-between !important; align-items: center !important;">
                                            <div>
                                                <i class="ri-check-line"
                                                    style="font-size: 20px !important; color: #b5b6ba !important; font-weight: bold;"></i>
                                            </div>
                                            <div style="text-align: right !important;">
                                                <span
                                                    style="font-weight: 700 !important; color: #1dbf73 !important; font-size: 16px !important; display: flex; align-items: center; gap: 2px;">
                                                    <span
                                                        style="font-size: 14px; font-weight: 600;">&#2547;</span>{{ number_format($product->price) }}
                                                </span>
                                            </div>
                                        </div>

                                        <hr style="border: 0; border-top: 1px solid #e4e5e7; margin:0 !important;">

                                        <div class="px-2 py-2"
                                            style="display: flex !important; align-items: center !important; justify-content: space-between !important;">
                                            <div
                                                style="display: flex !important; flex-direction: column !important; gap: 4px !important;">
                                                <div onclick="window.open('{{ route('public.profile', ['username' => $product->user->username, 'contact' => 'true']) }}', '_blank')"
                                                    style="display: flex !important; align-items: center !important; gap: 6px !important; cursor: pointer !important;">
                                                    <span
                                                        style="width: 8px; height: 8px; background-color: #b5b6ba; border-radius: 50%; display: inline-block;"></span>
                                                    <span
                                                        style="font-size: 13px !important; text-transform: capitalize; font-weight: 600 !important; color: #404145 !important; max-width: 90px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;"
                                                        title="{{ $product->user ? $product->user->username : $product->username ?? 'babsmart_' }}">
                                                        {{ $product->user ? $product->user->username : $product->username ?? 'babsmart_' }}
                                                    </span>
                                                </div>

                                                <div
                                                    style="display: inline-flex; align-items: center; background: {{ $badgeBg }}; border: 1px solid {{ $badgeColor }}40; padding: 2px 6px; border-radius: 3px; width: fit-content;">
                                                    <span
                                                        style="color: {{ $badgeColor }}; font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        {{ $badgeText }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div
                                                style="display: flex !important; align-items: center !important; gap: 3px !important; font-size: 13px !important; font-weight: 700 !important;">
                                                <span
                                                    style="color: #ffb33e !important; font-size: 14px !important;">★</span>
                                                <span style="color: #ff7a00 !important;">{{ $cardAvgRating }}</span>
                                                <span
                                                    style="color: #74767e !important; font-weight: 400 !important;">({{ $totalReviews }})</span>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    <style>
                        .kwrk-custom-grid-container {
                            display: flex !important;
                            flex-wrap: wrap !important;
                        }

                        .kwrk-custom-grid-col {
                            width: 50% !important;
                            padding: 8px !important;
                        }

                        @media (min-width: 576px) {
                            .kwrk-custom-grid-col {
                                width: 33.333% !important;
                            }
                        }

                        @media (min-width: 768px) {
                            .kwrk-custom-grid-col {
                                width: 25% !important;
                            }
                        }

                        @media (min-width: 1200px) {
                            .kwrk-custom-grid-col {
                                width: 20% !important;
                            }
                        }
                    </style>
                </div>
            </section>
        @endif
    </main>

    @auth
        <div class="mobile-fixed-bottom-action d-sm-none">
            <div class="container-fluid px-3">
                <div class="d-flex align-items-center gap-2 w-100">
                    <button type="button" class="btn btn-chat-mobile d-flex align-items-center justify-content-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#contactModal">
                        <i class="far fa-comment-dots"></i>
                        <span>@lang('Chat')</span>
                    </button>

                    <button type="button" class="btn btn-order-mobile flex-grow-1 text-center js-mobile-fixed-order-trigger">
                        @lang('Order for') &#2547;<span
                            class="totalPrice">{{ number_format($basicPkg->price ?? 0, 0) }}</span>
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="mobile-fixed-bottom-action d-sm-none">
            <div class="container-fluid px-3">
                <div class="d-flex align-items-center gap-2 w-100">
                    <button type="button" class="btn btn-chat-mobile d-flex align-items-center justify-content-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#signInModal">
                        <i class="far fa-comment-dots"></i>
                        <span>@lang('Chat')</span>
                    </button>

                    <button type="button" class="btn btn-order-mobile flex-grow-1 text-center" data-bs-toggle="modal"
                        data-bs-target="#signInModal">
                        @lang('Order for') &#2547;<span
                            class="totalPrice">{{ number_format($basicPkg->price ?? 0, 0) }}</span>
                    </button>
                </div>
            </div>
        </div>
    @endauth

    @auth
        @push('script')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const mobileOrderBtn = document.querySelector('.js-mobile-order-submit');
                    const desktopOrderBtn = document.getElementById('desktopOrderBtn');
                    const mainOrderForm = document.getElementById('mainOrderForm');

                    if (mobileOrderBtn && desktopOrderBtn && mainOrderForm) {
                        mobileOrderBtn.addEventListener('click', function(e) {
                            e.preventDefault();

                            const extraContainer = mainOrderForm.querySelector('.extra_services_container');
                            if (extraContainer) {
                                extraContainer.innerHTML = '';

                                document.querySelectorAll('.extraServices:checked').forEach(function(checkbox) {
                                    const hiddenInput = document.createElement('input');
                                    hiddenInput.type = 'hidden';
                                    hiddenInput.name = 'extra_services[]';
                                    hiddenInput.value = checkbox.value;
                                    extraContainer.appendChild(hiddenInput);
                                });
                            }

                            desktopOrderBtn.click();
                        });
                    }
                });
            </script>
        @endpush
    @endauth

    <style>
        .hover-translate-y {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .hover-translate-y:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 38px;
            line-height: 1.4;
        }

        .small-title-link {
            color: #222;
            transition: color 0.2s;
        }

        .small-title-link:hover {
            color: #0073ec;
        }

        .max-w-150 {
            max-width: 150px;
        }
    </style>
@endsection

@push('script')
    <script>
        (function($) {
                "use strict";

                let quantity = 1;
                let servicePrice = parseFloat('{{ number_format($productDetails->price, 0, '.', '') }}');
                let extraService = 0;
                let extraServicesArray = [];

                $('.extraServices:checked').each(function() {
                    extraService += parseFloat($(this).data('price'));
                    extraServicesArray.push($(this).val());
                });
                updatePrices();
                updateExtraServices();

                $(document).on('click', '.incrementBtn', function() {
                    quantity++;
                    $('.quantity').text(quantity);
                    $('input[name="service_qty"]').val(quantity);
                    updatePrices();
                });

                $(document).on('click', '.decrementBtn', function() {
                    if (quantity > 1) {
                        quantity--;
                        $('.quantity').text(quantity);
                        $('input[name="service_qty"]').val(quantity);
                        updatePrices();
                    }
                });

                $(document).on('change', '.extraServices', function() {
                    extraService = 0;
                    extraServicesArray = [];
                    $('.extraServices:checked').each(function() {
                        extraService += parseFloat($(this).data('price'));
                        extraServicesArray.push($(this).val());
                    });
                    $('.extraServicePrice').text(extraService.toFixed(2));
                    updatePrices();
                    updateExtraServices();
                });

                function updatePrices() {
                    let totalServicePrice = servicePrice * quantity;
                    let totalExtraPrice = extraService;
                    let total = totalServicePrice + totalExtraPrice;

                    $('.servicePrice').text(totalServicePrice.toFixed(2));
                    $('.extraServicePrice').text(totalExtraPrice.toFixed(2));
                    $('.totalPrice').text(total.toFixed(2));

                    updateOrderNowLink();
                }

                function updateExtraServices() {
                    $('.extra_services_container').empty();
                    $('.extraServices:checked').each(function() {
                        const extraServiceId = $(this).val();
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'extra_services[]',
                            value: extraServiceId
                        }).appendTo('.extra_services_container');
                    });
                }

                function updateOrderNowLink() {
                    let extraServicesQuery = extraServicesArray.join(',');
                    let orderNowUrl =
                        `{{ route('user.service.add.booking', $productDetails->id) }}?quantity=${quantity}&extra_services=${extraServicesQuery}`;
                    $('.order-now-btn').attr('href', orderNowUrl);
                }

                if ($('.details-sidebar').length && $('.jss-details-main__block.three').length) {
                    var sidebarContent = $('.details-sidebar').html();
                    $('.jss-details-main__block.two').html(sidebarContent);
                }

                @guest
                $('.comments-tab-btn').on('click', function(e) {
                    e.preventDefault();
                    $('#loginModal').modal('show');
                });
            @endguest


        })(jQuery);
    </script>
@endpush
