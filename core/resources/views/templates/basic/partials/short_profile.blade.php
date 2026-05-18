@if (@$user)
    <div class="kwork-profile-card bg-white border rounded p-4 mb-4">

        <div class="d-flex align-items-center mb-4">
            <div class="position-relative me-3">
                <img class="kwork-avatar rounded-circle object-fit-cover"
                    src="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                    alt="@lang('user-profile-image')" width="60" height="60">
            </div>
            <div>
                <div class="kwork-meta-text text-muted mb-0" style="font-size: 14px; line-height: 1.2;">
                    {{ __(@$user->designation ?? 'Freelancer') }}
                </div>
                <h5 class="kwork-seller-name fw-semibold my-1" style="font-size: 16px; color: #222;">
                    {{ __(@$user->username) }}
                </h5>
                <div class="d-flex align-items-center kwork-status text-muted" style="font-size: 13px;">
                    <span class="status-dot me-1"></span> @lang('Offline')
                </div>
            </div>
        </div>

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

        <div class="kwork-info-divider pt-3 border-top">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="kwork-info-label">@lang("Seller's rating")</span>
                <span class="kwork-info-value fw-semibold d-flex align-items-center">
                    <span class="kwork-star-icon me-1">★</span> 5.0
                </span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="kwork-info-label">@lang('Completed orders')</span>
                <span
                    class="kwork-info-value">{{ @$user->services()->active()->count() + @$user->softwares()->active()->count() }}</span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="kwork-info-label">@lang('2 total reviews')</span>
                <span class="kwork-info-value d-flex align-items-center gap-2">
                    <span class="d-flex align-items-center"><span class="review-dot bg-success me-1"></span>
                        {{ $user->total_review ?? 0 }}</span>
                    <span class="d-flex align-items-center"><span class="review-dot bg-danger me-1"></span> 0</span>
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

    <div class="kwork-share-card bg-white border rounded p-4 text-center">
        <h6 class="fw-bold text-dark mb-3" style="font-size: 15px; opacity: 0.85;">@lang('Share on your social media')</h6>
        <div class="d-flex justify-content-center gap-2">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                class="social-share-btn fb-btn d-flex align-items-center justify-content-center rounded">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                    class="bi bi-facebook" viewBox="0 0 16 16">
                    <path
                        d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                </svg>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank"
                class="social-share-btn tw-btn d-flex align-items-center justify-content-center rounded">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-twitter-x" viewBox="0 0 16 16">
                    <path
                        d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                </svg>
            </a>
        </div>
    </div>
@endif
