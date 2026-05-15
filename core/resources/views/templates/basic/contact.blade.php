@extends('Template::layouts.frontend')
@section('content')
    @php
        $contactContent = getContent('contact.content', true);
        $contactElements = getContent('contact.element', false, null, true);
    @endphp

    <main class="page-wrapper pt-0">
        <section class="contact">
            <div class="container">
                <div class="row gy-4">
                    <!-- Contact Form Section -->
                    <div class="col-lg-7">
                        <div class="contact-card">
                            <div class="contact-card__header">
                                <h3 class="contact-card__title">{{ __(@$contactContent->data_values->form_heading) }}</h3>
                                <p class="contact-card__desc">{{ __(@$contactContent->data_values->form_sub_heading) }}</p>
                            </div>
                            <div class="contact-card__body">
                                <form class="contact-form verify-gcaptcha" method="POST">
                                    @csrf
                                    <div class="row gy-3">
                                        <div class="col-sm-6">
                                            <label class="form-label form--label required"
                                                for="name">@lang('Full name')</label>
                                            <input class="form-control form--control" name="name" type="text"
                                                value="{{ old('name', @$user->fullname) }}" placeholder="@lang('Your name')"
                                                @if ($user && $user->profile_complete) readonly @endif required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label form--label required"
                                                for="email">@lang('Email')</label>
                                            <input class="form-control form--control" name="email" type="email"
                                                value="{{ old('email', @$user->email) }}" placeholder="@lang('Your email')"
                                                @readonly(@$user) required>
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label form--label required"
                                                for="subject">@lang('Subject')</label>
                                            <input class="form-control form--control" name="subject" type="text"
                                                value="{{ old('subject') }}" placeholder="@lang('Your subject')" required>
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label form--label required"
                                                for="message">@lang('Message')</label>
                                            <textarea class="form-control form--control" name="message" placeholder="@lang('Your message')" required>{{ old('message') }}</textarea>
                                        </div>
                                        <div class="col-sm-12">
                                            <x-captcha frontend="true" isCustom="true" />
                                        </div>
                                        <div class="col-sm-12">
                                            <button class="w-100 btn btn--lg btn--base"
                                                type="submit">@lang('Send Message')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="col-lg-5">
                        <div class="contact-info">
                            <h4 class="contact-info__title">{{ __(@$contactContent->data_values->heading) }}</h4>
                            <p class="contact-info__desc">{{ __(@$contactContent->data_values->sub_heading) }}</p>
                            <ul class="contact-list">
                                @if (@$contactContent->data_values->address)
                                    <li class="contact-list-item">
                                        <div class="contact-list-item__icon">
                                            @include('Template::partials.icons.address')
                                        </div>
                                        <div class="contact-list-item__content">
                                            <h6 class="contact-list-item__title">@lang('Address')</h6>
                                            <p class="contact-list-item__desc">
                                                {{ __(@$contactContent->data_values->address) }}</p>
                                        </div>
                                    </li>
                                @endif

                                @if (@$contactContent->data_values->email)
                                    <li class="contact-list-item">
                                        <div class="contact-list-item__icon">
                                            @include('Template::partials.icons.email')
                                        </div>
                                        <div class="contact-list-item__content">
                                            <h6 class="contact-list-item__title">@lang('Email')</h6>
                                            <p class="contact-list-item__desc">
                                                <a class="contact-list-item__link"
                                                    href="mailto:{{ __(@$contactContent->data_values->email) }}">{{ __(@$contactContent->data_values->email) }}</a>
                                            </p>
                                        </div>
                                    </li>
                                @endif

                                @if (@$contactContent->data_values->contact)
                                    <li class="contact-list-item">
                                        <div class="contact-list-item__icon">
                                            @include('Template::partials.icons.contact')
                                        </div>
                                        <div class="contact-list-item__content">
                                            <h6 class="contact-list-item__title">@lang('Contact')</h6>
                                            <p class="contact-list-item__desc">
                                                <a class="contact-list-item__link"
                                                    href="tel:{{ __(@$contactContent->data_values->contact) }}">{{ __(@$contactContent->data_values->contact) }}</a>
                                            </p>
                                        </div>
                                    </li>
                                @endif

                                @if (@$contactContent->data_values->fax)
                                    <li class="contact-list-item">
                                        <div class="contact-list-item__icon">
                                            @include('Template::partials.icons.fax')
                                        </div>
                                        <div class="contact-list-item__content">
                                            <h6 class="contact-list-item__title">@lang('Fax')</h6>
                                            <p class="contact-list-item__desc">{{ __(@$contactContent->data_values->fax) }}
                                            </p>
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
        .contact-list-item__icon {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
    </style>
@endpush
