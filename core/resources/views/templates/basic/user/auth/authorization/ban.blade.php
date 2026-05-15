@extends('Template::layouts.app')
@section('panel')
    @php
        $bgImageContent = getContent('bg_image.content', true);
    @endphp

    <section class="account-section ptb-80 bg-overlay-white bg_img"
        data-background="{{ frontendImage('bg_image', @$bgImageContent->data_values->image, '1920x1200') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6">
                    <div class="account-form-area">
                        <div class="account-logo-area text-center">
                            <div class="account-logo">
                                <a href="{{ route('home') }}">
                                    <img src="{{ siteLogo() }}" alt="{{ __(gs('site_name')) }}" class="logo-img">
                                </a>
                            </div>
                        </div>
                        <div class="ban-message">
                            <div class="ban-icon">
                                <i class="las la-user-slash"></i>
                            </div>
                            <div class="account-header text-center">
                                <h3 class="title">@lang('Account Suspended')</h3>
                                <div class="reason-box">
                                    <h5 class="reason-title">@lang('Reason for Suspension')</h5>
                                    <p class="reason-text">{{ $user->ban_reason }}</p>
                                </div>
                            </div>
                            <div class="action-btn">
                                <a href="{{ route('home') }}" class="btn btn--base">
                                    <i class="las la-home"></i> @lang('Return to Homepage')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .account-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
        }

        .account-form-area {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .logo-img {
            max-width: 200px;
            margin-bottom: 30px;
        }

        .ban-message {
            text-align: center;
            padding: 30px 0;
        }

        .ban-icon {
            font-size: 80px;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .ban-message .title {
            color: #dc3545;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .reason-box {
            background: #f8d7da;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0 30px;
        }

        .reason-title {
            color: #721c24;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .reason-text {
            color: #721c24;
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
        }

        .action-btn {
            margin-top: 25px;
        }

        .btn--base {
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn--base:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .footer {
            display: none;
        }
    </style>
@endpush
