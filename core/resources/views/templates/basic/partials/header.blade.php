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
</style>

<header class="w-100 bg-white border-bottom sticky-top" style="z-index: 1020;">
    <div class="container-fluid" style="max-width: 1400px; padding: 0 20px;">
        <div class="d-flex align-items-center justify-content-between py-2 py-lg-3 gap-3">

            <div class="d-flex align-items-center gap-2">
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
            </div>

            <div class="d-none d-sm-flex flex-grow-1 mx-3" style="max-width: 600px;">
                <form action="{{ route('service') }}" method="GET"
                    class="w-100 d-flex align-items-center border rounded overflow-hidden shadow-sm bg-white">
                    <input type="text" name="search" placeholder="Find Services..."
                        class="form-control border-0 px-3 py-2 shadow-none" style="font-size: 14px;" />
                    <button type="submit"
                        class="btn btn-kwork px-4 py-2 rounded-0 d-flex align-items-center justify-content-center">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="d-flex align-items-center gap-3">
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
                    <div class="d-flex align-items-center gap-2 gap-md-3">
                        <a href="{{ route('user.login') }}"
                            class="text-secondary font-weight-bold text-decoration-none small">Sign In</a>
                        <a href="{{ route('user.register') }}"
                            class="btn btn-kwork btn-sm px-3 font-weight-bold shadow-sm">Sign Up</a>
                        <a href="{{ route('service') }}"
                            class="d-none d-lg-block text-muted text-decoration-none small ps-2">Are you a
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

@if (!$isUser)
    @if (hasSlider())
        <div class="bg-light py-1">
            @include('Template::partials.category_slider')
        </div>
    @endif
@endif
