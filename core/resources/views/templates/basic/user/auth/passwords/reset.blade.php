@extends('Template::layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center py-120">
            <div class="col-lg-7">
                <div class="contact-card">
                    <div class="contact-card__header">
                        <h3 class="contact-card__title">@lang('Reset Password')</h3>
                        <p class="contact-card__desc">@lang('Your account is verified successfully. Now you can change your password.')</p>
                    </div>
                    <div class="contact-card__body">
                        <form method="POST" action="{{ route('user.password.update') }}" class="contact-form">
                            @csrf
                            <input name="email" type="hidden" value="{{ $email }}">
                            <input name="token" type="hidden" value="{{ $token }}">
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <label class="form-label form--label required">@lang('Password')</label>
                                    <input
                                        class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                        name="password" type="password" required>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label form--label required">@lang('Confirm Password')</label>
                                    <input class="form-control form--control" name="password_confirmation" type="password"
                                        required>
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

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
