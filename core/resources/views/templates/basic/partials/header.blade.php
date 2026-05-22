@php
    $user = auth()->user();
@endphp

<style>
    .bg-kwork-green {
        bg-color: #3C88EE !important;
    }

    .btn-kwork {
        background-color: #3C88EE !important;
        border-color: #3C88EE !important;
        color: #fff !important;
    }

    .btn-kwork:hover {
        background-color: #3C88EE !important;
        border-color: #3C88EE !important;
    }

    .text-kwork-green {
        color: #3C88EE !important;
    }

    .kwork-custom-nav {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        position: relative;
    }

    .nav-mega-wrapper {
        position: relative;
    }

    .nav-mega-wrapper .nav-link {
        transition: border-color 0.3s ease, color 0.3s ease;
        white-space: nowrap;
    }

    .nav-mega-wrapper .dropdown-mega {
        position: absolute;
        top: 100%;
        width: 480px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: opacity 0.15s ease-in-out, transform 0.15s ease-in-out, visibility 0.15s;
        z-index: 1050;
        background: #ffffff;
    }

    .nav-mega-wrapper:nth-child(-n+5) .dropdown-mega {
        left: 0;
        right: auto;
    }

    .nav-mega-wrapper:nth-child(n+7) .dropdown-mega {
        left: auto;
        right: 0;
    }

    .nav-mega-wrapper:nth-child(6) .dropdown-mega {
        left: 50%;
        transform: translateX(-50%) translateY(10px);
    }

    .nav-mega-wrapper:nth-child(6):hover .dropdown-mega {
        transform: translateX(-50%) translateY(0);
    }

    .nav-mega-wrapper:hover .dropdown-mega {
        opacity: 1;
        visibility: visible;
    }

    .nav-mega-wrapper:not(:nth-child(6)):hover .dropdown-mega {
        transform: translateY(0);
    }

    .nav-mega-wrapper:hover .nav-link {
        border-bottom-color: #3C88EE !important;
        color: #3C88EE !important;
    }

    .category-divider {
        color: #dee2e6;
        padding: 0 8px;
        align-self: center;
        user-select: none;
    }

    .mega-menu-link {
        text-transform: capitalize;
        font-size: 14px;
        color: #555555;
        text-decoration: none;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: color 0.2s ease, padding-left 0.2s ease;
    }

    .mega-menu-link:hover {
        color: #3C88EE !important;
        padding-left: 4px;
    }

    .dropdown-mega h6 {
        white-space: nowrap;
    }

    .border-end {
        border-right: 1px solid #eaeaea !important;
    }

    .auth-toggle-wrapper {
        display: flex;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        position: relative;
    }

    .auth-toggle-item {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 0;
        font-size: 14px;
        font-weight: 600;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 6px;
    }

    .toggle-icon {
        font-size: 15px;
    }

    .auth-toggle-item.active {
        background: #ffffff;
        color: #3C88EE;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        border-bottom: 2px solid #3C88EE;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }

    @media (max-width: 1200px) {
        .nav-mega-wrapper .dropdown-mega {
            max-width: 520px;
        }
    }

    @media (min-width: 992px) {
        .desktop-stretch-width {
            width: stretch !important;
            width: -webkit-fill-available !important;
            width: -moz-available !important;
        }

        .desktop-stretch-height {
            height: stretch !important;
            height: -webkit-fill-available !important;
        }
    }

    @media (max-width: 991.98px) {

        #signInModal .modal-content,
        #profileCompleteModal .modal-content,
        #signUpModal .modal-content {
            border-radius: 0px !important;
            height: 100%;
        }

        #signInModal .modal-header,
        #profileCompleteModal .modal-header,
        #signUpModal .modal-header {
            padding-top: 30px !important;
        }
    }
</style>

<header class="w-100 bg-white sticky-top" style="z-index: 1020;">
    <div class="container-fluid" style="max-width: 1400px; padding: 0 20px;">
        <div class="d-flex align-items-center justify-content-between py-2 py-lg-3">

            <div class="d-flex align-items-center justify-content-between justify-content-lg-start w-100 w-lg-auto">
                <button class="btn btn-link text-dark p-1 d-lg-none shadow-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                    <svg class="bi bi-list" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                    </svg>
                </button>

                <a href="{{ route('home') }}" class="d-flex align-items-center navbar-brand me-0">
                    <img src="{{ siteLogo() }}" alt="Site Logo" class="img-fluid"
                        style="height: 32px; object-fit: contain;" />
                </a>

                @if (auth()->check())
                    <a href=""
                        class="d-block d-lg-none text-secondary font-weight-bold text-decoration-none small"></a>
                @else
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#signInModal"
                        class="d-block d-lg-none text-secondary font-weight-bold text-decoration-none small">Sign In</a>
                @endif

            </div>

            <div class="d-none d-sm-flex flex-grow-1 mx-3 desktop-stretch-width" style="max-width: 600px;">
                <form action="{{ route('search') }}" method="GET"
                    class="w-100 d-flex align-items-center border rounded overflow-hidden bg-white">
                    <input type="text" name="search" placeholder="Find Services..." value="{{ request()->search }}"
                        class="form-control border-0 px-3 py-2 shadow-none" style="font-size: 14px;" />
                    <button type="submit"
                        class="btn btn-kwork px-4 py-2 rounded-0 d-flex align-items-center justify-content-center"
                        style="height: stretch;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="d-flex align-items-center gap-3 desktop-stretch-width justify-content-end">
                @if ($isUser || $user)
                    <div class="d-none d-lg-block small font-weight-bold">
                        @if (session('userType') === 'buyer' || (session('userType') === null && request()->routeIs('user.buyer.*')))
                            <a href="{{ route('user.seller.home') }}"
                                class="text-kwork-green text-decoration-none font-weight-600">@lang('Switch to Seller')</a>
                        @else
                            <a href="{{ route('user.buyer.home') }}"
                                class="text-primary text-decoration-none font-weight-600">@lang('Switch to Buyer')</a>
                        @endif
                    </div>

                    <div class="dropdown">
                        <button class="btn p-0 border-0 rounded-circle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false" data-bs-display="static">
                            <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, isAvatar: true) }}"
                                alt="User Avatar" class="rounded-circle border"
                                style="width: 42px; height: 42px; object-fit: cover;" />
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-0"
                            style="width: 240px; border-radius: 8px;">
                            <div class="px-3 py-2 bg-light rounded-top border-bottom">
                                <div class="font-weight-bold text-dark text-truncate small" style="font-weight: 600;">
                                    {{ @$user->fullname }}</div>
                                <div class="text-muted text-truncate" style="font-size: 11px;">
                                    {{ '@' . @$user->username }}</div>
                            </div>
                            <div class="py-1">
                                <a class="dropdown-item d-flex align-items-center py-2 text-secondary"
                                    style="font-size: 14px;" href="{{ route('user.seller.home') }}">
                                    <i class="ri-dashboard-line me-2 text-secondary fs-5"></i> @lang('Dashboard')
                                </a>
                                <a class="dropdown-item d-flex align-items-center py-2 text-secondary"
                                    style="font-size: 14px;" href="{{ route('user.profile.setting') }}">
                                    <i class="ri-user-settings-line me-2 text-secondary fs-5"></i> @lang('Edit Profile')
                                </a>
                                <a class="dropdown-item d-flex align-items-center py-2 text-secondary"
                                    style="font-size: 14px;" href="{{ route('user.change.password') }}">
                                    <i class="ri-key-2-line me-2 text-secondary fs-5"></i> @lang('Change Password')
                                </a>
                            </div>
                            <div class="border-top py-1">
                                <a class="dropdown-item d-flex align-items-center py-2 text-danger font-weight-bold"
                                    style="font-size: 14px;" href="{{ route('user.logout') }}">
                                    <i class="ri-logout-box-r-line me-2 text-danger fs-5"></i> @lang('Logout')
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="d-none d-lg-flex align-items-center gap-2 gap-md-3">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#signInModal"
                            class="text-secondary font-weight-bold text-decoration-none small">Sign In</a>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#signUpModal"
                            class="btn btn btn-kwork btn-sm px-3 font-weight-bold shadow-sm">Sign
                            Up</a>
                        <a href="{{ route('service') }}" class="text-muted text-decoration-none small ps-2">Are you a
                            freelancer?</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="d-sm-none pb-2 pt-1">
            <form action="{{ route('search') }}" method="GET"
                class="w-100 d-flex align-items-center border rounded bg-light overflow-hidden">
                <span class="ps-3 text-muted d-flex align-items-center">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" placeholder="Find Services..." value="{{ request()->search }}"
                    class="form-control border-0 bg-transparent px-2 py-2 shadow-none" style="font-size: 13px;" />
            </form>
        </div>
    </div>

    @if (!$isUser)
        <div class="d-none d-lg-block border-top bg-white shadow-sm">
            <div class="container-fluid" style="max-width: 1400px;">
                <nav class="d-flex align-items-center justify-content-center text-secondary py-1 kwork-custom-nav"
                    style="font-size: 14px; font-weight: 500;">

                    @foreach ($categories->sortByDesc(function ($category) {
            return $category->subCategories->count();
        })->take(7) as $category)
                        @if ($category->subCategories && $category->subCategories->count() > 0)
                            <div class="nav-mega-wrapper">
                                <a href="{{ route('category.wise.product', [slug($category->name), $category->id]) }}"
                                    class="nav-link text-dark px-3 py-2 border-bottom border-2 border-white"
                                    style="text-transform: capitalize; font-size: 14px;">
                                    {{ __($category->name) }}
                                </a>

                                <div class="dropdown-mega bg-white border rounded shadow p-4">
                                    <div class="row">
                                        @foreach ($category->subCategories->chunk(ceil($category->subCategories->count() / 2)) as $chunk)
                                            <div class="col-6 {{ $loop->first ? 'border-end' : 'ps-4' }}">
                                                <h6 class="font-weight-bold text-dark pb-1 mb-3"
                                                    style="font-size: 14px; opacity: 0.9;">
                                                    @if ($loop->first)
                                                        @lang('Popular Services')
                                                    @else
                                                        @lang('More Categories')
                                                    @endif
                                                </h6>

                                                @foreach ($chunk as $subCategory)
                                                    <div class="mb-3">
                                                        <a href="{{ route('subcategory.wise.product', [slug($subCategory->name), $subCategory->id]) }}"
                                                            class="mega-menu-link"
                                                            title="{{ __($subCategory->name) }}">
                                                            {{ __($subCategory->name) }}
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('category.wise.product', [slug($category->name), $category->id]) }}"
                                class="nav-link text-dark px-3 py-2"
                                style="text-transform: capitalize; font-size: 14px;">
                                {{ __($category->name) }}
                            </a>
                        @endif

                        @if (!$loop->last)
                            <span class="category-divider">|</span>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>
    @endif
</header>

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel"
    style="width: 290px;">
    <div class="offcanvas-header border-bottom py-3">
        <button type="button" class="btn-close text-reset shadow-none" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
        <img src="{{ siteLogo() }}" alt="Logo" class="img-fluid"
            style="height: 26px; object-fit: contain;" />
        <div style="width: 24px;"></div>
    </div>
    <div class="offcanvas-body px-3 py-4">
        @guest
            <div class="d-flex flex-column gap-2 mb-4">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#signUpModal"
                    class="btn btn-kwork w-100 font-weight-bold py-2">Sign Up</a>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#signInModal"
                    class="btn btn-light w-100 font-weight-bold border text-secondary py-2">Sign In</a>
            </div>
        @endguest

        <div class="list-group list-group-flush border-top pt-2">
            <a href="{{ route('home') }}"
                class="list-group-item list-group-item-action border-0 px-2 py-2.5 d-flex align-items-center text-secondary small">
                <i class="ri-home-4-line me-3 fs-5 text-muted"></i> @lang('Home')
            </a>

            <a href="{{ route('service') }}"
                class="list-group-item list-group-item-action border-0 px-2 py-2.5 d-flex align-items-center justify-content-between text-secondary small">
                <div class="d-flex align-items-center">
                    <i class="ri-briefcase-line me-3 fs-5 text-muted"></i> @lang('Service')
                </div>
                <i class="ri-arrow-right-s-line text-muted"></i>
            </a>

            <a href="{{ route('software') }}"
                class="list-group-item list-group-item-action border-0 px-2 py-2.5 d-flex align-items-center justify-content-between text-secondary small">
                <div class="d-flex align-items-center">
                    <i class="ri-terminal-window-line me-3 fs-5 text-muted"></i> @lang('Software')
                </div>
                <i class="ri-arrow-right-s-line text-muted"></i>
            </a>

            <a href="{{ route('job') }}"
                class="list-group-item list-group-item-action border-0 px-2 py-2.5 d-flex align-items-center justify-content-between text-secondary small">
                <div class="d-flex align-items-center">
                    <i class="ri-search-eye-line me-3 fs-5 text-muted"></i> @lang('Jobs')
                </div>
                <i class="ri-arrow-right-s-line text-muted"></i>
            </a>

            <a href="{{ route('blogs') }}"
                class="list-group-item list-group-item-action border-0 px-2 py-2.5 d-flex align-items-center justify-content-between text-secondary small">
                <div class="d-flex align-items-center">
                    <i class="ri-article-line me-3 fs-5 text-muted"></i> @lang('Blog')
                </div>
                <i class="ri-arrow-right-s-line text-muted"></i>
            </a>

            <a href="{{ route('contact') }}"
                class="list-group-item list-group-item-action border-0 px-2 py-2.5 d-flex align-items-center text-secondary small">
                <i class="ri-customer-service-2-line me-3 fs-5 text-muted"></i> @lang('Contact')
            </a>
        </div>
    </div>
</div>

<!-- user sign in popup -->

<div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-lg-down"
        style="max-width: 480px; margin-left: auto; margin-right: auto;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">

            <div class="modal-header border-0 pt-4 px-4 pb-2 position-relative">
                <h5 class="modal-title font-weight-bold w-100 text-start text-lg-center" id="signInModalLabel"
                    style="font-weight: 700; font-size: 22px;">Sign In</h5>
                <button type="button" class="btn-close shadow-none position-absolute" data-bs-dismiss="modal"
                    aria-label="Close" style="top: 24px; right: 24px;"></button>
            </div>

            @php
                $loginRegisterContent = getContent('login_register.content', true);
                $credentials = gs('socialite_credentials');
                $socialLoginActive =
                    @$credentials->google->status == Status::ENABLE ||
                    @$credentials->facebook->status == Status::ENABLE ||
                    @$credentials->linkedin->status == Status::ENABLE;
            @endphp

            <div class="modal-body px-4 py-3">
                <form action="{{ route('user.login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group border rounded overflow-hidden bg-white">
                            <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                <i class="fas fa-user" style="font-size: 14px;"></i>
                            </span>
                            <input type="text" name="username" class="form-control border-0 px-3 shadow-none"
                                placeholder="Email address or username" style="font-size: 14px; padding: 12px 0;"
                                value="{{ old('username') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group border rounded overflow-hidden bg-white position-relative">
                            <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                <i class="fas fa-lock" style="font-size: 14px;"></i>
                            </span>
                            <input type="password" name="password" id="modalPassword"
                                class="form-control border-0 px-3 shadow-none" placeholder="Password"
                                style="font-size: 14px; padding: 12px 0;" required>

                            <span
                                class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted toggle-password"
                                style="cursor: pointer; font-size: 14px; z-index: 10;">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4" style="font-size: 13px;">
                        <div class="form-check">
                            <input class="form-check-input shadow-none" type="checkbox" name="remember"
                                id="rememberMe">
                            <label class="form-check-label text-secondary" style="cursor: pointer;" mercantile
                                for="rememberMe">
                                Remember me
                            </label>
                        </div>
                        <a href="#" class="text-primary text-decoration-none" style="font-weight: 500;">Forgot
                            your password?</a>
                    </div>

                    <button type="submit" style="padding: 12px 0;" class="btn btn-kwork w-100 font-weight-bold mb-4"
                        style="font-size: 15px; border-radius: 6px; font-weight: 600;">
                        Sign In
                    </button>
                </form>

                <div class="position-relative text-center my-4">
                    <hr class="text-muted opacity-25">
                    <span
                        class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">OR</span>
                </div>

                <div class="d-flex justify-content-center gap-3 mb-4">
                    @if ($socialLoginActive)
                        <div class="d-flex justify-content-center mb-2">
                            @include('Template::partials.social_login')
                        </div>
                    @endif
                </div>

                <div class="text-center small text-secondary mt-2 pb-2">
                    New to compulancer? <a href="javascript:void(0)" data-bs-toggle="modal"
                        data-bs-target="#signUpModal" class="text-primary text-decoration-none"
                        style="font-weight: 500;">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!--user sign up popup-->

<div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
    @if (gs('registration'))
        @php
            $loginRegisterContent = getContent('login_register.content', true);
            $credentials = gs('socialite_credentials');
            $socialLoginActive =
                @$credentials->google->status == Status::ENABLE ||
                @$credentials->facebook->status == Status::ENABLE ||
                @$credentials->linkedin->status == Status::ENABLE;
        @endphp

        <div class="modal-dialog modal-dialog-centered modal-fullscreen-lg-down"
            style="max-width: 520px; margin-left: auto; margin-right: auto;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">

                <div class="modal-header border-0 pt-4 px-4 pb-2 position-relative">
                    <h5 class="modal-title font-weight-bold w-100 text-start text-lg-center" id="signUpModalLabel"
                        style="font-weight: 700; font-size: 22px;">
                        @lang(@$loginRegisterContent->data_values->register_title)
                    </h5>
                    <button type="button" class="btn-close shadow-none position-absolute" data-bs-dismiss="modal"
                        aria-label="Close" style="top: 24px; right: 24px;"></button>
                </div>

                <div class="modal-body px-4 py-3">

                    <div class="auth-toggle-wrapper mb-4">
                        <div class="auth-toggle-item active" data-type="buyer">
                            <i class="fas fa-shopping-bag toggle-icon"></i>
                            <span>@lang('Buyer')</span>
                        </div>
                        <div class="auth-toggle-item" data-type="seller">
                            <i class="fas fa-store toggle-icon"></i>
                            <span>@lang('Seller')</span>
                        </div>
                    </div>

                    <form id="modalSignUpForm" class="verify-gcaptcha" action="{{ route('user.register') }}"
                        method="POST" novalidate>
                        @csrf
                        <div class="row g-3">

                            @if (session()->get('reference') != null)
                                <div class="col-12">
                                    <div class="input-group border rounded overflow-hidden bg-white">
                                        <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                            <i class="fas fa-user-friends" style="font-size: 14px;"></i>
                                        </span>
                                        <input type="text" name="referBy"
                                            class="form-control border-0 px-3 shadow-none bg-light"
                                            value="{{ session()->get('reference') }}" readonly
                                            style="font-size: 14px; padding: 12px 0;">
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-6">
                                <div class="input-group border rounded overflow-hidden bg-white">
                                    <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                        <i class="fas fa-user" style="font-size: 14px;"></i>
                                    </span>
                                    <input type="text" name="firstname"
                                        class="form-control border-0 px-3 shadow-none"
                                        placeholder="@lang('First name')" value="{{ old('firstname') }}"
                                        style="font-size: 14px; padding: 12px 0;" required>
                                </div>
                                <div class="invalid-feedback text-danger d-block mt-1 ps-1 small"
                                    style="display: none;"></div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group border rounded overflow-hidden bg-white">
                                    <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                        <i class="fas fa-user" style="font-size: 14px;"></i>
                                    </span>
                                    <input type="text" name="lastname"
                                        class="form-control border-0 px-3 shadow-none"
                                        placeholder="@lang('Last name')" value="{{ old('lastname') }}"
                                        style="font-size: 14px; padding: 12px 0;" required>
                                </div>
                                <div class="invalid-feedback text-danger d-block mt-1 ps-1 small"
                                    style="display: none;"></div>
                            </div>

                            <div class="col-12">
                                <div class="input-group border rounded overflow-hidden bg-white">
                                    <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                        <i class="fas fa-envelope" style="font-size: 14px;"></i>
                                    </span>
                                    <input type="email" name="email"
                                        class="form-control border-0 px-3 shadow-none checkUser"
                                        placeholder="@lang('Email Address')" value="{{ old('email') }}"
                                        style="font-size: 14px; padding: 12px 0;" required>
                                </div>
                                <div class="invalid-feedback text-danger d-block mt-1 ps-1 small"
                                    style="display: none;"></div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group border rounded overflow-hidden bg-white position-relative">
                                    <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                        <i class="fas fa-lock" style="font-size: 14px;"></i>
                                    </span>
                                    <input type="password" name="password"
                                        class="form-control border-0 px-3 shadow-none @if (gs('secure_password')) secure-password @endif"
                                        placeholder="@lang('Password')" style="font-size: 14px; padding: 12px 0;"
                                        required>
                                    <span
                                        class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted toggle-password"
                                        style="cursor: pointer; font-size: 14px; z-index: 10;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                                <div class="invalid-feedback text-danger d-block mt-1 ps-1 small"
                                    style="display: none;"></div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group border rounded overflow-hidden bg-white position-relative">
                                    <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                        <i class="fas fa-lock" style="font-size: 14px;"></i>
                                    </span>
                                    <input type="password" name="password_confirmation"
                                        class="form-control border-0 px-3 shadow-none"
                                        placeholder="@lang('Confirm Password')" style="font-size: 14px; padding: 12px 0;"
                                        required>
                                    <span
                                        class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted toggle-password"
                                        style="cursor: pointer; font-size: 14px; z-index: 10;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                                <div class="invalid-feedback text-danger d-block mt-1 ps-1 small"
                                    style="display: none;"></div>
                            </div>

                            <div class="col-12">
                                <x-captcha :frontend="true" :isCustom="true" />
                            </div>

                            @if (gs('agree'))
                                @php
                                    $policyPages = getContent('policy_pages.element', orderById: true);
                                @endphp
                                <div class="col-12 mt-2">
                                    <div class="form-check" style="font-size: 13px;">
                                        <input class="form-check-input shadow-none" id="agreeModal" name="agree"
                                            type="checkbox" required>
                                        <label class="form-check-label text-secondary" for="agreeModal"
                                            style="cursor: pointer;">
                                            @lang('I agree with')
                                            @foreach ($policyPages as $policy)
                                                <a class="text-primary text-decoration-none font-weight-500"
                                                    target="_blank"
                                                    href="{{ route('policy.pages', $policy->slug) }}">
                                                    {{ __($policy->data_values->title) }}
                                                </a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </label>
                                    </div>
                                    <div class="invalid-feedback text-danger d-block mt-1 ps-1 small"
                                        style="display: none;"></div>
                                </div>
                            @endif

                            <div class="col-12 mt-3">
                                <button type="submit" id="btnModalSignUp"
                                    class="btn btn-kwork w-100 font-weight-bold mb-3"
                                    style="font-size: 15px; padding: 12px 0; border-radius: 6px; font-weight: 600;">
                                    @lang('Sign Up')
                                </button>

                                <div class="d-flex justify-content-center gap-3 mb-2">
                                    @if ($socialLoginActive)
                                        <div class="d-flex justify-content-center mb-2">
                                            @include('Template::partials.social_login')
                                        </div>
                                    @endif
                                </div>

                                <div class="text-center small text-secondary">
                                    @lang('Already have an account?')
                                    <a href="javascript:void(0)" data-bs-dismiss="modal" data-bs-toggle="modal"
                                        data-bs-target="#signInModal" class="text-primary text-decoration-none"
                                        style="font-weight: 500;">
                                        @lang('Sign In')
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endif
</div>

@if (auth()->check() && auth()->user()->profile_complete == 0)
    <div class="modal fade" id="profileCompleteModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="profileCompleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-lg-down"
            style="max-width: 550px; margin-left: auto; margin-right: auto;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">

                <div class="modal-header border-0 pt-4 px-4 pb-2 position-relative text-center">
                    <h5 class="modal-title font-weight-bold w-100" id="profileCompleteModalLabel"
                        style="font-weight: 700; font-size: 22px;">
                        @lang('Complete Your Profile')
                    </h5>
                </div>

                <div class="modal-body px-4 py-3">
                    <p class="text-muted text-center small mb-4">Please fill up the remaining details to get full
                        access to your account.</p>

                    <form id="modalProfileCompleteForm" method="POST" action="{{ route('user.data.submit') }}"
                        novalidate>
                        @csrf
                        <div class="row g-3">

                            <div class="col-12">
                                <div class="input-group border rounded overflow-hidden bg-white">
                                    <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                        <i class="fas fa-at" style="font-size: 14px;"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control border-0 px-3 shadow-none checkUserComplete"
                                        name="username" placeholder="@lang('Username')"
                                        value="{{ old('username') }}" style="font-size: 14px; padding: 12px 0;"
                                        required />
                                </div>
                                <small class="text-danger d-block mt-1 ps-1 usernameExistModal small"
                                    style="display:none;"></small>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group border rounded overflow-hidden bg-white">
                                    <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                        <i class="fas fa-globe" style="font-size: 14px;"></i>
                                    </span>
                                    <select name="country" class="form-select border-0 px-3 shadow-none"
                                        style="font-size: 14px; padding: 12px 0; height: auto;" required>
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $country->country }}" data-code="{{ $key }}">
                                                {{ __($country->country) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group border rounded overflow-hidden bg-white">
                                    <span
                                        class="input-group-text mobile-code-modal border-0 text-muted bg-transparent ps-3 pe-1"
                                        style="font-size: 14px;"></span>
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                    <input type="number" name="mobile" value="{{ old('mobile') }}"
                                        class="form-control border-0 px-2 shadow-none checkUserComplete"
                                        placeholder="@lang('Mobile Number')" style="font-size: 14px; padding: 12px 0;"
                                        required>
                                </div>
                                <small class="text-danger d-block mt-1 ps-1 mobileExistModal small"
                                    style="display:none;"></small>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group border rounded overflow-hidden bg-white"
                                    style="padding: 5px 0">
                                    <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                        <i class="fas fa-map-marker-alt" style="font-size: 14px;"></i>
                                    </span>
                                    <input type="text" class="form-control border-0 px-3 shadow-none"
                                        name="address" placeholder="@lang('Address')"
                                        value="{{ old('address') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group border rounded overflow-hidden bg-white"
                                    style="padding: 5px 0">
                                    <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                        <i class="fas fa-map" style="font-size: 14px;"></i>
                                    </span>
                                    <input type="text" class="form-control border-0 px-3 shadow-none"
                                        name="state" placeholder="@lang('State')" value="{{ old('state') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group border rounded overflow-hidden bg-white"
                                    style="padding: 5px 0">
                                    <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                        <i class="fas fa-mail-bulk" style="font-size: 14px;"></i>
                                    </span>
                                    <input type="text" class="form-control border-0 px-3 shadow-none"
                                        name="zip" placeholder="@lang('Zip Code')" value="{{ old('zip') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group border rounded overflow-hidden bg-white"
                                    style="padding: 5px 0">
                                    <span class="input-group-text bg-transparent border-0 pe-0 ps-3 text-muted">
                                        <i class="fas fa-city" style="font-size: 14px;"></i>
                                    </span>
                                    <input type="text" class="form-control border-0 px-3 shadow-none"
                                        name="city" placeholder="@lang('City')" value="{{ old('city') }}">
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-kwork w-100 font-weight-bold"
                                    style="font-size: 15px; padding: 12px 0; border-radius: 6px;">
                                    @lang('Submit Details')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endif

@if (!$isUser)
    @if (hasSlider())
        <div class="bg-light py-1">
            @include('Template::partials.category_slider')
        </div>
    @endif
@endif
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleItems = document.querySelectorAll('.auth-toggle-item');

            toggleItems.forEach(item => {
                item.addEventListener('click', function() {
                    document.querySelector('.auth-toggle-item.active').classList.remove('active');
                    this.classList.add('active');
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {

            @if (auth()->check() && auth()->user()->profile_complete == 0)
                const profileCompleteModal = new bootstrap.Modal(document.getElementById('profileCompleteModal'));
                profileCompleteModal.show();
            @endif

            const $countrySelect = $('select[name=country]');
            if ($countrySelect.length) {

                function updateMobileCode() {
                    const $selected = $countrySelect.find(':selected');
                    const mobileCode = $selected.data('mobile_code');
                    const countryCode = $selected.data('code');

                    $('input[name=mobile_code]').val(mobileCode);
                    $('input[name=country_code]').val(countryCode);
                    $('.mobile-code-modal').text('+' + mobileCode);
                }

                updateMobileCode();

                $countrySelect.on('change', function() {
                    updateMobileCode();
                    var value = $('[name=mobile]').val();
                    if (value) checkUserModal(value, 'mobile');
                });
            }

            $('.checkUserComplete').on('focusout', function() {
                var value = $(this).val();
                var name = $(this).attr('name');
                if (value) checkUserModal(value, name);
            });

            function checkUserModal(value, name) {
                var url = '{{ route('user.checkUser') }}';
                var token = '{{ csrf_token() }}';
                var data = {};

                if (name == 'mobile') {
                    data = {
                        mobile: value,
                        mobile_code: $('.mobile-code-modal').text().substr(1),
                        _token: token
                    }
                } else if (name == 'username') {
                    data = {
                        username: value,
                        _token: token
                    }
                }

                $.post(url, data, function(response) {
                    const $feedback = $(`.${response.type}ExistModal`);
                    const $inputGroup = $(`input[name=${name}]`).closest('.input-group');

                    if (response.data != false) {
                        $feedback.text(`${response.field} already exists`).show();
                        $inputGroup.css('border-color', '#dc3545');
                    } else {
                        $feedback.text('').hide();
                        $inputGroup.css('border-color', '#dee2e6');
                    }
                });
            }

            $('#modalProfileCompleteForm').on('submit', function(e) {
                let isValid = true;

                $(this).find('input[required]').each(function() {
                    const $inputGroup = $(this).closest('.input-group');
                    if (!$(this).value().trim()) {
                        $inputGroup.css('border-color', '#dc3545');
                        isValid = false;
                    } else {
                        $inputGroup.css('border-color', '#dee2e6');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const togglePasswordButtons = document.querySelectorAll('.toggle-password');

            togglePasswordButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const passwordInput = this.closest('.position-relative').querySelector('input');

                    if (passwordInput) {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' :
                            'password';
                        passwordInput.setAttribute('type', type);

                        const icon = this.querySelector('i');

                        if (icon) {
                            if (type === 'password') {
                                icon.classList.remove('fa-eye');
                                icon.classList.add('fa-eye-slash');
                            } else {
                                icon.classList.remove('fa-eye-slash');
                                icon.classList.add('fa-eye');
                            }
                        }
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                @if (old('firstname') ||
                        old('lastname') ||
                        old('email') ||
                        old('password') ||
                        old('password_confirmation') ||
                        old('agree'))
                    const signUpModal = new bootstrap.Modal(document.getElementById('signUpModal'));
                    signUpModal.show();
                @else
                    const signInModal = new bootstrap.Modal(document.getElementById('signInModal'));
                    signInModal.show();
                @endif
            @endif
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('modalSignUpForm');
            if (!form) return;

            const securePassword = @json(gs('secure_password') ? true : false);
            const agreeRequired = @json(gs('agree') ? true : false);

            function showError(input, message) {
                const parentGroup = input.closest('.col-12, .col-sm-6');
                const feedback = parentGroup.querySelector('.invalid-feedback');
                const inputGroup = input.closest('.input-group');

                if (inputGroup) inputGroup.style.borderColor = '#dc3545';
                if (feedback) {
                    feedback.textContent = message;
                    feedback.style.display = 'block';
                }
            }

            function clearError(input) {
                const parentGroup = input.closest('.col-12, .col-sm-6');
                const feedback = parentGroup.querySelector('.invalid-feedback');
                const inputGroup = input.closest('.input-group');

                if (inputGroup) inputGroup.style.borderColor = '#dee2e6';
                if (feedback) {
                    feedback.textContent = '';
                    feedback.style.display = 'none';
                }
            }

            function validateField(input) {
                const name = input.name;
                const value = input.value.trim();

                clearError(input);

                if (input.required && !value && input.type !== 'checkbox') {
                    showError(input, 'This field is required.');
                    return false;
                }

                if (name === 'firstname' && value.length < 2) {
                    showError(input, 'First name must be at least 2 characters.');
                    return false;
                }

                if (name === 'lastname' && value.length < 2) {
                    showError(input, 'Last name must be at least 2 characters.');
                    return false;
                }

                if (name === 'email') {
                    const emailRegex = /^[^\s@]+Box\+*@[^\s@]+\.[^\s@]+$/;
                    const basicEmailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!basicEmailRegex.test(value)) {
                        showError(input, 'Please enter a valid email address.');
                        return false;
                    }
                }

                if (name === 'password') {
                    if (value.length < 6) {
                        showError(input, 'Password must be at least 6 characters.');
                        return false;
                    }
                    if (securePassword) {
                        if (!/[A-Z]/.test(value) || !/[a-z]/.test(value)) {
                            showError(input, 'Password must contain both uppercase and lowercase letters.');
                            return false;
                        }
                        if (!/[0-9]/.test(value)) {
                            showError(input, 'Password must contain at least one number.');
                            return false;
                        }
                        if (!/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
                            showError(input, 'Password must contain at least one special character.');
                            return false;
                        }
                    }
                }

                if (name === 'password_confirmation') {
                    const passwordVal = form.querySelector('input[name="password"]').value;
                    if (value !== passwordVal) {
                        showError(input, 'Confirm password does not match.');
                        return false;
                    }
                }

                if (name === 'agree' && agreeRequired && !input.checked) {
                    showError(input, 'You must agree with our policies.');
                    return false;
                }

                return true;
            }

            form.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', () => validateField(input));
                input.addEventListener('blur', () => validateField(input));
                if (input.type === 'checkbox') {
                    input.addEventListener('change', () => validateField(input));
                }
            });

            form.addEventListener('submit', function(e) {
                let isFormValid = true;

                form.querySelectorAll('input').forEach(input => {
                    if (!validateField(input)) {
                        isFormValid = false;
                    }
                });

                if (!isFormValid) {
                    e.preventDefault();
                    const firstErrorInput = form.querySelector(
                        '.invalid-feedback[style*="display: block"]');
                    if (firstErrorInput) {
                        firstErrorInput.closest('.col-12, .col-sm-6').scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>
@endpush
