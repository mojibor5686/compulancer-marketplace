@extends('Template::layouts.frontend')
@section('content')
    @php
        $contactContent = getContent('contact.content', true);
        $contactElements = getContent('contact.element', false, null, true);
    @endphp

    <main class="page-wrapper pt-80 pb-80 main-contact-wrapper">
        <div class="container">

            <div class="row g-5 align-items-stretch">
                <div class="col-lg-7 d-flex">
                    <div class="latest-contact-card w-100">
                        <form class="contact-form verify-gcaptcha" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="input-glow-group">
                                        <label class="latest-label required" for="name">@lang('Full name')</label>
                                        <input class="form-control latest-input" name="name" type="text"
                                            value="{{ old('name', @$user->fullname) }}" placeholder="@lang('e.g. John Doe')"
                                            @if ($user && $user->profile_complete) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-glow-group">
                                        <label class="latest-label required" for="email">@lang('Email Address')</label>
                                        <input class="form-control latest-input" name="email" type="email"
                                            value="{{ old('email', @$user->email) }}" placeholder="@lang('e.g. john@example.com')"
                                            @readonly(@$user) required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input-glow-group">
                                        <label class="latest-label required" for="subject">@lang('Subject')</label>
                                        <input class="form-control latest-input" name="subject" type="text"
                                            value="{{ old('subject') }}" placeholder="@lang('What is this regarding?')" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input-glow-group">
                                        <label class="latest-label required" for="message">@lang('Message')</label>
                                        <textarea class="form-control latest-input" name="message" rows="5" placeholder="@lang('Describe your inquiry in detail...')" required>{{ old('message') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12 my-2">
                                    <x-captcha frontend="true" isCustom="true" />
                                </div>

                                <div class="col-sm-12 mt-4">
                                    <button class="btn latest-submit-btn w-100" type="submit">
                                        <span>@lang('Send Message')</span>
                                        <i class="ri-send-plane-fill ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5 d-flex">
                    <div class="latest-info-panel w-100">
                        <div class="panel-header mb-4">
                            <h4 class="fw-bold text-white mb-2">@lang('Contact Information')</h4>
                            <p class="text-white-50 small m-0">@lang('Reach out to us directly through any of these channels.')</p>
                        </div>

                        <div class="info-cards-stack">
                            @if (@$contactContent->data_values->address)
                                <div class="premium-info-card">
                                    <div class="premium-icon-box">
                                        @include('Template::partials.icons.address')
                                    </div>
                                    <div class="premium-text-box">
                                        <span class="premium-label">@lang('Our Office')</span>
                                        <p class="premium-value">{{ __(@$contactContent->data_values->address) }}</p>
                                    </div>
                                </div>
                            @endif

                            @if (@$contactContent->data_values->email)
                                <div class="premium-info-card">
                                    <div class="premium-icon-box">
                                        @include('Template::partials.icons.email')
                                    </div>
                                    <div class="premium-text-box">
                                        <span class="premium-label">@lang('Email Us')</span>
                                        <p class="premium-value">
                                            <a href="mailto:{{ __(@$contactContent->data_values->email) }}"
                                                class="premium-link">
                                                {{ __(@$contactContent->data_values->email) }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if (@$contactContent->data_values->contact)
                                <div class="premium-info-card">
                                    <div class="premium-icon-box">
                                        @include('Template::partials.icons.contact')
                                    </div>
                                    <div class="premium-text-box">
                                        <span class="premium-label">@lang('Call Support')</span>
                                        <p class="premium-value">
                                            <a href="tel:{{ __(@$contactContent->data_values->contact) }}"
                                                class="premium-link">
                                                {{ __(@$contactContent->data_values->contact) }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if (@$contactContent->data_values->fax)
                                <div class="premium-info-card">
                                    <div class="premium-icon-box">
                                        @include('Template::partials.icons.fax')
                                    </div>
                                    <div class="premium-text-box">
                                        <span class="premium-label">@lang('Fax Machine')</span>
                                        <p class="premium-value text-white-50 fw-medium">
                                            {{ __(@$contactContent->data_values->fax) }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('style')
    <style>
        /* মডার্ন গ্লোবাল সেটিংস */
        .main-contact-wrapper {
            background: radial-gradient(circle at 10% 20%, rgba(234, 241, 253, 0.6) 0%, rgba(255, 255, 255, 1) 90.1%) !important;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .pt-80 {
            padding-top: 80px;
        }

        .pb-80 {
            padding-bottom: 80px;
        }

        .max-w-700 {
            max-width: 700px;
        }

        .bg-theme-light {
            background-color: rgba(60, 136, 238, 0.1) !important;
        }

        .text-theme {
            color: #3C88EE !important;
        }

        .main-title {
            font-size: 36px;
            letter-spacing: -1px;
            color: #1e293b !important;
        }

        .sub-title {
            font-size: 15px;
            line-height: 1.6;
        }

        /* লেটেস্ট ও প্রিমিয়াম ফর্ম কার্ড ডিজাইন */
        .latest-contact-card {
            background: #ffffff;
            border: 1px solid rgba(60, 136, 238, 0.12);
            border-radius: 24px;
            padding: 45px;
            box-shadow: 0 10px 40px -10px rgba(60, 136, 238, 0.06), 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }

        .latest-contact-card:hover {
            box-shadow: 0 20px 50px -15px rgba(60, 136, 238, 0.12);
        }

        .latest-label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .latest-label.required::after {
            content: " *";
            color: #ef4444;
        }

        .latest-input {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 12px !important;
            padding: 14px 18px !important;
            font-size: 14px !important;
            color: #1e293b !important;
            background-color: #f8fafc !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .latest-input::placeholder {
            color: #94a3b8 !important;
        }

        /* ইনপুট ফিল্ডে হোভার ও ফোকাস গ্লো ইফেক্ট */
        .latest-input:hover {
            border-color: #cbd5e1 !important;
            background-color: #ffffff !important;
        }

        .latest-input:focus {
            border-color: #3C88EE !important;
            background-color: #ffffff !important;
            box-shadow: 0 0 0 4px rgba(60, 136, 238, 0.12) !important;
            outline: none !important;
        }

        textarea.latest-input {
            resize: none;
        }

        /* প্রিমিয়াম সাবমিট বাটন অ্যানিমেশন */
        .latest-submit-btn {
            background: linear-gradient(135deg, #3C88EE 0%, #1e70dd 100%) !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            padding: 16px 30px !important;
            border-radius: 12px !important;
            border: none !important;
            font-size: 16px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px rgba(60, 136, 238, 0.3) !important;
        }

        .latest-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(60, 136, 238, 0.45) !important;
            opacity: 0.95;
        }

        .latest-submit-btn:active {
            transform: translateY(0);
        }

        /* ডান পাশের প্রিমিয়াম গ্রেডিয়েন্ট ইনফো প্যানেল */
        .latest-info-panel {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
            border-radius: 24px;
            padding: 45px;
            color: #ffffff;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
            display: flex;
            flex-direction: column;
        }

        .info-cards-stack {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: auto;
            margin-bottom: auto;
        }

        /* গ্লাস মরফিজম ইনফো কার্ড */
        .premium-info-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .premium-info-card:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(60, 136, 238, 0.4);
            transform: translateX(5px);
        }

        /* আইকন বক্স ডিজাইন */
        .premium-icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: rgba(60, 136, 238, 0.15);
            color: #3C88EE;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(60, 136, 238, 0.25);
            transition: all 0.3s ease;
        }

        .premium-info-card:hover .premium-icon-box {
            background: #3C88EE;
            color: #ffffff;
            box-shadow: 0 0 15px rgba(60, 136, 238, 0.5);
        }

        .premium-icon-box svg {
            width: 22px;
            height: 22px;
            fill: currentColor;
        }

        /* টেক্সট কন্টেন্ট */
        .premium-text-box {
            display: flex;
            flex-direction: column;
        }

        .premium-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 4px;
        }

        .premium-value {
            font-size: 15px;
            color: #f1f5f9;
            font-weight: 500;
            margin: 0;
            line-height: 1.4;
        }

        .premium-link {
            color: #f1f5f9;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .premium-link:hover {
            color: #3C88EE;
        }

        /* ডেস্কটপ ও মোবাইলের জন্য নিখুঁত রেসপনসিভ মিডিয়া কুয়েরি */
        @media (max-width: 991.98px) {
            .pt-80 {
                padding-top: 40px;
            }

            .pb-80 {
                padding-bottom: 40px;
            }

            .main-title {
                font-size: 28px;
            }

            .latest-contact-card,
            .latest-info-panel {
                padding: 30px;
                border-radius: 20px;
            }

            .premium-info-card {
                padding: 16px;
            }
        }

        @media (max-width: 575.98px) {

            .latest-contact-card,
            .latest-info-panel {
                padding: 20px;
            }

            .premium-info-card {
                gap: 14px;
            }

            .premium-icon-box {
                width: 42px;
                height: 42px;
            }

            .premium-value {
                font-size: 13px;
            }
        }
    </style>
@endpush
