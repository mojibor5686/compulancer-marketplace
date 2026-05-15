@if (@$user)
    <div class="widget-profile">
        <div class="widget-profile__header">
            <div class="widget-profile__cover-img">
                <img src="{{ cover(@$user->bg_image ? getFilePath('userBgImage') . '/' . @$user->bg_image : null, true) }}"
                    alt="@lang('user-background-image')">
            </div>
            <div class="widget-profile-user">
                <img class="widget-profile-user__thumb"
                    src="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                    alt="@lang('user-profile-image')">
                <div class="widget-profile-user__content">
                    <h6 class="widget-profile-user__name">
                        <a
                            href="{{ @$user ? route('public.profile', @$user->username) : '#' }}">{{ __(@$user->username) }}</a>
                    </h6>
                    <span class="widget-profile-user__position">{{ __(@$user->designation) }}</span>
                </div>
            </div>
        </div>

        <div class="widget-profile__body">
            <ul class="profile-info-list">
                <li class="profile-info-list__item">
                    <span class="label">@lang('Total Services')</span>
                    <span class="value">{{ @$user->services()->active()->count() }}</span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('Total Software')</span>
                    <span class="value">{{ $user->softwares()->active()->count() }}</span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('Inprogress Jobs')</span>
                    <span class="value">{{ __($user->jobBids()->inprogress()->count()) }}</span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('Rating')</span>
                    <div class="ratings">
                        <div class="ratings-stars">
                            @php echo userStars($user->total_rating); @endphp
                        </div>

                        @if ($user->total_review)
                            <span class="ratings__total">({{ $user->total_review }})</span>
                        @else
                            <span class="ratings__total">(0)</span>
                        @endif
                    </div>
                </li>

                @if (@$user->level)
                    <li class="profile-info-list__item">
                        <span class="label">@lang('Level')</span>
                        <span
                            class="value text--base fw-semibold">{{ __(ucFirst(@$user?->level?->name ?? 'N/A')) }}</span>
                    </li>
                @endif

                <li class="profile-info-list__item">
                    <span class="label">@lang('User Verified')</span>
                    <span
                        class="badge badge--solid {{ $user->kv == Status::KYC_VERIFIED ? 'badge--success' : 'badge--danger' }}">
                        {{ $user->kv == Status::KYC_VERIFIED ? __('Yes') : __('No') }}
                    </span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('Mobile Verified')</span>
                    <span class="badge badge--solid {{ $user->sv ? 'badge--success' : 'badge--danger' }}">
                        {{ $user->sv ? __('Yes') : __('No') }}
                    </span>
                </li>
                <li class="profile-info-list__item">
                    <span class="label">@lang('Email Verified')</span>
                    <span class="badge badge--solid {{ $user->ev ? 'badge--success' : 'badge--danger' }}">
                        {{ $user->ev ? __('Yes') : __('No') }}
                    </span>
                </li>
            </ul>
            @if (!request()->routeIs('job.details'))
                <a class="mt-4 btn btn--lg btn--base w-100" href="{{ route('public.profile', $user->username) }}"
                    role="button">
                    @lang('Hire Me')
                </a>
            @endif

        </div>
    </div>
@endif
