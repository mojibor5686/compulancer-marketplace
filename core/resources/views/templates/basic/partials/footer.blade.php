@php
    $footerContent = getContent('footer.content', true);
    $footerElements = getContent('footer.element', false, null, true);
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp

<footer class="footer kwork-footer">
    <div class="container">
        <!-- Top Content -->
        <div class="kwork-footer__top">
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="kwork-footer__brand-top">
                        <img src="{{ siteLogo() }}" alt="Logo" class="work-footer__logo"
                            style="height: 40px !important;">
                        <h2 class="kwork-footer__title mt-2">
                            {{ __(@$footerContent->data_values->heading) }}
                        </h2>
                    </div>
                    <p class="kwork-footer__subtitle">
                        {{ __(@$footerContent->data_values->description) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Middle Links -->
        <div class="kwork-footer__middle">
            <div class="row g-4 align-items-start">
                <!-- Brand & Payments -->
                <div class="col-lg-3 col-sm-6">
                    <div class="kwork-footer__brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ siteLogo() }}" alt="Logo" class="kwork-footer__logo" height="40">
                        </a>
                    </div>
                </div>

                <!-- About Menu -->
                <div class="col-lg-3 col-sm-6 kwork-footer__col">
                    <h5 class="kwork-footer__heading d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" data-bs-target="#footerAbout" aria-expanded="false">
                        @lang('Abouts Us')
                        <i class="las la-angle-down d-md-none"></i>
                    </h5>
                    <div class="collapse d-md-block" id="footerAbout">
                        <ul class="kwork-footer__menu">
                            <li><a href="/policy/terms-of-service">@lang('Terms of Service')</a></li>
                            <li><a href="/policy/privacy-policy">@lang('Privacy Policy')</a></li>
                            <li><a href="/contact">@lang('Contact Us')</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Resources Menu -->
                <div class="col-lg-3 col-sm-6 kwork-footer__col">
                    <h5 class="kwork-footer__heading d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" data-bs-target="#footerResources" aria-expanded="false">
                        @lang('Resources')
                        <i class="las la-angle-down d-md-none"></i>
                    </h5>
                    <div class="collapse d-md-block" id="footerResources">
                        <ul class="kwork-footer__menu">
                            <li><a href="{{ route('service') }}">@lang('Services')</a></li>
                            <li><a href="{{ route('software') }}">@lang('Software')</a></li>
                            <li><a href="{{ route('job') }}">@lang('Jobs')</a></li>
                            <li><a href="{{ route('blogs') }}">@lang('Blogs')</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Help Center Menu -->
                <div class="col-lg-3 col-sm-6 kwork-footer__col">
                    <h5 class="kwork-footer__heading d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" data-bs-target="#footerHelp" aria-expanded="false">
                        @lang('Help Center')
                        <i class="las la-angle-down d-md-none"></i>
                    </h5>
                    <div class="collapse d-md-block" id="footerHelp">
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
        </div>

        <!-- Bottom -->
        <div class="kwork-footer__bottom">
            <div class="row align-items-center gy-3">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0" style="font-size: 14px;">
                        {{ __(@$footerContent->data_values->copyright_text) }}
                    </p>
                </div>

                <div class="col-md-6">
                    <ul class="social-list justify-content-center justify-content-md-end">
                        @foreach ($footerElements as $footer)
                            <li class="social-list__item">
                                <a href="{{ @$footer->data_values->url }}" class="social-list__link" target="_blank">
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
        padding: 60px 0 20px;
        border-top: 1px solid #e9e9e9;
        margin-top: 20px;
    }

    .kwork-footer__top {
        padding-bottom: 40px;
    }

    .kwork-footer__title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #222;
    }

    .kwork-footer__subtitle {
        font-size: 16px;
        margin-bottom: 0;
        color: #555;
        line-height: 1.6;
    }

    .kwork-footer__middle {
        padding: 40px 0;
        border-top: 1px solid #ececec;
        border-bottom: 1px solid #ececec;
    }

    .kwork-footer__logo {
        max-width: 140px;
        height: auto;
    }

    .kwork-footer__payments {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .kwork-footer__heading {
        font-size: 18px;
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
        font-size: 14px;
        transition: 0.3s;
    }

    .kwork-footer__menu a:hover {
        color: #111;
    }

    .kwork-footer__bottom {
        padding-top: 20px;
        font-size: 14px;
        color: #777;
    }

    .social-list {
        display: flex;
        gap: 15px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    @media (max-width: 767px) {
        .kwork-footer {
            padding: 40px 0 20px;
        }

        .kwork-footer__top {
            text-center: center;
            padding-bottom: 30px;
        }

        .kwork-footer__heading {
            margin-bottom: 0;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f5;
            cursor: pointer;
            font-size: 16px;
        }

        .kwork-footer__col {
            border-bottom: 1px solid #ececec;
            padding-bottom: 5px;
        }

        .kwork-footer__menu {
            padding: 15px 5px 10px;
        }

        .kwork-footer__brand {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 15px;
        }
    }
</style>
