@extends('Template::layouts.master')
@section('content')
    <div class="card card--lg custom--card">
        <div class="card-body">
            <div class="gig-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    @lang('Change Password')
                </h5>
            </div>
            <div class="gig-body">
                <form method="POST">
                    @csrf
                    <!-- Current Password -->
                    <div class="form--group-lg">
                        <div class="row align-items-start">
                            <div class="col-lg-3">
                                <label class="form-label form--label required mt-3"
                                    for="current_password">@lang('Current Password')</label>
                            </div>
                            <div class="col-lg-9">
                                <input class="form-control form--control" name="current_password" type="password"
                                    placeholder="@lang('Current Password')" required>
                            </div>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="form--group-lg mt-3">
                        <div class="row align-items-start">
                            <div class="col-lg-3">
                                <label class="form-label form--label required mt-3" for="password">@lang('New Password')</label>
                            </div>
                            <div class="col-lg-9">
                                <input
                                    class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                    name="password" type="password" placeholder="@lang('New Password')" required>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form--group-lg mt-3">
                        <div class="row align-items-start">
                            <div class="col-lg-3">
                                <label class="form-label form--label required mt-3"
                                    for="password_confirmation">@lang('Confirm Password')</label>
                            </div>
                            <div class="col-lg-9">
                                <input class="form-control form--control" name="password_confirmation" type="password"
                                    placeholder="@lang('Confirm Password')" required>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form--group-lg text-end mt-4">
                        <button class="btn btn--base btn--lg" type="submit">
                            @lang('Change Password')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
