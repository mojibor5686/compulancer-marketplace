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
                                @lang('Join the Future of Freelancing')
                            </span>

                            <h2 class="text-white fw-bold display-6 mb-3 lh-sm">
                                {{ __(@$loginRegisterContent->data_values->register_title ?? 'Empowering Digital Creators Worldwide') }}
                            </h2>

                            <p class="text-white-50 fs-15 lh-base mb-4">
                                Welcome to the ultimate hub where talent meets opportunity. Whether you are looking to hire
                                elite developers, purchase high-quality pre-built scripts, or monetize your skills, we
                                provide the perfect ecosystem to grow your digital business.
                            </p>

                            <!-- ছোট ছোট ফিচার পয়েন্ট যা গ্যাপটি সুন্দরভাবে পূরণ করবে -->
                            <div class="auth-features-list d-flex flex-column gap-3 pt-2">
                                <div class="d-flex align-items-start gap-3">
                                    <div
                                        class="feature-icon-box bg-white-10 rounded-circle p-2 d-flex align-items-center justify-content-center">
                                        <i class="las la-check-circle text-primary fs-18"></i>
                                    </div>
                                    <div>
                                        <h6 class="m-0 fw-semibold text-white fs-15">@lang('Verified Freelancers & Agencies')</h6>
                                        <p class="m-0 text-white-50 fs-13">Collaborate with top-tier professionals vetted
                                            for quality.</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start gap-3">
                                    <div
                                        class="feature-icon-box bg-white-10 rounded-circle p-2 d-flex align-items-center justify-content-center">
                                        <i class="las la-shield-alt text-primary fs-18"></i>
                                    </div>
                                    <div>
                                        <h6 class="m-0 fw-semibold text-white fs-15">@lang('Secure Escrow & Payments')</h6>
                                        <p class="m-0 text-white-50 fs-13">Your funds are completely safe with our
                                            multi-layered milestone system.</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start gap-3">
                                    <div
                                        class="feature-icon-box bg-white-10 rounded-circle p-2 d-flex align-items-center justify-content-center">
                                        <i class="las la-code text-primary fs-18"></i>
                                    </div>
                                    <div>
                                        <h6 class="m-0 fw-semibold text-white fs-15">@lang('Premium Scripts & Source Codes')</h6>
                                        <p class="m-0 text-white-50 fs-13">Instantly buy or sell ready-made web applications
                                            and scripts.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ফুটার কপিরাইট ও সোশ্যাল লিংক -->
                        <div
                            class="position-relative z-index-5 d-flex justify-content-between align-items-center border-top border-white-10 pt-3">
                            <p class="text-white-50 m-0 fs-13">&copy; {{ date('Y') }} {{ __(gs('site_name')) }}. All
                                rights reserved.</p>
                            <div class="d-flex gap-2 text-white-50 fs-14">
                                <span class="opacity-50">v1.2</span>
                            </div>
                        </div>
                    </div>

                    <!-- ডান পাশের মেইন রেজিস্ট্রেশন ফর্ম সেকশন -->
                    <div
                        class="col-lg-7 d-flex align-items-center justify-content-center bg-white p-4 p-md-5 position-relative">

                        <!-- ব্যাক টু হোম বাটন -->
                        <a href="{{ route('home') }}" class="auth-back-to-home" title="Back to home">
                            <i class="las la-times"></i>
                        </a>

                        <div class="auth-form-container w-100">

                            <!-- হেডিং -->
                            <div class="mb-4 text-center text-lg-start">
                                <h3 class="fw-bold text-dark mb-1">@lang('Create an Account')</h3>
                                <p class="text-muted fs-14">Please fill in your details to get started.</p>
                            </div>

                            <!-- বায়ার/সেলার টাইপ কাস্টম ট্যাব (স্ক্রিনশটের অনুকরণে) -->
                            <div
                                class="d-flex role-tab-wrapper gap-2 p-1 bg-light rounded-3 mb-4 max-w-400 mx-auto mx-lg-0">
                                <button type="button"
                                    class="btn role-tab-btn active flex-grow-1 py-2.5 rounded-2 text-center"
                                    data-role="buyer">
                                    <i class="las la-shopping-bag me-1"></i> @lang('Buyer')
                                </button>
                                <button type="button" class="btn role-tab-btn flex-grow-1 py-2.5 rounded-2 text-center"
                                    data-role="seller">
                                    <i class="las la-store me-1"></i> @lang('Seller')
                                </button>
                            </div>

                            <!-- মেইন ফর্ম -->
                            <form class="account-form verify-gcaptcha" action="{{ route('user.register') }}" method="POST">
                                @csrf

                                <input type="hidden" name="type" id="user-role" value="buyer">

                                <div class="row g-3">

                                    @if (session()->get('reference') != null)
                                        <div class="col-12">
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="las la-user-tag"></i></span>
                                                <input class="form-control" name="referBy" type="text"
                                                    value="{{ session()->get('reference') }}" readonly>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- ফার্স্ট নেম ও লাস্ট নেম পাশাপাশি -->
                                    <div class="col-sm-6">
                                        <div class="input-group-custom">
                                            <span class="input-icon"><i class="las la-user"></i></span>
                                            <input class="form-control" name="firstname" type="text"
                                                value="{{ old('firstname') }}" placeholder="@lang('First name')" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group-custom">
                                            <span class="input-icon"><i class="las la-user"></i></span>
                                            <input class="form-control" name="lastname" type="text"
                                                value="{{ old('lastname') }}" placeholder="@lang('Last name')" required>
                                        </div>
                                    </div>

                                    <!-- ইমেইল এড্রেস -->
                                    <div class="col-12">
                                        <div class="input-group-custom">
                                            <span class="input-icon"><i class="las la-envelope"></i></span>
                                            <input class="form-control checkUser" name="email" type="text"
                                                value="{{ old('email') }}" placeholder="@lang('Email Address')" required>
                                        </div>
                                    </div>

                                    <!-- পাসওয়ার্ড -->
                                    <div class="col-12">
                                        <div class="input-group-custom">
                                            <span class="input-icon"><i class="las la-lock"></i></span>
                                            <input
                                                class="form-control @if (gs('secure_password')) secure-password @endif"
                                                id="reg-pass" name="password" type="password"
                                                placeholder="@lang('Password')" required>
                                            <button class="input-pass-toggle toggle-password" type="button">
                                                <i class="far fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- কনফার্ম পাসওয়ার্ড -->
                                    <div class="col-12">
                                        <div class="input-group-custom">
                                            <span class="input-icon"><i class="las la-lock"></i></span>
                                            <input class="form-control" id="reg-pass-confirm"
                                                name="password_confirmation" type="password"
                                                placeholder="@lang('Confirm Password')" required>
                                            <button class="input-pass-toggle toggle-password" type="button">
                                                <i class="far fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- জিক্যাপচা রেন্ডার -->
                                    <div class="col-12 custom-captcha-wrapper">
                                        <x-captcha :frontend="true" :isCustom="true" />
                                    </div>

                                    <!-- এগ্রিমেন্ট এবং টার্মস পলিসি -->
                                    @if (gs('agree'))
                                        @php
                                            $policyPages = getContent('policy_pages.element', orderById: true);
                                        @endphp
                                        <div class="col-12 py-1">
                                            <div
                                                class="form-check custom-form-check custom-agree-checkbox d-flex align-items-start gap-2">
                                                <input class="form-check-input flex-shrink-0" id="agree"
                                                    name="agree" type="checkbox" required>
                                                <label class="form-check-label text-muted fs-14 lh-sm" for="agree">
                                                    <span style="font-size: 13px;">@lang('I agree with')</span>
                                                    @foreach ($policyPages as $policy)
                                                        <a class="text-primary text-decoration-none fw-medium"
                                                            target="_blank"
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

                                    <!-- মেইন অ্যাকশন বাটন -->
                                    <div class="col-12 mt-2">
                                        <button class="w-100 btn custom-submit-btn py-2.5 fw-semibold"
                                            type="submit">@lang('Sign Up')</button>
                                    </div>
                                </div>
                            </form>

                            <!-- ওথ বা সোশ্যাল মিডিয়া লগইন লিংক -->
                            @if ($socialLoginActive)
                                <div class="custom-card-divider my-4 position-relative text-center">
                                    <span class="bg-white px-3 text-muted fs-14">@lang('OR')</span>
                                </div>
                                <div class="d-flex justify-content-center social-login-wrapper">
                                    @include('Template::partials.social_login')
                                </div>
                            @endif

                            <!-- সাইন ইন রিডাইরেক্ট লিংক -->
                            <div class="text-center mt-4 text-muted fs-14">
                                @lang('Already have an account?') <a href="{{ route('user.login') }}"
                                    class="text-primary text-decoration-none fw-semibold ms-1">@lang('Sign In')</a>
                            </div>

                        </div>
                    </div>

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
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" id="existModalLongTitle">@lang('You are with us')</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <p class="text-secondary m-0">@lang('You already have an account please Login')</p>
                </div>
                <div class="modal-footer border-top-0 pt-0 pb-4 px-4 gap-2">
                    <button type="button" class="btn btn-light rounded-3 px-3 fs-14"
                        data-bs-dismiss="modal">@lang('Close')</button>
                    <a class="btn btn-primary rounded-3 px-4 fs-14"
                        href="{{ route('user.login') }}">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('style')
    <style>
        .custom-agree-checkbox .form-check-input {
            width: 18px !important;
            height: 18px !important;
            cursor: pointer;
            border: 2px solid #3C88EE !important;
            border-radius: 4px !important;
            transition: all 0.2s ease-in-out;
            margin-top: -1px !important;
        }

        .custom-agree-checkbox .form-check-input:checked {
            background-color: #3C88EE !important;
            border-color: #3C88EE !important;
        }

        .custom-agree-checkbox .form-check-input:focus {
            border-color: #3C88EE !important;
            box-shadow: 0 0 0 0.25rem rgba(5, 150, 105, 0.25) !important;
        }

        .custom-agree-checkbox {
            display: flex;
            align-items: flex-start;
        }
    </style>

    <style>
        .auth-full-page {
            background-color: #ffffff;
            overflow-x: hidden;
        }

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
            max-w: 450px;
        }

        .max-w-400 {
            max-w: 400px;
        }

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

        .role-tab-wrapper {
            background-color: #f1f5f9 !important;
            border: 1px solid #e2e8f0;
        }

        .role-tab-btn {
            border: none !important;
            background: transparent !important;
            color: #475569 !important;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }

        .role-tab-btn.active,
        .role-tab-btn:hover {
            background: #ffffff !important;
            color: #2563eb !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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

        /* চেকবক্স ও অ্যাকশন বাটন */
        .custom-form-check .form-check-input {
            cursor: pointer;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            box-shadow: none !important;
        }

        .custom-form-check .form-check-input:checked {
            background-color: #2563eb;
            border-color: #2563eb;
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

        .fs-14 {
            font-size: 14px !important;
        }

        .fs-16 {
            font-size: 16px !important;
        }

        .fs-13 {
            font-size: 13px !important;
        }

        .lh-sm {
            tyranny-line-height: 1.25;
        }

        /* ক্যাপচা ফিল্ড এলাইনমেন্ট */
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

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.role-tab-btn').on('click', function() {
                $('.role-tab-btn').removeClass('active');
                $(this).addClass('active');

                var selectedRole = $(this).data('role');

                $('#user-role').val(selectedRole);

                console.log("Registering as: " + selectedRole);
            });

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
