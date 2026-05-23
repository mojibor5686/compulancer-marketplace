@extends('Template::layouts.frontend')
@section('content')
    <style>
        .kwork-hero-section {
            display: none
        }
    </style>
    <main class="page-wrapper">
        <section class="jss-details py-50">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-8">
                        <div class="jss-details-main bg--white">
                            <div class="kwork-detail-header mb-3"
                                style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                <nav class="kwork-breadcrumb d-flex align-items-center gap-2 mb-3"
                                    style="font-size: 14px; color: #777777;">
                                    <a href="#"
                                        style="color: #777777; text-decoration: none; transition: color 0.2s;">{{ __(@$productDetails->category->name ?? 'Design') }}</a>
                                    <span style="font-size: 11px; color: #b5b5b5;"><i class="las la-angle-right"></i></span>
                                    <a href="#"
                                        style="color: #777777; text-decoration: none; transition: color 0.2s;">{{ __(@$productDetails->subCategory->name ?? 'Logo Design') }}</a>
                                    <span style="font-size: 11px; color: #b5b5b5;"><i class="las la-angle-right"></i></span>
                                </nav>

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

                            @include('Template::items.details.banner', ['type' => 'service'])

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
                                    @if ($extraServices->count() > 0)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#jss-details-tab-2" type="button" role="tab">
                                                @lang('Extra Services')
                                            </button>
                                        </li>
                                    @endif
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
                                            'type' => 'service',
                                        ])
                                    </div>

                                    <!-- Extra Services Tab -->
                                    @if ($extraServices->count() > 0)
                                        <div class="tab-pane" id="jss-details-tab-2" role="tabpanel" tabindex="0">
                                            <div class="extra-services">
                                                <div class="extra-services-list service-card-body">
                                                    <div class="service-card-form">
                                                        @forelse ($extraServices as $key => $extraService)
                                                            <div class="form-row">
                                                                <div class="left">
                                                                    <div class="form-group custom-check-group">
                                                                        <input class="extraServices custom-checkbox"
                                                                            type="checkbox" name="extra_services[]"
                                                                            id="extra_service_{{ $key }}"
                                                                            data-id="{{ $extraService->id }}"
                                                                            data-key="{{ $key }}"
                                                                            data-price="{{ number_format($extraService->price, 0, '.', '') }}"
                                                                            value="{{ $extraService->id }}">
                                                                        <label class="custom-checkbox-label"
                                                                            for="extra_service_{{ $key }}">{{ $extraService->name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="right">
                                                                    <span
                                                                        class="value">{{ number_format($extraService->price, 0) }}</span>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="empty-message-box">
                                                                <i class="las la-folder-open icon"></i>
                                                                <p class="caption">@lang('No extra services available at this time.')</p>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Reviews Tab -->
                                    <div class="tab-pane" id="jss-details-tab-3" role="tabpanel" tabindex="0">
                                        @include('Template::items.details.reviews', [
                                            'type' => 'service',
                                        ])
                                    </div>

                                    <!-- Comments Tab -->
                                    <div class="tab-pane" id="jss-details-tab-4" role="tabpanel" tabindex="0">
                                        @include('Template::items.details.comments', [
                                            'type' => 'service',
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

                    <div class="col-lg-4 d-none d-lg-block details-sidebar">
                        <div class="jss-details-sidebar">
                            <!-- Service Details Widget -->
                            <div class="jss-details-sidebar__block">
                                <form class="jss-details-sidebar__block"
                                    action="{{ route('user.service.add.booking', $productDetails->id) }}" method="POST">
                                    @csrf
                                    <div class="extra_services_container"></div>

                                    <div class="widget-card">
                                        <div class="widget-card__header">
                                            <h5 class="widget-card__title">@lang('Service Details')</h5>
                                        </div>
                                        <div class="widget-card__body">
                                            <ul class="info-list style-two">
                                                <li class="info-list-item">
                                                    <span class="info-list-item__label">@lang('Estimated Delivery Time')</span>
                                                    <span
                                                        class="info-list-item__value">{{ $productDetails->delivery_time ?? 'N/A' }}
                                                        @lang('Days')</span>
                                                </li>
                                                <li class="info-list-item">
                                                    <span class="info-list-item__label">@lang('Service Price')</span>
                                                    <span class="info-list-item__value">{{ gs('cur_sym') }}<span
                                                            class="servicePrice">{{ number_format($productDetails->price) }}</span></span>
                                                </li>
                                                <li
                                                    class="info-list-item {{ $extraServices->count() > 0 ? '' : 'd-none' }}">
                                                    <span class="info-list-item__label">@lang('Extras Service')</span>
                                                    <span class="info-list-item__value">
                                                        {{ gs('cur_sym') }}<span
                                                            class="extraServicePrice">{{ number_format($productDetails->extraServices->price) }}</span>
                                                    </span>
                                                </li>
                                                <li class="info-list-item">
                                                    <span class="info-list-item__label">@lang('Quantity')</span>
                                                    <div class="quantity-control">
                                                        <button type="button"
                                                            class="quantity-btn quantity-btn--minus decrementBtn">
                                                            <i class="las la-minus"></i>
                                                        </button>
                                                        <span
                                                            class="info-list-item__value d-flex align-items-center quantity">1</span>
                                                        <button type="button"
                                                            class="quantity-btn quantity-btn--plus incrementBtn">
                                                            <i class="las la-plus"></i>
                                                        </button>
                                                        <input type="hidden" name="service_qty" value="1">
                                                    </div>
                                                </li>
                                            </ul>

                                            @auth
                                                <button type="submit" class="mt-4 btn btn--lg btn--base w-100">
                                                    @lang('Order Now')
                                                    ({{ gs('cur_sym') }}<span
                                                        class="totalPrice">{{ number_format($productDetails->price) }}</span>)
                                                </button>
                                            @else
                                                <button type="button" class="mt-4 btn btn--lg btn--base w-100"
                                                    data-bs-toggle="modal" data-bs-target="#signInModal">
                                                    @lang('Order Now')
                                                    ({{ gs('cur_sym') }}<span
                                                        class="totalPrice">{{ number_format($productDetails->price) }}</span>)
                                                </button>
                                            @endauth

                                        </div>
                                    </div>
                                </form>
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
                                        <div class="widget-card__body" data-bs-toggle="modal"
                                            data-bs-target="#contactModal">
                                            <a class="btn btn--lg btn--base w-100" href="#">
                                                @lang('Message Now')
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

        @include('Template::partials.contact_modal', ['user' => $productDetails->user])

        @php
            // ব্লেড ফাইলের ভেতরেই ডাইনামিকালি রিলেটেড সার্ভিস কুয়েরি করা হলো
            $relatedServices = \App\Models\Service::active()
                ->where('category_id', $productDetails->category_id)
                ->where('id', '!=', $productDetails->id) // বর্তমান সার্ভিসটি বাদ থাকবে
                ->with(['user', 'category'])
                ->latest()
                ->take(4) // টপ ৪টি রিলেটেড সার্ভিস শো করবে
                ->get();

            $type = 'service'; // রাউট এবং ফাইল পাথের জন্য টাইপ ফিক্সড রাখা হলো
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

                    <div class="row g-4">
                        @foreach ($relatedServices as $product)
                            <div class="col-sm-6 col-md-4 col-lg-3">

                                <article class="card jss--card jss--card-{{ $type }}"
                                    style="background: #ffffff !important; border: 1px solid #eef2f5 !important; border-radius: 4px !important; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04) !important; overflow: hidden !important; display: flex !important; flex-direction: column !important; height: 100% !important; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important; position: relative !important;">
                                    <link
                                        href="https://fonts.googleapis.com/css2?family=Roboto:wght=600;700;800&display=swap"
                                        rel="stylesheet">

                                    <div
                                        style="position: relative !important; display: block !important; width: 100% !important; aspect-ratio: 16 / 10 !important; overflow: hidden !important; background: #f8f9fa !important;">
                                        <a href="{{ route("$type.details", [slug($product->name ?? $product->title), $product->id]) }}"
                                            style="display: block !important; width: 100% !important; height: 100% !important;">
                                            <img src="{{ getImage(getFilePath($type) . '/' . $product->image, getFileSize($type)) }}"
                                                alt="{{ $product->name ?? $product->title }}"
                                                style="width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important;">
                                        </a>
                                    </div>

                                    <div
                                        style="padding: 12px 16px !important; display: flex !important; flex-direction: column !important; flex-grow: 1 !important; justify-content: space-between !important; background: #ffffff !important;">
                                        <div style="width: 100% !important;">

                                            <div
                                                style="display: flex !important; align-items: center !important; justify-content: space-between !important; margin-bottom: 12px !important; padding-bottom: 2px !important;">
                                                <div onclick="window.open('{{ route('public.profile', ['username' => @$product->user->username, 'contact' => 'true']) }}', '_blank')"
                                                    style="display: flex !important; align-items: center !important; gap: 8px !important; cursor: pointer !important;">
                                                    <img src="{{ $product->user && $product->user->image ? getImage(getFilePath('userProfile') . '/' . $product->user->image) : asset('assets/images/default.png') }}"
                                                        alt="Seller"
                                                        style="width: 32px !important; height: 32px !important; border-radius: 50% !important; object-fit: cover !important; display: block !important; border: 1px solid #e1e4e6 !important;">

                                                    <div
                                                        style="display: flex !important; flex-direction: column !important; line-height: 1.2 !important;">
                                                        <span
                                                            style="font-size: 13px !important; text-transform: capitalize !important; font-weight: 700 !important; color: #404145 !important; display: block !important; max-width: 110px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;"
                                                            title="{{ $product->user ? $product->user->username : $product->username ?? 'babsmart_' }}">
                                                            {{ $product->user ? $product->user->username : $product->username ?? 'babsmart_' }}
                                                        </span>
                                                        <span
                                                            style="font-size: 11px !important; color: #74767e !important; font-weight: 400 !important; text-transform: capitalize;">
                                                            {{ __($type) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                @php
                                                    $cardAvgRating =
                                                        $product->total_review > 0
                                                            ? number_format(
                                                                $product->total_rating / $product->total_review,
                                                                1,
                                                            )
                                                            : '0.0';
                                                @endphp

                                                <div
                                                    style="display: flex !important; align-items: center !important; gap: 3px !important; font-size: 12px !important; font-weight: 700 !important; color: #ffb33e !important;">
                                                    <span
                                                        style="font-size: 14px !important; line-height: 1 !important;">★</span>
                                                    <span style="color: #404145 !important;">{{ $cardAvgRating }}</span>
                                                    <span
                                                        style="color: #b5b6ba !important; font-weight: 400 !important; font-size: 11px !important;">({{ $product->total_review }})</span>
                                                </div>
                                            </div>

                                            <h6
                                                style="margin: 0 0 16px 0 !important; text-transform: capitalize; font-size: 14px !important; font-weight: 400 !important; line-height: 1.4 !important; height: 38px !important; overflow: hidden !important; display: -webkit-box !important; -webkit-line-clamp: 2 !important; -webkit-box-orient: vertical !important;">
                                                <a href="{{ route("$type.details", [slug($product->name ?? $product->title), $product->id]) }}"
                                                    style="color: #404145 !important; text-decoration: none !important; display: block !important; transition: color 0.1s ease !important;"
                                                    onmouseover="this.style.color='#3C88EE'"
                                                    onmouseout="this.style.color='#404145'">
                                                    {{ __($product->name ?? $product->title) }}
                                                </a>
                                            </h6>
                                        </div>

                                        <div
                                            style="border-top: 1px solid #e4e5e7 !important; padding-top: 10px !important; width: 100% !important; background: #ffffff !important; margin-top: auto !important;">
                                            <div
                                                style="text-align: right !important; display: flex !important; flex-direction: row !important; justify-content: space-between; line-height: 1.1 !important;">
                                                <div
                                                    style="display: flex; flex-direction: column; justify-content: start; align-items: baseline; gap:5px;">
                                                    <span
                                                        style="display: inline-flex !important; align-items: center !important; gap: 4px !important; font-weight: 800 !important; color: #23c366 !important; font-size: 16px !important;">
                                                        <span
                                                            style="font-family: 'Roboto', sans-serif !important; font-size: 15px !important; font-weight: 600 !important; margin-right: 1px !important;">৳</span>
                                                        {{ number_format($product->price, 2) }}
                                                    </span>
                                                    <span
                                                        style="display: block !important; font-size: 10px !important; color: #74767e !important; text-transform: uppercase !important; font-weight: 600 !important; letter-spacing: 0.3px !important; margin-bottom: 2px !important;">@lang('Starting at')</span>
                                                </div>
                                                <span
                                                    style="color: #2b2b2b !important; font-size: 16px !important; font-weight: 700 !important;">
                                                    <x-item view="item-footer-right" :product="$product" :type="$type" />
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </article>

                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>
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

                // Calculate initial extra service prices if any are selected
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

                // Check if both elements exist on the page
                if ($('.details-sidebar').length && $('.jss-details-main__block.three').length) {
                    var sidebarContent = $('.details-sidebar').html();
                    $('.jss-details-main__block.two').html(sidebarContent);
                }

                @guest
                $('.comments-tab-btn').on('click', function(e) {
                    e.preventDefault(); // Prevent default tab behavior
                    $('#loginModal').modal('show'); // Show the login modal
                });
            @endguest


        })(jQuery);
    </script>
@endpush
