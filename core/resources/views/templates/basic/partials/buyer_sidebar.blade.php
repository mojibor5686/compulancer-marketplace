<aside id="dashboard-offcanvas-sidebar" class="offcanvas-sidebar offcanvas-sidebar--dashboard">
    <button type="button" class="btn--close">
        <i class="fas fa-times"></i>
    </button>

    <div
        class="sidebar-brand-wrapper d-flex align-items-center p-3 border-bottom border-secondary border-opacity-25 mb-2">
        <a href="{{ url('/') }}" class="text-decoration-none">
            <img src="https://work.mojibor.com/assets/images/logo_icon/logo.png" alt="Compulancer Logo" class="img-fluid"
                style="max-height: 35px; object-fit: contain;">
        </a>
    </div>

    <div class="offcanvas-sidebar__body" data-overlayscrollbars-theme="os-theme-dark" style="padding-top: 0px;">
        <ul class="offcanvas-sidebar-menu">
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.home') }}">
                <a href="{{ route('user.buyer.home') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-tachometer-alt smart-icon"></i>
                    <span>@lang('Buyer Dashboard')</span>
                </a>
            </li>
            <li
                class="offcanvas-sidebar-menu__item {{ menuActive(['user.buyer.job.basic', 'user.buyer.job.gallery', 'user.buyer.job.requirement']) }}">
                <a href="{{ route('user.buyer.job.basic') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-plus-circle smart-icon"></i>
                    <span>@lang('Create Job')</span>
                </a>
            </li>
            <li
                class="offcanvas-sidebar-menu__item {{ menuActive(['user.buyer.job.index', 'user.buyer.job.bidding.list']) }}">
                <a href="{{ route('user.buyer.job.index') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-briefcase smart-icon"></i>
                    <span>@lang('Manage Job')</span>
                </a>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.favorite.service') }}">
                <a href="{{ route('user.buyer.favorite.service') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-star smart-icon"></i>
                    <span>@lang('Favorite Service')</span>
                </a>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.favorite.software') }}">
                <a href="{{ route('user.buyer.favorite.software') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-heart smart-icon"></i>
                    <span>@lang('Favorite Software')</span>
                </a>
            </li>

            <li class="offcanvas-sidebar-menu__item offcanvas-sidebar-menu__items">
                <span class="offcanvas-sidebar-menu__title">@lang('Orders & Hirings')</span>
            </li>

            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.hiring*') }}">
                <a href="{{ route('user.buyer.hiring.list') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-users smart-icon"></i>
                    <span>@lang('Hiring List')</span>
                </a>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.booked.*') }}">
                <a href="{{ route('user.buyer.booked.services') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-calendar-check smart-icon"></i>
                    <span>@lang('Booked Services')</span>
                </a>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.software.*') }}">
                <a href="{{ route('user.buyer.software.log') }}" class="offcanvas-sidebar-menu__link">
                    <i class="fas fa-shopping-cart smart-icon"></i>
                    <span>@lang('Software Purchase')</span>
                </a>
            </li>

            <!-- Include additional sidebar content if necessary -->
            @include('Template::partials.basic_sidebar')
        </ul>
    </div>
</aside>
