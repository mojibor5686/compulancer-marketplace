@extends('Template::layouts.seller_software')
@section('software')
    <form id="galleryForm" enctype="multipart/form-data">
        <div class="form--group-lg">
            <label class="form-label form--label">@lang('Thumbnail Image')</label>
            @php
                $hasImage = $software->image && file_exists(getFilePath('software') . '/' . $software->image);
                $imgPath = $hasImage ? getImage(getFilePath('software') . '/' . $software->image) : '';
            @endphp

            <div class="box mb-3 upload-content" id="thumbnailWrapper"
                style="@if ($hasImage) background-image: url({{ $imgPath }}); @endif">
                <div class="dark-overlay"></div>

                <div class="upload-options">
                    <div class="show-image-area">
                        <input class="image-upload" id="image-upload" name="image" type="file"
                            accept="image/png, image/jpeg" style="display: none;">
                    </div>
                </div>
            </div>

            <small class="mt-3 text-muted text-center d-block">
                @lang('Supported Files'): <b>@lang('.png, .jpg, .jpeg')</b> <br>
                @lang('Image will be resized into') <b>{{ getFileSize('software') }}px</b>
            </small>
        </div>

        @php
            $images = [];
            if ($software->extra_image && is_array($software->extra_image)) {
                foreach ($software->extra_image as $key => $image) {
                    $images[] = [
                        'id' => $key,
                        'src' => getImage(getFilePath('extraImage') . '/' . $image),
                    ];
                }
            }
        @endphp

        <div class="form--group-lg image-gallery-wrapper" data-images='@json($images)'>
            <label class="form-label form--label">@lang('Image Gallery')</label>
            <div class="input-images"></div>
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
                @lang('Save & Continue') <i class="las la-angle-right"></i>
            </button>
        </div>
    </form>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset(activeTemplate(true) . 'css/image-uploader.min.css') }}">
@endpush

@push('style')
    <style>
        .upload-content {
            border: 2px dashed #cccccc;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 180px;
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

        .upload-options {
            position: relative;
            z-index: 2;
            pointer-events: none;
            /* ক্লিকের ঝামেলা এড়াতে */
        }

        .show-image-area {
            color: #ffffff;
            font-size: 24px;
            text-align: center;
        }

        .show-image-area::before {
            font-family: 'Line Awesome Free';
            font-weight: 900;
            content: "\f382";
            font-size: 48px;
            display: block;
            margin-bottom: 5px;
        }
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset(activeTemplate(true) . 'js/image-uploader.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            // থাম্বনেইল বক্সে ক্লিক করলেই ফাইল আপলোডার ওপেন হবে
            $('#thumbnailWrapper').on('click', function() {
                $('#image-upload').click();
            });

            // ফাইল সিলেক্ট করার পর ইনস্ট্যান্ট প্রিভিউ দেখানোর লজিক
            $('#image-upload').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#thumbnailWrapper').css('background-image', `url(${e.target.result})`);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // ইমেজ গ্যালারি প্লাগইন ইনিশিয়ালাইজেশন
            const preloadedImages = $('.image-gallery-wrapper').data('images') || [];
            $('.input-images').imageUploader({
                preloaded: preloadedImages,
                imagesInputName: 'extra_image',
                preloadedInputName: 'old',
                maxFiles: 6
            });

            // কাস্টম নোটিফিকেশন ফাংশন (iziToast সাপোর্ট সহ)
            function showNotify(type, message) {
                if (typeof notify !== 'undefined') {
                    notify(type, message);
                } else if (typeof iziToast !== 'undefined') {
                    iziToast[type]({
                        title: type === 'success' ? 'Success' : 'Error',
                        message: message,
                        position: 'topRight'
                    });
                } else {
                    alert(message);
                }
            }

            // ফর্ম সাবমিশন (AJAX)
            $('#saveAndContinue').on('click', function() {
                var btn = $(this);
                var originalHtml = btn.html();

                btn.html(`<div class="spinner-border spinner-border-sm"></div> @lang('Saving')...`).prop(
                    'disabled', true);

                var formData = new FormData($('#galleryForm')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('user.seller.software.store.gallery', $software->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            showNotify('success', response.message || `@lang('Gallery updated successfully')`);
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            }
                        } else {
                            if (Array.isArray(response.message)) {
                                response.message.forEach(msg => showNotify('error', msg));
                            } else {
                                showNotify('error', response.message);
                            }
                            btn.html(originalHtml).prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        showNotify('error', '@lang('Something went wrong. Please try again.')');
                        btn.html(originalHtml).prop('disabled', false);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
