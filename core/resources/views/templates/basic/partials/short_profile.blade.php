@if (@$user)
    <div class="kwork-profile-card bg-white border rounded p-4 mb-4">

        <a href="{{ route('public.profile', $user->username) }}"
            class="kwork-header-profile-link d-flex align-items-center mb-4 text-decoration-none">
            <div class="position-relative me-3">
                <img class="kwork-avatar rounded-circle object-fit-cover"
                    src="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                    alt="@lang('user-profile-image')" width="60" height="60">
            </div>
            <div>
                <div class="kwork-meta-text text-muted mb-0"
                    style="font-size: 14px; line-height: 1.2; text-transform: capitalize;">
                    {{ __(@$user->designation ?? 'Freelancer') }}
                </div>
                <h5 class="kwork-seller-name fw-semibold my-1"
                    style="font-size: 16px; color: #222; text-transform: capitalize;">
                    {{ __(@$user->username) }}
                </h5>
            </div>
        </a>

        @if (!request()->routeIs('job.details'))
            <a href="{{ route('public.profile', $user->username) }}"
                class="kwork-contact-btn w-100 d-flex align-items-center justify-content-center fw-medium py-3 mb-4 border rounded text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                    class="bi bi-send me-2" viewBox="0 0 16 16">
                    <path
                        d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                </svg>
                @lang('Contact this seller')
            </a>
        @endif

        @php
            $userAvgRating =
                $user->total_review > 0 ? number_format($user->total_rating / $user->total_review, 1) : '0.0';
        @endphp

        <div class="kwork-info-divider pt-3 border-top">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="kwork-info-label">@lang("Seller's rating")</span>
                <span class="kwork-info-value fw-semibold d-flex align-items-center">
                    <span class="kwork-star-icon me-1">★</span>
                    <span class="rating-number-value">{{ $userAvgRating }}</span>
                </span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="kwork-info-label">@lang('Completed orders')</span>
                <span
                    class="kwork-info-value">{{ @$user->services()->active()->count() + @$user->softwares()->active()->count() }}</span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="kwork-info-label">{{ $user->total_review }} @lang('total reviews')</span>
                <span class="kwork-info-value d-flex align-items-center gap-2">
                    <span class="d-flex align-items-center review-count-green" title="@lang('Positive Reviews')">
                        <span class="review-dot bg-success me-1"></span>{{ $user->total_review }}
                    </span>
                    <span class="d-flex align-items-center review-count-red" title="@lang('Negative Reviews')">
                        <span class="review-dot bg-danger me-1"></span>0
                    </span>
                </span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="kwork-info-label">@lang('Orders in progress')</span>
                <span class="kwork-info-value">{{ __($user->jobBids()->inprogress()->count()) }}</span>
            </div>
        </div>

        <div class="kwork-info-divider pt-3 mt-3 border-top">
            <div class="mb-2">
                <div class="kwork-info-value fw-normal text-dark">{{ __(@$user->address->country ?? 'Global') }}</div>
            </div>
            <div>
                <div class="kwork-info-label text-muted" style="font-size: 14px;">
                    @lang('Joined') {{ showDateTime($user->created_at, 'F d, Y') }}
                </div>
            </div>
        </div>
    </div>
@endif

@push('style')
    <style>
        .kwork-header-profile-link {
            cursor: pointer;
            display: flex;
            transition: opacity 0.2s ease;
        }

        .kwork-header-profile-link:hover {
            opacity: 0.85;
        }

        .kwork-header-profile-link:hover .kwork-seller-name {
            color: #0073ec !important;
        }

        .kwork-star-icon {
            color: #ff9800 !important;
            font-size: 16px;
        }

        .rating-number-value {
            color: #ff4500 !important;
        }

        .review-count-green {
            color: #1dbf73 !important;
            font-weight: 600;
        }

        .review-count-red {
            color: #f44336 !important;
            font-weight: 600;
        }

        .review-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }
    </style>
@endpush
