<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ gs()->siteName(__($pageTitle ?? '')) }}</title>
    @include('partials.seo')
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/overlayscrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/iziToast_custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset(activeTemplate(true) . 'css/jquery-ui.min.css') }}">
    @stack('style-lib')
    <link rel="stylesheet" href="{{ asset(activeTemplate(true) . 'css/style.css') }}">
    @stack('style')
    <link rel="stylesheet" href="{{ asset(activeTemplate(true) . 'css/custom.css') }}">

    <link rel="stylesheet"
        href="{{ asset(activeTemplate(true) . 'css/color.php') }}?color={{ gs('base_color') }}&secondColor={{ gs('secondary_color') }}&get=20">
</head>
<style>
    .user-profile-dropdown-wrapper:hover .custom-hover-menu {
        visibility: visible !important;
        opacity: 1 !important;
        transform: translateY(0) !important;
    }

    .hover-menu-link {
        text-decoration: none;
        color: #495057;
        font-size: 13px;
        font-weight: 500;
        display: flex;
        transition: all 0.2s ease;
    }

    .hover-menu-link i {
        font-size: 16px;
        color: #6c757d;
        width: 20px;
    }

    .hover-menu-link:hover {
        background-color: #f8f9fa;
        color: var(--bs-primary, #0d6efd);
    }

    .hover-menu-link:hover i {
        color: var(--bs-primary, #0d6efd);
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>

<body>
    <div class="preloader">
        <div class="loader-p"></div>
    </div>

    <div class="body-overlay"></div>
    <div class="sidebar-overlay"></div>
    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>


    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>

    <script src="{{ asset(activeTemplate(true) . 'js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset(activeTemplate(true) . 'js/overlayscrollbars.min.js') }}"></script>
    <script src="{{ asset(activeTemplate(true) . 'js/main.js') }}"></script>

    <main class="page-wrapper">
        <section class="dashboard">
            <div class="w-100 px-0">
                <div class="dashboard-inner">
                    @if (session('userType') === 'buyer' || (session('userType') === null && request()->routeIs('user.buyer.*')))
                        @include('Template::partials.buyer_sidebar')
                    @else
                        @include('Template::partials.seller_sidebar')
                    @endif

                    <div class="dashboard-content">
                        <div class="dashboard-topnav d-flex align-items-center justify-content-between w-100 bg-white border-bottom px-4 py-2"
                            style="height: 70px; z-index: 99;">

                            <div class="topnav-left d-lg-block d-none">
                                <a href="{{ url('/') }}"
                                    class="text-decoration-none text-dark fw-medium d-flex align-items-center gap-2 fs-6"
                                    style="transition: color 0.2s ease;"
                                    onmouseover="this.style.color='var(--bs-primary)'"
                                    onmouseout="this.style.color='var(--text-dark)'">
                                    <i class="fas fa-arrow-left"></i>
                                    <span style="font-size: 14px;">@lang('Back to Home')</span>
                                </a>
                            </div>

                            <button class="btn btn--base d-lg-none mb-4" type="button" data-toggle="offcanvas-sidebar"
                                data-target="#dashboard-offcanvas-sidebar">
                                <span class="d-inline-flex align-items-center justify-content-center gap-2">
                                    <i class="fas fa-bars"></i>
                                    <span style="font-size: 14px;">@lang('Menu')</span>
                                </span>
                            </button>

                            <div class="topnav-right d-flex align-items-center gap-4">

                                <div class="notification-box position-relative cursor-pointer">
                                    <a href="#" class="text-dark position-relative">
                                        <i class="far fa-bell fs-4"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger d-flex align-items-center justify-content-center p-0"
                                            style="width: 16px; height: 16px; font-size: 10px; margin-top: 2px;">
                                            0
                                        </span>
                                    </a>
                                </div>

                                <div class="user-profile-dropdown-wrapper position-relative py-2">
                                    <div class="user-profile-trigger d-flex align-items-center gap-2 cursor-pointer">
                                        <img src="https://work.mojibor.com/assets/images/avatar.jpg" alt="User Profile"
                                            class="rounded-circle object-fit-cover"
                                            style="width: 42px; height: 42px; border: 2px solid #e9ecef;">
                                        <div class="user-info-text lh-sm">
                                            <h6 class="m-0 fw-bold text-dark" style="font-size: 14px;">
                                                {{ auth()->user()->name }}</h6>
                                            <small class="text-muted d-block" style="font-size: 11px;">
                                                @lang('Freelancer') <span
                                                    class="text-danger fw-semibold">{{ number_format(auth()->user()->balance, 2) }}</span>
                                            </small>
                                        </div>
                                    </div>

                                    <div class="custom-hover-menu shadow border rounded bg-white position-absolute end-0 pt-2 pb-2"
                                        style="width: 230px; top: 100%; transition: all 0.2s ease-in-out; visibility: hidden; opacity: 0; transform: translateY(10px); z-index: 9999;">
                                        <ul class="list-unstyled m-0 p-0">
                                            <li class="px-3 py-2 border-bottom mb-1 bg-light">
                                                @if (session('userType') === 'buyer' || (session('userType') === null && request()->routeIs('user.buyer.*')))
                                                    <a href="{{ route('user.seller.home') }}"
                                                        class="text-decoration-none text-dark fw-bold d-flex align-items-center gap-2"
                                                        style="font-size: 13px;">
                                                        <i class="las la-random text-primary"></i> @lang('Switch to Employer')
                                                    </a>
                                                @else
                                                    <a href="{{ route('user.buyer.home') }}"
                                                        class="text-decoration-none text-dark fw-bold d-flex align-items-center gap-2"
                                                        style="font-size: 13px;">
                                                        <i class="las la-random text-primary"></i> @lang('Switch to Buyer')
                                                    </a>
                                                @endif
                                            </li>
                                            <li><a class="hover-menu-link px-3 py-2 d-flex align-items-center gap-2"
                                                    href="{{ route('user.seller.home') }}"><i
                                                        class="las la-border-all"></i> @lang('Dashboard')</a></li>
                                            <li><a class="hover-menu-link px-3 py-2 d-flex align-items-center gap-2"
                                                    href="{{ route('user.inbox.messages') }}"><i
                                                        class="las la-sms"></i>
                                                    @lang('Messages')</a>
                                            </li>
                                            <li><a class="hover-menu-link px-3 py-2 d-flex align-items-center gap-2"
                                                    href="{{ route('user.seller.service.index') }}"><i
                                                        class="las la-box"></i> @lang('My Package')</a>
                                            </li>
                                            <li><a class="hover-menu-link px-3 py-2 d-flex align-items-center gap-2"
                                                    href="{{ route('user.profile.setting') }}"><i
                                                        class="las la-cog"></i> @lang('Settings')</a>
                                            </li>
                                            <li class="border-top mt-1 pt-1"><a
                                                    class="hover-menu-link px-3 py-2 d-flex align-items-center gap-2 text-danger"
                                                    href="{{ route('user.logout') }}"><i
                                                        class="las la-sign-out-alt"></i>
                                                    @lang('Logout')</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dashboard-main-content">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @stack('script')

    <script>
        (function($) {
            "use strict";

            $(document).ready(function() {

                $('.select2-basic').wrap('<div class="select2-wrapper"></div>');
                $('.select2-auto-tokenize').wrap('<div class="select2-wrapper"></div>');


                $(".select2-basic").each((index, select) => {
                    $(select).select2({
                        dropdownParent: $(select).closest(".select2-wrapper"),
                    });
                });

                $(".select2-auto-tokenize").each((index, select) => {
                    $(select).select2({
                        tags: true,
                        tokenSeparators: [','],
                        dropdownParent: $(select).closest(".select2-wrapper"),
                    });
                });

            });

            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                        colum.setAttribute('data-label', heading[i].innerText)
                    });
                });
            });
            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            let disableSubmission = false;
            $('.disableSubmission').on('submit', function(e) {
                if (disableSubmission) {
                    e.preventDefault()
                } else {
                    disableSubmission = true;
                }
            });

            $.each($('input:not([type=checkbox]):not([type=hidden]), select, textarea'), function(i, element) {

                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }

            });
        })(jQuery);
    </script>
</body>

</html>
