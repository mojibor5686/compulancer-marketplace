@extends('Template::layouts.buyer_job')
@section('job')
    <div class="gig-overview">
        <form id="tagFeatureForm">
            <!-- Job Skill Section -->
            <div class="gig-overview-space">
                <div class="form--group">
                    <label class="form-label form--label required">@lang('Job Skill')</label>
                    <div class="select2Tag">
                        <select class="form-control form--control select2-auto-tokenize" name="skill[]" multiple="multiple"
                            required>
                            @if (@$job->skill)
                                @foreach ($job->skill as $option)
                                    <option value="{{ $option }}" selected>{{ __($option) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <small class="mt-2 d-block">
                            @lang('Separate multiple keywords by') <code>,</code> (@lang('comma'))
                            @lang('or') <code>@lang('enter')</code> @lang('key').
                            @lang('Minimum 3 & maximum 15 tags.')
                        </small>
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
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <style>
        .iziToast {
            z-index: 99999 !important;
        }
    </style>
@endpush

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

    <script>
        (function($) {
            "use strict";

            function customNotify(type, message) {
                if (typeof notify !== 'undefined') {
                    notify(type, message);
                } else {
                    if (type === 'success') {
                        iziToast.success({
                            title: 'Success',
                            message: message,
                            position: 'topRight'
                        });
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: message,
                            position: 'topRight'
                        });
                    }
                }
            }

            // Handle form submission
            $('#saveAndContinue').on('click', function() {
                var btn = $(this);
                var originalButtonText = btn.html();
                btn.html(`<div class="spinner-border spinner-border-sm"></div> @lang('Saving')...`).prop(
                    'disabled', true);

                var formData = new FormData($('#tagFeatureForm')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('user.buyer.job.store.skill', $job->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            if (!response.is_update) {
                                window.location.href = response.redirect_url;
                            } else {
                                customNotify('success', `@lang('Job skill updated successfully')`);
                                btn.html(originalButtonText).prop('disabled', false);
                            }
                        } else {
                            customNotify('error', response.message);
                            btn.html(originalButtonText).prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        customNotify('error', error);
                        btn.html(originalButtonText).prop('disabled', false);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
