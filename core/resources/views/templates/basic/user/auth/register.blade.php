@extends('Template::layouts.app')
@section('panel')
    @if (gs('registration'))
        @php
            $bgImageContent = getContent('bg_image.content', true);
            $loginRegisterContent = getContent('login_register.content', true);
            $credentials = gs('socialite_credentials');
            $socialLoginActive =
                @$credentials->google->status == Status::ENABLE ||
                @$credentials->facebook->status == Status::ENABLE ||
                @$credentials->linkedin->status == Status::ENABLE;
        @endphp

        <section class="account">
            <div class="account-inner">
                <div class="account-inner__side thumb">
                    <img src="{{ frontendImage('login_register', @$loginRegisterContent->data_values->image, '960x945') }}"
                        alt="Account Image" />
                </div>
                <div class="account-inner__side content">
                    <div class="account-card">
                        <div class="account-card__header">
                            <div class="account-card__headings">
                                <h4 class="title">@lang(@$loginRegisterContent->data_values->register_title)</h4>
                                @php
                                    $subtitle = $socialLoginActive
                                        ? __(
                                            @$loginRegisterContent->data_values->social_subtitle ??
                                                'Sign Up With Social Media',
                                        )
                                        : __(
                                            @$loginRegisterContent->data_values->subtitle ??
                                                'Please fill up the details',
                                        );
                                    $class = !$socialLoginActive ? ' mb-5' : '';
                                @endphp
                                <p class="subtitle{{ $class }}">{{ $subtitle }}</p>
                            </div>

                            @if ($socialLoginActive)
                                @include('Template::partials.social_login')
                            @endif
                        </div>

                        @if ($socialLoginActive)
                            <div class="account-card__divider">
                                <span>@lang('OR')</span>
                            </div>
                        @endif

                        <div class="account-card__body">
                            <form class="account-form verify-gcaptcha" action="{{ route('user.register') }}" method="POST">
                                @csrf
                                <div class="row gy-4">
                                    @if (session()->get('reference') != null)
                                        <div class="col-sm-12 form-group">
                                            <label class="form-label form--label" for="reference">@lang('Reference By')</label>
                                            <input class="form-control form--control" name="referBy" type="text"
                                                value="{{ session()->get('reference') }}" readonly>
                                        </div>
                                    @endif

                                    <div class="col-sm-6 form-group">
                                        <label class="form-label form--label required"
                                            for="firstname">@lang('First Name')</label>
                                        <input class="form-control form--control" name="firstname" type="text"
                                            value="{{ old('firstname') }}" placeholder="@lang('First name')" required>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label class="form-label form--label required"
                                            for="lastname">@lang('Last Name')</label>
                                        <input class="form-control form--control" name="lastname" type="text"
                                            value="{{ old('lastname') }}" placeholder="@lang('Last name')" required>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label class="form-label form--label required"
                                            for="email">@lang('Email Address')</label>
                                        <input class="form-control form--control checkUser" name="email" type="text"
                                            value="{{ old('email') }}" placeholder="@lang('Email Address')" required>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label class="form-label form--label required"
                                            for="password">@lang('Password')</label>
                                        <div class="input-group input--group input--group-password">
                                            <input
                                                class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                                name="password" type="password" placeholder="@lang('Password')" required>
                                            <button class="input-group-text input-group-btn toggle-password" type="button">
                                                <i class="far fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label class="form-label form--label required"
                                            for="password_confirmation">@lang('Confirm Password')</label>
                                        <div class="input-group input--group input--group-password">
                                            <input class="form-control form--control" name="password_confirmation"
                                                type="password" placeholder="@lang('Confirm Password')" required>
                                            <button class="input-group-text input-group-btn toggle-password" type="button">
                                                <i class="far fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <x-captcha :frontend="true" :isCustom="true" />

                                    @if (gs('agree'))
                                        @php
                                            $policyPages = getContent('policy_pages.element', orderById: true);
                                        @endphp
                                        <div class="col-sm-12 form-group">
                                            <div class="form-check form--check">
                                                <input class="form-check-input" id="agree" name="agree"
                                                    type="checkbox">
                                                <label class="form-check-label" for="agree">
                                                    @lang('I agree with')
                                                    @foreach ($policyPages as $policy)
                                                        <a class="text--base" target="_blank"
                                                            href="{{ route('policy.pages', $policy->slug) }}">
                                                            {{ __($policy->data_values->title) }}
                                                        </a>
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-sm-12">
                                        <button class="w-100 btn btn--lg btn--base"
                                            type="submit">@lang('Sign Up')</button>
                                        <p class="text-center mt-4">
                                            @lang('Already have an account?') <a href="{{ route('user.login') }}">@lang('Sign In')</a>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn--close style-two" title="Back to home">
                        <i class="las la-times"></i>
                    </a>
                </div>
            </div>
        </section>
    @else
        @include('Template::partials.registration_disabled')
    @endif
@endsection

@push('modal')
    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <p class="text-center">@lang('You already have an account please Login')</p>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-dark btn--sm"
                        data-bs-dismiss="modal">@lang('Close')</button>
                    <a class="btn btn--base btn--sm" href="{{ route('user.login') }}">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('style')
    <style>
        @media screen and (min-width: 1200px) {
            .account-inner__side.thumb {
                -webkit-mask-image: url("{{ getImage(activeTemplate(true) . '/images/account-thumb-mask.png') }}");
                mask-image: url("{{ getImage(activeTemplate(true) . '/images/account-thumb-mask.png') }}");
            }
        }
    </style>
@endpush

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                var data = {
                    email: value,
                    _token: token
                };

                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $('#existModalCenter').modal('show');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
