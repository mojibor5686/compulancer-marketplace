<aside id="dashboard-offcanvas-sidebar" class="offcanvas-sidebar offcanvas-sidebar--dashboard">
    <button type="button" class="btn--close">
        <i class="fas fa-times"></i>
    </button>

    <div class="offcanvas-sidebar__body" data-overlayscrollbars-theme="os-theme-dark">
        <ul class="offcanvas-sidebar-menu">
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.seller.home') }}">
                <a href="{{ route('user.seller.home') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-tachometer-alt smart-icon"></i>
                    <span>@lang('Seller Dashboard')</span>
                </a>
            </li>
            <li
                class="offcanvas-sidebar-menu__item {{ menuActive(['user.seller.service.basic', 'user.seller.service.feature', 'user.seller.service.gallery', 'user.seller.service.extra']) }}">
                <a href="{{ route('user.seller.service.basic') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-plus-circle smart-icon"></i>
                    <span>@lang('Create Service')</span>
                </a>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.seller.service.index') }}">
                <a href="{{ route('user.seller.service.index') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-briefcase smart-icon"></i>
                    <span>@lang('Manage Services')</span>
                </a>
            </li>
            <li
                class="offcanvas-sidebar-menu__item {{ menuActive(['user.seller.software.basic', 'user.seller.software.feature', 'user.seller.software.gallery']) }}">
                <a href="{{ route('user.seller.software.basic') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-upload smart-icon"></i>
                    <span>@lang('Sell Software')</span>
                </a>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.seller.software.index') }}">
                <a href="{{ route('user.seller.software.index') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-laptop-code smart-icon"></i>
                    <span>@lang('Manage Software')</span>
                </a>
            </li>

            <li class="offcanvas-sidebar-menu__item offcanvas-sidebar-menu__items">
                <span class="offcanvas-sidebar-menu__title">@lang('Business Insights')</span>
            </li>

            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.seller.booking.service*') }}">
                <a href="{{ route('user.seller.booking.service.list') }}"
                    class="offcanvas-sidebar-menu__link d-flex align-items-center">
                    <i class="fas fa-calendar-check smart-icon"></i>
                    <span class="pending-badge-title">@lang('Service Booking')</span>

                    @if (isset($pendingServiceBookingCount) && $pendingServiceBookingCount > 0)
                        <span class="badge pending-badge" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="@lang('Pending Service Bookings')">
                            {{ $pendingServiceBookingCount }}
                        </span>
                    @endif

                </a>
            </li>

            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.seller.sale.software.log') }}">
                <a href="{{ route('user.seller.sale.software.log') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-shopping-cart smart-icon"></i>
                    <span>@lang('Software Sales')</span>
                </a>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.seller.job.*') }}">
                <a href="{{ route('user.seller.job.list') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-user-tie smart-icon"></i>
                    <span>@lang('Job List')</span>
                </a>
            </li>

            @include('Template::partials.basic_sidebar')
        </ul>
    </div>
</aside>

@push('style')
    <style>
        .smart-icon {
            font-size: 16px;
            margin-right: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            color: #6c757d;
        }

        .pending-badge-title {
            -webkit-line-clamp: unset !important;
        }

        .pending-badge {
            background-color: #dc3545;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-left: 8px;
        }
    </style>
@endpush
