@extends('Template::layouts.seller_service')

@section('service')
    <form id="galleryForm" enctype="multipart/form-data">
        <div class="form--group-lg">
            <label class="form-label form--label">@lang('Thumbnail Image')</label>
            <div class="box mb-3 upload-content custom-upload-box-design" id="thumbnailBox"
                style="background: {{ $service->image ? 'url(' . getImage(getFilePath('service') . '/' . $service->image) . ') center center / cover no-repeat' : '#ffffff' }};">
                <div class="dark-overlay" style="{{ $service->image ? '' : 'display:none;' }}"></div>
                <div class="upload-options firstUploadOption">
                    <label class="show-image" for="image-upload">
                        <span class="upload-content__label show-image-area">
                            <i class="las la-plus-circle"></i>
                            <span>@lang('Upload Image')</span>
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
                        'id' => $image,
                        'src' => getImage(getFilePath('extraImage') . '/' . $image),
                    ];
                }
            }
        @endphp

        <div class="form--group-lg mt-4">
            <label class="form-label form--label">@lang('Image Gallery')</label>
            <div class="custom-gallery-wrapper">
                <div class="gallery-grid" id="galleryGrid">
                    @if ($service->extra_image && is_array($service->extra_image))
                        @foreach ($service->extra_image as $key => $image)
                            <div class="gallery-item old-image-item" data-image-name="{{ $image }}">
                                <img src="{{ getImage(getFilePath('extraImage') . '/' . $image) }}" alt="Gallery Image">
                                <button type="button" class="remove-old-btn">×</button>
                                <input type="hidden" name="old[]" value="{{ $image }}">
                            </div>
                        @endforeach
                    @endif
                    <div class="custom-upload-box-design" id="uploadTriggerBox">
                        <div class="upload-box-content">
                            <i class="las la-plus-circle"></i>
                            <span>@lang('Upload Image')</span>
                        </div>
                        <input type="file" id="customGalleryInput" multiple accept="image/png, image/jpeg"
                            style="display: none;">
                    </div>
                </div>
            </div>
            <small class="mt-3 text-muted text-center d-block">
                @lang('Supported Files'): <b>@lang('.png, .jpg, .jpeg')</b> <br>
                @lang('Maximum 6 images allowed') <br>
                @lang('Image will be resized into') <b>{{ getFileSize('extraImage') }}px</b>
            </small>
        </div>

        <div class="form--group-lg text-end mt-4">
            <button class="btn btn--base btn--lg" id="saveAndContinue" type="button">
                @lang('Save & Continue')
            </button>
        </div>
    </form>
@endsection

@push('style')
    <style>
        .custom-upload-box-design {
            border: 2px dashed #cbd5e1;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 140px;
            width: 100%;
            border-radius: 12px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            background-size: cover;
            background-position: center;
        }

        .custom-upload-box-design:hover {
            border-color: #4f46e5;
            background-color: #f8fafc;
        }

        .custom-upload-box-design i {
            font-size: 32px;
            display: block;
            margin-bottom: 5px;
            color: #64748b;
            text-align: center;
        }

        .custom-upload-box-design span {
            font-size: 13px;
            font-weight: 500;
            color: #64748b;
            display: block;
            text-align: center;
        }

        .dark-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
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

        .upload-options label.show-image .show-image-area input[type="file"] {
            display: none;
        }

        .custom-gallery-wrapper {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px;
            min-height: 170px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 15px;
            align-items: center;
        }

        .gallery-item {
            width: 100%;
            height: 140px;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            border: 1px solid #cbd5e1;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-item button {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #ef4444;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 14px;
            font-weight: bold;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            let selectedGalleryFiles = [];

            function safeNotify(type, msg) {
                if (typeof notify !== 'undefined') {
                    notify(type, msg);
                } else {
                    alert(msg);
                }
            }

            $('#thumbnailBox').on('click', function(event) {
                if (!$(event.target).is('#image-upload')) {
                    $('#image-upload').trigger('click');
                }
            });

            $('#image-upload').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#thumbnailBox').css({
                            'background-image': `url(${e.target.result})`
                        });
                        $('#thumbnailBox').find('.dark-overlay').show();
                        $('#thumbnailBox').find('.upload-box-content, i, span').css('color', '#ffffff');
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#uploadTriggerBox').on('click', function(event) {
                if (!$(event.target).is('#customGalleryInput')) {
                    $('#customGalleryInput').trigger('click');
                }
            });

            $('#customGalleryInput').on('change', function() {
                const files = this.files;
                let currentTotal = $('.gallery-item').length + selectedGalleryFiles.filter(f => f !== null)
                    .length;

                if (currentTotal + files.length > 6) {
                    safeNotify('error', '@lang('Maximum 6 images are allowed!')');
                    $(this).val('');
                    return;
                }

                $.each(files, function(index, file) {
                    if (!file.type.match('image.*')) return;

                    selectedGalleryFiles.push(file);
                    const fileIndex = selectedGalleryFiles.length - 1;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const html = `
                            <div class="gallery-item new-preview-item" data-index="${fileIndex}">
                                <img src="${e.target.result}" alt="Preview">
                                <button type="button" class="remove-new-btn">×</button>
                            </div>
                        `;
                        $('#uploadTriggerBox').before(html);
                    };
                    reader.readAsDataURL(file);
                });

                $(this).val('');
            });

            $(document).on('click', '.remove-new-btn', function(e) {
                e.stopPropagation();
                const item = $(this).closest('.gallery-item');
                const index = item.data('index');
                selectedGalleryFiles[index] = null;
                item.remove();
            });

            $(document).on('click', '.remove-old-btn', function(e) {
                e.stopPropagation();
                $(this).closest('.gallery-item').remove();
            });

            $('#saveAndContinue').on('click', function(e) {
                e.preventDefault();

                var btn = $(this);
                var originalButtonText = btn.html();
                btn.html(`<div class="spinner-border spinner-border-sm"></div> @lang('Saving')...`).prop(
                    'disabled', true);

                var formData = new FormData($('#galleryForm')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                selectedGalleryFiles.forEach(function(file) {
                    if (file !== null) {
                        formData.append('extra_image[]', file);
                    }
                });

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
