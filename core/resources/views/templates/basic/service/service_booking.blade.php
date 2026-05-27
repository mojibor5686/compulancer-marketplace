@extends('Template::layouts.frontend')
@section('content')
    <section class="all-sections pt-60">
        <div class="container-fluid p-max-sm-0">
            <div class="sections-wrapper d-flex flex-wrap justify-content-center">
                <article class="main-section">
                    <div class="section-inner">
                        <div class="item-section">
                            <div class="container">
                                <form class="row justify-content-center mb-30-none"
                                    action="{{ route('user.service.add.booking', $service->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="package_type" value="{{ request()->package_type }}">
                                    <input type="hidden" name="package_id" value="{{ request()->package_id }}">

                                    <div class="col-xl-9 col-lg-9 mb-30">
                                        <div class="item-details-area">
                                            <div class="item-card-wrapper border-0 p-0 list-view">
                                                <div class="item-card">
                                                    <x-item view="item-thumb" :product="$service" type="service" />
                                                    <div class="item-card-content">
                                                        <div class="item-card-content-top">
                                                            <x-item view="item-top-left" :product="$service" type="service" />
                                                            <div class="right d-flex flex-wrap align-items-center">
                                                                <select class="select me-3" name="service_qty" required>
                                                                    @for ($i = 1; $i <= ($service->max_order_qty ?: 1); $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                                <div class="item-amount">
                                                                    {{ showAmount($service->price) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3 class="item-card-title"><span>{{ __($service->name) }}</span>
                                                        </h3>
                                                    </div>
                                                    <div class="item-card-footer">
                                                        <x-item view="item-footer-left" :product="$service" type="service" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-desc mt-40">
                                                <div class="section-header">
                                                    <h2 class="section-title">@lang('Service Description')</h2>
                                                </div>
                                                <div class="product-desc-content pt-0">
                                                    @php echo $service->description @endphp
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 mb-30">
                                        <div class="sidebar">
                                            <div class="widget custom-widget mb-30">
                                                <h3 class="widget-title">@lang('Your Order Details')</h3>
                                                <ul class="details-list">
                                                    <li><span>@lang('Service Price'):</span>
                                                        <div class="order-price-tags">
                                                            <span>{{ gs('cur_sym') }}</span><span
                                                                id="servicePrice">{{ showAmount($service->price, currencyFormat: false) }}</span>
                                                        </div>
                                                    </li>
                                                    <li><span>@lang('Package Type'):</span>
                                                        <span
                                                            class="badge badge--success text-capitalize">{{ __(request()->package_type ?? 'Basic') }}</span>
                                                    </li>
                                                    <li><span>@lang('Quantity'):</span>
                                                        <span id="quantity">1</span>
                                                    </li>
                                                </ul>
                                                <div
                                                    class="total-price-area d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="left">
                                                        <h4 class="title">@lang('Total Price') :</h4>
                                                    </div>
                                                    <div class="right">
                                                        <h4 class="title">
                                                            {{ gs('cur_sym') }}<span
                                                                id="totalPrice">{{ showAmount($service->price, currencyFormat: false) }}</span>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="widget-btn mt-20">
                                                    <button type="submit" class="btn--base w-100">
                                                        <i class="las la-sign-in-alt"></i> @lang('Proceed')
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    @include('Template::partials.down_ad')
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            var basePrice = parseFloat('{{ getAmount($service->price) }}');

            $('[name=service_qty]').on('change', function() {
                var quantity = parseInt($(this).val()) || 1;
                var calculatedTotal = basePrice * quantity;

                $('#quantity').text(quantity);
                $('#servicePrice').text(calculatedTotal.toFixed(2));
                $('#totalPrice').text(calculatedTotal.toFixed(2));
            });
        })(jQuery);
    </script>
@endpush
