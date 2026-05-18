<div class="jss-details-sidebar__block">
    @if (@$user)
        <div
            style="background-color: #ffffff; border: 1px solid #eef2f5; border-radius: 4px; padding: 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); margin-bottom: 24px;">

            <div style="display: flex; align-items: center; margin-bottom: 24px;">
                <div style="position: relative; margin-right: 16px;">
                    <img src="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                        alt="{{ __($user->username) }}"
                        style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; display: block;">
                </div>
                <div>
                    <div style="font-size: 14px; color: #888888; line-height: 1.2; margin-bottom: 2px;">
                        {{ __(@$user->designation ?? 'Freelancer') }}
                    </div>
                    <h5
                        style="font-size: 16px; font-weight: 600; color: #222222; margin: 0 0 4px 0; font-family: sans-serif;">
                        {{ __($user->username) }}
                    </h5>
                    <div style="display: flex; align-items: center; font-size: 13px; color: #888888;">
                        <span
                            style="height: 8px; width: 8px; background-color: #e0e0e0; border-radius: 50%; display: inline-block; margin-right: 6px;"></span>
                        @lang('Offline')
                    </div>
                </div>
            </div>

            @auth
                <button class="contactBtn" data-bs-toggle="modal" data-bs-target="#contactModal"
                    style="width: 100%; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border: 1px solid #d5dbed; color: #333333; border-radius: 4px; font-size: 15px; font-weight: 500; padding: 10px 16px; cursor: pointer; transition: all 0.2s ease; margin-bottom: 24px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#10c469" class="bi bi-send"
                        viewBox="0 0 16 16" style="margin-right: 8px;">
                        <path
                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                    </svg>
                    @lang('Contact this seller')
                </button>
            @else
                <button type="button" class="contactBtn" data-bs-toggle="modal" data-bs-target="#loginModal"
                    style="width: 100%; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border: 1px solid #d5dbed; color: #333333; border-radius: 4px; font-size: 15px; font-weight: 500; padding: 10px 16px; cursor: pointer; transition: all 0.2s ease; margin-bottom: 24px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#10c469" class="bi bi-send"
                        viewBox="0 0 16 16" style="margin-right: 8px;">
                        <path
                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                    </svg>
                    @lang('Contact this seller')
                </button>
            @endauth

            <div style="border-top: 1px solid #eef2f5; padding-top: 16px;">

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <span style="font-size: 15px; color: #555555;">@lang("Seller's rating")</span>
                    <span
                        style="font-size: 15px; color: #222222; font-weight: 600; display: flex; align-items: center;">
                        <span style="color: #ff9800; margin-right: 4px; font-size: 16px;">★</span> 5.0
                    </span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <span style="font-size: 15px; color: #555555;">@lang('Completed orders')</span>
                    <span
                        style="font-size: 15px; color: #222222;">{{ $user->services()->active()->count() + $user->softwares()->active()->count() }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <span style="font-size: 15px; color: #555555;">
                        {{ $user->total_review > 0 ? $user->total_review : 0 }} @lang('total reviews')
                    </span>
                    <span style="font-size: 15px; color: #222222; display: flex; align-items: center; gap: 12px;">
                        <span style="display: flex; align-items: center;"><span
                                style="height: 10px; width: 10px; background-color: #10c469; border-radius: 50%; display: inline-block; margin-right: 6px;"></span>
                            {{ $user->total_review ?? 0 }}</span>
                        <span style="display: flex; align-items: center;"><span
                                style="height: 10px; width: 10px; background-color: #ff5b5b; border-radius: 50%; display: inline-block; margin-right: 6px;"></span>
                            0</span>
                    </span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                    <span style="font-size: 15px; color: #555555;">@lang('Orders in progress')</span>
                    <span style="font-size: 15px; color: #222222;">{{ $user->jobBids()->inprogress()->count() }}</span>
                </div>
            </div>

            <div style="border-top: 1px solid #eef2f5; padding-top: 16px; margin-top: 16px;">
                <div style="margin-bottom: 6px;">
                    <span
                        style="font-size: 15px; color: #222222; font-weight: 400;">{{ __(@$user->address->country ?? 'Global') }}</span>
                </div>
                <div>
                    <span style="font-size: 14px; color: #888888;">
                        @lang('Joined') {{ showDateTime($user->created_at, 'F d, Y') }}
                    </span>
                </div>
            </div>
        </div>

        <div
            style="background-color: #ffffff; border: 1px solid #eef2f5; border-radius: 4px; padding: 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); text-align: center;">
            <h6 style="font-size: 15px; font-weight: 600; color: #333333; margin: 0 0 16px 0; opacity: 0.9;">
                @lang('Share on your social media')</h6>
            <div style="display: flex; justify-content: center; gap: 8px;">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                    target="_blank"
                    style="width: 40px; height: 36px; background-color: #0066ff; color: #ffffff; display: flex; align-items: center; justify-content: center; border-radius: 4px; text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-facebook" viewBox="0 0 16 16">
                        <path
                            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                    </svg>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank"
                    style="width: 40px; height: 36px; background-color: #00c3ff; color: #ffffff; display: flex; align-items: center; justify-content: center; border-radius: 4px; text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-twitter-x" viewBox="0 0 16 16">
                        <path
                            d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                    </svg>
                </a>
            </div>
        </div>
    @endif

    @if (@$user->about_me)
        <div
            style="background-color: #ffffff; border: 1px solid #eef2f5; border-radius: 4px; padding: 20px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); margin-top: 24px;">
            <h5 style="font-size: 16px; font-weight: 600; color: #222222; margin: 0 0 12px 0;">@lang('About Me')</h5>
            <p style="font-size: 14px; color: #555555; line-height: 1.5; margin: 0;">
                {{ __($user->about_me) }}
            </p>
        </div>
    @endif
</div>
