@extends('Template::layouts.buyer_job')
@section('job')
    <form id="basicForm">
        <!-- Job Name -->
        <div class="form--group-lg">
            <label class="form-label form--label required" for="name">@lang('Name')</label>
            <input class="form-control form--control" name="name" type="text" value="{{ old('name', @$job->name) }}"
                placeholder="@lang('Job name')" required>
            <p class="fs-14 mt-1">@lang('Your job name is essential to include keywords that buyers might use to search for a job like yours.')</p>
        </div>

        <!-- Category & Subcategory -->
        <div class="form--group-lg">
            <label class="form-label form--label required">@lang('Category & Subcategory')</label>
            <div class="row gy-4">
                <div class="col-md-6">
                    <select class="form-select form--select select2-basic" name="category_id" required>
                        <option value="">@lang('Select Category')</option>
                        @foreach ($categories as $category)
                            <option data-subcategories='@json($category->subcategories)' value="{{ $category->id }}"
                                @selected($category->id == @$job->category_id)>
                                {{ __($category->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <select class="form-select form--select select2-basic" name="sub_category_id">
                        <option value="">@lang('Select Subcategory')</option>
                    </select>
                </div>
            </div>
            <p class="fs-14 mt-1">@lang('Choose the category and subcategory most suitable for your job.')</p>
        </div>

        <!-- Budget & Delivery Time -->
        <div class="form--group-lg">
            <label class="form-label form--label required">@lang('Budget & Delivery Time')</label>
            <div class="row gy-4">
                <div class="col-md-6">
                    <div class="input-group input--group">
                        <input class="form-control form--control" name="price" type="number"
                            value="{{ old('price', @$job->price) }}" step="any" min="0"
                            placeholder="@lang('Budget price')" required>
                        <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input--group">
                        <input class="form-control form--control" name="delivery_time" type="number"
                            value="{{ old('delivery_time', @$job->delivery_time) }}" min="1"
                            placeholder="@lang('Delivery time')" required>
                        <span class="input-group-text">@lang('Days')</span>
                    </div>
                </div>
            </div>
            <p class="fs-14 mt-1">@lang('Provide the budget and expected delivery time.')</p>
        </div>

        <!-- Job Description -->
        <div class="form--group-lg">
            <label class="form-label form--label required">@lang('Job Description')</label>
            <textarea class="form-control form--control" name="description" rows="6" placeholder="@lang('Write a detailed description...')"
                required>{{ old('description', @$job->description) }}</textarea>
            <p class="fs-14 mt-1">@lang('Provide a detailed description of your job.')</p>
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

            // Initialize Select2 for category and subcategory dropdowns
            if ($.isFunction($.fn.select2)) {
                $('.select2-basic').select2({
                    width: '100%'
                });
            }

            // Handle subcategory loading based on selected category
            let jobSubcategoryId = `{{ @$job->sub_category_id }}`;
            $('select[name="category_id"]').on('change', function() {
                let subcategories = $(this).find(`option:selected`).data(`subcategories`) || [];
                let html = `<option value="">{{ __('Select Subcategory') }}</option>`;
                $.each(subcategories, function(i, subcategory) {
                    let isSelected = jobSubcategoryId == subcategory.id ? 'selected' : '';
                    html +=
                        `<option value="${subcategory.id}" ${isSelected}>${subcategory.name}</option>`;
                });
                $('select[name="sub_category_id"]').html(html);
            }).change();

            // Handle form submission for 'Save & Continue' button
            $('#saveAndContinue').on("click", function() {

                // HTML5 ভ্যালিডেশন চেক
                if (!$('#basicForm')[0].checkValidity()) {
                    $('#basicForm')[0].reportValidity();
                    return false;
                }

                let btn = $(this);
                let originalButtonText = btn.html();
                btn.html(`<div class="spinner-border spinner-border-sm"></div> {{ __('Saving') }}...`).prop(
                    'disabled', true);

                let formData = new FormData($('#basicForm')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('user.buyer.job.store.basic', @$job->id ?? '') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            } else {
                                if (typeof notify !== 'undefined') {
                                    notify('success',
                                        `{{ __('Job basic info updated successfully') }}`);
                                } else {
                                    alert(`{{ __('Job basic info updated successfully') }}`);
                                }
                                btn.html(originalButtonText).prop('disabled', false);
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
