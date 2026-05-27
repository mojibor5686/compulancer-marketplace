@extends('Template::layouts.seller_service')
@section('service')
    @push('style')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
        <style>
            .iziToast {
                z-index: 99999 !important;
            }
        </style>
    @endpush

    <div class="gig-overview">
        <form id="servicePackageForm">
            @php
                $basicPkg = $service->packages->where('package_type', 'basic')->first();
                $standardPkg = $service->packages->where('package_type', 'standard')->first();
                $premiumPkg = $service->packages->where('package_type', 'premium')->first();

                $savedFeatures = $basicPkg && is_array($basicPkg->features) ? array_keys($basicPkg->features) : [];

                $basicFeatures = $basicPkg ? $basicPkg->features : [];
                $standardFeatures = $standardPkg ? $standardPkg->features : [];
                $premiumFeatures = $premiumPkg ? $premiumPkg->features : [];
            @endphp

            <div class="gig-overview-space">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label form--label mb-0"><i class="las la-box"></i> @lang('Service Pricing Packages')</label>
                    <button type="button" class="btn btn--success btn--sm" id="addNewFeatureBtn">
                        <i class="las la-plus"></i> @lang('Add Custom Feature Row')
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle bg-white" id="packagesTable"
                        style="border: 1px solid #dadbdd !important;">
                        <thead>
                            <tr class="bg-light text-center">
                                <th style="width: 25%; min-width: 200px;" class="text-start p-3">@lang('Package Criteria (Custom)')</th>
                                <th style="width: 22%; min-width: 150px;" class="p-3">@lang('BASIC')</th>
                                <th style="width: 22%; min-width: 150px;" class="p-3">@lang('STANDARD')</th>
                                <th style="width: 22%; min-width: 150px;" class="p-3">@lang('PREMIUM')</th>
                                <th style="width: 9%; text-align: center;">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody id="packageTableBody">
                            <tr class="fixed-row">
                                <td class="fw-bold p-3">@lang('Package Title')</td>
                                <td><input type="text" name="package_title[basic]" class="form-control form--control"
                                        value="{{ $basicPkg->package_title ?? '' }}" placeholder="e.g. Silver Plan"
                                        required></td>
                                <td><input type="text" name="package_title[standard]" class="form-control form--control"
                                        value="{{ $standardPkg->package_title ?? '' }}" placeholder="e.g. Gold Plan"
                                        required></td>
                                <td><input type="text" name="package_title[premium]" class="form-control form--control"
                                        value="{{ $premiumPkg->package_title ?? '' }}" placeholder="e.g. Diamond Plan"
                                        required></td>
                                <td></td>
                            </tr>

                            <tr class="fixed-row">
                                <td class="fw-bold p-3">@lang('Package Description')</td>
                                <td>
                                    <textarea name="package_description[basic]" class="form-control form--control" rows="2"
                                        placeholder="What's included..." required>{{ $basicPkg->package_description ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="package_description[standard]" class="form-control form--control" rows="2"
                                        placeholder="What's included..." required>{{ $standardPkg->package_description ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="package_description[premium]" class="form-control form--control" rows="2"
                                        placeholder="What's included..." required>{{ $premiumPkg->package_description ?? '' }}</textarea>
                                </td>
                                <td></td>
                            </tr>

                            <tr class="fixed-row">
                                <td class="fw-bold p-3">@lang('Delivery Time')</td>
                                <td><input type="text" name="delivery_time[basic]" class="form-control form--control"
                                        value="{{ $basicPkg->delivery_time ?? '' }}" placeholder="e.g. 1 Day" required></td>
                                <td><input type="text" name="delivery_time[standard]" class="form-control form--control"
                                        value="{{ $standardPkg->delivery_time ?? '' }}" placeholder="e.g. 3 Days" required>
                                </td>
                                <td><input type="text" name="delivery_time[premium]" class="form-control form--control"
                                        value="{{ $premiumPkg->delivery_time ?? '' }}" placeholder="e.g. 5 Days" required>
                                </td>
                                <td></td>
                            </tr>

                            @if (count($savedFeatures) > 0)
                                @foreach ($savedFeatures as $index => $featureKey)
                                    <tr class="feature-row">
                                        <td>
                                            <input type="text" name="custom_features[{{ $index }}][name]"
                                                class="form-control form--control" value="{{ $featureKey }}"
                                                placeholder="e.g. Keywords, Meta tags" required>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="custom_features[{{ $index }}][basic]"
                                                value="yes"
                                                {{ isset($basicFeatures[$featureKey]) && $basicFeatures[$featureKey] == 'yes' ? 'checked' : '' }}
                                                style="transform: scale(1.3);">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="custom_features[{{ $index }}][standard]"
                                                value="yes"
                                                {{ isset($standardFeatures[$featureKey]) && $standardFeatures[$featureKey] == 'yes' ? 'checked' : '' }}
                                                style="transform: scale(1.3);">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="custom_features[{{ $index }}][premium]"
                                                value="yes"
                                                {{ isset($premiumFeatures[$featureKey]) && $premiumFeatures[$featureKey] == 'yes' ? 'checked' : '' }}
                                                style="transform: scale(1.3);">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn--danger btn--sm removeFeatureRowBtn"><i
                                                    class="las la-times"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="feature-row">
                                    <td><input type="text" name="custom_features[0][name]"
                                            class="form-control form--control" placeholder="e.g. Keywords" required></td>
                                    <td class="text-center"><input type="checkbox" name="custom_features[0][basic]"
                                            value="yes" style="transform: scale(1.3);"></td>
                                    <td class="text-center"><input type="checkbox" name="custom_features[0][standard]"
                                            value="yes" style="transform: scale(1.3);"></td>
                                    <td class="text-center"><input type="checkbox" name="custom_features[0][premium]"
                                            value="yes" style="transform: scale(1.3);"></td>
                                    <td class="text-center"><button type="button"
                                            class="btn btn--danger btn--sm removeFeatureRowBtn"><i
                                                class="las la-times"></i></button></td>
                                </tr>
                            @endif

                            <tr id="priceRow">
                                <td class="fw-bold p-3">@lang('Price') ({{ __(gs('cur_text')) }})</td>
                                <td><input type="number" step="any" name="price[basic]"
                                        class="form-control form--control fw-bold"
                                        value="{{ $basicPkg ? getAmount($basicPkg->price) : '' }}" placeholder="0.00"
                                        required></td>
                                <td><input type="number" step="any" name="price[standard]"
                                        class="form-control form--control fw-bold"
                                        value="{{ $standardPkg ? getAmount($standardPkg->price) : '' }}"
                                        placeholder="0.00" required></td>
                                <td><input type="number" step="any" name="price[premium]"
                                        class="form-control form--control fw-bold"
                                        value="{{ $premiumPkg ? getAmount($premiumPkg->price) : '' }}" placeholder="0.00"
                                        required></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form--group-lg text-end mt-4">
                    <button class="btn btn--base btn--lg" id="saveAndContinue" type="button">
                        <i class="las la-save"></i> @lang('Save & Continue')
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

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

            $('#addNewFeatureBtn').on('click', function() {
                let index = $('.feature-row').length + Date.now();

                var html = `<tr class="feature-row">
                                <td>
                                    <input type="text" name="custom_features[${index}][name]" class="form-control form--control" placeholder="Enter feature name (e.g. Meta tags)" required>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="custom_features[${index}][basic]" value="yes" style="transform: scale(1.3);">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="custom_features[${index}][standard]" value="yes" style="transform: scale(1.3);">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="custom_features[${index}][premium]" value="yes" style="transform: scale(1.3);">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn--danger btn--sm removeFeatureRowBtn"><i class="las la-times"></i></button>
                                </td>
                            </tr>`;

                $('#priceRow').before(html);
            });

            $(document).on('click', '.removeFeatureRowBtn', function() {
                $(this).closest('.feature-row').remove();
            });

            $('#saveAndContinue').on('click', function() {
                var btn = $(this);
                var originalButtonText = btn.html();

                if (!$('#servicePackageForm')[0].checkValidity()) {
                    $('#servicePackageForm')[0].reportValidity();
                    return false;
                }

                btn.html(`<div class="spinner-border spinner-border-sm"></div> @lang('Saving')...`).prop(
                    'disabled', true);

                var formData = new FormData($('#servicePackageForm')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('user.seller.service.store.packages', $service->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            customNotify('success', response.message);
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            }
                        } else {
                            customNotify('error', response.message);
                        }
                        btn.html(originalButtonText).prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        customNotify('error', '@lang('Something went wrong. Please try again.')');
                        btn.html(originalButtonText).prop('disabled', false);
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
