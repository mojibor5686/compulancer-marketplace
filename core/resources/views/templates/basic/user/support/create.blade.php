@extends('Template::layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-body">
            <form action="{{ route('ticket.store') }}" class="disableSubmission" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gy-4">
                    <div class="col-md-6">
                        <label class="form--label required">@lang('Subject')</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-control form--control"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="form--label required">@lang('Priority')</label>
                        <select name="priority" class="form-select form--control select2-basic"
                            data-minimum-results-for-search="-1" required>
                            <option value="3">@lang('High')</option>
                            <option value="2">@lang('Medium')</option>
                            <option value="1">@lang('Low')</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form--label required">@lang('Message')</label>
                        <textarea name="message" id="inputMessage" rows="6" class="form-control form--control" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="col-12">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <button type="button" class="btn btn--dark addAttachment btn--lg">
                                <i class="fas fa-plus"></i> @lang('Add Attachment')
                            </button>
                            <button class="btn btn--base  btn--lg" type="submit">
                                <i class="las la-paper-plane"></i> @lang('Submit')
                            </button>
                        </div>
                        <p class="text--info mt-2">
                            @lang('Max 5 files can be uploaded') | @lang('Maximum upload size is')
                            {{ convertToReadableSize(ini_get('upload_max_filesize')) }} |
                            @lang('Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')
                        </p>
                    </div>
                    <div class="col-12">
                        <div class="row gy-2 fileUploadsContainer"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }

        .form-group {
            margin-top: 15px;
        }

        .input--group .input-group-text {
            border-radius: 4px;
            color: hsl(var(--white)) !important;
            background-color: hsl(var(--danger)) !important;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";

            let fileAdded = 0;
            const MAX_FILES = 5;

            $('.addAttachment').on('click', function() {
                fileAdded++;

                if (fileAdded === MAX_FILES) {
                    $(this).attr('disabled', true);
                }

                $(".fileUploadsContainer").append(`
                    <div class="col-md-6 removeFileInput">
                        <div class="form-group">
                            <div class="input-group input--group">
                                <input
                                    type="file"
                                    name="attachments[]"
                                    class="form-control form--control"
                                    accept=".jpeg,.jpg,.png,.pdf,.doc,.docx"
                                    required
                                >
                                <button
                                    type="button"
                                    class="input-group-text removeFile"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `);
            });

            $(document).on('click', '.removeFile', function() {
                $('.addAttachment').removeAttr('disabled', true)
                fileAdded--;
                $(this).closest('.removeFileInput').remove();
            });

        })(jQuery);
    </script>
@endpush
