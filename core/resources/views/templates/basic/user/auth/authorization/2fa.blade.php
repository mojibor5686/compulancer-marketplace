@extends('Template::layouts.frontend')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center py-120">
            <div class="verification-code-wrapper ">
                <div class="verification-area">
                    <form action="{{ route('user.2fa.verify') }}" method="POST" class="submit-form">
                        @csrf

                        @include('Template::partials.verification_code')

                        <div class="form--group">
                            <button type="submit" class="btn btn--base btn--lg">@lang('Submit')</button>
                        </div>

                        <div class="mt-4">
                            <p class="mb-2">@lang('Please verify your 2FA code to access your account.')</p>
                            <a href="{{ route('user.logout') }}">@lang('Logout')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
