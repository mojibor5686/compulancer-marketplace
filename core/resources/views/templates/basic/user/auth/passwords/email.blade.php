@extends('Template::layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center py-120">
            <div class="col-lg-7">
                <div class="contact-card reset-password-page">
                    <div class="contact-card__header">
                        <h3 class="contact-card__title">@lang('Recover Your Account')</h3>
                        <p class="contact-card__desc">@lang('To recover your account please provide your email or username to find your account.')</p>
                    </div>
                    <div class="contact-card__body">
                        <form method="POST" action="{{ route('user.password.email') }}" class="contact-form verify-gcaptcha">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <label class="form-label form--label required" for="value">@lang('Email or Username')</label>
                                    <input type="text" class="form-control form--control" name="value"
                                        value="{{ old('value') }}" placeholder="@lang('Your email or username')" required autofocus="off"
                                        id="value">
                                </div>
                                <div class="col-sm-12">
                                    <x-captcha frontend="true" />
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="w-100 btn btn--lg btn--base">@lang('Submit')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
