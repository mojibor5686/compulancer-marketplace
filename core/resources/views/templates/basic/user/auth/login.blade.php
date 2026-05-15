@extends('Template::layouts.app')
@section('panel')
    @php
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
                            <h4 class="title">@lang(@$loginRegisterContent->data_values->login_title)</h4>
                            @php
                                $subtitle = $socialLoginActive
                                    ? __(@$loginRegisterContent->data_values->social_subtitle)
                                    : __(@$loginRegisterContent->data_values->subtitle);
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
                        <form class="account-form verify-gcaptcha" method="POST" action="{{ route('user.login') }}">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-sm-12">
                                    <label class="form-label form--label required" for="username">@lang('Email or Username')</label>
                                    <input class="form-control form--control" name="username" type="text"
                                        placeholder="@lang('Email or Username')" value="{{ old('username') }}" required>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label form--label required" for="password">@lang('Password')</label>
                                    <div class="input-group input--group input--group-password">
                                        <input class="form-control form--control" name="password" type="password"
                                            placeholder="@lang('Password')" id="password" required>
                                        <button class="input-group-text input-group-btn toggle-password" type="button">
                                            <i class="far fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                <x-captcha :frontend="true" :isCustom="true" />
                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="form-check form--check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember-me"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember-me">@lang('Remember Me')</label>
                                        </div>
                                        <a class="fs-15" href="{{ route('user.password.request') }}">@lang('Forgot Password?')</a>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button class="w-100 btn btn--lg btn--base" type="submit">@lang('Sign In')</button>
                                    @if (gs('registration'))
                                        <p class="text-center mt-4">
                                            @lang("Don't have an account?") <a href="{{ route('user.register') }}">@lang('Register')</a>
                                        </p>
                                    @endif
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
@endsection


@push('style')
    <style>
        @media screen and (min-width: 1200px) {
            .account-inner__side.thumb {
                -webkit-mask-image: url("{{ frontendImage('login_register', @$loginRegisterContent->data_values->image, '960x945') }}");
                mask-image: url("{{ getImage(activeTemplate(true) . '/images/account-thumb-mask.png') }}");
            }
        }
    </style>
@endpush
