@extends('Template::layouts.seller_service')
@section('service')
    <form id="galleryForm">
        <div class="row gy-4">
            <!-- Thumbnail Image -->
            <div class="col-lg-4 col-md-6">
                <label class="form-label form--label">@lang('Thumbnail Image')</label>
                <div class="box mb-3 upload-content"
                    style="background: {{ $service->image ? 'url(' . getImage(getFilePath('service') . '/' . $service->image) . ') center center / cover no-repeat' : '#f9f9f9' }};">
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

                <!-- File Information for Thumbnail Image -->
                <small class="mt-3 text-muted text-center d-block">
                    @lang('Supported Files'): <b>@lang('.png, .jpg, .jpeg')</b> <br>
                    @lang('Image will be resized into') <b>{{ getFileSize('service') }}px</b>
                </small>
            </div>

            <!-- Image Gallery -->
            @php
                if ($service->extra_image) {
                    foreach ($service->extra_image as $key => $image) {
                        $img['id'] = $key;
                        $img['src'] = getImage(getFilePath('extraImage') . '/' . $image);
                        $images[] = $img;
                    }
                }
            @endphp
            <div class="col-lg-8 col-md-6"
                @if ($service->extra_image) data-images='@json(@$images)' @endif>
                <label class="form-label form--label">@lang('Image Gallery')</label>
                <div class="input-images"></div>

                <!-- File Information for Image Gallery -->
                <small class="mt-3 text-muted text-center d-block">
                    @lang('Supported Files'): <b>@lang('.png, .jpg, .jpeg')</b> <br>
                    @lang('Maximum 6 images allowed') <br>
                    @lang('Image will be resized into') <b>{{ getFileSize('extraImage') }}px</b>
                </small>

                <!-- Error Modal -->
                <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <button type="button" class="close m-3 ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                <i class="las la-times"></i>
                            </button>
                            <div class="modal-body text-center">
                                <i class="las la-times-circle f-size--100 text--danger mb-15"></i>
                                <h3 class="text--danger mb-15">@lang('Maximum 6 images are allowed!')</h3>
                                <p class="mb-15">@lang('The rest of the images you have selected are removed')</p>
                                <button type="button" class="btn btn--dark"
                                    data-bs-dismiss="modal">@lang('Continue')</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Error Modal -->
            </div>
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
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            position: relative;
            cursor: pointer;
        }

        .dark-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
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
        }

        .upload-options label.show-image .show-image-area {
            display: inline-block;
            color: #ffffff;
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

@push('style-lib')
    <link rel="stylesheet" href="{{ asset(activeTemplate(true) . 'css/image-uploader.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset(activeTemplate(true) . 'js/image-uploader.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            // Prevent the click event on the label from bubbling up
            $('label.show-image').on('click', function(event) {
                event.stopPropagation();
            });

            // Prevent the click event on the input from bubbling up
            $('#image-upload').on('click', function(event) {
                event.stopPropagation();
            });

            // Handle click on the upload-content div
            $('.upload-content').on('click', function() {
                $('#image-upload').click();
            });

            // Initialize Image Uploader
            $('.input-images').each((i, element) => {
                const data = $(element).parent().data();
                $(element).imageUploader({
                    preloaded: data.images,
                    imagesInputName: 'extra_image',
                    preloadedInputName: 'old',
                    maxFiles: 6
                });
            });

            // Thumbnail Preview
            $('#image-upload').on('change', function() {
                const [file] = this.files;
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('.upload-content').css('background-image', `url(${e.target.result})`);
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
                    url: '{{ route('user.seller.service.store.gallery', $service->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            if (!response.is_update) {
                                window.location.href = response.redirect_url;
                            } else {
                                notify('success', `@lang('Service gallery images updated successfully')`);
                                btn.html(originalButtonText).prop('disabled', false);
                            }
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
