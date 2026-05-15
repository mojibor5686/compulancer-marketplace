@extends('Template::layouts.seller_service')
@section('service')
    <div class="gig-overview">
        <form id="extraServiceForm">
            <div class="gig-overview-space">
                <div class="row">
                    <div class="gig-overview__form">
                        @if (count($service->extraServices))
                            <div class="row justify-content-center addExtraService">
                                @foreach ($service->extraServices as $extra)
                                    <div class="col-lg-12 extraServiceRemove mb-3">
                                        <div class="row gy-3 align-items-center">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-0">
                                                    <input name="extra_service[{{ $loop->index }}][id]" type="hidden"
                                                        value="{{ $extra->id }}">
                                                    <input class="form-control form--control h-45"
                                                        name="extra_service[{{ $loop->index }}][name]" type="text"
                                                        value="{{ $extra->name }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group mb-0">
                                                    <input class="form-control form--control h-45"
                                                        name="extra_service[{{ $loop->index }}][price]" type="text"
                                                        value="{{ getAmount($extra->price) }}">
                                                    <span class="input-group-text h-45">{{ __(gs('cur_text')) }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                @if ($extra->status == Status::DISABLE)
                                                    <button class="btn btn--success btn--sm confirmationBtn h-45 w-100"
                                                        data-question="@lang('Are you sure to enable this')?"
                                                        data-action="{{ route('user.seller.service.extra.service.status', [$service->id, $extra->id]) }}"
                                                        type="button">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @else
                                                    <button class="btn btn--danger confirmationBtn btn--sm h-45 w-100"
                                                        data-question="@lang('Are you sure to disable this')?"
                                                        data-action="{{ route('user.seller.service.extra.service.status', [$service->id, $extra->id]) }}"
                                                        type="button">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="row align-items-center mb-3 gy-3">
                                <div class="col-lg-6">
                                    <input class="form-control form--control h-45" name="extra_service[0][name]"
                                        type="text" maxlength="255" placeholder="@lang('Enter service name')" required>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input class="form-control form--control h-45" name="extra_service[0][price]"
                                            type="number" step="any" placeholder="@lang('Enter Price')" required>
                                        <span class="input-group-text h-45">{{ __(gs('cur_text')) }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <button class="btn btn--base btn--sm addExtra h-45 w-100" type="button"><i
                                            class="las la-plus"></i> @lang('Add')</button>
                                </div>

                                <div class="addExtraService mt-3"></div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form--group-lg text-end mt-3">
                    <button class="btn btn--base btn--lg" id="saveAndContinue" type="button">
                        @lang('Save & Continue')
                    </button>
                </div>

            </div>
        </form>
    </div>
    <x-confirmation-modal class="frontend" />
@endsection

@push('button')
    @if (count($service->extraServices))
        <button type="button" class="btn btn--base addExtra btn--lg">
            <i class="las la-plus"></i> @lang('Add New')
        </button>
    @endif
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";

            // Add Extra Service
            $('.addExtra').on('click', function() {
                let length = $('.extraServiceRemove').length;
                var html = `<div class="col-lg-12 extraServiceRemove mb-3">
                                <div class="row align-items-center gy-3">
                                    <div class="col-lg-6">
                                        <input type="text" name="extra_service[${length}][name]" maxlength="255" class="form-control form--control h-45" placeholder="@lang('Enter service name')" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control form--control h-45" name="extra_service[${length}][price]" placeholder="@lang('Enter Price')" required>
                                            <span class="input-group-text h-45">{{ __(gs('cur_text')) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn--danger h-45 btn--sm w-100 removeBtn">
                                            <i class="las la-times"></i> @lang('Remove')
                                        </button>
                                    </div>
                                </div>
                            </div>`;
                $('.addExtraService').append(html);
            });

            // Remove Extra Service
            $(document).on('click', '.removeBtn', function() {
                $(this).closest('.extraServiceRemove').remove();
            });

            // Handle form submission
            $('#saveAndContinue').on('click', function() {
                var btn = $(this);
                var originalButtonText = btn.html();
                btn.html(`<div class="spinner-border"></div> @lang('Saving')...`).prop('disabled', true);

                var formData = new FormData($('#extraServiceForm')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('user.seller.service.store.extra', $service->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect_url;
                            notify('success', `@lang('Service extra services updated successfully')`);
                        } else {
                            notify('error', response.message);
                        }
                        btn.html(originalButtonText).prop('disabled', false);
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
