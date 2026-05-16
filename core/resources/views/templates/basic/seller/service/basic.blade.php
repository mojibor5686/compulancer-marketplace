@extends('Template::layouts.seller_service')
@section('service')
    <form id="basicForm">
        <!-- Service Name -->
        <div class="form--group-lg">
            <label class="form-label form--label required" for="name">@lang('Name')</label>
            <input class="form-control form--control" name="name" type="text" value="{{ old('name', @$service->name) }}"
                required>
            <p class="fs-14 mt-1">@lang('Your service name is the most important place to include keywords that buyers would likely use to search for a service like yours.')</p>
        </div>

        <!-- Category & Subcategory -->
        <div class="form--group-lg">
            <label class="form-label form--label required">@lang('Category & Subcategory')</label>
            <div class="row gy-4">
                <div class="col-md-6">
                    <select class="form-select form--select select2-basic " name="category_id" required>
                        <option value="">@lang('Select Category')</option>
                        @foreach ($categories as $category)
                            <option data-subcategories='@json($category->subcategories)' value="{{ $category->id }}"
                                @selected($category->id == @$service->category_id)>
                                {{ __($category->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <select class="form-select form--select select2-basic " name="sub_category_id" required>
                        <option value="">@lang('Select Subcategory')</option>
                    </select>
                </div>
            </div>
            <p class="fs-14 mt-1">@lang('Choose the category and subcategory most suitable for your service.')</p>
        </div>

        <!-- Price & Max Order Quantity -->
        <div class="form--group-lg">
            <label class="form-label form--label required">@lang('Price & Max Order Quantity')</label>
            <div class="row gy-4">
                <div class="col-md-6">
                    <div class="input-group input--group">
                        <input class="form-control form--control" name="price" type="number"
                            value="{{ old('price', @$service->price ? showAmount($service->price, currencyFormat: false) : null) }}"
                            step="any" min="0" required>
                        <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input--group">
                        <input class="form-control form--control" name="max_order_qty" type="number"
                            value="{{ old('max_order_qty', @$service->max_order_qty) }}" min="1" required>
                        <span class="input-group-text">@lang('Unit')</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Time -->
        <div class="form--group-lg">
            <label class="form-label form--label required">@lang('Estimated Delivery Time')</label>
            <div class="input-group input--group">
                <input class="form-control form--control" name="delivery_time" type="number"
                    value="{{ old('delivery_time', @$service->delivery_time) }}" required>
                <span class="input-group-text">@lang('Days')</span>
            </div>
            <p class="fs-14 mt-1">@lang('Provide the most affordable delivery days.')</p>
        </div>

        <!-- Service Description -->
        <div class="form--group-lg">
            <label class="form-label form--label required">@lang('Service Description')</label>
            <textarea class="form-control form--control nicEdit" name="description">{{ old('description', @$service->description) }}</textarea>
            <p class="fs-14 mt-1">@lang('Provide a detailed description of your service.')</p>
        </div>

        <!-- Submit Button -->
        <div class="form--group-lg text-end mt-4">
            <button class="btn btn--base btn--lg" id="saveAndContinue" type="button">
                @lang('Save & Continue')
            </button>
        </div>
    </form>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";

            // Initialize NicEdit for rich text areas
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

            // Initialize Select2 for category and subcategory dropdowns
            $('.select2').select2({
                width: '100%'
            });

            // Handle subcategory loading based on selected category
            let serviceSubcategoryId = `{{ @$service->sub_category_id }}`;
            $('select[name="category_id"]').on('change', function() {
                let subcategories = $(this).find(`option:selected`).data(`subcategories`);
                let html = `<option value="">{{ __('Select Subcategory') }}</option>`;
                $.each(subcategories, function(i, subcategory) {
                    let isSelected = serviceSubcategoryId == subcategory.id ? 'selected' : '';
                    html +=
                        `<option value="${subcategory.id}" ${isSelected}>${subcategory.name}</option>`;
                });

                $('select[name="sub_category_id"]').html(html);
            }).change();

            // Handle form submission for 'Save & Continue' button
            $('#saveAndContinue').on("click", function() {
                let btn = $(this);
                let originalButtonText = btn.html();
                btn.html(`<div class="spinner-border"></div> {{ __('Saving') }}...`).prop('disabled', true);

                let formData = new FormData($('#basicForm')[0]);
                let nicInstance = nicEditors.findEditor('nicEditor0');
                let nicContent = nicInstance.getContent();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('description', nicContent);

                $.ajax({
                    url: '{{ route('user.seller.service.store.basic', @$service->id ?? '') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            @if (!$service)
                                window.location.href = response.redirect_url;
                            @else
                                notify('success',
                                    `{{ __('Service basic info updated successfully') }}`);
                                btn.html(originalButtonText).prop('disabled', false);
                            @endif
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
