<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLongTitle">@lang('Login')</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                @php
                    $credentials = gs('socialite_credentials');
                    $socialLoginActive =
                        @$credentials->google->status == Status::ENABLE ||
                        @$credentials->facebook->status == Status::ENABLE ||
                        @$credentials->linkedin->status == Status::ENABLE;
                @endphp

                @if ($socialLoginActive)
                    @include('Template::partials.social_login')
                    <div class="account-card__divider my-3">
                        <span>@lang('OR')</span>
                    </div>
                @endif

                <form id="ajaxLoginForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">@lang('Email or Username')</label>
                        <input type="text" class="form-control form--control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">@lang('Password')</label>
                        <div class="input-group input--group input--group-password">
                            <input class="form-control form--control" name="password" type="password"
                                placeholder="@lang('Password')" id="password" required>
                            <button class="input-group-text input-group-btn toggle-password" type="button">
                                <i class="far fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- CAPTCHA -->
                    <div class="mb-3" id="captcha-container">
                        @include('Template::partials.captcha')
                    </div>

                    <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                            <label class="form-check-label" for="rememberMe">@lang('Remember Me')</label>
                        </div>
                        <a class="fs-15 mb-3" href="{{ route('user.password.request') }}">@lang('Forgot Password?')</a>
                    </div>

                    <button type="submit" class="btn btn--base w-100 h-45">@lang('Sign In')</button>

                    @if (gs('registration'))
                        <p class="text-center mt-3">
                            @lang("Don't have an account?") <a href="{{ route('user.register') }}">@lang('Register')</a>
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";

            // AJAX Login
            $("#ajaxLoginForm").on("submit", function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('user.login.ajax') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            location.reload(); // Refresh page on successful login
                        } else {
                            notify("error", response
                                .error); // Use notify instead of inline error message
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON ? xhr.responseJSON.error :
                            "@lang('Something went wrong!')";
                        notify("error", errorMsg);

                        // Update CAPTCHA
                        if (xhr.responseJSON && xhr.responseJSON.captcha) {
                            $("#captcha-container").html(xhr.responseJSON.captcha);
                        }
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
