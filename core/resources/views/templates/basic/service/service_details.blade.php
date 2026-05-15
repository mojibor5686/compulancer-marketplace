@extends('Template::layouts.frontend')
@section('content')
    <main class="page-wrapper">
        <section class="jss-details py-120">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-8">
                        <div class="jss-details-main bg--white">
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
                                                                            data-price="{{ showAmount($extraService->price, currencyFormat: false) }}"
                                                                            value="{{ $extraService->id }}">
                                                                        <label class="custom-checkbox-label"
                                                                            for="extra_service_{{ $key }}">{{ $extraService->name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="right">
                                                                    <span
                                                                        class="value">{{ showAmount($extraService->price) }}</span>
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
                                                            class="servicePrice">{{ showAmount($productDetails->price, currencyFormat: false) }}</span></span>
                                                </li>
                                                <li
                                                    class="info-list-item {{ $extraServices->count() > 0 ? '' : 'd-none' }}">
                                                    <span class="info-list-item__label">@lang('Extras Service')</span>
                                                    <span class="info-list-item__value">{{ gs('cur_sym') }}<span
                                                            class="extraServicePrice">0.00</span></span>
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
                                                    @lang('Book Now')
                                                    ({{ gs('cur_sym') }}<span
                                                        class="totalPrice">{{ showAmount($productDetails->price, currencyFormat: false) }}</span>)
                                                </button>
                                            @else
                                                <button type="button" class="mt-4 btn btn--lg btn--base w-100"
                                                    data-bs-toggle="modal" data-bs-target="#loginModal">
                                                    @lang('Book Now')
                                                    ({{ gs('cur_sym') }}<span
                                                        class="totalPrice">{{ showAmount($productDetails->price, currencyFormat: false) }}</span>)
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

@push('script')
    <script>
        (function($) {
                "use strict";

                let quantity = 1;
                let servicePrice = parseFloat('{{ showAmount($productDetails->price, currencyFormat: false) }}');
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
