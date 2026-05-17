@php
    $footerContent = getContent('footer.content', true);
    $footerElements = getContent('footer.element', false, null, true);
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp

<footer class="footer kwork-footer d-none d-lg-block">
    <div class="container">
        <!-- Top Content -->
        <div class="kwork-footer__top">
            <div class="row g-4">
                <div class="col-lg-6">
                    <h2 class="kwork-footer__title">
                        <img src="{{ siteLogo() }}" alt="Logo" class="work-footer__logo" height="40">
                        <div>
                            {{ __(@$footerContent->data_values->heading ?? 'Professional Services') }}
                        </div>
                    </h2>
                    <p class="kwork-footer__subtitle">
                        {{ __(@$footerContent->data_values->description ?? 'Getting things done has never been easier.') }}
                    </p>

                    <p class="kwork-footer__text">
                        {{ __(@$footerContent->data_values->top_text_left ?? 'We built our platform to help users find the right services quickly and confidently.') }}
                    </p>
                </div>

                <div class="col-lg-6">
                    <p class="kwork-footer__text">
                        {{ __(@$footerContent->data_values->top_text_right ?? 'Need something done fast? Post a request and get offers from talented professionals.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Middle Links -->
        <div class="kwork-footer__middle">
            <div class="row g-4 align-items-start">
                <div class="col-lg-3 col-md-6">
                    <div class="kwork-footer__brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ siteLogo() }}" alt="Logo" class="kwork-footer__logo" height="40">
                        </a>

                        <div class="kwork-footer__payments">
                            <img src="https://cdn.kwork.com/images/footer/mastercard.svg" alt="Mastercard">
                            <img src="https://cdn.kwork.com/images/footer/visa.svg" alt="Visa">
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="kwork-footer__heading">@lang('About')</h5>
                    <ul class="kwork-footer__menu">
                        <li><a href="">@lang('About Us')</a></li>
                        <li><a href="">@lang('Terms of Service')</a></li>
                        <li><a href="">@lang('Privacy Policy')</a></li>
                        <li><a href="">@lang('Contact Us')</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="kwork-footer__heading">@lang('Resources')</h5>
                    <ul class="kwork-footer__menu">
                        <li><a href="{{ route('service') }}">@lang('Services')</a></li>
                        <li><a href="{{ route('software') }}">@lang('Software')</a></li>
                        <li><a href="{{ route('job') }}">@lang('Jobs')</a></li>
                        <li><a href="{{ route('blogs') }}">@lang('Blogs')</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="kwork-footer__heading">@lang('Help Center')</h5>
                    <ul class="kwork-footer__menu">
                        <li><a href="{{ route('contact') }}">@lang('Contact Support')</a></li>
                        @foreach ($policyPages->take(3) as $policy)
                            <li>
                                <a href="{{ route('policy.pages', $policy->slug) }}">
                                    {{ __(@$policy->data_values->title) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom -->
        <div class="kwork-footer__bottom">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <p class="mb-0">
                        {{ __(@$footerContent->data_values->copyright_text) }}
                    </p>
                </div>

                <div class="col-lg-6 text-lg-end">
                    <ul class="social-list justify-content-lg-end">
                        @foreach ($footerElements as $footer)
                            <li class="social-list__item">
                                <a href="{{ @$footer->data_values->url }}" class="social-list__link" target="__blank">
                                    @php echo @$footer->data_values->social_icon @endphp
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<style>
    .kwork-footer {
        background: #fff;
        color: #222;
        padding: 70px 0 20px;
        border-top: 1px solid #e9e9e9;
    }

    .kwork-footer__top {
        padding-bottom: 55px;
    }

    .kwork-footer__title {
        font-size: 34px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #222;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .kwork-footer__subtitle {
        font-size: 18px;
        margin-bottom: 22px;
        color: #555;
    }

    .kwork-footer__text {
        font-size: 15px;
        line-height: 1.8;
        color: #555;
        margin-bottom: 14px;
    }

    .kwork-footer__middle {
        padding: 35px 0;
        border-top: 1px solid #ececec;
        border-bottom: 1px solid #ececec;
    }

    .kwork-footer__logo {
        max-width: 150px;
        height: auto;
        margin-bottom: 25px;
    }

    .kwork-footer__payments {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    

    .kwork-footer__heading {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 18px;
        color: #333;
    }

    .kwork-footer__menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .kwork-footer__menu li {
        margin-bottom: 12px;
    }

    .kwork-footer__menu a {
        color: #555;
        text-decoration: none;
        font-size: 15px;
        transition: 0.3s;
    }

    .kwork-footer__menu a:hover {
        color: #111;
    }

    .kwork-footer__bottom {
        padding-top: 18px;
        font-size: 14px;
        color: #777;
    }

    @media (max-width: 991px) {
        .kwork-footer {
            display: none !important;
        }
    }
</style>
