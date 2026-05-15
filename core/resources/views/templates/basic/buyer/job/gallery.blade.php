@extends('Template::layouts.buyer_job')
@section('job')
    <form id="galleryForm">
        <div class="row d-flex justify-content-center">
            <!-- Single Image Upload for Job Thumbnail -->
            <div class="{{ $job->image ? 'col-lg-8 col-md-6' : 'col-lg-5 col-md-6' }}">
                <div class="box mb-3 upload-content" id="thumbnailBox"
                    style="{{ $job->image ? 'background: url(' . getImage(getFilePath('job') . '/' . $job->image) . ') center center / cover no-repeat' : '' }}">
                    <!-- Dark Overlay -->
                    <div class="dark-overlay"></div>

                    <div class="upload-options firstUploadOption">
                        <label class="show-image" for="image-upload">
                            <span class="upload-content__label show-image-area">
                                <input class="image-upload" id="image-upload" name="image" type="file"
                                    accept="image/png, image/jpeg">
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <small class="mt-3 text-muted text-center d-block"> @lang('Supported Files'): <b>@lang('.png, .jpg, .jpeg')</b>
                @lang('Image will be resized into')
                <b>{{ getFileSize('job') }}px</b> </small>
        </div>

        <!-- Submit Button -->
        <div class="form--group-lg text-end mt-4">
            <button class="btn btn--base btn--lg" id="saveAndContinue" type="button">
                @lang('Save & Continue')
            </button>
        </div>
    </form>
@endsection

@push('style')
    <style>
        .upload-content {
            border: 2px dashed #cccccc;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150px;
            background-color: #f9f9f9;
            border-radius: 8px;
            position: relative;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .dark-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            /* Dark overlay with opacity */
            border-radius: 8px;
            z-index: 1;
        }

        .upload-options label.show-image {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
            cursor: pointer;
            position: relative;
            z-index: 2;
            /* Above the dark overlay */
        }

        .upload-options label.show-image .show-image-area {
            display: inline-block;
            color: #ffffff;
            /* Light icon color */
            font-size: 24px;
            text-align: center;
        }

        .upload-options label.show-image .show-image-area::before {
            font-family: 'Line Awesome Free';
            font-weight: 900;
            content: "\f382";
            font-size: 48px;
        }

        .upload-options label.show-image .show-image-area input[type="file"] {
            display: none;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            // Prevent the click event on the label from bubbling up
            $('label.show-image').on('click', function(event) {
                event.stopPropagation();
            });

            // Open file dialog when clicking on .upload-content
            $('.upload-content').on('click', function() {
                $('#image-upload').trigger('click');
            });

            // Prevent click event from bubbling up when clicking on the file input
            $('#image-upload').on('click', function(e) {
                e.stopPropagation();
            });

            // Preview image upon upload
            $('#image-upload').on('change', function() {
                const [file] = this.files;
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#thumbnailBox').css('background-image', `url(${e.target.result})`);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle form submission
            $('#saveAndContinue').on('click', function() {
                var btn = $(this);
                var originalButtonText = btn.html();
                btn.html(`<div class="spinner-border"></div> @lang('Saving')...`).prop('disabled', true);

                var formData = new FormData($('#galleryForm')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('user.buyer.job.store.gallery', $job->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect_url;
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
