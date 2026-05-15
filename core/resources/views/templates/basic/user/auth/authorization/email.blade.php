@extends('Template::layouts.frontend')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center my-120">
            <div class="verification-code-wrapper">
                <div class="verification-area">
                    <form action="{{ route('user.verify.email') }}" method="POST" class="submit-form">
                        @csrf
                        <div class="mb-4">
                            <p class="verification-text">@lang('A 6 digit verification code sent to your email address'): {{ showEmailAddress(auth()->user()->email) }}</p>
                        </div>

                        <div class="mb-4">
                            @include('Template::partials.verification_code')
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="w-100 btn btn--lg btn--base">@lang('Submit')</button>
                        </div>

                        <div class="mb-4">
                            <p class="mb-2">
                                @lang('If you don\'t get any code'), <span class="countdown-wrapper">@lang('try again after') <span id="countdown"
                                        class="fw-bold">--</span> @lang('seconds')</span> <a
                                    href="{{ route('user.send.verify.code', 'email') }}" class="try-again-link d-none">
                                    @lang('Try again')</a>
                            </p>
                            <a href="{{ route('user.logout') }}">@lang('Logout')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var distance = Number("{{ @$user->ver_code_send_at->addMinutes(2)->timestamp - time() }}");
        var x = setInterval(function() {
            distance--;
            document.getElementById("countdown").innerHTML = distance;
            if (distance <= 0) {
                clearInterval(x);
                document.querySelector('.countdown-wrapper').classList.add('d-none');
                document.querySelector('.try-again-link').classList.remove('d-none');
            }
        }, 1000);
    </script>
@endpush
