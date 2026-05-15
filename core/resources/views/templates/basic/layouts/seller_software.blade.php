@extends('Template::layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="gig-wrapper">
                <ul class="step-counter">
                    <li class="step-counter__item @if (!@$software || @$software->step >= 0) active @endif">
                        <span class="step-counter__num">1</span>
                        <a href="{{ route('user.seller.software.basic', @$software->id) }}"
                            class="step-counter__name {{ request()->routeIs('user.seller.software.basic') ? 'active' : '' }}">@lang('Basic')</a>
                    </li>
                    <li class="step-counter__item @if (@$software && @$software->step >= 1) active @endif">
                        <span class="step-counter__num">2</span>
                        <a href="@if ($software && @$software->step >= 1) {{ route('user.seller.software.feature', @$software->id) }} @else javascript:void(0); @endif"
                            class="step-counter__name {{ request()->routeIs('user.seller.software.feature') ? 'active' : '' }}">@lang('Tags & Feature')</a>
                    </li>
                    <li class="step-counter__item @if (@$software && @$software->step >= 2) active @endif">
                        <span class="step-counter__num">3</span>
                        <a href="@if ($software && @$software->step >= 2) {{ route('user.seller.software.gallery', @$software->id) }} @else javascript:void(0); @endif"
                            class="step-counter__name {{ request()->routeIs('user.seller.software.gallery') ? 'active' : '' }}">@lang('Gallery')</a>
                    </li>
                    <li class="step-counter__item @if (@$software && @$software->step >= 3) active @endif">
                        <span class="step-counter__num">4</span>
                        <a href="@if ($software && @$software->step >= 3) {{ route('user.seller.software.document', @$software->id) }} @else javascript:void(0); @endif"
                            class="step-counter__name {{ request()->routeIs('user.seller.software.document') ? 'active' : '' }}">@lang('Document')</a>
                    </li>
                </ul>

                <div class="card card--lg custom--card">
                    <div class="card-body">
                        <div class="gig-header d-flex align-items-center justify-content-between">
                            <div>
                                @if (request()->routeIs('user.seller.software.document'))
                                    <h5 class="mb-0">@lang('Upload your software')</h5>
                                @else
                                    <h5 class="mb-0">{{ __($pageTitle) }}</h5>
                                @endif
                            </div>
                        </div>
                        <div class="gig-body">
                            @yield('software')
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
