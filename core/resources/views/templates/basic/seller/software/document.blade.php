@extends('Template::layouts.seller_software')
@section('software')
    <div class="gig-overview">
        <form id="documentForm">
            <div class="gig-overview-space">
                <!-- Documentation File Upload Section -->
                <div class="form--group-lg">
                    <label class="form-label form--label">@lang('Documentation File')</label>
                    <div class="custom-file-wrapper">
                        <div class="custom-file">
                            <input class="custom-file-input" id="documentFile" name="document_file" type="file"
                                accept=".pdf" required>
                            <label class="custom-file-label" for="documentFile">@lang('Choose file')</label>
                        </div>
                        <p class="mt-1">@lang('Only .pdf file is supported. Document file is essential for user understanding.')</p>
                        @if (@$software->document_file)
                            <small>@lang('Existing document'):</small>
                            <a href="{{ route('file.download', [encrypt($software->document_file), 'documentation']) }}"
                                title="@lang('Download Document')" data-bs-toggle="tooltip" data-bs-placement="top">
                                <i class="las la-download"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Software File Upload Section -->
                <div class="form--group-lg">
                    <label class="form-label form--label">@lang('Software File')</label>
                    <div class="custom-file-wrapper">
                        <div class="custom-file">
                            <input class="custom-file-input" id="softwareFile" name="software_file" type="file"
                                accept=".zip" required>
                            <label class="custom-file-label" for="softwareFile">@lang('Choose file')</label>
                        </div>
                        <p class="mt-1">@lang('Only .zip file is supported.')</p>
                        @if (@$software->software_file)
                            <small>@lang('Existing software'):</small>
                            <a href="{{ route('file.download', [encrypt($software->software_file), 'file']) }}"
                                title="@lang('Download Software')" data-bs-toggle="tooltip" data-bs-placement="top">
                                <i class="las la-download"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Save and Complete Button -->
                <div class="text-end mt-4">
                    <button type="button" class="btn btn--base btn--lg" id="saveAndComplete">
                        @lang('Save & Continue') <i class="las la-angle-right"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('style')
    <style>
        .custom-file-wrapper {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
            position: relative;
        }

        .custom-file {
            display: flex;
            align-items: center;
        }

        .custom-file-input {
            display: none;
        }

        .custom-file-label {
            display: inline-block;
            color: #555;
            cursor: pointer;
            font-weight: bold;
            margin: 0;
            background-color: #e9ecef;
            padding: 8px 15px;
            border-radius: 5px;
            flex-grow: 1;
            text-align: center;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            // Custom file input label update on file selection
            $('#documentFile').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });

            $('#softwareFile').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });

            // AJAX for form submission
            $('#saveAndComplete').on('click', function() {
                var btn = $(this);
                var originalButtonText = btn.html();
                btn.html(`<div class="spinner-border"></div> @lang('Saving')...`).prop('disabled', true);

                var formData = new FormData($('#documentForm')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('user.seller.software.store.document', $software->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect_url;
                            notify('success', `@lang('Software uploaded successfully')`);
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
