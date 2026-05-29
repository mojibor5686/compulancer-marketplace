@extends('Template::layouts.seller_software')
@section('software')
    <form id="galleryForm" enctype="multipart/form-data">
        <div class="form--group-lg">
            <label class="form-label form--label">@lang('Thumbnail Image')</label>
            @php
                $hasImage = $software->image && file_exists(getFilePath('software') . '/' . $software->image);
                $imgPath = $hasImage ? getImage(getFilePath('software') . '/' . $software->image) : '';
            @endphp

            <label for="image-upload" class="box mb-3 upload-content" id="thumbnailWrapper"
                style="@if ($hasImage) background-image: url({{ $imgPath }}); @endif">
                <div class="dark-overlay"></div>

                <div class="upload-options">
                    <div class="show-image-area">
                        <input class="image-upload" id="image-upload" name="image" type="file"
                            accept="image/png, image/jpeg" style="display: none;">
                    </div>
                </div>
            </label>

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

            // প্লাগইন লোড হতে যাতে মিস না হয় তাই আমরা উইন্ডো লোড হবার পর বা সেফ জোনে ইনিশিয়েট করব
            $(window).on('load', function() {
                if ($.isFunction($.fn.imageUploader)) {
                    const preloadedImages = $('.image-gallery-wrapper').data('images') || [];
                    $('.input-images').imageUploader({
                        preloaded: preloadedImages,
                        imagesInputName: 'extra_image',
                        preloadedInputName: 'old',
                        maxFiles: 6
                    });
                } else {
                    console.error("imageUploader library asset path is missing or not loading properly.");
                }
            });

            // থাম্বনেইল প্রিভিউ (কোনো লুপ ক্র্যাশ নাই কারণ ইভেন্ট সিঙ্গেল)
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

            // কাস্টম নোটিফিকেশন ফাংশন
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

            // AJAX ফর্ম সাবমিট
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
