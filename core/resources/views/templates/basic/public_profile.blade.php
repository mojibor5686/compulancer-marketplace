@extends('Template::layouts.frontend')
@section('content')
    @php
        $forLoadMoreReviewId = $user->id;
    @endphp

    <div style="width: 100%; height: 260px; position: relative; background-color: #f1f3f5;">
        <img src="{{ cover(@$user->bg_image ? getFilePath('userBgImage') . '/' . @$user->bg_image : null, true) }}"
            alt="@lang('user-background-image')" style="width: 100%; height: 100%; object-fit: cover; display: block;">
    </div>

    <section class="all-sections pb-60"
        style="background-color: #f7f9fa !important; margin-top: -60px; position: relative; z-index: 5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;">
        <div class="container">

            <div class="row">

                <div class="col-xl-8 col-lg-8 mb-4">
                    <div
                        style="background-color: #ffffff; border: 1px solid #eef2f5; border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,0.03); padding: 30px;">

                        <div
                            style="display: flex; gap: 24px; align-items: flex-start; border-bottom: 1px solid #f1f3f5; padding-bottom: 24px; margin-bottom: 24px;">
                            <div style="flex-shrink: 0;">
                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                                    alt="{{ __($user->username) }}"
                                    style="width: 110px; height: 110px; border-radius: 4px; object-fit: cover; display: block; border: 1px solid #eef2f5; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                            </div>
                            <div style="flex-grow: 1;">
                                <h3 style="font-size: 22px; font-weight: 700; color: #222222; margin: 0 0 6px 0;">
                                    {{ __($user->username) }}
                                </h3>
                                <h5 style="font-size: 15px; font-weight: 600; color: #10c469; margin: 0 0 12px 0;">
                                    {{ __(@$user->designation ?? 'Freelancer') }}
                                </h5>

                                <div style="display: flex; flex-wrap: wrap; gap: 15px; font-size: 13px; color: #74767e;">
                                    <span style="display: inline-flex; align-items: center; gap: 4px;">
                                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                        </svg>
                                        {{ __(@$user->address->country ?? 'Global') }}
                                    </span>
                                    <span style="display: inline-flex; align-items: center; gap: 4px;">
                                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zM9 9.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                        </svg>
                                        @lang('Joined') {{ showDateTime($user->created_at, 'F d, Y') }}
                                    </span>
                                    <span style="display: inline-flex; align-items: center; gap: 5px;">
                                        <span
                                            style="height: 8px; width: 8px; background-color: #10c469; border-radius: 50%; display: inline-block;"></span>
                                        @lang('Online')
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4
                                style="font-size: 16px; font-weight: 700; color: #222222; margin: 0 0 12px 0; text-transform: uppercase; letter-spacing: 0.3px;">
                                @lang('About Me')</h4>
                            <p style="font-size: 14px; color: #404145; line-height: 1.6; margin: 0; white-space: pre-line;">
                                {{ __($user->about_me ?? 'No description available.') }}
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 mb-4">
                    @include('Template::partials.sidebar_profile')
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div
                        style="background: #ffffff; border: 1px solid #eef2f5; border-radius: 4px; padding: 14px 20px; margin-bottom: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.02);">
                        <div
                            style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                            <ul class="nav nav-tabs custom--tab" role="tablist"
                                style="border-bottom: none; margin-bottom: 0;">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $maxKey == 'service' ? 'active' : '' }}" data-bs-toggle="tab"
                                        data-bs-target="#service" type="button" role="tab">@lang('Services')</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $maxKey == 'software' ? 'active' : '' }}"
                                        data-bs-toggle="tab" data-bs-target="#software" type="button"
                                        role="tab">@lang('Softwares')</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $maxKey == 'job' ? 'active' : '' }}" data-bs-toggle="tab"
                                        data-bs-target="#job" type="button" role="tab">@lang('Jobs')</button>
                                </li>
                            </ul>

                            <div class="layout-toggle-btns" style="display: flex; gap: 6px;">
                                <button class="layout-toggle-btn grid-layout active" type="button"
                                    style="border: 1px solid #eef2f5; background: #ffffff; padding: 6px 10px; border-radius: 4px;">
                                    @include('Template::partials.icons.grid')
                                </button>
                                <button class="layout-toggle-btn list-layout" type="button"
                                    style="border: 1px solid #eef2f5; background: #ffffff; padding: 6px 10px; border-radius: 4px;">
                                    @include('Template::partials.icons.list')
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="item-details-area">
                        @include('Template::partials.basic_card')

                        <div class="product-reviews-content mt-4"
                            style="background: #ffffff; border: 1px solid #eef2f5; border-radius: 4px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.02);">
                            <div class="section-header"
                                style="margin-bottom: 20px; border-bottom: 1px solid #f0f2f5; padding-bottom: 10px;">
                                <h4 class="section-title"
                                    style="font-size: 16px; font-weight: 700; color: #222222; margin: 0;">@lang('Reviews')
                                </h4>
                            </div>
                            @include('Template::partials.reviews')
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    @include('Template::partials.contact_modal')
@endsection

@push('style')
    <style>
        .custom--tab .nav-link {
            border: none !important;
            font-weight: 600 !important;
            font-size: 15px !important;
            padding: 8px 16px !important;
            color: #74767e !important;
            background: transparent !important;
        }

        .custom--tab .nav-link.active {
            color: #ffffff !important;
            border-radius: 0 !important;
        }

        .page-content {
            margin-top: 0;
        }
    </style>
@endpush
