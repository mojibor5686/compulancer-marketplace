@extends('Template::layouts.seller_service')

@section('service')
    <form id="galleryForm" enctype="multipart/form-data">
        <div class="form--group-lg">
            <label class="form-label form--label">@lang('Thumbnail Image')</label>
            <div class="box mb-3 upload-content" id="thumbnailBox"
                style="background: {{ $service->image ? 'url(' . getImage(getFilePath('service') . '/' . $service->image) . ') center center / cover no-repeat' : '#f9f9f9' }};">
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

            <small class="mt-3 text-muted text-center d-block">
                @lang('Supported Files'): <b>@lang('.png, .jpg, .jpeg')</b> <br>
                @lang('Image will be resized into') <b>{{ getFileSize('service') }}px</b>
            </small>
        </div>

        @php
            $images = [];
            if ($service->extra_image && is_array($service->extra_image)) {
                foreach ($service->extra_image as $key => $image) {
                    $images[] = [
                        'id' => $image, // ব্যাকএন্ড ট্র্যাকিং এর জন্য ইমেজ নেম আইডি হিসেবে ব্যবহার উত্তম
                        'src' => getImage(getFilePath('extraImage') . '/' . $image),
                    ];
                }
            }
        @endphp

        <div class="form--group-lg mt-4" id="galleryContainer" data-images="{{ json_encode($images) }}">
            <label class="form-label form--label">@lang('Image Gallery')</label>

            <div class="input-images" style="padding-top: .5rem;"></div>

            <small class="mt-3 text-muted text-center d-block">
                @lang('Supported Files'): <b>@lang('.png, .jpg, .jpeg')</b> <br>
                @lang('Maximum 6 images allowed') <br>
                @lang('Image will be resized into') <b>{{ getFileSize('extraImage') }}px</b>
            </small>

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
                            <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Continue')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form--group-lg text-end mt-4">
            <button class="btn btn--base btn--lg" id="saveAndContinue" type="button">
                @lang('Save & Continue')
            </button>
        </div>
    </form>
@endsection

@push('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/christianbueso/image-uploader@master/dist/image-uploader.min.css">

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

        /* ইমেজ গ্যালারি ডিজাইন ফিক্স (বক্স শো না হওয়ার সমস্যা সমাধান) */
        .image-uploader {
            min-height: 12rem;
            border: 2px dashed #cbd5e1 !important;
            background: #f8fafc !important;
            border-radius: 8px !important;
            padding: 15px !important;
        }

        .image-uploader .upload-text i {
            color: #64748b !important;
            font-size: 40px !important;
        }
    </style>
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/gh/christianbueso/image-uploader@master/dist/image-uploader.min.js"></script>

    <script>
        (function($) {
            "use strict";

            function safeNotify(type, msg) {
                if (typeof notify !== 'undefined') {
                    notify(type, msg);
                } else {
                    alert(msg);
                }
            }

            // Click Bubbling Stop করা হয়েছে 
            $('label.show-image').on('click', function(event) {
                event.stopPropagation();
            });

            $('#image-upload').on('click', function(event) {
                event.stopPropagation();
            });

            $('.upload-content').on('click', function() {
                $('#image-upload').click();
            });

            // উইন্ডো সম্পূর্ণ লোড হওয়ার পর প্লাগইন ফায়ার করার ব্যবস্থা
            $(window).on('load', function() {
                if ($.fn.imageUploader) {
                    $('.input-images').each((i, element) => {
                        let dataImages = $('#galleryContainer').attr('data-images');
                        let preloadedArr = [];

                        try {
                            if (dataImages) {
                                preloadedArr = JSON.parse(dataImages);
                            }
                        } catch (e) {
                            console.error("Failed to parse gallery images JSON:", e);
                        }

                        $(element).imageUploader({
                            preloaded: preloadedArr,
                            imagesInputName: 'extra_image', // কন্ট্রোলারের $request->extra_image নেম পাবে
                            preloadedInputName: 'old',
                            maxFiles: 6
                        });
                    });
                } else {
                    console.error("imageUploader library is missing.");
                }
            });

            // Thumbnail Live Preview
            $('#image-upload').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#thumbnailBox').css({
                            'background-image': `url(${e.target.result})`,
                            'background-size': 'cover',
                            'background-position': 'center'
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });

            // AJAX Form Submission (গ্যালারি ইমেজ পুশিং সহ ফিক্সড)
            $('#saveAndContinue').on('click', function(e) {
                e.preventDefault();

                var btn = $(this);
                var originalButtonText = btn.html();
                btn.html(`<div class="spinner-border spinner-border-sm"></div> @lang('Saving')...`).prop(
                    'disabled', true);

                var formData = new FormData($('#galleryForm')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                // ক্রিশ্চিয়ান বুয়েসোর প্লাগইনের ফাইলগুলো ম্যানুয়ালি FormData-তে যুক্ত করার সেকশন (ব্যাকএন্ডে ডেটা পাওয়ার জন্য)
                let imageUploaderInput = window.Element || $('.input-images input[type="file"]');
                if (imageUploaderInput.length && imageUploaderInput[0].files) {
                    $.each(imageUploaderInput[0].files, function(i, file) {
                        formData.append('extra_image[]', file);
                    });
                }

                $.ajax({
                    url: '{{ route('user.seller.service.store.gallery', $service->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            safeNotify('success', `@lang('Service gallery images saved successfully')`);
                            if (!response.is_update && response.redirect_url) {
                                window.location.href = response.redirect_url;
                            } else {
                                btn.html(originalButtonText).prop('disabled', false);
                            }
                        } else {
                            safeNotify('error', response.message || "@lang('Something went wrong')");
                            btn.html(originalButtonText).prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        safeNotify('error', error || "@lang('Server Error')");
                        btn.html(originalButtonText).prop('disabled', false);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
