<div class="social-auth-btns">
    @if (@$credentials->facebook->status == Status::ENABLE)
        <a class="btn btn--lg btn-outline--white" href="{{ route('user.social.login', 'facebook') }}">
            <img src="{{ getImage(activeTemplate(true) . '/icons/facebook.png') }}" alt="">
            <span>@lang('Facebook')</span>
        </a>
    @endif
    @if (@$credentials->google->status == Status::ENABLE)
        <a class="btn btn--lg btn-outline--white" href="{{ route('user.social.login', 'google') }}">
            <img src="{{ getImage(activeTemplate(true) . '/icons/google.png') }}" alt="">
            <span>@lang('Google')</span>
        </a>
    @endif
    @if (@$credentials->linkedin->status == Status::ENABLE)
        <a class="btn btn--lg btn-outline--white" href="{{ route('user.social.login', 'linkedin') }}">
            <img src="{{ getImage(activeTemplate(true) . '/icons/linkedin.png') }}" alt="">
            <span>@lang('Linkedin')</span>
        </a>
    @endif
</div>
