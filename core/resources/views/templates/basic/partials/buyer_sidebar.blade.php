<aside id="dashboard-offcanvas-sidebar" class="offcanvas-sidebar offcanvas-sidebar--dashboard">
    <button type="button" class="btn--close">
        <i class="fas fa-times"></i>
    </button>

    <div class="offcanvas-sidebar__body" data-overlayscrollbars-theme="os-theme-dark">
        <ul class="offcanvas-sidebar-menu">
            <li class="offcanvas-sidebar-menu__item">
                <span class="offcanvas-sidebar-menu__title">@lang('Buyer Account')</span>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.home') }}">
                <a href="{{ route('user.buyer.home') }}" class="offcanvas-sidebar-menu__link">
                    <i class="lab la-buffer"></i>
                    <span>@lang('Buyer Dashboard')</span>
                </a>
            </li>
            <li
                class="offcanvas-sidebar-menu__item {{ menuActive(['user.buyer.job.basic', 'user.buyer.job.gallery', 'user.buyer.job.requirement']) }}">
                <a href="{{ route('user.buyer.job.basic') }}" class="offcanvas-sidebar-menu__link">
                    <i class="las la-plus-circle"></i>
                    <span>@lang('Create Job')</span>
                </a>
            </li>
            <li
                class="offcanvas-sidebar-menu__item {{ menuActive(['user.buyer.job.index', 'user.buyer.job.bidding.list']) }}">
                <a href="{{ route('user.buyer.job.index') }}" class="offcanvas-sidebar-menu__link">
                    <i class="las la-user-secret"></i>
                    <span>@lang('Manage Job')</span>
                </a>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.favorite.service') }}">
                <a href="{{ route('user.buyer.favorite.service') }}" class="offcanvas-sidebar-menu__link">
                    <i class="lab la-gratipay"></i>
                    <span>@lang('Favorite Service')</span>
                </a>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.favorite.software') }}">
                <a href="{{ route('user.buyer.favorite.software') }}" class="offcanvas-sidebar-menu__link">
                    <i class="las la-heart"></i>
                    <span>@lang('Favorite Software')</span>
                </a>
            </li>

            <!-- Additional Section -->
            <li class="offcanvas-sidebar-menu__item">
                <span class="offcanvas-sidebar-menu__title">@lang('Purchase')</span>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.hiring*') }}">
                <a href="{{ route('user.buyer.hiring.list') }}" class="offcanvas-sidebar-menu__link">
                    <i class="las la-user-secret"></i>
                    <span>@lang('Hiring List')</span>
                </a>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.booked.*') }}">
                <a href="{{ route('user.buyer.booked.services') }}" class="offcanvas-sidebar-menu__link">
                    <i class="las la-taxi"></i>
                    <span>@lang('Booked Services')</span>
                </a>
            </li>
            <li class="offcanvas-sidebar-menu__item {{ menuActive('user.buyer.software.*') }}">
                <a href="{{ route('user.buyer.software.log') }}" class="offcanvas-sidebar-menu__link">
                    <i class="las la-laptop-code"></i>
                    <span>@lang('Software Purchase')</span>
                </a>
            </li>

            <!-- Include additional sidebar content if necessary -->
            @include('Template::partials.basic_sidebar')
        </ul>
    </div>
</aside>
