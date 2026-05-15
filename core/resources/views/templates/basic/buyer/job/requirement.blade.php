@extends('Template::layouts.buyer_job')
@section('job')
    <div class="gig-overview">
        <form id="requirementForm">
            <!-- Job Requirement Section -->
            <div class="gig-overview-space">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="gig-overview__title">
                            <h6>@lang('Job Requirement')</h6>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="gig-overview__form">
                            <textarea class="form--control nicEdit" id="dsc" placeholder="@lang('Write a description')">{{ old('requirements', @$job->requirements) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save & Complete Button -->
            <div class="form--group-lg text-end mt-4">
                <button class="btn btn--base" id="saveAndComplete" type="button">
                    @lang('Save & Complete') <i class="las la-angle-right"></i>
                </button>
            </div>
        </form>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            // Handle Save & Complete button click
            $('#saveAndComplete').on("click", function() {
                var btn = $(this);
                var originalButtonText = btn.html();
                btn.html(`<div class="spinner-border me-2"></div> @lang('Saving')...`).prop('disabled', true);

                // Collect form data
                var formData = new FormData($('#requirementForm')[0]);
                var nicInstance = nicEditors.findEditor('nicEditor0');
                var nicContent = nicInstance.getContent();

                formData.append('_token', '{{ csrf_token() }}');
                formData.append('requirements', nicContent);

                // AJAX request to save requirements
                $.ajax({
                    url: '{{ route('user.buyer.job.store.requirement', $job->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect_url;
                            notify('success', `@lang('Job created successfully')`);
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

            // Initialize NicEdit for rich text area
            bkLib.onDomLoaded(function() {
                $(".nicEdit").each(function(index) {
                    $(this).attr("id", "nicEditor" + index);
                    new nicEditor({
                        fullPanel: true
                    }).panelInstance('nicEditor' + index, {
                        hasPanel: true
                    });
                });
            });
        })(jQuery);
    </script>
@endpush
