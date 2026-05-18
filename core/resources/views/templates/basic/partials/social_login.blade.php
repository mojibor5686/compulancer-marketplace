<div class="social-auth-btns d-flex justify-content-center align-items-center gap-3 w-100">
    @if (@$credentials->facebook->status == Status::ENABLE)
        <a class="btn btn-light d-flex align-items-center justify-content-center border shadow-sm p-0"
            href="{{ route('user.social.login', 'facebook') }}"
            style="width: 46px; height: 46px; border-radius: 50%; background-color: #fff;" title="@lang('Facebook')">
            <img src="{{ getImage(activeTemplate(true) . '/icons/facebook.png') }}" alt="Facebook"
                style="width: 22px; height: 22px; object-fit: contain;">
        </a>
    @endif

    @if (@$credentials->google->status == Status::ENABLE)
        <a class="btn btn-light d-flex align-items-center justify-content-center border shadow-sm p-0"
            href="{{ route('user.social.login', 'google') }}"
            style="width: 46px; height: 46px; border-radius: 50%; background-color: #fff;" title="@lang('Google')">
            <img src="{{ getImage(activeTemplate(true) . '/icons/google.png') }}" alt="Google"
                style="width: 22px; height: 22px; object-fit: contain;">
        </a>
    @endif

    @if (@$credentials->linkedin->status == Status::ENABLE)
        <a class="btn btn-light d-flex align-items-center justify-content-center border shadow-sm p-0"
            href="{{ route('user.social.login', 'linkedin') }}"
            style="width: 46px; height: 46px; border-radius: 50%; background-color: #fff;" title="@lang('Linkedin')">
            <img src="{{ getImage(activeTemplate(true) . '/icons/linkedin.png') }}" alt="Linkedin"
                style="width: 22px; height: 22px; object-fit: contain;">
        </a>
    @endif
</div>
