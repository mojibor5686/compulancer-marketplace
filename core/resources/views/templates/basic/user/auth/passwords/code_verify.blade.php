@extends('Template::layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center py-120">
            <div class="col-md-8 col-lg-7 col-xl-5">
                <div class="d-flex justify-content-center">
                    <div class="verification-code-wrapper">
                        <div class="verification-area">
                            <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form">
                                @csrf
                                <p class="verification-text mb-2 pb-2">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
                                <input type="hidden" name="email" value="{{ $email }}" class="my-2 py-2">
                                <div class="my-2 pt-2">
                                    @include('Template::partials.verification_code')
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn--base w-100 btn--lg">@lang('Submit')</button>
                                </div>
                                <div class="form-group pt-3">
                                    @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                    <a href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
