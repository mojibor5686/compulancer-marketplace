@extends('Template::layouts.seller_software')
@section('software')
    <form id="basicForm">
        <!-- Software Name -->
        <div class="form--group-lg">
            <label class="form-label form--label required" for="name">@lang('Name')</label>
            <input class="form-control form--control" name="name" type="text" value="{{ old('name', @$software->name) }}"
                placeholder="@lang('Software name')" required>
            <p class="fs-14 mt-1">@lang('Your software name is the most important place to include keywords that buyers would likely use to search for software like yours.')</p>
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
                                @selected($category->id == @$software->category_id)>
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
            <p class="fs-14 mt-1">@lang('Choose the category and subcategory most suitable for your software.')</p>
        </div>

        <!-- Price & Demo URL -->
        <div class="form--group-lg">
            <label class="form-label form--label required">@lang('Price & Demo URL')</label>
            <div class="row gy-4">
                <div class="col-md-6">
                    <div class="input-group input--group">
                        <input class="form-control form--control" name="price" type="number"
                            value="{{ old('price', @$software->price) }}" step="any" min="0"
                            placeholder="@lang('Software price')" required>
                        <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <input class="form-control form--control" name="demo_url" type="url"
                        value="{{ old('demo_url', @$software->demo_url) }}" placeholder="@lang('https://example.com/')" required>
                </div>
            </div>
            <p class="fs-14 mt-1">@lang('Provide software price and live demo URL for accuracy.')</p>
        </div>

        <!-- Software Description -->
        <div class="form--group-lg">
            <label class="form-label form--label required">@lang('Software Description')</label>
            <textarea class="form-control form--control nicEdit" name="description" placeholder="@lang('Write a description')">{{ old('description', @$software->description) }}</textarea>
            <p class="fs-14 mt-1">@lang('Provide a detailed description of your software.')</p>
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
            $(document).ready(function() {
                if (typeof nicEditor !== 'undefined' && typeof bkLib !== 'undefined') {
                    bkLib.onDomLoaded(function() {
                        $(".nicEdit").each(function(index) {
                            try {
                                $(this).attr("id", "nicEditor" + index);
                                new nicEditor({
                                    fullPanel: true
                                }).panelInstance('nicEditor' + index, {
                                    hasPanel: true
                                });
                            } catch (e) {
                                console.error('NicEdit initialization error:', e);
                            }
                        });
                    });
                } else {
                    console.warn('NicEdit library not loaded');
                }
            });

            // Handle subcategory loading based on selected category
            let softwareSubcategoryId = `{{ @$software->sub_category_id }}`;
            $('select[name="category_id"]').on('change', function() {
                let subcategories = $(this).find('option:selected').data('subcategories');
                let html = `<option value="">{{ __('Select Subcategory') }}</option>`;
                $.each(subcategories, function(i, subcategory) {
                    let isSelected = softwareSubcategoryId == subcategory.id ? 'selected' : '';
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
                let nicContent = nicInstance ? nicInstance.getContent() : '';
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('description', nicContent);

                $.ajax({
                    url: '{{ route('user.seller.software.store.basic', @$software->id ?? '') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            @if (!$software)
                                window.location.href = response.redirect_url;
                            @else
                                notify('success',
                                    `{{ __('Software basic info updated successfully') }}`);
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
