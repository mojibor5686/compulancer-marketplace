@extends('Template::layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="gig-wrapper">
                <!-- Step Counter for Job Setup -->
                <ul class="step-counter">
                    <li class="step-counter__item @if (!@$job || @$job->step >= 0) active @endif">
                        <span class="step-counter__num">1</span>
                        <a href="{{ route('user.buyer.job.basic', @$job->id) }}"
                            class="step-counter__name {{ request()->routeIs('user.buyer.job.basic') ? 'active' : '' }}">@lang('Basic')</a>
                    </li>
                    <li class="step-counter__item @if (@$job && @$job->step >= 1) active @endif">
                        <span class="step-counter__num">2</span>
                        <a href="@if ($job && @$job->step >= 1) {{ route('user.buyer.job.gallery', @$job->id) }} @else javascript:void(0); @endif"
                            class="step-counter__name {{ request()->routeIs('user.buyer.job.gallery') ? 'active' : '' }}">@lang('Image')</a>
                    </li>
                    <li class="step-counter__item @if (@$job && @$job->step >= 2) active @endif">
                        <span class="step-counter__num">3</span>
                        <a href="@if ($job && @$job->step >= 2) {{ route('user.buyer.job.skill', @$job->id) }} @else javascript:void(0); @endif"
                            class="step-counter__name {{ request()->routeIs('user.buyer.job.skill') ? 'active' : '' }}">@lang('Skill')</a>
                    </li>
                    <li class="step-counter__item @if (@$job && @$job->step >= 3) active @endif">
                        <span class="step-counter__num">4</span>
                        <a href="@if ($job && @$job->step >= 3) {{ route('user.buyer.job.requirement', @$job->id) }} @else javascript:void(0); @endif"
                            class="step-counter__name {{ request()->routeIs('user.buyer.job.requirement') ? 'active' : '' }}">@lang('Requirement')</a>
                    </li>
                </ul>

                <!-- Card Container -->
                <div class="card card--lg custom--card">
                    <div class="card-body">
                        <!-- Body Section for Job Content -->
                        <div class="gig-body">
                            @yield('job')
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
