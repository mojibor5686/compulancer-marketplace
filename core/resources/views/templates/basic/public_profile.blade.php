@extends('Template::layouts.frontend')
@section('content')
    @php
        $forLoadMoreReviewId = $user->id;
    @endphp

    <div class="profile-hero-banner">
        <img src="{{ cover(@$user->bg_image ? getFilePath('userBgImage') . '/' . @$user->bg_image : null, true) }}"
            alt="@lang('user-background-image')" class="hero-cover-img">
        <div class="hero-overlay"></div>
    </div>

    <section class="all-sections pb-5">
        <div class="container position-relative" style="z-index: 10;">
            <div class="row">

                <div class="col-12 mb-4">
                    <div class="modern-profile-card">

                        <div class="profile-main-grid-layout">

                            <div class="profile-left-details">
                                <div class="profile-header-wrapper">
                                    <div class="avatar-container">
                                        <img src="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                                            alt="{{ __($user->username) }}" class="profile-main-avatar">
                                        <span class="active-status-badge"></span>
                                    </div>

                                    <div class="profile-meta-details">
                                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                            <h2 class="user-fullname m-0" style="text-transform: capitalize;">
                                                {{ __($user->username) }}</h2>
                                            <span class="pro-badge"><i class="ri-checkbox-circle-fill"></i>
                                                @lang('Pro Verified')</span>
                                        </div>
                                        <h5 class="user-designation">{{ __(@$user->designation ?? 'Top Rated Freelancer') }}
                                        </h5>

                                        <div class="user-tags-row">
                                            <span class="meta-tag">
                                                <i class="ri-map-pin-2-fill text-danger"></i>
                                                {{ __(@$user->address->country ?? 'Global') }}
                                            </span>
                                            <span class="meta-tag">
                                                <i class="ri-calendar-todo-fill text-primary"></i> @lang('Member since')
                                                {{ showDateTime($user->created_at, 'Y') }}
                                            </span>
                                            <span class="meta-tag success">
                                                <i class="ri-focus-3-line"></i> @lang('Available Now')
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="about-me-section">
                                    <h4 class="section-block-title">
                                        <span>@lang('Professional Overview')</span>
                                    </h4>
                                    <p class="about-description">
                                        {{ __($user->about_me ?? 'No professional description available yet.') }}
                                    </p>
                                </div>
                            </div>

                            @if (@$user)
                                <div class="profile-right-stats-panel">
                                    <div class="stats-action-wrapper">
                                        @auth
                                            <button class="modern-msg-btn contactBtn" data-bs-toggle="modal"
                                                data-bs-target="#contactModal">
                                                <i class="ri-send-plane-fill"></i> @lang('Message Me')
                                            </button>
                                        @else
                                            <button type="button" class="modern-msg-btn contactBtn" data-bs-toggle="modal"
                                                data-bs-target="#signInModal">
                                                <i class="ri-send-plane-fill"></i> @lang('Message Me')
                                            </button>
                                        @endauth
                                    </div>

                                    @php
                                        $profileAvgRating =
                                            $user->total_review > 0
                                                ? number_format($user->total_rating / $user->total_review, 1)
                                                : '0.0';
                                    @endphp

                                    <div class="modern-stats-list">
                                        <div class="stats-item">
                                            <span class="stats-label"><i class="ri-star-fill text-warning"></i>
                                                @lang("Seller's rating")</span>
                                            <span class="stats-value fw-bold">
                                                {{ $profileAvgRating }} <span
                                                    class="review-count-bracket">({{ $user->total_review ?? 0 }})</span>
                                            </span>
                                        </div>

                                        <div class="stats-item">
                                            <span class="stats-label"><i class="ri-checkbox-circle-line text-success"></i>
                                                @lang('Completed orders')</span>
                                            <span
                                                class="stats-value">{{ $user->services()->active()->count() + $user->softwares()->active()->count() }}</span>
                                        </div>

                                        <div class="stats-item">
                                            <span class="stats-label"><i class="ri-git-merge-line text-primary"></i>
                                                @lang('Orders in progress')</span>
                                            <span
                                                class="stats-value text-primary fw-bold">{{ $user->jobBids()->inprogress()->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>

            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="modern-action-bar">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 w-100">
                            <ul class="nav nav-pills custom-capsule-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $maxKey == 'service' ? 'active' : '' }}"
                                        data-bs-toggle="tab" data-bs-target="#service" type="button" role="tab">
                                        <i class="ri-briefcase-line me-2"></i>@lang('Services')
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $maxKey == 'software' ? 'active' : '' }}"
                                        data-bs-toggle="tab" data-bs-target="#software" type="button" role="tab">
                                        <i class="ri-terminal-window-line me-2"></i>@lang('Softwares')
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $maxKey == 'job' ? 'active' : '' }}" data-bs-toggle="tab"
                                        data-bs-target="#job" type="button" role="tab">
                                        <i class="ri-search-eye-line me-2"></i>@lang('Jobs')
                                    </button>
                                </li>
                            </ul>

                            <div class="layout-toggle-btns">
                                <button class="layout-toggle-btn grid-layout active" type="button" title="Grid View">
                                    @include('Template::partials.icons.grid')
                                </button>
                                <button class="layout-toggle-btn list-layout" type="button" title="List View">
                                    @include('Template::partials.icons.list')
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="item-details-area">
                        @include('Template::partials.basic_card')

                        <div class="modern-reviews-panel mt-4">
                            <div class="reviews-header">
                                <h4 class="section-block-title m-0">
                                    <span><i class="ri-star-smile-line text-warning me-2"></i>@lang('Client Endorsements')</span>
                                </h4>
                            </div>
                            <div class="reviews-wrapper-body pt-3">
                                @include('Template::partials.reviews')
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    @include('Template::partials.contact_modal')
@endsection

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        /* 🎨 গ্লোবাল ও টাইপোগ্রাফি ফিক্স */
        body {
            background-color: #f4f6f8 !important;
        }

        /* কভার ব্যানার আর্কিটেকচার */
        .profile-hero-banner {
            width: 100%;
            height: 320px;
            position: relative;
            overflow: hidden;
        }

        .hero-cover-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.02);
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0) 40%, rgba(0, 0, 0, 0.4) 100%);
        }

        /* মডার্ন প্রোফাইল মেইন কার্ড লেআউট */
        .modern-profile-card {
            background-color: #ffffff;
            border: 1px solid #e4e8ec;
            border-radius: 16px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            margin-top: -100px;
        }

        /* গ্রিড আর্কিটেকচার ২ কলাম */
        .profile-main-grid-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            align-items: start;
        }

        .profile-right-stats-panel {
            background: #f8fafc;
            border: 1px solid #eef2f6;
            border-radius: 12px;
            padding: 24px;
        }

        /* মডার্ন মেসেজ বাটন */
        .modern-msg-btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background-color: #3C88EE;
            border: none;
            color: #ffffff;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            padding: 12px 24px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(20, 168, 0, 0.15);
        }

        .modern-msg-btn:hover {
            background-color: #3C88EE;
            box-shadow: 0 6px 16px rgba(60, 136, 238, 0.25);
        }

        /* স্ট্যাটিস্টিকস আইটেম রো */
        .modern-stats-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .stats-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #e2e8f0;
        }

        .stats-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .stats-label {
            color: #5e6267;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .stats-value {
            color: #1d1e20;
            font-weight: 700;
        }

        .review-count-bracket {
            color: #94a3b8;
            font-weight: 400;
            font-size: 12px;
        }

        /* অবতার কন্টেইনার ফ্লোটিং ইফেক্ট */
        .profile-header-wrapper {
            display: flex;
            gap: 28px;
            align-items: center;
            border-bottom: 1px solid #edf1f4;
            padding-bottom: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .avatar-container {
            position: relative;
            flex-shrink: 0;
        }

        .profile-main-avatar {
            width: 130px;
            height: 130px;
            border-radius: 50% !important;
            object-fit: cover;
            border: 5px solid #ffffff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .active-status-badge {
            height: 16px;
            width: 16px;
            background-color: #3C88EE;
            border: 3px solid #ffffff;
            border-radius: 50%;
            position: absolute;
            bottom: 8px;
            right: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* টাইপোগ্রাফি ও ইনফো ট্যাগ */
        .user-fullname {
            font-size: 26px;
            font-weight: 800;
            color: #1d1e20;
            letter-spacing: -0.5px;
        }

        .user-designation {
            font-size: 16px;
            font-weight: 600;
            color: #3C88EE;
            margin: 0 0 16px 0;
        }

        .user-tags-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .meta-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: #5e6267;
            background: #f4f6f8;
            padding: 6px 14px;
            border-radius: 50px;
            border: 1px solid #e9ecef;
        }

        .meta-tag.success {
            background-color: #eaf7ec;
            color: #3C88EE;
            border-color: #d2f1d7;
        }

        .pro-badge {
            background: #3C88EE;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* টাইটেল সেকশন বার */
        .section-block-title {
            font-size: 16px;
            font-weight: 700;
            color: #1d1e20;
            margin: 0 0 16px 0;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            position: relative;
        }

        .section-block-title span::after {
            content: "";
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 40px;
            height: 3px;
            background: #3C88EE;
            border-radius: 2px;
        }

        .about-description {
            font-size: 15px;
            color: #404145;
            line-height: 1.7;
            margin: 0;
        }

        /* ফিল্টার ও ট্যাব অ্যাকশন বার ডিজাইন */
        .modern-action-bar {
            background: #ffffff;
            border: 1px solid #e4e8ec;
            border-radius: 12px;
            padding: 14px 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.01);
            display: flex;
        }

        /* ক্যাপসুল আকৃতির মডার্ন পিলস ট্যাব */
        .custom-capsule-tabs {
            gap: 8px;
        }

        .custom-capsule-tabs .nav-link {
            border: 1px solid #e4e8ec !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            padding: 10px 22px !important;
            color: #5e6267 !important;
            background: #ffffff !important;
            border-radius: 50px !important;
            transition: all 0.2s ease-in-out !important;
        }

        .custom-capsule-tabs .nav-link:hover {
            background: #f4f6f8 !important;
            color: #1d1e20 !important;
        }

        .custom-capsule-tabs .nav-link.active {
            background: #3C88EE !important;
            color: #ffffff !important;
            border-color: #3C88EE !important;
            box-shadow: 0 4px 12px rgba(60, 136, 238, 0.2) !important;
        }

        /* ভিউ টগল বাটন */
        .layout-toggle-btns {
            display: flex;
            gap: 8px;
        }

        .layout-toggle-btn {
            border: 1px solid #e4e8ec;
            background: #ffffff;
            padding: 8px 12px;
            border-radius: 8px;
            color: #5e6267;
            transition: all 0.2s;
        }

        .layout-toggle-btn.active,
        .layout-toggle-btn:hover {
            background: #1d1e20;
            color: #ffffff;
            border-color: #1d1e20;
        }

        /* রিভিউ প্যানেল */
        .modern-reviews-panel {
            background: #ffffff;
            border: 1px solid #e4e8ec;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.01);
        }

        /* মোবাইল রেসপনসিভ হ্যান্ডলার */
        @media (max-width: 991.98px) {
            .profile-main-grid-layout {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }

        @media (max-width: 767.98px) {
            .profile-header-wrapper {
                flex-direction: column;
                text-align: center;
                justify-content: center;
            }

            .modern-profile-card {
                padding: 24px;
                margin-top: -60px;
            }

            .profile-main-avatar {
                width: 110px;
                height: 110px;
            }

            .modern-action-bar {
                padding: 12px;
            }

            .custom-capsule-tabs .nav-link {
                padding: 8px 14px !important;
                font-size: 13px !important;
            }
        }
    </style>
@endpush
