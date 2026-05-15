@extends('Template::layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="gig-wrapper">
                <ul class="step-counter">
                    <li class="step-counter__item @if (!@$service || @$service->step >= 0) active @endif">
                        <span class="step-counter__num">1</span>
                        <a href="{{ route('user.seller.service.basic', @$service->id) }}"
                            class="step-counter__name {{ request()->routeIs('user.seller.service.basic') ? 'active' : '' }}">@lang('Basic')</a>
                    </li>
                    <li class="step-counter__item @if (@$service && @$service->step >= 1) active @endif">
                        <span class="step-counter__num">2</span>
                        <a href="@if ($service && @$service->step >= 1) {{ route('user.seller.service.feature', @$service->id) }} @else javascript:void(0); @endif"
                            class="step-counter__name {{ request()->routeIs('user.seller.service.feature') ? 'active' : '' }}">@lang('Tags & Feature')</a>
                    </li>
                    <li class="step-counter__item @if (@$service && @$service->step >= 2) active @endif">
                        <span class="step-counter__num">3</span>
                        <a href="@if ($service && @$service->step >= 2) {{ route('user.seller.service.gallery', @$service->id) }} @else javascript:void(0); @endif"
                            class="step-counter__name {{ request()->routeIs('user.seller.service.gallery') ? 'active' : '' }}">@lang('Gallery')</a>
                    </li>
                    <li class="step-counter__item @if (@$service && @$service->step >= 3) active @endif">
                        <span class="step-counter__num">4</span>
                        <a href="@if ($service && @$service->step >= 3) {{ route('user.seller.service.extra', @$service->id) }} @else javascript:void(0); @endif"
                            class="step-counter__name {{ request()->routeIs('user.seller.service.extra') ? 'active' : '' }}">@lang('Extra Service')</a>
                    </li>
                </ul>

                <div class="card card--lg custom--card">
                    <div class="card-body">
                        <div class="gig-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h5 class="mb-0">
                                {{ request()->routeIs('user.seller.service.extra') ? __('Save your service') : __($pageTitle) }}
                            </h5>
                            @stack('button')
                        </div>
                        <div class="gig-body">
                            @yield('service')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .spinner-border {
            width: 1rem;
            height: 1rem;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.step-counter__num').on('click', function() {
                $(this).siblings('.step-counter__name')[0].click();
            });
        })(jQuery);
    </script>
@endpush
