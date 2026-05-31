@extends('Template::layouts.frontend')
@section('content')
    <style>
        .kwork-hero-section {
            display: none
        }
    </style>
    <main class="page-wrapper">
        <section class="jss-details py-40">
            <div class="container">
                <div class="row gy-5">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <div class="jss-details-main">

                            <div class="kwork-detail-header"
                                style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                <nav class="kwork-breadcrumb d-flex align-items-center gap-2 mb-3 mt-3"
                                    style="font-size: 14px; color: #777777;">
                                    <a href="#"
                                        style="color: #777777; text-decoration: none; transition: color 0.2s;">{{ __(@$productDetails->category->name ?? 'Design') }}</a>
                                    <span style="font-size: 11px; color: #b5b5b5;"><i class="las la-angle-right"></i></span>
                                    <a href="#"
                                        style="color: #777777; text-decoration: none; transition: color 0.2s;">{{ __(@$productDetails->subCategory->name ?? 'Logo Design') }}</a>
                                    <span style="font-size: 11px; color: #b5b5b5;"><i class="las la-angle-right"></i></span>
                                </nav>

                                <div style="border: 1px solid #eee; padding: 10px; border-bottom: none;">
                                    <h1 class="kwork-gig-title mb-1 fs-3 fs-lg-1"
                                        style="font-weight: 700; color: #222222; line-height: 1.25; letter-spacing: -0.5px;">
                                        {{ __($productDetails->name ?? 'I will do unique, modern and professional business logo design') }}
                                    </h1>

                                    @php
                                        $mainAvgRating =
                                            $productDetails->total_review > 0
                                                ? number_format(
                                                    $productDetails->total_rating / $productDetails->total_review,
                                                    1,
                                                )
                                                : '0.0';
                                        $mainStars = round($mainAvgRating);
                                    @endphp

                                    <div class="kwork-gig-meta d-flex align-items-center flex-wrap justify-content-between">
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <div class="d-flex align-items-center gap-2 me-2">
                                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$productDetails->user->image, isAvatar: true) }}"
                                                    class="rounded-circle object-fit-cover" width="28" height="28"
                                                    alt="avatar">
                                                <a href="{{ route('public.profile', @$productDetails->user->username) }}"
                                                    style="font-size: 15px; font-weight: 600; color: #555555; text-decoration: none; transition: color 0.2s; text-transform: capitalize;"
                                                    onmouseover="this.style.color='#0073ec'"
                                                    onmouseout="this.style.color='#555555'">
                                                    {{ __(@$productDetails->user->username ?? 'Mobi_designs') }}
                                                </a>
                                            </div>

                                            <div class="d-flex align-items-center me-2">
                                                <div class="kwork-stars me-1"
                                                    style="color: #ff9800; font-size: 14px; letter-spacing: -1px;">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $mainStars)
                                                            <i class="las la-star"></i>
                                                        @else
                                                            <i class="lar la-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span
                                                    style="font-size: 14px; font-weight: 600; color: #ff4500;">{{ $mainAvgRating }}</span>
                                            </div>

                                            <div style="font-size: 14px; color: #777777;">
                                                <span style="color: #b5b5b5; margin-right: 5px;">•</span>
                                                <a href="#jss-details-tab-3" class="review-link-trigger"
                                                    style="color: #777777; text-decoration: underline;">
                                                    {{ $productDetails->total_review }} @lang('reviews')
                                                </a>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0">
                                            <button
                                                class="btn d-flex align-items-center gap-1 border rounded px-3 py-1.5 bg-white shadow-sm-hover"
                                                style="font-size: 14px; color: #555555; border-color: #e4e8eb !important; height: 36px;">
                                                <span
                                                    style="font-size: 14px; font-weight: 500; color: #222;">{{ $productDetails->favorite ?? 0 }}</span>
                                                <i class="lar la-heart" style="font-size: 16px; margin-left: 2px;"></i>
                                            </button>
                                            <button
                                                class="btn d-flex align-items-center justify-content-center border rounded bg-white shadow-sm-hover"
                                                style="border-color: #e4e8eb !important; width: 36px; height: 36px; color: #a9ae injection;">
                                                <i class="las la-exclamation-triangle"
                                                    style="font-size: 18px; color: #999;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Slider and Job Details -->
                            @include('Template::items.details.banner', ['type' => 'job'])

                            <!-- Tab Navigation and Content -->
                            <div class="jss-details-main__block three">
                                <!-- Tabs Navigation -->
                                <ul class="nav nav-tabs custom--tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#jss-details-tab-1" type="button" role="tab">
                                            @lang('Description')
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#req" type="button"
                                            role="tab">
                                            @lang('Requirements')
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bids" type="button"
                                            role="tab">
                                            @lang('Bids') ({{ $productDetails->total_bid }})
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link comments-tab-btn" data-bs-toggle="tab"
                                            data-bs-target="#comment" type="button" role="tab">
                                            @lang('Comments')
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tabs Content -->
                                <div class="tab-content">
                                    <!-- Description Tab -->
                                    <div class="tab-pane active" id="jss-details-tab-1" role="tabpanel" tabindex="0">
                                        @include('Template::items.details.description', [
                                            'type' => 'job',
                                        ])
                                    </div>

                                    <!-- Requirements Tab -->
                                    <div class="tab-pane" id="req" role="tabpanel" tabindex="0">
                                        <div>
                                            @php echo $productDetails->requirements @endphp
                                        </div>
                                    </div>

                                    <!-- Bids Tab -->
                                    <div class="tab-pane" id="bids" role="tabpanel" tabindex="0">
                                        @include('Template::items.details.bids')
                                    </div>

                                    <!-- Comments Tab -->
                                    <div class="tab-pane" id="comment" role="tabpanel" tabindex="0">
                                        @include('Template::items.details.comments', [
                                            'type' => 'job',
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4 d-none d-lg-block details-sidebar" style="margin-top:95px;">
                        <div class="jss-details-sidebar">
                            <!-- Bid Details -->
                            <div class="jss-details-sidebar__block">
                                <div class="widget-card">
                                    <div class="widget-card__header">
                                        <h5 class="widget-card__title">@lang('Bid Details')</h5>
                                    </div>
                                    <div class="widget-card__body">
                                        <ul class="info-list">
                                            <li class="info-list-item">
                                                <span class="info-list-item__label">@lang('Completion Time')</span>
                                                <span class="info-list-item__value">{{ $productDetails->delivery_time }}
                                                    @lang('Days')</span>
                                            </li>
                                            <li class="info-list-item">
                                                <span class="info-list-item__label">@lang('Budget')</span>
                                                <span
                                                    class="info-list-item__value">{{ showAmount($productDetails->price) }}</span>
                                            </li>
                                        </ul>
                                        @auth
                                            @if (auth()->id() != $productDetails->user_id)
                                                <div class="widget-card__footer mt-3">
                                                    <button class="btn btn--base w-100 btn--lg" data-bs-toggle="modal"
                                                        data-bs-target="#bidModal" type="button"
                                                        @disabled(@$existingJobBidCheck)>@lang('Bid Now')</button>
                                                </div>
                                            @endif
                                        @else
                                            <div class="widget-card__footer mt-3">
                                                <button class="btn btn--base w-100 btn--lg" data-bs-toggle="modal"
                                                    data-bs-target="#loginModal" type="button"
                                                    @disabled(@$existingJobBidCheck)>@lang('Bid Now')</button>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                            <!-- Include other widgets if needed -->
                            @include('Template::partials.short_profile', [
                                'user' => $productDetails->user,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('Template::partials.down_ad')

        <!-- Bid Modal -->
        @auth
            @if (auth()->id() != $productDetails->user_id)
                <div id="bidModal" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">@lang('Bid Now')</h5>
                                <span class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </span>
                            </div>
                            <form action="{{ route('user.job.bidding.store') }}" method="POST">
                                @csrf
                                <input name="job_id" type="hidden" value="{{ $productDetails->id }}">
                                <div class="modal-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label form--label mb-2" for="title">@lang('Title')</label>
                                        <input class="form-control form--control" name="title" type="text"
                                            value="{{ old('title') }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label form--label mb-2" for="price">@lang('Price')</label>
                                        <div class="input-group">
                                            <input class="form-control form--control" name="price" type="number"
                                                value="{{ old('price') }}" step="any" required>
                                            <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label form--label mb-2"
                                            for="description">@lang('Description')</label>
                                        <textarea class="form-control form--control" name="description" rows="5" required>{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--base w-100 btn--lg">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </main>
@endsection

@push('style')
    <style>
        .reviews-list-item__title {
            margin: 12px 0 5px 0;
        }

        .reviews-list-item__desc {
            margin: 0px 0 16px 0;
            /* Added more spacing between description and price */
            font-size: 15px;
            color: #333;
        }

        .reviews-list-item__price {
            font-size: 16px;
            /* Increased font size slightly */
            font-weight: 500;
            color: #444;
        }

        .reviews-list-item__price strong {
            font-weight: 600;
            color: #000;
        }

        .reviews-list-item__price .highlighted-price {
            font-size: 18px;
            /* Larger font size for price */
            font-weight: bold;
            color: hsl(var(--base));
            /* Bright red color for price to make it stand out */
            margin-left: 5px;
        }
    </style>
@endpush


@push('script')
    <script>
        (function($) {
                "use strict";

                @guest
                $('.comments-tab-btn').on('click', function(e) {
                    e.preventDefault(); // Prevent default tab behavior
                    $('#loginModal').modal('show'); // Show the login modal
                });
            @endguest

        })(jQuery);
    </script>
@endpush
