@extends('Template::layouts.app')
@section('panel')
    @php
        $bgImageContent = getContent('bg_image.content', true);
        $loginRegisterContent = getContent('login_register.content', true);
        $credentials = gs('socialite_credentials');
        $socialLoginActive =
            @$credentials->google->status == Status::ENABLE ||
            @$credentials->facebook->status == Status::ENABLE ||
            @$credentials->linkedin->status == Status::ENABLE;
    @endphp

    <section class="auth-full-page min-vh-100 d-flex align-items-stretch">
        <div class="container-fluid p-0">
            <div class="row g-0 min-vh-100">

                <!-- বাম পাশের ব্র্যান্ডিং/হিরো সেকশন -->
                <div
                    class="col-lg-5 d-none d-lg-flex flex-column justify-content-between p-5 auth-side-banner position-relative">
                    <div class="auth-side-overlay"></div>

                    <!-- টপ লোগো এরিয়া -->
                    <div class="position-relative z-index-5">
                        <a href="{{ route('home') }}"
                            class="brand-logo text-white text-decoration-none h4 fw-bold d-flex align-items-center gap-2">
                            <i class="las la-cubes text-primary fs-24"></i> {{ __(gs('site_name')) }}
                        </a>
                    </div>

                    <!-- মিডেল টেক্সট/স্লোগান (গ্যাপ ফিলাপ করার জন্য বড় এবং আকর্ষণীয় কনটেন্ট) -->
                    <div class="position-relative z-index-5 my-auto max-w-450 text-white">
                        <span
                            class="badge bg-primary text-white px-3 py-2 rounded-pill fs-12 fw-semibold mb-3 text-uppercase tracking-wider">
                            @lang('Welcome Back!')
                        </span>

                        <h2 class="text-white fw-bold display-6 mb-3 lh-sm">
                            {{ __(@$loginRegisterContent->data_values->login_title ?? 'Access Your Digital Marketplace') }}
                        </h2>

                        <p class="text-white-50 fs-15 lh-base mb-4">
                            Log in to your account to manage your projects, purchase high-quality scripts, or connect with
                            industry-leading developers and global clients seamlessly.
                        </p>

                        <!-- ছোট ছোট ফিচার পয়েন্ট যা গ্যাপটি সুন্দরভাবে পূরণ করবে -->
                        <div class="auth-features-list d-flex flex-column gap-3 pt-2">
                            <div class="d-flex align-items-start gap-3">
                                <div
                                    class="feature-icon-box bg-white-10 rounded-circle p-2 d-flex align-items-center justify-content-center">
                                    <i class="las la-chart-line text-primary fs-18"></i>
                                </div>
                                <div>
                                    <h6 class="m-0 fw-semibold text-white fs-15">@lang('Track Your Orders & Projects')</h6>
                                    <p class="m-0 text-white-50 fs-13">Monitor active jobs, download scripts, and manage
                                        tickets.</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div
                                    class="feature-icon-box bg-white-10 rounded-circle p-2 d-flex align-items-center justify-content-center">
                                    <i class="las la-wallet text-primary fs-18"></i>
                                </div>
                                <div>
                                    <h6 class="m-0 fw-semibold text-white fs-15">@lang('Fast & Protected Earnings')</h6>
                                    <p class="m-0 text-white-50 fs-13">Withdraw your funds or release milestones securely.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div
                                    class="feature-icon-box bg-white-10 rounded-circle p-2 d-flex align-items-center justify-content-center">
                                    <i class="las la-comments text-primary fs-18"></i>
                                </div>
                                <div>
                                    <h6 class="m-0 fw-semibold text-white fs-15">@lang('Real-Time Safe Collaboration')</h6>
                                    <p class="m-0 text-white-50 fs-13">Connect instantly through our encrypted chat system.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ফুটার কপিরাইট ও সোশ্যাল লিংক -->
                    <div
                        class="position-relative z-index-5 d-flex justify-content-between align-items-center border-top border-white-10 pt-3">
                        <p class="text-white-50 m-0 fs-13">&copy; {{ date('Y') }} {{ __(gs('site_name')) }}. All rights
                            reserved.</p>
                        <div class="d-flex gap-2 text-white-50 fs-14">
                            <span class="opacity-50">v1.2</span>
                        </div>
                    </div>
                </div>

                <!-- ডান পাশের মেইন লগইন ফর্ম সেকশন -->
                <div
                    class="col-lg-7 d-flex align-items-center justify-content-center bg-white p-4 p-md-5 position-relative">

                    <!-- ব্যাক টু হোম বাটন -->
                    <a href="{{ route('home') }}" class="auth-back-to-home" title="Back to home">
                        <i class="las la-times"></i>
                    </a>

                    <div class="auth-form-container w-100">

                        <!-- হেডিং -->
                        <div class="mb-4 text-center text-lg-start">
                            <h3 class="fw-bold text-dark mb-1">@lang('Welcome Back')</h3>
                            <p class="text-muted fs-14">@lang('Please enter your credentials to access your account.')</p>
                        </div>

                        <!-- মেইন ফর্ম -->
                        <form class="account-form verify-gcaptcha" method="POST" action="{{ route('user.login') }}">
                            @csrf
                            <div class="row g-3">

                                <!-- ইউজারনেম/ইমেইল ফিল্ড -->
                                <div class="col-12">
                                    <div class="input-group-custom">
                                        <span class="input-icon"><i class="las la-user"></i></span>
                                        <input class="form-control" name="username" type="text"
                                            value="{{ old('username') }}" placeholder="@lang('Email or Username')" required>
                                    </div>
                                </div>

                                <!-- পাসওয়ার্ড ফিল্ড -->
                                <div class="col-12">
                                    <div class="input-group-custom">
                                        <span class="input-icon"><i class="las la-lock"></i></span>
                                        <input class="form-control" id="password" name="password" type="password"
                                            placeholder="@lang('Password')" required>
                                        <button class="input-pass-toggle toggle-password" type="button">
                                            <i class="far fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- জিক্যাপচা রেন্ডার -->
                                <div class="col-12 custom-captcha-wrapper">
                                    <x-captcha :frontend="true" :isCustom="true" />
                                </div>

                                <!-- রিমেম্বার মি এবং ফরগট পাসওয়ার্ড লিঙ্ক -->
                                <div class="col-12 py-1">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                        <div
                                            class="form-check custom-form-check custom-agree-checkbox d-flex align-items-start gap-2">
                                            <input class="form-check-input flex-shrink-0" type="checkbox" name="remember"
                                                id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label text-muted fs-14 lh-sm" for="remember-me">
                                                @lang('Remember Me')
                                            </label>
                                        </div>
                                        <a class="fs-14 text-primary text-decoration-none fw-medium"
                                            href="{{ route('user.password.request') }}">@lang('Forgot Password?')</a>
                                    </div>
                                </div>

                                <!-- মেইন অ্যাকশন বাটন -->
                                <div class="col-12 mt-2">
                                    <button class="w-100 btn custom-submit-btn py-2.5 fw-semibold"
                                        type="submit">@lang('Sign In')</button>
                                </div>
                            </div>
                        </form>

                        <!-- ওথ বা সোশ্যাল মিডিয়া লগইন লিংক -->
                        @if ($socialLoginActive)
                            <div class="custom-card-divider my-4 position-relative text-center">
                                <span class="bg-white px-3 text-muted fs-14">@lang('OR')</span>
                            </div>
                            <div class="d-flex justify-content-center social-login-wrapper">
                                @include('Template::partials.social_login')
                            </div>
                        @endif

                        <!-- রেজিস্টার রিডাইরেক্ট লিংক -->
                        @if (gs('registration'))
                            <div class="text-center mt-4 text-muted fs-14">
                                @lang("Don't have an account?") <a href="{{ route('user.register') }}"
                                    class="text-primary text-decoration-none fw-semibold ms-1">@lang('Register')</a>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .custom-agree-checkbox .form-check-input {
            width: 18px !important;
            height: 18px !important;
            cursor: pointer;
            border: 2px solid #2563eb !important;
            border-radius: 4px !important;
            transition: all 0.2s ease-in-out;
            margin-top: -1px !important;
        }

        .custom-agree-checkbox .form-check-input:checked {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }

        .custom-agree-checkbox .form-check-input:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25) !important;
        }

        /* ফুল-পেজ ডিজাইন আর্কিটেকচার */
        .auth-full-page {
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* বাম পাশের আধুনিক হিরো ব্যানার */
        .auth-side-banner {
            background-image: url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1964&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }

        .auth-side-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.8) 100%);
            z-index: 1;
        }

        .z-index-5 {
            z-index: 5 !important;
        }

        .max-w-450 {
            max-width: 450px;
        }

        /* রাইট সাইড বাটন ও কন্টেইনার ফিক্স */
        .auth-form-container {
            max-width: 460px;
            margin: 0 auto;
        }

        .auth-back-to-home {
            position: absolute;
            top: 30px;
            right: 30px;
            font-size: 22px;
            color: #94a3b8;
            transition: color 0.2s;
            text-decoration: none;
        }

        .auth-back-to-home:hover {
            color: #1e293b;
        }

        /* স্ক্রিনশটের মতো কাস্টম ইনপুট ডিজাইন */
        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-custom .form-control {
            padding: 12px 40px 12px 44px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            font-size: 14px;
            box-shadow: none !important;
            transition: all 0.2s ease;
            color: #334155;
            background-color: #fff;
        }

        .input-group-custom .form-control:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
        }

        .input-group-custom .input-icon {
            position: absolute;
            left: 16px;
            color: #94a3b8;
            font-size: 18px;
            display: flex;
            align-items: center;
            pointer-events: none;
        }

        .input-pass-toggle {
            position: absolute;
            right: 16px;
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            padding: 0;
        }

        .custom-submit-btn {
            background-color: #2563eb !important;
            color: #fff !important;
            border-radius: 10px !important;
            font-size: 15px;
            border: none;
            padding: 11px !important;
            transition: background-color 0.2s;
        }

        .custom-submit-btn:hover {
            background-color: #1d4ed8 !important;
        }

        /* ওআর ডিভাইডার */
        .custom-card-divider::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background-color: #e2e8f0;
            z-index: 1;
        }

        .custom-card-divider span {
            position: relative;
            z-index: 2;
        }

        /* ফুটার সোশ্যাল মিডিয়া ওথ আইকন ফিক্স */
        .social-login-wrapper .btn,
        .social-login-wrapper a {
            border-radius: 50% !important;
            width: 46px;
            height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #cbd5e1 !important;
            background: #fff !important;
            margin: 0 6px;
            transition: all 0.2s;
        }

        .social-login-wrapper .btn:hover,
        .social-login-wrapper a:hover {
            background: #f8fafc !important;
            transform: translateY(-2px);
        }

        .bg-white-10 {
            background-color: rgba(255, 255, 255, 0.08) !important;
            width: 34px;
            height: 34px;
            flex-shrink: 0;
        }

        .border-white-10 {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }

        .fs-14 {
            font-size: 14px !important;
        }

        .fs-15 {
            font-size: 15px !important;
        }

        .fs-13 {
            font-size: 13px !important;
        }

        .lh-sm {
            line-height: 1.25;
        }

        .custom-captcha-wrapper label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            color: #475569;
            font-weight: 500;
        }

        .custom-captcha-wrapper input {
            padding: 11px 16px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            font-size: 14px;
        }
    </style>
@endpush
