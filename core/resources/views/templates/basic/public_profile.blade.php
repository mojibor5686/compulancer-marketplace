@extends('Template::layouts.frontend')
@section('content')
    @php
        $forLoadMoreReviewId = $user->id;
    @endphp

    <section class="all-sections pt-60 pb-60"
        style="background-color: #f7f9fa !important; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;">
        <div class="container">
            <div class="row">

                <div class="col-xl-4 col-lg-4 mb-4">
                    <div class="jss-details-sidebar__block" style="position: sticky !important; top: 20px !important;">
                        @if (@$user)
                            <div
                                style="background-color: #ffffff !important; border: 1px solid #eef2f5 !important; border-radius: 4px !important; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04) !important; overflow: hidden !important; margin-bottom: 20px !important;">

                                <div
                                    style="width: 100% !important; height: 120px !important; position: relative !important; background-color: #f1f3f5 !important;">
                                    <img src="{{ cover(@$user->bg_image ? getFilePath('userBgImage') . '/' . @$user->bg_image : null, true) }}"
                                        alt="@lang('user-background-image')"
                                        style="width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important;">
                                </div>

                                <div style="padding: 0 20px 20px 20px !important; position: relative !important;">

                                    <div
                                        style="display: flex !important; align-items: flex-end !important; margin-top: -30px !important; margin-bottom: 20px !important; position: relative !important; z-index: 2 !important;">
                                        <div
                                            style="position: relative !important; margin-right: 12px !important; flex-shrink: 0 !important;">
                                            <img src="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                                                alt="{{ __($user->username) }}"
                                                style="width: 75px !important; height: 75px !important; border-radius: 50% !important; object-fit: cover !important; display: block !important; border: 3px solid #ffffff !important; box-shadow: 0 2px 8px rgba(0,0,0,0.12) !important;">
                                        </div>
                                        <div
                                            style="padding-bottom: 4px !important; flex-grow: 1 !important; overflow: hidden !important;">
                                            <h5
                                                style="font-size: 16px !important; font-weight: 700 !important; color: #222222 !important; margin: 0 0 2px 0 !important; line-height: 1.2 !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;">
                                                {{ __($user->username) }}
                                            </h5>
                                            <div
                                                style="font-size: 13px !important; color: #555555 !important; line-height: 1.2 !important; margin-bottom: 4px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;">
                                                {{ __(@$user->designation ?? 'Freelancer') }}
                                            </div>
                                            <div
                                                style="display: flex !important; align-items: center !important; font-size: 12px !important; color: #74767e !important;">
                                                <span
                                                    style="height: 8px !important; width: 8px !important; background-color: #23c366 !important; border-radius: 50% !important; display: inline-block !important; margin-right: 6px !important;"></span>
                                                @lang('Online')
                                            </div>
                                        </div>
                                    </div>

                                    @auth
                                        <button class="contactBtn" data-bs-toggle="modal" data-bs-target="#contactModal"
                                            style="width: 100% !important; display: flex !important; align-items: center !important; justify-content: center !important; background-color: #ffffff !important; border: 1px solid #3C88EE !important; color: #3C88EE !important; border-radius: 4px !important; font-size: 14px !important; font-weight: 600 !important; padding: 10px 16px !important; cursor: pointer !important; transition: all 0.2s ease !important; margin-bottom: 20px !important;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" class="bi bi-send" viewBox="0 0 16 16"
                                                style="margin-right: 8px !important;">
                                                <path
                                                    d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                                            </svg>
                                            @lang('Contact this seller')
                                        </button>
                                    @else
                                        <button type="button" class="contactBtn" data-bs-toggle="modal"
                                            data-bs-target="#loginModal"
                                            style="width: 100% !important; display: flex !important; align-items: center !important; justify-content: center !important; background-color: #ffffff !important; border: 1px solid #3C88EE !important; color: #3C88EE !important; border-radius: 4px !important; font-size: 14px !important; font-weight: 600 !important; padding: 10px 16px !important; cursor: pointer !important; transition: all 0.2s ease !important; margin-bottom: 20px !important;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" class="bi bi-send" viewBox="0 0 16 16"
                                                style="margin-right: 8px !important;">
                                                <path
                                                    d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                                            </svg>
                                            @lang('Contact this seller')
                                        </button>
                                    @endauth

                                    <div style="border-top: 1px solid #f0f2f5 !important; padding-top: 16px !important;">
                                        <div
                                            style="display: flex !important; justify-content: space-between !important; align-items: center !important; margin-bottom: 12px !important;">
                                            <span
                                                style="font-size: 14px !important; color: #74767e !important;">@lang("Seller's rating")</span>
                                            <span
                                                style="font-size: 14px !important; color: #222222 !important; font-weight: 600 !important; display: flex !important; align-items: center !important;">
                                                <span
                                                    style="color: #ffb33e !important; margin-right: 4px !important; font-size: 15px !important;">★</span>
                                                5.0
                                            </span>
                                        </div>

                                        <div
                                            style="display: flex !important; justify-content: space-between !important; align-items: center !important; margin-bottom: 12px !important;">
                                            <span
                                                style="font-size: 14px !important; color: #74767e !important;">@lang('Completed orders')</span>
                                            <span
                                                style="font-size: 14px !important; color: #222222 !important; font-weight: 600 !important;">{{ $user->services()->active()->count() + $user->softwares()->active()->count() }}</span>
                                        </div>

                                        <div
                                            style="display: flex !important; justify-content: space-between !important; align-items: center !important; margin-bottom: 12px !important;">
                                            <span
                                                style="font-size: 14px !important; color: #74767e !important;">@lang('Total reviews')</span>
                                            <span
                                                style="font-size: 14px !important; color: #222222 !important; font-weight: 600 !important; display: flex !important; align-items: center !important; gap: 10px !important;">
                                                <span
                                                    style="display: flex !important; align-items: center !important;"><span
                                                        style="height: 8px !important; width: 8px !important; background-color: #10c469 !important; border-radius: 50% !important; display: inline-block !important; margin-right: 5px !important;"></span>{{ $user->total_review ?? 0 }}</span>
                                                <span
                                                    style="display: flex !important; align-items: center !important;"><span
                                                        style="height: 8px !important; width: 8px !important; background-color: #ff5b5b !important; border-radius: 50% !important; display: inline-block !important; margin-right: 5px !important;"></span>0</span>
                                            </span>
                                        </div>

                                        <div
                                            style="display: flex !important; justify-content: space-between !important; align-items: center !important; margin-bottom: 0px !important;">
                                            <span
                                                style="font-size: 14px !important; color: #74767e !important;">@lang('Orders in progress')</span>
                                            <span
                                                style="font-size: 14px !important; color: #222222 !important; font-weight: 600 !important;">{{ $user->jobBids()->inprogress()->count() }}</span>
                                        </div>
                                    </div>

                                    <div
                                        style="border-top: 1px solid #f0f2f5 !important; padding-top: 14px !important; margin-top: 14px !important; display: flex !important; justify-content: space-between !important; font-size: 13px !important; color: #74767e !important;">
                                        <span>{{ __(@$user->address->country ?? 'Global') }}</span>
                                        <span>@lang('Joined') {{ showDateTime($user->created_at, 'M Y') }}</span>
                                    </div>

                                </div>
                            </div>
                        @endif

                        @if (@$user->about_me)
                            <div
                                style="background-color: #ffffff !important; border: 1px solid #eef2f5 !important; border-radius: 4px !important; padding: 20px !important; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04) !important;">
                                <h5
                                    style="font-size: 15px !important; font-weight: 700 !important; color: #222222 !important; margin: 0 0 12px 0 !important; text-transform: uppercase !important; letter-spacing: 0.5px !important;">
                                    @lang('About Me')</h5>
                                <p
                                    style="font-size: 14px !important; color: #404145 !important; line-height: 1.6 !important; margin: 0 !important; white-space: pre-line !important;">
                                    {{ __($user->about_me) }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-8 col-lg-8">
                    <div
                        style="background: #ffffff !important; border: 1px solid #eef2f5 !important; border-radius: 4px !important; padding: 16px 20px !important; margin-bottom: 24px !important; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.02) !important;">
                        <div
                            style="display: flex !important; align-items: center !important; justify-content: space-between !important; flex-wrap: wrap !important; gap: 15px !important;">

                            <ul class="nav nav-tabs custom--tab" role="tablist"
                                style="border-bottom: none !important; margin-bottom: 0 !important; gap: 5px !important;">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $maxKey == 'service' ? 'active' : '' }}"
                                        data-bs-toggle="tab" data-bs-target="#service" type="button" role="tab"
                                        style="border: none !important; font-weight: 600 !important; font-size: 15px !important; padding: 8px 16px !important; color: #74767e !important; background: transparent !important;"
                                        aria-selected="{{ $maxKey == 'service' ? 'true' : 'false' }}">
                                        @lang('Services')
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $maxKey == 'software' ? 'active' : '' }}"
                                        data-bs-toggle="tab" data-bs-target="#software" type="button" role="tab"
                                        style="border: none !important; font-weight: 600 !important; font-size: 15px !important; padding: 8px 16px !important; color: #74767e !important; background: transparent !important;"
                                        aria-selected="{{ $maxKey == 'software' ? 'true' : 'false' }}">
                                        @lang('Softwares')
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $maxKey == 'job' ? 'active' : '' }}" data-bs-toggle="tab"
                                        data-bs-target="#job" type="button" role="tab"
                                        style="border: none !important; font-weight: 600 !important; font-size: 15px !important; padding: 8px 16px !important; color: #74767e !important; background: transparent !important;"
                                        aria-selected="{{ $maxKey == 'job' ? 'true' : 'false' }}">
                                        @lang('Jobs')
                                    </button>
                                </li>
                            </ul>

                            <div class="layout-toggle-btns" style="display: flex !important; gap: 6px !important;">
                                <button class="layout-toggle-btn grid-layout active" type="button"
                                    style="border: 1px solid #eef2f5 !important; background: #ffffff !important; padding: 6px 10px !important; border-radius: 4px !important;">
                                    @include('Template::partials.icons.grid')
                                </button>
                                <button class="layout-toggle-btn list-layout" type="button"
                                    style="border: 1px solid #eef2f5 !important; background: #ffffff !important; padding: 6px 10px !important; border-radius: 4px !important;">
                                    @include('Template::partials.icons.list')
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="item-details-area">
                        @include('Template::partials.basic_card')

                        <div class="product-reviews-content mt-4"
                            style="background: #ffffff !important; border: 1px solid #eef2f5 !important; border-radius: 4px !important; padding: 24px !important; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.02) !important;">
                            <div class="section-header"
                                style="margin-bottom: 20px !important; border-bottom: 1px solid #f0f2f5 !important; padding-bottom: 10px !important;">
                                <h4 class="section-title"
                                    style="font-size: 16px !important; font-weight: 700 !important; color: #222222 !important; margin: 0 !important;">
                                    @lang('Reviews')</h4>
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
        .custom--tab .nav-link.active {
            color: #3C88EE !important;
            border-bottom: 2px solid #3C88EE !important;
            border-radius: 0 !important;
        }

        .page-content {
            margin-top: 0;
        }

        .page-top {
            border-bottom: unset;
            padding-bottom: 14px;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            "use strict";
            @if (request()->contact)
                @guest
                $('#loginModal').modal('show');
            @else
                $('.contactBtn').trigger('click');
            @endguest
        @endif
        });
    </script>
@endpush
