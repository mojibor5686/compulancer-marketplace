@extends('Template::layouts.buyer_job')
@section('job')
    <div class="gig-overview">
        <form id="requirementForm">
            <!-- Job Requirement Section -->
            <div class="gig-overview-space">
                <div class="form--group">
                    <label class="form-label form--label required">@lang('Job Requirement')</label>
                    <div class="gig-overview__form">
                        <!-- nicEdit ক্লাসটি বাদ দিয়ে rows="6" এবং স্ট্যান্ডার্ড ফর্ম ক্লাস রাখা হয়েছে -->
                        <textarea class="form-control form--control" name="requirements" id="dsc" rows="6"
                            placeholder="@lang('Write a description...')" required>{{ old('requirements', @$job->requirements) }}</textarea>
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

@push('script')
    <script>
        (function($) {
            "use strict";

            // Handle Save & Complete button click
            $('#saveAndComplete').on("click", function() {

                // HTML5 ভ্যালিডেশন চেক (টেক্সট এরিয়া ফাঁকা থাকলে ব্রাউজার পপআপ দেবে)
                if (!$('#requirementForm')[0].checkValidity()) {
                    $('#requirementForm')[0].reportValidity();
                    return false;
                }

                var btn = $(this);
                var originalButtonText = btn.html();
                btn.html(`<div class="spinner-border spinner-border-sm me-2"></div> @lang('Saving')...`).prop(
                    'disabled', true);

                // Collect form data সরাসরি (কোনো nicEdit অবজেক্ট ছাড়াই ডিরেক্ট ভ্যালু যাবে)
                var formData = new FormData($('#requirementForm')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                // AJAX request to save requirements
                $.ajax({
                    url: '{{ route('user.buyer.job.store.requirement', $job->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            }
                            if (typeof notify !== 'undefined') {
                                notify('success', `@lang('Job created successfully')`);
                            }
                        } else {
                            if (typeof notify !== 'undefined') {
                                notify('error', response.message);
                            } else {
                                alert(response.message);
                            }
                            btn.html(originalButtonText).prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        if (typeof notify !== 'undefined') {
                            notify('error', '@lang('Something went wrong. Please try again.')');
                        } else {
                            alert(error);
                        }
                        btn.html(originalButtonText).prop('disabled', false);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
