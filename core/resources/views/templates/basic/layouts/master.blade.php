<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ gs()->siteName(__($pageTitle ?? '')) }}</title>
    @include('partials.seo')
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
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


<body>
    <div class="preloader">
        <div class="loader-p"></div>
    </div>

    <div class="body-overlay"></div>
    <div class="sidebar-overlay"></div>
    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>


    <!-- Scripts -->
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
                        <button class="btn btn--base d-lg-none mb-4" type="button" data-toggle="offcanvas-sidebar"
                            data-target="#dashboard-offcanvas-sidebar">
                            <span class="d-inline-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-bars"></i>
                                <span>@lang('Menu')</span>
                            </span>
                        </button>
                        @yield('content')
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
