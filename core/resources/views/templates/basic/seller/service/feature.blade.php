@extends('Template::layouts.seller_service')
@section('service')
    <form id="tagFeatureForm">
        <!-- Search Tag -->
        <div class="form--group-lg">
            <div class="row align-items-start">
                <div class="col-lg-3">
                    <label class="form-label form--label">@lang('Search Tag')</label>
                </div>
                <div class="col-lg-9">
                    <div class="form--group">
                        <select class="form-control form--control select2-auto-tokenize" name="tag[]" multiple="multiple"
                            required>
                            @if (@$service->tag)
                                @foreach ($service->tag as $option)
                                    <option value="{{ $option }}" selected>{{ __($option) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <small class="mt-2">
                            @lang('Separate multiple keywords by') <code>,</code> (@lang('comma'))
                            @lang('or') <code>@lang('enter')</code> @lang('key').
                        </small>
                        <p class="fs-14 mt-2">
                            @lang('Please add 3-5 relevant tags that accurately describe your service\'s key features and expertise. These tags help potential clients find your services when searching.')
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Include Feature -->
        <div class="form--group-lg">
            <div class="row align-items-start">
                <div class="col-lg-3">
                    <label class="form-label form--label">@lang('Include Feature')</label>
                </div>
                <div class="col-lg-9">
                    <div class="form--group">
                        <div class="d-flex gap-3 flex-wrap">
                            @foreach ($features as $feature)
                                <div class="form-group custom-check-group">
                                    <input id="features_{{ $feature->id }}" name="features[]" type="checkbox"
                                        value="{{ $feature->id }}" @checked($service->features && in_array($feature->id, $service->features))>
                                    <label for="features_{{ $feature->id }}">{{ __($feature->name) }}</label>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-2 fs-14">
                            @lang('Enhance your service visibility by selecting relevant features. This helps potential buyers discover services that match their specific requirements and preferences.')
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form--group-lg text-end mt-4">
            <button class="btn btn--base btn--lg" id="saveAndContinue" type="button">
                @lang('Save & Continue')
            </button>
        </div>
    </form>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            // Handle form submission for 'Save & Continue' button
            $('#saveAndContinue').on('click', function() {
                var btn = $(this);
                var originalButtonText = btn.html();
                btn.html(`<div class="spinner-border"></div> @lang('Saving')...`).prop('disabled', true);

                var formData = new FormData($('#tagFeatureForm')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('user.seller.service.store.feature', $service->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            if (!response.is_update) {
                                window.location.href = response.redirect_url;
                            } else {
                                notify('success', `@lang('Service tag & feature updated successfully')`);
                                btn.html(originalButtonText).prop('disabled', false);
                            }
                        } else {
                            notify('error', response.message);
                            btn.html(originalButtonText).prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        notify('error', error);
                        btn.html(originalButtonText).prop('disabled', false);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
