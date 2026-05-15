@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Site Title')</label>
                                    <input class="form-control" type="text" name="site_name" required
                                        value="{{ gs('site_name') }}">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label> @lang('Timezone')</label>
                                <select class="select2 form-control" name="timezone">
                                    @foreach ($timezones as $key => $timezone)
                                        <option value="{{ @$key }}" @selected(@$key == $currentTimezone)>{{ __($timezone) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Currency')</label>
                                    <input class="form-control" type="text" name="cur_text" required
                                        value="{{ gs('cur_text') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Currency Symbol')</label>
                                    <input class="form-control" type="text" name="cur_sym" required
                                        value="{{ gs('cur_sym') }}">
                                </div>
                            </div>

                            <div class="form-group col-sm-6">
                                <label> @lang('Site Base Color')</label>
                                <div class="input-group">
                                    <span class="input-group-text p-0 border-0">
                                        <input type='text' class="form-control colorPicker"
                                            value="{{ gs('base_color') }}">
                                    </span>
                                    <input type="text" class="form-control colorCode" name="base_color"
                                        value="{{ gs('base_color') }}">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label> @lang('Record to Display Per page')</label>
                                <select class="select2 form-control" name="paginate_number"
                                    data-minimum-results-for-search="-1">
                                    <option value="20" @selected(gs('paginate_number') == 20)>@lang('20 items per page')</option>
                                    <option value="50" @selected(gs('paginate_number') == 50)>@lang('50 items per page')</option>
                                    <option value="100" @selected(gs('paginate_number') == 100)>@lang('100 items per page')</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-6 ">
                                <label> @lang('Currency Showing Format')</label>
                                <select class="select2 form-control" name="currency_format"
                                    data-minimum-results-for-search="-1">
                                    <option value="1" @selected(gs('currency_format') == Status::CUR_BOTH)>@lang('Show Currency Text and Symbol Both')</option>
                                    <option value="2" @selected(gs('currency_format') == Status::CUR_TEXT)>@lang('Show Currency Text Only')</option>
                                    <option value="3" @selected(gs('currency_format') == Status::CUR_SYM)>@lang('Show Currency Symbol Only')</option>
                                </select>
                            </div>

                            @php
                                $services = [
                                    'service' => __('Service'),
                                    'software' => __('Software'),
                                    'job' => __('Job'),
                                ];
                            @endphp

                            <div class="form-group col-sm-6">
                                <label>@lang('Home Default Service')</label>
                                <select class="form-control select2" data-minimum-results-for-search="-1"
                                    name="default_service" required>
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    @foreach ($services as $key => $value)
                                        <option value="{{ $key }}" @selected(gs('default_service') === $key)>
                                            @lang($value)
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted fw-bold text--primary">
                                    <i class="las la-info-circle text--primary"></i>
                                    @lang('To display a service on the home page, you must manually set it as featured.')
                                </small>
                            </div>

                            <div class="form-group col-sm-12">
                                <label>@lang('Referral Commission')</label>
                                <div class="input-group">
                                    <input class="form-control" name="referral_commission" type="text"
                                        value="{{ gs('referral_commission') }}">
                                    <span class="input-group-text">@lang('%')</span>
                                </div>
                                <small class="form-text text-muted fw-bold text--primary">
                                    <i class="las la-info-circle text--primary"></i>
                                    @lang('The user will earn a commission when the person they referred makes a deposit.')
                                </small>
                            </div>


                            <h5 class="mt-4 mb-2">@lang('Pusher Configuration')</h5>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('App ID')</label>
                                    <input class="form-control" name="app_id" type="text"
                                        value="{{ gs('pusher_config')?->app_id }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('App Key')</label>
                                    <input class="form-control" name="app_key" type="text"
                                        value="{{ gs('pusher_config')?->app_key }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('App Secret Key')</label>
                                    <input class="form-control" name="app_secret_key" type="text"
                                        value="{{ gs('pusher_config')?->app_secret_key }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Cluster')</label>
                                    <input class="form-control" name="cluster" type="text"
                                        value="{{ gs('pusher_config')?->cluster }}">
                                </div>
                            </div>
                        </div>

                        @can('admin.setting.general.update')
                            <div class="form-group">
                                <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                            </div>
                        @endcan

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";


            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function(color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function() {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });
        })(jQuery);
    </script>
@endpush
