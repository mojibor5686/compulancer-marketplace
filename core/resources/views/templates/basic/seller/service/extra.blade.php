@extends('Template::layouts.seller_service')
@section('service')
    <div class="gig-overview">
        <form id="servicePackageForm">
            @php
                $basicPkg = $service->packages->where('package_type', 'basic')->first();
                $standardPkg = $service->packages->where('package_type', 'standard')->first();
                $premiumPkg = $service->packages->where('package_type', 'premium')->first();

                $basicFeatures = $basicPkg ? $basicPkg->features : [];
                $standardFeatures = $standardPkg ? $standardPkg->features : [];
                $premiumFeatures = $premiumPkg ? $premiumPkg->features : [];
            @endphp

            <div class="gig-overview-space">
                <div class="form--group-lg mb-3">
                    <label class="form-label form--label"><i class="las la-box"></i> @lang('Service Pricing Packages')</label>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle bg-white" style="border: 1px solid #dadbdd !important;">
                        <thead>
                            <tr class="bg-light text-center">
                                <th style="width: 25%; min-width: 200px;" class="text-start p-3">@lang('Package Criteria')</th>
                                <th style="width: 25%; min-width: 200px;" class="p-3">@lang('BASIC')</th>
                                <th style="width: 25%; min-width: 200px;" class="p-3">@lang('STANDARD')</th>
                                <th style="width: 25%; min-width: 200px;" class="p-3">@lang('PREMIUM')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
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
                            </tr>

                            <tr>
                                <td class="fw-bold p-3">@lang('Package Description')</td>
                                <td>
                                    <textarea name="package_description[basic]" class="form-control form--control" rows="3"
                                        placeholder="What's included..." required>{{ $basicPkg->package_description ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="package_description[standard]" class="form-control form--control" rows="3"
                                        placeholder="What's included..." required>{{ $standardPkg->package_description ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="package_description[premium]" class="form-control form--control" rows="3"
                                        placeholder="What's included..." required>{{ $premiumPkg->package_description ?? '' }}</textarea>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold p-3">@lang('Delivery Time')</td>
                                <td><input type="text" name="delivery_time[basic]" class="form-control form--control"
                                        value="{{ $basicPkg->delivery_time ?? '' }}" placeholder="e.g. 1 Day" required></td>
                                <td><input type="text" name="delivery_time[standard]" class="form-control form--control"
                                        value="{{ $standardPkg->delivery_time ?? '' }}" placeholder="e.g. 3 Days" required>
                                </td>
                                <td><input type="text" name="delivery_time[premium]" class="form-control form--control"
                                        value="{{ $premiumPkg->delivery_time ?? '' }}" placeholder="e.g. 5 Days" required>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold p-3">@lang('Complex Layout')</td>
                                <td class="text-center"><input type="checkbox" name="features[basic][complex_layout]"
                                        value="yes"
                                        {{ isset($basicFeatures['complex_layout']) && $basicFeatures['complex_layout'] == 'yes' ? 'checked' : '' }}
                                        style="transform: scale(1.3);"></td>
                                <td class="text-center"><input type="checkbox" name="features[standard][complex_layout]"
                                        value="yes"
                                        {{ isset($standardFeatures['complex_layout']) && $standardFeatures['complex_layout'] == 'yes' ? 'checked' : '' }}
                                        style="transform: scale(1.3);"></td>
                                <td class="text-center"><input type="checkbox" name="features[premium][complex_layout]"
                                        value="yes"
                                        {{ isset($premiumFeatures['complex_layout']) && $premiumFeatures['complex_layout'] == 'yes' ? 'checked' : '' }}
                                        style="transform: scale(1.3);"></td>
                            </tr>

                            <tr>
                                <td class="fw-bold p-3">@lang('Schema Markup')</td>
                                <td class="text-center"><input type="checkbox" name="features[basic][schema_markup]"
                                        value="yes"
                                        {{ isset($basicFeatures['schema_markup']) && $basicFeatures['schema_markup'] == 'yes' ? 'checked' : '' }}
                                        style="transform: scale(1.3);"></td>
                                <td class="text-center"><input type="checkbox" name="features[standard][schema_markup]"
                                        value="yes"
                                        {{ isset($standardFeatures['schema_markup']) && $standardFeatures['schema_markup'] == 'yes' ? 'checked' : '' }}
                                        style="transform: scale(1.3);"></td>
                                <td class="text-center"><input type="checkbox" name="features[premium][schema_markup]"
                                        value="yes"
                                        {{ isset($premiumFeatures['schema_markup']) && $premiumFeatures['schema_markup'] == 'yes' ? 'checked' : '' }}
                                        style="transform: scale(1.3);"></td>
                            </tr>

                            <tr>
                                <td class="fw-bold p-3">@lang('Menu Included')</td>
                                <td class="text-center"><input type="checkbox" name="features[basic][menu]" value="yes"
                                        {{ isset($basicFeatures['menu']) && $basicFeatures['menu'] == 'yes' ? 'checked' : '' }}
                                        style="transform: scale(1.3);"></td>
                                <td class="text-center"><input type="checkbox" name="features[standard][menu]"
                                        value="yes"
                                        {{ isset($standardFeatures['menu']) && $standardFeatures['menu'] == 'yes' ? 'checked' : '' }}
                                        style="transform: scale(1.3);"></td>
                                <td class="text-center"><input type="checkbox" name="features[premium][menu]"
                                        value="yes"
                                        {{ isset($premiumFeatures['menu']) && $premiumFeatures['menu'] == 'yes' ? 'checked' : '' }}
                                        style="transform: scale(1.3);"></td>
                            </tr>

                            <tr>
                                <td class="fw-bold p-3">@lang('Number of Pages')</td>
                                <td><input type="text" name="features[basic][pages_count]"
                                        class="form-control form--control"
                                        value="{{ $basicFeatures['pages_count'] ?? '' }}" placeholder="e.g. 1"></td>
                                <td><input type="text" name="features[standard][pages_count]"
                                        class="form-control form--control"
                                        value="{{ $standardFeatures['pages_count'] ?? '' }}" placeholder="e.g. 5"></td>
                                <td><input type="text" name="features[premium][pages_count]"
                                        class="form-control form--control"
                                        value="{{ $premiumFeatures['pages_count'] ?? '' }}" placeholder="e.g. 10"></td>
                            </tr>

                            <tr>
                                <td class="fw-bold p-3">@lang('Revisions')</td>
                                <td><input type="text" name="features[basic][revisions]"
                                        class="form-control form--control"
                                        value="{{ $basicFeatures['revisions'] ?? '' }}" placeholder="e.g. 3"></td>
                                <td><input type="text" name="features[standard][revisions]"
                                        class="form-control form--control"
                                        value="{{ $standardFeatures['revisions'] ?? '' }}" placeholder="e.g. 5"></td>
                                <td><input type="text" name="features[premium][revisions]"
                                        class="form-control form--control"
                                        value="{{ $premiumFeatures['revisions'] ?? '' }}" placeholder="e.g. Unlimited">
                                </td>
                            </tr>

                            <tr>
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
    <script>
        (function($) {
            "use strict";

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
                            notify('success', `@lang('Service packages saved successfully')`);
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            }
                        } else {
                            notify('error', response.message);
                        }
                        btn.html(originalButtonText).prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        notify('error', '@lang('Something went wrong. Please try again.')');
                        btn.html(originalButtonText).prop('disabled', false);
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
