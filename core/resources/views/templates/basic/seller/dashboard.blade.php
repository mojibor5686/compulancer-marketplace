@extends('Template::layouts.master')
@section('content')
    <div class="notice"></div>
    @include('Template::partials.kyc')
    <!-- Dashboard Widgets -->
    <div class="dashboard-widget-grid">
        <!-- Current Balance Widget -->
        <div class="widget-dashboard widget-gradient widget-balance">
            <a href="{{ route('user.transactions') }}" class="widget-link"></a>
            <div class="widget-dashboard__wrapper">
                <img class="widget-dashboard__icon"
                    src="{{ getImage(activeTemplate(true) . '/images/thumbs/widget-dashboard-icon-1.png') }}" alt="">
                <span class="widget-dashboard__label">@lang('Current Balance')</span>
                <h4 class="widget-dashboard__total">
                    {{ gs('cur_sym') }}{{ showAmount(auth()->user()->balance, currencyFormat: false) }}
                </h4>
            </div>
            <span class="widget-dashboard__arrow">
                @include('Template::partials.icons.dashboard.balance')
            </span>
        </div>

        <!-- Total Service Widget -->
        <div class="widget-dashboard">
            <div class="widget-dashboard__icon">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M3.5 20C3.08334 20 2.72916 19.8541 2.4375 19.5625C2.14584 19.2709 2 18.9166 2 18.5V13.775H7.1V14.175C7.1 14.3917 7.17085 14.5708 7.3125 14.7125C7.45415 14.8541 7.63335 14.925 7.85 14.925C8.06665 14.925 8.24585 14.8541 8.3875 14.7125C8.52915 14.5708 8.6 14.3917 8.6 14.175V13.775H15.4V14.175C15.4 14.3917 15.4709 14.5708 15.6125 14.7125C15.7542 14.8541 15.9333 14.925 16.15 14.925C16.3666 14.925 16.5458 14.8541 16.6875 14.7125C16.8292 14.5708 16.9 14.3917 16.9 14.175V13.775H22V18.5C22 18.9166 21.8541 19.2709 21.5625 19.5625C21.2709 19.8541 20.9166 20 20.5 20H3.5ZM2.275 12.275L4.6 6.625C4.75 6.375 4.95 6.17085 5.2 6.0125C5.45 5.85415 5.71665 5.775 6 5.775H7.6V4.5C7.6 4.08334 7.74585 3.72916 8.0375 3.4375C8.32915 3.14584 8.68335 3 9.1 3H14.875C15.2916 3 15.6459 3.14584 15.9375 3.4375C16.2291 3.72916 16.375 4.08334 16.375 4.5V5.775H17.975C18.2584 5.775 18.525 5.85415 18.775 6.0125C19.025 6.17085 19.225 6.375 19.375 6.625L21.725 12.275H16.9V11.875C16.9 11.6584 16.8292 11.4791 16.6875 11.3375C16.5458 11.1958 16.3666 11.125 16.15 11.125C15.9333 11.125 15.7542 11.1958 15.6125 11.3375C15.4709 11.4791 15.4 11.6584 15.4 11.875V12.275H8.6V11.875C8.6 11.6584 8.52915 11.4791 8.3875 11.3375C8.24585 11.1958 8.06665 11.125 7.85 11.125C7.63335 11.125 7.45415 11.1958 7.3125 11.3375C7.17085 11.4791 7.1 11.6584 7.1 11.875V12.275H2.275ZM9.1 5.775H14.875V4.5H9.1V5.775Z"
                        fill="hsl(var(--base))" />
                </svg>
            </div>
            <div class="widget-dashboard__content">
                <a href="{{ route('user.seller.service.index') }}" class="widget-link"></a>
                <div class="widget-dashboard__wrapper">
                    <span class="widget-dashboard__label">@lang('Total Service')</span>
                    <h4 class="widget-dashboard__total">{{ $totalServiceCount }}</h4>
                </div>
                <span class="widget-dashboard__arrow">
                    @include('Template::partials.icons.dashboard.total_service')
                </span>
            </div>
        </div>

        <!-- Total Software Widget -->
        <div class="widget-dashboard">
            <div class="widget-dashboard__icon">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.5 21C4.08334 21 3.72916 20.8541 3.4375 20.5625C3.14584 20.2709 3 19.9166 3 19.5V6.125C3 5.95835 3.02917 5.80415 3.0875 5.6625C3.14584 5.52085 3.23333 5.38335 3.35 5.25L4.775 3.4C4.875 3.26667 4.99583 3.16666 5.1375 3.1C5.27915 3.03333 5.43335 3 5.6 3H18.425C18.5916 3 18.7459 3.03333 18.8875 3.1C19.0292 3.16666 19.15 3.26667 19.25 3.4L20.675 5.25C20.7583 5.38335 20.8333 5.52085 20.9 5.6625C20.9666 5.80415 21 5.95835 21 6.125V19.5C21 19.9166 20.8541 20.2709 20.5625 20.5625C20.2709 20.8541 19.9166 21 19.5 21H4.5ZM4.95 5.625H19.05L18.15 4.5H5.85L4.95 5.625ZM14.75 16.575L18 13.325L14.75 10.075L13.75 11.075L16 13.325L13.75 15.575L14.75 16.575ZM9.25 16.675L10.25 15.675L8 13.425L10.25 11.175L9.25 10.175L6 13.425L9.25 16.675Z"
                        fill="hsl(var(--base))" />
                </svg>
            </div>
            <div class="widget-dashboard__content">
                <a href="{{ route('user.seller.software.index') }}" class="widget-link"></a>
                <div class="widget-dashboard__wrapper">
                    <span class="widget-dashboard__label">@lang('Total Software')</span>
                    <h4 class="widget-dashboard__total">{{ $totalSoftwareCount }}</h4>
                </div>
                <span class="widget-dashboard__arrow">
                    @include('Template::partials.icons.dashboard.total_software')
                </span>
            </div>
        </div>

        <!-- Total Service Booking Widget -->
        <div class="widget-dashboard">
            <div class="widget-dashboard__icon">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.5 21C4.0875 21 3.73441 20.8531 3.44075 20.5592C3.14691 20.2656 3 19.9125 3 19.5V6.275C3 6.11035 3.025 5.9515 3.075 5.7985C3.125 5.6455 3.2 5.50435 3.3 5.375L4.6 3.6C4.73333 3.41666 4.90783 3.27083 5.1235 3.1625C5.33915 3.05416 5.56465 3 5.8 3H18.175C18.4103 3 18.6358 3.05416 18.8515 3.1625C19.0671 3.27083 19.2417 3.41666 19.375 3.6L20.7 5.375C20.8 5.50435 20.875 5.6455 20.925 5.7985C20.975 5.9515 21 6.11035 21 6.275V19.5C21 19.9125 20.8531 20.2656 20.5595 20.5592C20.2656 20.8531 19.9125 21 19.5 21H4.5ZM4.925 5.65H19.05L18.1397 4.5H5.825L4.925 5.65ZM16 7.15H8V15.7L12 13.7L16 15.7V7.15Z"
                        fill="hsl(var(--base))" />
                </svg>
            </div>
            <div class="widget-dashboard__content">
                <a href="{{ route('user.seller.booking.service.list') }}" class="widget-link"></a>
                <div class="widget-dashboard__wrapper">
                    <span class="widget-dashboard__label">@lang('Total Service Booking')</span>
                    <h4 class="widget-dashboard__total">{{ $totalServiceBooking }}</h4>
                </div>
                <span class="widget-dashboard__arrow">
                    @include('Template::partials.icons.dashboard.total_service_booking')
                </span>
            </div>
        </div>

        <!-- Total Software Sales Widget -->
        <div class="widget-dashboard">
            <div class="widget-dashboard__icon">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 7.28595 22 4.92893 20.5355 3.46447C19.0711 2 16.714 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447ZM15.5303 8.46967C15.8232 8.76256 15.8232 9.23744 15.5303 9.53033L9.53033 15.5303C9.23744 15.8232 8.76256 15.8232 8.46967 15.5303C8.17678 15.2374 8.17678 14.7626 8.46967 14.4697L14.4697 8.46967C14.7626 8.17678 15.2374 8.17678 15.5303 8.46967ZM10.5 9.5C10.5 10.0523 10.0523 10.5 9.5 10.5C8.94772 10.5 8.5 10.0523 8.5 9.5C8.5 8.94772 8.94772 8.5 9.5 8.5C10.0523 8.5 10.5 8.94772 10.5 9.5ZM14.5 15.5C15.0523 15.5 15.5 15.0523 15.5 14.5C15.5 13.9477 15.0523 13.5 14.5 13.5C13.9477 13.5 13.5 13.9477 13.5 14.5C13.5 15.0523 13.9477 15.5 14.5 15.5Z"
                        fill="hsl(var(--base))" />
                </svg>

            </div>
            <div class="widget-dashboard__content">
                <a href="{{ route('user.seller.sale.software.log') }}" class="widget-link"></a>
                <div class="widget-dashboard__wrapper">
                    <span class="widget-dashboard__label">@lang('Total Software Sales')</span>
                    <h4 class="widget-dashboard__total">{{ $totalSoftwareSales }}</h4>
                </div>
                <span class="widget-dashboard__arrow">
                    @include('Template::partials.icons.dashboard.total_software_sales')
                </span>
            </div>
        </div>

        <!-- Customer Reviews Section -->
        <div class="cs-reviews">
            <div class="cs-reviews__header">
                <h6 class="cs-reviews__title">@lang('Customer Reviews')</h6>
            </div>
            <div class="cs-reviews__body" data-overlayscrollbars-theme="os-theme-light">
                @if (count(@$reviews ?? []))
                    <ul class="cs-reviews-list">
                        @foreach (@$reviews ?? [] as $review)
                            <li class="cs-reviews-list-item">
                                <img class="cs-reviews-list-item__thumb"
                                    src="{{ getImage(getFilePath('userProfile') . '/' . @$review->user->image, isAvatar: true) }}"
                                    alt="">
                                <div class="cs-reviews-list-item__content">
                                    <div class="cs-reviews-list-item__wrapper">
                                        <h6 class="cs-reviews-list-item__name">{{ @$review->user->username }}</h6>
                                        <span
                                            class="cs-reviews-list-item__time">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="ratings style-two">
                                        @for ($i = 0; $i < intval($review->rating); $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </div>
                                    <p class="cs-reviews-list-item__desc">
                                        {{ __($review->review) }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="empty-message-box h-100">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="50" height="50" x="0" y="0" viewBox="0 0 512.002 512.002"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path
                                    d="M151.57 208.93c-1.86-1.86-4.44-2.93-7.07-2.93s-5.209 1.069-7.07 2.93c-1.86 1.86-2.93 4.44-2.93 7.07s1.07 5.21 2.93 7.069c1.86 1.86 4.44 2.931 7.07 2.931s5.21-1.07 7.07-2.931c1.86-1.859 2.93-4.439 2.93-7.069s-1.07-5.21-2.93-7.07z"
                                    fill="CurrentColor" opacity="1" data-original="CurrentColor" class="">
                                </path>
                                <path
                                    d="M482 0H84C67.458 0 54 13.458 54 30v166c0 16.542 13.458 30 30 30h18c5.523 0 10-4.478 10-10s-4.477-10-10-10H84c-5.514 0-10-4.486-10-10V30c0-5.514 4.486-10 10-10h398c5.514 0 10 4.486 10 10v166c0 5.514-4.486 10-10 10h-66.887a10.001 10.001 0 0 0-7.071 2.929l-32.929 32.929-32.929-32.929a10.001 10.001 0 0 0-7.071-2.929h-77.985a58.724 58.724 0 0 0-2.507-5.579c-7.16-13.911-19.348-24.078-34.316-28.629l-14.458-4.396c-5.09-1.55-10.502 1.162-12.312 6.165l-22.718 62.789a75.664 75.664 0 0 1-34.993 40.74l-21.326 11.612c-5.241-6.362-13.176-10.425-22.043-10.425h-63.9c-15.744 0-28.552 12.809-28.552 28.553v176.616C.001 499.191 12.81 512 28.554 512h63.9c9.954 0 18.729-5.123 23.841-12.868l10.204 4.002a127.9 127.9 0 0 0 46.898 8.868h134.928c20.245 0 36.715-16.47 36.715-36.715a36.47 36.47 0 0 0-4.962-18.396c14.894-4.681 25.729-18.615 25.729-35.034a36.489 36.489 0 0 0-5.2-18.81c14.26-5.044 24.506-18.655 24.506-34.621 0-16.63-11.118-30.705-26.308-35.203a36.475 36.475 0 0 0 4.865-18.229c0-20.244-16.47-36.715-36.715-36.715h-80.188l11.214-33.294a57.464 57.464 0 0 0 3.02-18.984h69.97l37.071 37.071c1.953 1.952 4.512 2.929 7.071 2.929s5.119-.977 7.071-2.929L419.256 226H482c16.542 0 30-13.458 30-30V30c0-16.542-13.458-30-30-30zM101.007 483.447c-.001 4.716-3.837 8.553-8.553 8.553h-63.9c-4.716 0-8.552-3.837-8.552-8.553V306.831c0-4.716 3.836-8.553 8.552-8.553h21.95v123.121c0 5.522 4.477 10 10 10s10-4.478 10-10V298.278h21.95c3.735 0 6.91 2.411 8.073 5.755.083.484.203.964.361 1.439.071.444.119.895.119 1.359v176.616zm225.949-185.17v.001c9.217 0 16.715 7.498 16.715 16.715 0 9.217-7.498 16.716-16.715 16.716h-54.251c-5.523 0-10 4.478-10 10s4.477 10 10 10l75.694.002c9.217 0 16.715 7.498 16.715 16.715 0 9.217-7.498 16.716-16.715 16.716h-75.694c-5.523 0-10 4.478-10 10s4.477 10 10 10h56.388c9.217 0 16.715 7.498 16.715 16.715 0 9.217-7.498 16.715-16.715 16.715h-56.388c-5.523 0-10 4.478-10 10s4.477 10 10 10h35.621c9.217 0 16.715 7.499 16.715 16.716 0 9.217-7.498 16.715-16.715 16.715H173.397c-13.607 0-26.929-2.52-39.596-7.487l-12.795-5.018V307.931l24.381-13.276a95.638 95.638 0 0 0 44.235-51.5l19.489-53.862 5.376 1.634c9.75 2.965 17.688 9.587 22.352 18.647s5.441 19.369 2.188 29.026l-15.657 46.485a10 10 0 0 0 9.477 13.192h94.109z"
                                    fill="CurrentColor" opacity="1" data-original="CurrentColor" class="">
                                </path>
                                <path
                                    d="M466.201 96.976c-1.894-5.824-6.836-9.989-12.898-10.868l-17.688-2.565-7.915-16.025c-2.712-5.491-8.199-8.901-14.323-8.901h-.004c-6.125.002-11.613 3.415-14.322 8.908l-7.906 16.03-17.688 2.575c-6.061.883-11.001 5.05-12.892 10.876-1.891 5.825-.341 12.1 4.047 16.375l12.802 12.472-3.017 17.617c-1.034 6.038 1.402 12.023 6.359 15.623a15.918 15.918 0 0 0 9.372 3.065c2.54 0 5.094-.613 7.453-1.854l15.819-8.322 15.823 8.313c5.422 2.848 11.868 2.381 16.823-1.221 4.954-3.602 7.387-9.589 6.35-15.626l-3.026-17.615 12.797-12.48c4.381-4.278 5.928-10.553 4.034-16.377zm-32.313 16.017a15.971 15.971 0 0 0-4.59 14.141l2.003 11.662-10.479-5.506a15.977 15.977 0 0 0-14.864.006l-10.473 5.51 1.997-11.663a15.97 15.97 0 0 0-4.598-14.14l-8.477-8.258 11.711-1.705a15.965 15.965 0 0 0 12.025-8.741l5.235-10.613 5.24 10.61a15.973 15.973 0 0 0 12.03 8.735l11.711 1.698-8.471 8.264zM338.988 96.976c-1.895-5.824-6.836-9.988-12.898-10.868l-17.688-2.565-7.915-16.025c-2.712-5.491-8.199-8.901-14.323-8.901h-.004c-6.125.002-11.614 3.415-14.323 8.909l-7.905 16.029-17.688 2.575c-6.061.883-11.001 5.05-12.892 10.876-1.891 5.825-.341 12.1 4.047 16.375l12.802 12.472-3.017 17.617c-1.034 6.038 1.403 12.024 6.359 15.623a15.915 15.915 0 0 0 9.371 3.065c2.54 0 5.093-.613 7.452-1.854l15.819-8.322 15.824 8.313c5.423 2.848 11.867 2.381 16.823-1.221 4.954-3.602 7.387-9.589 6.35-15.626l-3.026-17.615 12.797-12.48c4.383-4.278 5.93-10.552 4.035-16.377zm-32.313 16.017a15.971 15.971 0 0 0-4.59 14.141l2.003 11.662-10.479-5.505a15.974 15.974 0 0 0-14.865.005l-10.473 5.51 1.997-11.663a15.97 15.97 0 0 0-4.598-14.14l-8.477-8.258 11.71-1.705a15.972 15.972 0 0 0 12.027-8.742l5.234-10.613 5.239 10.609a15.971 15.971 0 0 0 12.031 8.737l11.711 1.698-8.47 8.264zM211.776 96.976c-1.895-5.824-6.837-9.989-12.898-10.868l-17.688-2.565-7.915-16.025c-2.712-5.491-8.199-8.901-14.323-8.901h-.004c-6.125.002-11.614 3.415-14.323 8.909l-7.905 16.029-17.688 2.575c-6.062.883-11.001 5.051-12.893 10.877-1.891 5.825-.34 12.1 4.047 16.374l12.802 12.472-3.017 17.617c-1.034 6.038 1.403 12.024 6.359 15.623a15.915 15.915 0 0 0 9.371 3.065c2.54 0 5.093-.613 7.452-1.854l15.819-8.322 15.823 8.313c5.422 2.848 11.868 2.381 16.823-1.221 4.954-3.602 7.387-9.589 6.35-15.626l-3.026-17.615 12.797-12.48c4.385-4.278 5.931-10.552 4.037-16.377zm-32.313 16.017a15.971 15.971 0 0 0-4.59 14.141l2.003 11.662-10.479-5.505a15.974 15.974 0 0 0-14.865.005l-10.473 5.51 1.998-11.666a15.977 15.977 0 0 0-4.599-14.137l-8.477-8.258 11.71-1.705a15.972 15.972 0 0 0 12.027-8.742l5.234-10.613 5.239 10.609a15.971 15.971 0 0 0 12.031 8.737l11.712 1.698-8.471 8.264zM60.504 447.359c-5.523 0-10 4.478-10 10v.156c0 5.522 4.477 10 10 10s10-4.478 10-10v-.156c0-5.522-4.477-10-10-10z"
                                    fill="CurrentColor" opacity="1" data-original="CurrentColor" class="">
                                </path>
                            </g>
                        </svg>
                        <p class="caption mt-2">@lang('No reviews available yet.')</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Transaction History Widget -->
        <div class="widget-compact">
            <div class="widget-compact__header">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <h6 class="widget-compact__title">@lang('Transaction History')</h6>
                    <div id="transactionDatePicker" class="border p-1 cursor-pointer rounded d-flex align-items-center">
                        <i class="la la-calendar"></i>&nbsp;
                        <span></span>
                        <i class="la la-caret-down ml-2"></i>
                    </div>
                </div>
            </div>
            <div class="widget-compact__body">
                <div id="transactionChart"></div>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="mt-4">
        @include('Template::partials.transaction')
    </div>
@endsection

@push('style')
    <style>
        .widget-gradient::after {
            background-image: url("{{ getImage(activeTemplate(true) . '/images/thumbs/widget-gradient.png') }}");
        }

        #transactionChart {
            height: 300px;
        }

        .date-picker {
            cursor: pointer;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            background-color: #fff;
            border-radius: 4px;
            display: inline-block;
        }

        .dashboard-content>*:not(:last-child) {
            margin-bottom: unset;
        }
    </style>
@endpush

@push('style-lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            // Initialize ApexCharts
            const transactionChartOptions = {
                chart: {
                    type: 'bar', // Keep 'bar' type for stacked bar effect
                    height: 300,
                    stacked: true, // Stack the bars
                    toolbar: {
                        show: false
                    },
                    background: '#ffffff' // White background
                },
                series: [{
                        name: "Plus Transactions",
                        data: []
                    },
                    {
                        name: "Minus Transactions",
                        data: []
                    }
                ],
                xaxis: {
                    categories: [], // Dates will be dynamically updated
                    labels: {
                        style: {
                            colors: '#333333', // Dark grey for x-axis labels for readability
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#333333', // Dark grey for y-axis labels
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '50%', // Adjust the width of the columns
                        borderRadius: 5, // Rounded bars
                    }
                },
                colors: ['#007bff', '#ffa500'], // Blue for Plus, Orange for Minus
                legend: {
                    position: 'top',
                    horizontalAlign: 'center',
                    labels: {
                        colors: '#333333' // Dark grey text for legend
                    }
                },
                dataLabels: {
                    enabled: false
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(val) {
                            return val.toFixed(1); // Format tooltip values to 1 decimal
                        }
                    },
                    style: {
                        fontSize: '14px',
                        colors: ['#333333'] // Dark grey text color for tooltip
                    },
                    theme: 'light'
                },
                grid: {
                    borderColor: '#e0e0e0', // Light grey grid lines
                    strokeDashArray: 3,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                }
            };

            const transactionChart = new ApexCharts(document.querySelector("#transactionChart"),
                transactionChartOptions);
            transactionChart.render();

            // Function to update chart data
            function updateTransactionChart(startDate, endDate) {
                const data = {
                    start_date: startDate.format('YYYY-MM-DD'),
                    end_date: endDate.format('YYYY-MM-DD')
                };
                const url = '{{ route('user.seller.transactions.chartData') }}'; // Ensure this route exists

                $.get(url, data, function(response) {
                    if (response.success) {
                        transactionChart.updateSeries([{
                                name: "Plus Transactions",
                                data: response.plusTransactions
                            },
                            {
                                name: "Minus Transactions",
                                data: response.minusTransactions
                            }
                        ]);
                        transactionChart.updateOptions({
                            xaxis: {
                                categories: response.dates
                            }
                        });
                    }
                });
            }

            // Display selected date range in the date picker
            function updateDatePickerDisplay(start, end) {
                $('#transactionDatePicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'));
            }

            // Set up the date range picker
            const start = moment().startOf('year');
            const end = moment();

            $('#transactionDatePicker').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                        .endOf('month')
                    ],
                    'This Year': [moment().startOf('year'), moment()]
                }
            }, updateTransactionChart);

            // Display the initial date range on page load
            updateDatePickerDisplay(start, end);

            // Initial chart load
            updateTransactionChart(start, end);

            // Apply new data on date range change and update display
            $('#transactionDatePicker').on('apply.daterangepicker', function(ev, picker) {
                updateTransactionChart(picker.startDate, picker.endDate);
                updateDatePickerDisplay(picker.startDate, picker.endDate);
            });

        })(jQuery);
    </script>
@endpush
