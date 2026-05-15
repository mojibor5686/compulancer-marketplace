<div class="jss-details-slider">
    <div class="jss-details-thumb-slider">
        <div class="jss-details-thumb-slider__slide">
            <a href="{{ getImage(getFilePath('service') . '/' . $itemDetails->image) }}"
                data-rel="lightcase:my-slideshow">
                <img src="{{ getImage(getFilePath('service') . '/' . $itemDetails->image, getFileSize('service')) }}"
                    alt="Service Main Image" />
            </a>
        </div>

        @if ($itemDetails->extra_image)
            @foreach ($itemDetails->extra_image as $extraImage)
                <div class="jss-details-thumb-slider__slide">
                    <a href="{{ getImage(getFilePath('extraImage') . '/' . $extraImage) }}"
                        data-rel="lightcase:my-slideshow">
                        <img src="{{ getImage(getFilePath('extraImage') . '/' . $extraImage, getFileSize('extraImage')) }}"
                            alt="Service Extra Image" />
                    </a>
                </div>
            @endforeach
        @endif
    </div>

    <div class="jss-details-preview-slider">
        <div class="jss-details-preview-slider__slide">
            <img src="{{ getImage(getFilePath('service') . '/' . $itemDetails->image, getFileSize('service')) }}"
                alt="Service Main Image" />
        </div>

        @if ($itemDetails->extra_image)
            @foreach ($itemDetails->extra_image as $extraImage)
                <div class="jss-details-preview-slider__slide">
                    <img src="{{ getImage(getFilePath('extraImage') . '/' . $extraImage, getFileSize('extraImage')) }}"
                        alt="Service Extra Image" />
                </div>
            @endforeach
        @endif
    </div>
</div>
