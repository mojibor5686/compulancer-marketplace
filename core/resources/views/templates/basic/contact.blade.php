@extends('Template::layouts.frontend')
@section('content')
    @php
        $contactContent = getContent('contact.content', true);
        $contactElements = getContent('contact.element', false, null, true);
    @endphp

    <main class="page-wrapper pt-5 pb-5 bg-fafafa">
        <section class="contact-section">
            <div class="container">
                <div class="row g-4 justify-content-between">
                    <div class="col-lg-7">
                        <div class="modern-contact-card">
                            <div class="card-header-custom mb-4">
                                <h4 class="fw-semibold text-dark mb-1">
                                    {{ __(@$contactContent->data_values->form_heading ?? 'Send us a message') }}
                                </h4>
                                <p class="text-muted small mb-0">
                                    {{ __(@$contactContent->data_values->form_sub_heading ?? 'Keep it professional, our agents respond within 24 hours.') }}
                                </p>
                            </div>

                            <form class="contact-form verify-gcaptcha" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="modern-label required" for="name">@lang('Full name')</label>
                                        <input class="form-control modern-input" name="name" type="text"
                                            value="{{ old('name', @$user->fullname) }}" placeholder="@lang('e.g. John Doe')"
                                            @if ($user && $user->profile_complete) readonly @endif required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="modern-label required" for="email">@lang('Email Address')</label>
                                        <input class="form-control modern-input" name="email" type="email"
                                            value="{{ old('email', @$user->email) }}" placeholder="@lang('e.g. john@example.com')"
                                            @readonly(@$user) required>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="modern-label required" for="subject">@lang('Subject')</label>
                                        <input class="form-control modern-input" name="subject" type="text"
                                            value="{{ old('subject') }}" placeholder="@lang('What is this regarding?')" required>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="modern-label required" for="message">@lang('Message')</label>
                                        <textarea class="form-control modern-input" name="message" rows="5" placeholder="@lang('Describe your inquiry in detail...')" required>{{ old('message') }}</textarea>
                                    </div>

                                    <div class="col-sm-12 my-2">
                                        <x-captcha frontend="true" isCustom="true" />
                                    </div>

                                    <div class="col-sm-12 mt-4">
                                        <button class="btn modern-submit-btn w-100" type="submit">
                                            @lang('Send Message') <i class="ri-send-plane-fill ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="modern-info-panel">
                            <ul class="modern-info-list m-0 p-0 list-unstyled">

                                @if (@$contactContent->data_values->address)
                                    <li class="info-card-item">
                                        <div class="info-icon-wrapper address-bg">
                                            @include('Template::partials.icons.address')
                                        </div>
                                        <div class="info-content">
                                            <span class="info-label">@lang('Our Office')</span>
                                            <p class="info-value">{{ __(@$contactContent->data_values->address) }}</p>
                                        </div>
                                    </li>
                                @endif

                                @if (@$contactContent->data_values->email)
                                    <li class="info-card-item">
                                        <div class="info-icon-wrapper email-bg">
                                            @include('Template::partials.icons.email')
                                        </div>
                                        <div class="info-content">
                                            <span class="info-label">@lang('Email Us')</span>
                                            <p class="info-value">
                                                <a href="mailto:{{ __(@$contactContent->data_values->email) }}"
                                                    class="info-link">
                                                    {{ __(@$contactContent->data_values->email) }}
                                                </a>
                                            </p>
                                        </div>
                                    </li>
                                @endif

                                @if (@$contactContent->data_values->contact)
                                    <li class="info-card-item">
                                        <div class="info-icon-wrapper phone-bg">
                                            @include('Template::partials.icons.contact')
                                        </div>
                                        <div class="info-content">
                                            <span class="info-label">@lang('Call Support')</span>
                                            <p class="info-value">
                                                <a href="tel:{{ __(@$contactContent->data_values->contact) }}"
                                                    class="info-link">
                                                    {{ __(@$contactContent->data_values->contact) }}
                                                </a>
                                            </p>
                                        </div>
                                    </li>
                                @endif

                                @if (@$contactContent->data_values->fax)
                                    <li class="info-card-item">
                                        <div class="info-icon-wrapper fax-bg">
                                            @include('Template::partials.icons.fax')
                                        </div>
                                        <div class="info-content">
                                            <span class="info-label">@lang('Fax Machine')</span>
                                            <p class="info-value text-dark fw-medium">
                                                {{ __(@$contactContent->data_values->fax) }}</p>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('style')
    <style>
        /* প্রফেশনাল প্ল্যাটফর্ম ব্যাকগ্রাউন্ড কালার */
        .bg-fafafa {
            background-color: #f7f9fa !important;
        }

        .max-w-700 {
            max-width: 700px;
        }

        .tracking-tight {
            letter-spacing: -0.6px;
        }

        /* ফাইভার/আপওয়ার্ক আর্কিটেকচার কন্টাক্ট কার্ড */
        .modern-contact-card {
            background: #ffffff;
            border: 1px solid #e4e6eb;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        }

        /* স্মার্ট ইনপুট ফিল্ড ও লেবেল সিস্টেম */
        .modern-label {
            font-size: 14px;
            font-weight: 600;
            color: #222222;
            margin-bottom: 6px;
            display: inline-block;
        }

        .modern-label.required::after {
            content: " *";
            color: #ec2222;
        }

        .modern-input {
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            padding: 12px 16px !important;
            font-size: 14px !important;
            color: #333333 !important;
            background-color: #ffffff !important;
            transition: all 0.2s ease-in-out !important;
        }

        .modern-input:focus {
            border-color: #108a00 !important;
            /* Upwork Green Focus */
            box-shadow: 0 0 0 4px rgba(16, 138, 0, 0.1) !important;
            outline: none !important;
        }

        textarea.modern-input {
            resize: none;
        }

        /* সাবমিট বাটন (Upwork/Fiverr Standard Premium Green) */
        .modern-submit-btn {
            background-color: #108a00 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            padding: 14px 24px !important;
            border-radius: 8px !important;
            border: none !important;
            font-size: 15px !important;
            transition: background 0.2s ease !important;
        }

        .modern-submit-btn:hover {
            background-color: #14a800 !important;
            color: #ffffff !important;
        }

        /* ডান পাশের মডার্ন ইনফো প্যানেল */
        .modern-info-panel {
            background: transparent;
        }

        .info-card-item {
            background: #ffffff;
            border: 1px solid #e4e6eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.01);
            transition: transform 0.2s ease;
        }

        .info-card-item:hover {
            transform: translateY(-2px);
        }

        /* মিনিমাল আইকন কন্টেইনার্স */
        .info-icon-wrapper {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-icon-wrapper svg {
            width: 20px;
            height: 20px;
        }

        /* আইকনগুলোর জন্য সফ্ট মেটেরিয়াল কালার প্যালেট */
        .address-bg {
            background-color: #eef2ff;
            color: #4f46e5;
        }

        .email-bg {
            background-color: #ecfdf5;
            color: #059669;
        }

        .phone-bg {
            background-color: #fff7ed;
            color: #ea580c;
        }

        .fax-bg {
            background-color: #f1f5f9;
            color: #475569;
        }

        /* টেক্সট ও লিংক ফরমেটিং */
        .info-content {
            display: flex;
            flex-column: column;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 2px;
            display: block;
        }

        .info-value {
            font-size: 15px;
            color: #1e293b;
            font-weight: 500;
            margin: 0;
            line-height: 1.4;
        }

        .info-link {
            color: #1e293b;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .info-link:hover {
            color: #108a00;
            text-decoration: underline;
        }

        /* রেসপনসিভ হ্যান্ডলার */
        @media (max-width: 767.98px) {
            .modern-contact-card {
                padding: 24px;
            }
        }
    </style>
@endpush
