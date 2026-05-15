@extends('Template::layouts.buyer_job')
@section('job')
    <div class="gig-overview">
        <form id="tagFeatureForm">
            <!-- Job Skill Section -->
            <div class="gig-overview-space">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="gig-overview__title">
                            <h6>@lang('Job Skill')</h6>
                        </div>
                    </div>
                    <div class="col-lg-9 select2Tag">
                        <div class="form--group">
                            <select class="form-control form--control select2-auto-tokenize" name="skill[]"
                                multiple="multiple" required>
                                @if (@$job->skill)
                                    @foreach ($job->skill as $option)
                                        <option value="{{ $option }}" selected>{{ __($option) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="mt-2">
                                @lang('Separate multiple keywords by') <code>,</code> (@lang('comma'))
                                @lang('or') <code>@lang('enter')</code> @lang('key').
                                @lang('Minimum 3 & maximum 15 tags.')
                            </small>
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
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            // Handle form submission
            $('#saveAndContinue').on('click', function() {
                var btn = $(this);
                var originalButtonText = btn.html();
                btn.html(`<div class="spinner-border"></div> @lang('Saving')...`).prop('disabled', true);

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
                                notify('success', `@lang('Job skill updated successfully')`);
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
