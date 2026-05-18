@php
    $user = auth()->user();
@endphp

<style>
    .bg-kwork-green {
        bg-color: #10c469 !important;
    }

    .btn-kwork {
        background-color: #10c469 !important;
        border-color: #10c469 !important;
        color: #fff !important;
    }

    .btn-kwork:hover {
        background-color: #0eb35f !important;
        border-color: #0eb35f !important;
    }

    .text-kwork-green {
        color: #10c469 !important;
    }

    /* Desktop Category Navigation Hover Mega Menu */
    .nav-mega-wrapper .dropdown-mega {
        position: absolute;
        left: 50%;
        transform: translateX(-30%);
        width: 550px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease-in-out;
        z-index: 1050;
    }

    .nav-mega-wrapper:hover .dropdown-mega {
        opacity: 1;
        visibility: visible;
        margin-top: 0;
    }

    .category-divider {
        color: #dee2e6;
        padding: 0 10px;
    }

    .mega-menu-link {
        font-size: 13px;
        color: #495057;
        text-decoration: none;
        display: block;
        padding: 4px 0;
    }

    .mega-menu-link:hover {
        color: #10c469;
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
        #signInModal .modal-content {
            border-radius: 0px !important;
            height: 100%;
        }

        #signInModal .modal-header {
            padding-top: 30px !important;
        }
    }
</style>

<header class="w-100 bg-white border-bottom sticky-top" style="z-index: 1020;">
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

                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#signInModal"
                    class="d-block d-lg-none text-secondary font-weight-bold text-decoration-none small">Sign In</a>
            </div>

            <div class="d-none d-sm-flex flex-grow-1 mx-3 desktop-stretch-width" style="max-width: 600px;">
                <form action="{{ route('service') }}" method="GET"
                    class="w-100 d-flex align-items-center border rounded overflow-hidden bg-white">
                    <input type="text" name="search" placeholder="Find Services..."
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
                                style="width: 38px; height: 38px; object-fit: cover;" />
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-0"
                            style="width: 240px; border-radius: 8px;">
                            <div class="px-3 py-2.5 bg-light rounded-top border-bottom">
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
                        <a href="{{ route('user.register') }}"
                            class="btn btn btn-kwork btn-sm px-3 font-weight-bold shadow-sm">Sign
                            Up</a>
                        <a href="{{ route('service') }}" class="text-muted text-decoration-none small ps-2">Are you a
                            freelancer?</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="d-sm-none pb-2 pt-1">
            <form action="{{ route('service') }}" method="GET"
                class="w-100 d-flex align-items-center border rounded bg-light overflow-hidden">
                <span class="ps-3 text-muted d-flex align-items-center">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" placeholder="Find Services..."
                    class="form-control border-0 bg-transparent px-2 py-2 shadow-none" style="font-size: 13px;" />
            </form>
        </div>
    </div>

    @if (!$isUser)
        <div class="d-none d-lg-block border-top bg-white shadow-sm">
            <div class="container-fluid" style="max-width: 1400px;">
                <nav class="d-flex align-items-center justify-content-center text-secondary py-1"
                    style="font-size: 14px; font-weight: 500;">

                    <div class="position-relative nav-mega-wrapper">
                        <a href="{{ route('service') }}"
                            class="nav-link text-dark px-3 py-2 border-bottom border-2 border-transparent">
                            Design
                        </a>
                        <div class="dropdown-mega bg-white border rounded-bottom shadow p-4">
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="font-weight-bold text-dark border-b pb-1 mb-2"
                                        style="font-size: 14px;">Popular Design</h6>
                                    <a href="#" class="mega-menu-link">Logo Design</a>
                                    <a href="#" class="mega-menu-link">Brand Identity</a>
                                    <a href="#" class="mega-menu-link">Business Cards</a>
                                    <a href="#" class="mega-menu-link">Web & Mobile Design</a>
                                </div>
                                <div class="col-6">
                                    <h6 class="font-weight-bold text-dark border-b pb-1 mb-2"
                                        style="font-size: 14px;">Graphics & Marketing</h6>
                                    <a href="#" class="mega-menu-link">Web Banners & Icons</a>
                                    <a href="#" class="mega-menu-link">Vector Tracing</a>
                                    <a href="#" class="mega-menu-link">3D Graphics</a>
                                    <a href="#" class="mega-menu-link">NFT Art</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <span class="category-divider">|</span>
                    <a href="{{ route('software') }}" class="nav-link text-dark px-3 py-2">Development & IT</a>
                    <span class="category-divider">|</span>
                    <a href="#" class="nav-link text-dark px-3 py-2">Writing & Translations</a>
                    <span class="category-divider">|</span>
                    <a href="#" class="nav-link text-dark px-3 py-2">SEO & Web Traffic</a>
                    <span class="category-divider">|</span>
                    <a href="#" class="nav-link text-dark px-3 py-2">Digital Marketing & SMM</a>
                    <span class="category-divider">|</span>
                    <a href="#" class="nav-link text-dark px-3 py-2">Audio & Video</a>
                    <span class="category-divider">|</span>
                    <a href="{{ route('job') }}" class="nav-link text-dark px-3 py-2">Business & Lifestyle</a>
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
                <a href="{{ route('user.register') }}" class="btn btn-kwork w-100 font-weight-bold py-2">Sign Up</a>
                <a href="{{ route('user.login') }}"
                    class="btn btn-light w-100 font-weight-bold border text-secondary py-2">Sign In</a>
            </div>
        @endguest

        <div class="list-group list-group-flush border-top pt-2">
            <a href="{{ route('home') }}"
                class="list-group-item list-group-item-action border-0 px-2 py-2.5 d-flex align-items-center text-secondary small">
                <i class="ri-home-4-line me-3 fs-5 text-muted"></i> To Homepage
            </a>
            <a href="{{ route('service') }}"
                class="list-group-item list-group-item-action border-0 px-2 py-2.5 d-flex align-items-center justify-content-between text-secondary small">
                <div class="d-flex align-items-center">
                    <i class="ri-grid-line me-3 fs-5 text-muted"></i> Browse Categories
                </div>
                <i class="ri-arrow-right-s-line text-muted"></i>
            </a>
            <a href="{{ route('blogs') }}"
                class="list-group-item list-group-item-action border-0 px-2 py-2.5 d-flex align-items-center justify-content-between text-secondary small">
                <div class="d-flex align-items-center">
                    <i class="ri-compass-3-line me-3 fs-5 text-muted"></i> @lang('Blogs')
                </div>
                <i class="ri-arrow-right-s-line text-muted"></i>
            </a>
            <a href="{{ route('contact') }}"
                class="list-group-item list-group-item-action border-0 px-2 py-2.5 d-flex align-items-center text-secondary small">
                <i class="ri-customer-service-2-line me-3 fs-5 text-muted"></i> @lang('Help & Contact')
            </a>
        </div>
    </div>
</div>

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

            <div class="modal-body px-4 py-3">
                <form action="{{ route('user.login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="username" style="padding: 12px 0;"
                            class="form-control px-3 shadow-none" placeholder="Email address or username"
                            style="font-size: 14px; border-radius: 6px;" required>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="password" name="password" id="modalPassword" style="padding: 12px 0;"
                            class="form-control px-3 shadow-none" placeholder="Password"
                            style="font-size: 14px; border-radius: 6px;" required>
                        <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted"
                            style="cursor: pointer; font-size: 14px;">
                            <i class="ri-eye-line"></i>
                        </span>
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
                        class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">or</span>
                </div>

                <div class="d-flex justify-content-center gap-3 mb-4">
                    <a href="#"
                        class="btn btn-light d-flex align-items-center justify-content-center border rounded-circle p-0"
                        style="width: 45px; height: 45px; background: #fff;">
                        <svg width="20" height="20" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l3.66-2.85z" />
                            <path fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.85c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                    </a>
                    <a href="#"
                        class="btn btn-light d-flex align-items-center justify-content-center border rounded-circle p-0 d-lg-none"
                        style="width: 45px; height: 45px; background: #fff;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                            class="text-dark">
                            <path
                                d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 4.17c.66-.81 1.11-1.93.99-3.06-1 .04-2.21.67-2.93 1.49-.62.69-1.16 1.84-1.01 2.96 1.12.09 2.27-.58 2.95-1.39z" />
                        </svg>
                    </a>
                </div>

                <div class="text-center small text-secondary mt-2 pb-2">
                    New to Kwork? <a href="#" class="text-primary text-decoration-none"
                        style="font-weight: 500;">Join now</a>
                </div>
            </div>

        </div>
    </div>
</div>

@if (!$isUser)
    @if (hasSlider())
        <div class="bg-light py-1">
            @include('Template::partials.category_slider')
        </div>
    @endif
@endif
