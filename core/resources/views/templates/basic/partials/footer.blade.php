@php
    $footerContent = getContent('footer.content', true);
    $footerElements = getContent('footer.element', false, null, true);
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp

<footer class="footer bg-img"
    data-background-image="{{ frontendImage('footer', @$footerContent->data_values->image, '1920x475') }}">
    <div class="footer-top">
        <div class="container">
            <div class="row gy-4">
                <!-- Footer Logo and Description -->
                <div class="col-12 col-sm-12 col-lg-3">
                    <div class="footer-item one">
                        <a class="footer-logo" href="{{ route('home') }}">
                            <img src="{{ siteLogo('dark') }}" alt="Logo" />
                        </a>

                        <p class="footer-item__desc">{{ __(@$footerContent->data_values->description) }}</p>
                    </div>
                </div>

                <!-- Quick Links Section -->
                <div class="col-6 col-sm-4 col-lg-2">
                    <div class="footer-item two">
                        <h6 class="footer-item__title">@lang('Quick Links')</h6>
                        <ul class="footer-menu">
                            <li class="footer-menu__item">
                                <a class="footer-menu__link" href="{{ route('service') }}">@lang('Services')</a>
                            </li>
                            <li class="footer-menu__item">
                                <a class="footer-menu__link" href="{{ route('software') }}">@lang('Software')</a>
                            </li>
                            <li class="footer-menu__item">
                                <a class="footer-menu__link" href="{{ route('job') }}">@lang('Jobs')</a>
                            </li>
                            <li class="footer-menu__item"><a class="footer-menu__link"
                                    href="{{ route('user.login') }}">@lang('Sign In')</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Our Services -->
                <div class="col-6 col-sm-4 col-lg-2">
                    <div class="footer-item three">
                        <h6 class="footer-item__title">@lang('Our Services')</h6>
                        <ul class="footer-menu">
                            @foreach ($categories->take(4) as $category)
                                <li class="footer-menu__item">
                                    <a class="footer-menu__link"
                                        href="{{ route('category.wise.product', [slug($category->name), $category->id]) }}">
                                        {{ __($category->name) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Legal & Support -->
                <div class="col-6 col-sm-4 col-lg-2">
                    <div class="footer-item four">
                        <h6 class="footer-item__title">@lang('Legal & Support')</h6>
                        <ul class="footer-menu">
                            @foreach ($policyPages as $policy)
                                <li class="footer-menu__item">
                                    <a class="footer-menu__link" href="{{ route('policy.pages', $policy->slug) }}">
                                        {{ __($policy->data_values->title) }}
                                    </a>
                                </li>
                            @endforeach
                            <li class="footer-menu__item"><a class="footer-menu__link"
                                    href="{{ route('contact') }}">@lang('Contact Us')</a></li>
                            <li class="footer-menu__item"><a class="footer-menu__link"
                                    href="{{ route('blogs') }}">@lang('Blogs')</a></li>

                        </ul>
                    </div>
                </div>
                <!-- Subscribe Section -->
                <div class="col-12 col-sm-12 col-lg-3">
                    <div class="footer-item five">
                        <h6 class="footer-item__title">{{ __(@$footerContent->data_values->subscribe_heading) }}</h6>
                        <p class="footer-item__desc">{{ __(@$footerContent->data_values->subscribe_description) }}</p>
                        <form class="subscribe-form" id="subscribeForm">
                            <div class="input-group">
                                <input class="form-control" type="email" placeholder="@lang('Email Address')"
                                    name="email" id="subscriberEmail" required />
                                <button class="btn btn--base" type="submit">
                                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4314 20.0454L15.8979 15.0773" stroke="white" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M22.5976 7.62511L1.74585 15.8297L11.1123 20.4003L16.6502 29.2293L22.5976 7.62511Z"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom__wrapper">
                <p class="footer-bottom__text">{{ __(@$footerContent->data_values->copyright_text) }}</p>
                <ul class="social-list">
                    @foreach ($footerElements as $footer)
                        <li class="social-list__item">
                            <a href="{{ @$footer->data_values->url }}" class="social-list__link"
                                target="__blank">@php echo @$footer->data_values->social_icon @endphp</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>



@push('script')
    <script>
        'use strict';
        (function($) {
            $('#subscribeForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                var email = $('#subscriberEmail').val();
                var csrfToken = '{{ csrf_token() }}';

                $.ajax({
                    type: 'POST',
                    url: '{{ route('subscriber.store') }}',
                    data: {
                        email: email,
                        _token: csrfToken
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            notify('success', response.success);
                            $('#subscriberEmail').val(''); // Clear the input field on success
                        } else {
                            notify('error', response.error);
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                            '@lang('An error occurred, please try again.')';
                        notify('error', errorMessage);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
