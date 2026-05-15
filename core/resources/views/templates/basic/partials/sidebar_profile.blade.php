<div class="jss-details-sidebar__block">
    <div class="widget-profile">
        <div class="widget-profile__header">
            <div class="widget-profile__cover-img">
                <img src="{{ cover(@$user->bg_image ? getFilePath('userBgImage') . '/' . @$user->bg_image : 'default-cover.png', true) }}"
                    alt="user-background-image">
            </div>
            <div class="widget-profile-user">
                <img class="widget-profile-user__thumb"
                    src="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                    alt="{{ __($user->username) }}">
                <div class="widget-profile-user__content">
                    <h6 class="widget-profile-user__name">
                        <a href="{{ route('public.profile', $user->username) }}">{{ __($user->username) }}</a>
                    </h6>
                    <span class="widget-profile-user__position">{{ @$user->designation }}</span>
                </div>
            </div>
        </div>

        <div class="widget-profile__body">
            <ul class="profile-info-list">
                <li class="profile-info-list__item">
                    <span class="label">@lang('Total Services')</span>
                    <span class="value">{{ $user->services()->active()->count() }}</span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('Total Software')</span>
                    <span class="value">{{ $user->softwares()->active()->count() }}</span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('Inprogress Jobs')</span>
                    <span class="value">{{ $user->jobBids()->inprogress()->count() }}</span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('Rating')</span>
                    <span class="value" data-bs-toggle="tooltip"
                        title="{{ $user->total_review > 0 ? $user->total_review . ' ' . __('reviews') : '0 ' . __('reviews') }}">
                        <span class="ratings">
                            @php echo userStars($user->total_rating); @endphp
                        </span>
                    </span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('Level')</span>
                    <span class="value text--base fw-semibold">{{ __(ucFirst(@$user->level->name ?? 'N/A')) }}</span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('User Verified')</span>
                    <span
                        class="badge badge--solid badge--{{ $user->kv == Status::KYC_VERIFIED ? 'success' : 'danger' }}">
                        {{ $user->kv == Status::KYC_VERIFIED ? __('Yes') : __('No') }}
                    </span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('Mobile Verified')</span>
                    <span class="badge badge--solid badge--{{ $user->sv ? 'success' : 'danger' }}">
                        {{ $user->sv ? __('Yes') : __('No') }}
                    </span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('Email Verified')</span>
                    <span class="badge badge--solid badge--{{ $user->ev ? 'success' : 'danger' }}">
                        {{ $user->ev ? __('Yes') : __('No') }}
                    </span>
                </li>
            </ul>
            @auth
                <button class="mt-4 btn btn--lg btn--base w-100 contactBtn" data-bs-toggle="modal"
                    data-bs-target="#contactModal">@lang('Contact Now')</button>
            @else
                <button type="button" class="mt-4 btn btn--lg btn--base w-100 contactBtn" data-bs-toggle="modal"
                    data-bs-target="#loginModal">
                    @lang('Contact Now')
                </button>
            @endauth
        </div>
    </div>

    <!-- About Me Section -->
    @if (@$user->about_me)
        <div class="widget-profile mt-4 p-3 border rounded">
            <h5 class="widget-title fw-bold mb-3">@lang('About Me')</h5>
            <p class="mb-0 text-secondary">
                {{ __(@$user->about_me ?? 'N/A') }}
            </p>
        </div>
    @endif

</div>
