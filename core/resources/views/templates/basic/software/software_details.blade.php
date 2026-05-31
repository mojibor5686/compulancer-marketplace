@extends('Template::layouts.frontend')
@section('content')
    <style>
        .kwork-hero-section {
            display: none
        }
    </style>
    <main class="page-wrapper">
        <section class="jss-details">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-8">
                        <div class="jss-details-main">

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
                                        {{ __($productDetails->name ?? 'I will do unique, modern and professional business logo design') }}
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

                            @include('Template::items.details.banner', ['type' => 'software'])

                            <!-- Hidden Block (if any content is needed) -->
                            <div class="jss-details-main__block two d-lg-none">
                                <!-- Content for block two (optional) -->
                            </div>

                            <!-- Tab Navigation and Content -->
                            <div class="jss-details-main__block three">
                                <!-- Tabs Navigation -->
                                <ul class="nav nav-tabs custom--tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#jss-details-tab-1" type="button" role="tab">
                                            @lang('Description')
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#jss-details-tab-3"
                                            type="button" role="tab">
                                            @lang('Reviews')
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link comments-tab-btn" data-bs-toggle="tab"
                                            data-bs-target="#jss-details-tab-4" type="button" role="tab">
                                            @lang('Comments')
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tabs Content -->
                                <div class="tab-content">
                                    <!-- Description Tab -->
                                    <div class="tab-pane active" id="jss-details-tab-1" role="tabpanel" tabindex="0">
                                        @include('Template::items.details.description', [
                                            'type' => 'software',
                                        ])
                                    </div>



                                    <!-- Reviews Tab -->
                                    <div class="tab-pane" id="jss-details-tab-3" role="tabpanel" tabindex="0">
                                        @include('Template::items.details.reviews', [
                                            'type' => 'software',
                                        ])
                                    </div>

                                    <!-- Comments Tab -->
                                    <div class="tab-pane" id="jss-details-tab-4" role="tabpanel" tabindex="0">
                                        @include('Template::items.details.comments', [
                                            'type' => 'software',
                                        ])
                                    </div>

                                    <!-- End of Comments Tab -->
                                </div>
                                <!-- End of Tab Content -->
                            </div>
                            <!-- End of jss-details-main__block three -->
                        </div>
                        <!-- End of jss-details-main -->
                    </div>
                    <!-- End of col-lg-8 -->

                    <div class="col-lg-4 d-none d-lg-block details-sidebar" style="margin-top:95px;">
                        <div class="jss-details-sidebar">
                            <!-- Software Details Widget -->
                            <div class="jss-details-sidebar_block">
                                <form action="{{ route('user.software.add.booking', $productDetails->id) }}" method="POST">
                                    @csrf
                                    <div class="widget-card">
                                        <div class="widget-card__header">
                                            <h5 class="widget-card__title">@lang('Software Details')</h5>
                                        </div>
                                        <div class="widget-card__body">
                                            <ul class="info-list">
                                                <li class="info-list-item">
                                                    <span class="info-list-item__label">@lang('Software Price')</span>
                                                    <span
                                                        class="info-list-item__value">{{ showAmount($productDetails->price) }}</span>
                                                </li>
                                            </ul>
                                            @auth
                                                <button type="submit" class="mt-4 btn btn--lg btn--base w-100">
                                                    @lang('Buy Now') ({{ showAmount($productDetails->price) }})
                                                </button>
                                            @else
                                                <button type="button" class="mt-4 btn btn--lg btn--base w-100"
                                                    data-bs-toggle="modal" data-bs-target="#signInModal">
                                                    @lang('Buy Now') ({{ showAmount($productDetails->price) }})
                                                </button>
                                            @endauth

                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Sales Widget -->
                            <div class="jss-details-sidebar__block text-center">
                                <div class="widget-card">
                                    <div class="widget-card__body">
                                        <h3 class="mb-0"><i class="fas fa-shopping-cart"></i>
                                            {{ __($productDetails->total_sale) }}
                                            @lang($productDetails->total_sale == 1 ? 'Sale' : 'Sales')
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Details Widget -->
                            <div class="jss-details-sidebar__block">
                                <div class="widget-card">
                                    <div class="widget-card__header">
                                        <h5 class="widget-card__title">@lang('Product Details')</h5>
                                    </div>
                                    <div class="widget-card__body">
                                        <ul class="info-list">
                                            <li class="info-list-item">
                                                <span class="info-list-item__label">@lang('First release')</span>
                                                <span
                                                    class="info-list-item__value">{{ showDateTime($productDetails->created_at, 'd M Y') }}</span>
                                            </li>
                                            <li class="info-list-item">
                                                <span class="info-list-item__label">@lang('Last update')</span>
                                                <span
                                                    class="info-list-item__value">{{ showDateTime($productDetails->updated_at, 'd M Y') }}</span>
                                            </li>
                                            <li class="info-list-item">
                                                <span class="info-list-item__label">@lang('Documentation')</span>
                                                <span class="info-list-item__value">@lang('Well Documented')</span>
                                            </li>
                                            <li class="info-list-item flex-wrap gap-2">
                                                <span class="info-list-item__label">@lang('Files Included')</span>
                                                <div class="align-items-center gap-2 file_includes">
                                                    @foreach ($productDetails->file_include as $fileName)
                                                        <span
                                                            class="badge badge--solid badge--secondary">{{ __(ucfirst($fileName)) }}</span>
                                                    @endforeach
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Us Widget -->
                            @if ($productDetails->user)
                                <div class="jss-details-sidebar__block">
                                    <div class="widget-card">
                                        <div class="widget-card__header">
                                            <h5 class="widget-card__title">
                                                @lang('Do you have any special requirements?')
                                            </h5>
                                        </div>
                                        <div class="widget-card__body">
                                            <a class="btn btn--lg btn--base w-100"
                                                href="{{ route('public.profile', ['username' => $productDetails->user->username, 'contact' => 'true']) }}">
                                                @lang('Contact Now')
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Short Profile Widget -->
                            <div class="jss-details-sidebar__block">
                                @include('Template::partials.short_profile', [
                                    'user' => $productDetails->user,
                                ])
                            </div>
                        </div>
                    </div>

                    <!-- End of col-lg-4 -->
                </div>
                <!-- End of row gy-5 -->
            </div>
            <!-- End of container -->
        </section>
    </main>
@endsection

@push('style')
    <style>
        .file_includes {
            display: block !important;
            float: left;
            box-sizing: border-box;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
                "use strict";

                let quantity = 1;
                let servicePrice = parseFloat('{{ showAmount($productDetails->price, currencyFormat: false) }}');
                let extraService = 0;

                $(document).on('click', '.incrementBtn', function() {
                    quantity++;
                    $('.quantity').text(quantity);
                    updatePrices();
                });

                $(document).on('click', '.decrementBtn', function() {
                    if (quantity > 1) {
                        quantity--;
                        $('.quantity').text(quantity);
                        updatePrices();
                    }
                });

                $(document).on('change', '.extraServices', function() {
                    extraService = 0;
                    $('.extraServices:checked').each(function() {
                        extraService += parseFloat($(this).data('price'));
                    });
                    $('.extraServicePrice').text(extraService.toFixed(2));
                    updatePrices();
                });

                function updatePrices() {
                    let totalServicePrice = servicePrice * quantity;
                    let totalExtraPrice = extraService;
                    let total = totalServicePrice + totalExtraPrice;

                    $('.servicePrice').text(totalServicePrice.toFixed(2));
                    $('.extraServicePrice').text(totalExtraPrice.toFixed(2));
                    $('.totalPrice').text(total.toFixed(2));
                }

                // Check if both elements exist on the page
                if ($('.details-sidebar').length && $('.jss-details-main__block.three').length) {
                    // Get the inner HTML of the details-sidebar
                    var sidebarContent = $('.details-sidebar').html();

                    // Paste it into .jss-details-main__block.three
                    $('.jss-details-main__block.two').html(sidebarContent);
                }

                @guest
                $('.comments-tab-btn').on('click', function(e) {
                    e.preventDefault(); // Prevent default tab behavior
                    $('#signInModal').modal('show'); // Show the login modal
                });
            @endguest

        })(jQuery);
    </script>
@endpush
