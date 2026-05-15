@extends('Template::layouts.frontend')
@section('content')
    @php
        $bgImageContent = getContent('bg_image.content', true);
    @endphp
    <section class="account-section ptb-80 bg-overlay-white bg_img"
        data-background="{{ frontendImage('bg_image', @$bgImageContent->data_values->image, '1920x1200') }}">
        <div class="container">
            <div class="row justify-content-center pt-120">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <div class="contact-card">
                        <div class="contact-card__body">
                            <form method="POST" action="{{ route('user.data.submit') }}">
                                @csrf
                                <div class="row gy-3">
                                    <div class="col-sm-12">
                                        <label class="form-label form--label required">@lang('Username')</label>
                                        <input type="text" class="form-control form--control checkUser" name="username"
                                            value="{{ old('username') }}" required />
                                        <small class="text--danger usernameExist"></small>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label form--label required">@lang('Country')</label>
                                        <select name="country" class="form-control form--control select2-basic" required>
                                            @foreach ($countries as $key => $country)
                                                <option data-mobile_code="{{ $country->dial_code }}"
                                                    value="{{ $country->country }}" data-code="{{ $key }}">
                                                    {{ __($country->country) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label form--label required">@lang('Mobile')</label>
                                        <div class="input-group">
                                            <span class="input-group-text mobile-code text-white bg--base border-0"></span>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                            <input type="number" name="mobile" value="{{ old('mobile') }}"
                                                class="form-control form--control checkUser" required>
                                        </div>
                                        <small class="text--danger mobileExist"></small>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label form--label">@lang('Address')</label>
                                        <input type="text" class="form-control form--control" name="address"
                                            value="{{ old('address') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label form--label">@lang('State')</label>
                                        <input type="text" class="form-control form--control" name="state"
                                            value="{{ old('state') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label form--label">@lang('Zip Code')</label>
                                        <input type="text" class="form-control form--control" name="zip"
                                            value="{{ old('zip') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label form--label">@lang('City')</label>
                                        <input type="text" class="form-control form--control" name="city"
                                            value="{{ old('city') }}">
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit" class="w-100 btn btn--lg btn--base">
                                            @lang('Submit')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .mobile-code {
            border-top-left-radius: 5px !important;
            border-bottom-left-radius: 5px !important;
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {

            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').on('change', function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
                var value = $('[name=mobile]').val();
                var name = 'mobile';
                checkUser(value, name);
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            $('.checkUser').on('focusout', function(e) {
                var value = $(this).val();
                var name = $(this).attr('name')
                checkUser(value, name);
            });

            function checkUser(value, name) {
                var url = '{{ route('user.checkUser') }}';
                var token = '{{ csrf_token() }}';

                if (name == 'mobile') {
                    var mobile = `${value}`;
                    var data = {
                        mobile: mobile,
                        mobile_code: $('.mobile-code').text().substr(1),
                        _token: token
                    }
                }
                if (name == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.field} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            }
        })(jQuery);
    </script>
@endpush
