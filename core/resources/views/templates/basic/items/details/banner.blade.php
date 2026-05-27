<div class="jss-details-main__block one" style="border-radius: 0px;">
    @if ($type == 'job')
        <!-- Job Image -->
        <div class="jss-details-slider">
            <div class="jss-details-thumb-slider">
                <div class="jss-details-thumb-slider__slide">
                    <a href="{{ getImage(getFilePath('job') . '/' . $productDetails->image) }}"
                        data-rel="lightcase:my-slideshow">
                        <img src="{{ getImage(getFilePath('job') . '/' . $productDetails->image, getFileSize('job')) }}"
                            alt="Job Image" />
                    </a>
                </div>
            </div>
        </div>

        <!-- Job Title -->
        <h4 class="jss-details__title">
            {{ __($productDetails->name) }}
        </h4>

        <!-- Skills -->
        <div class="tags">
            <h6 class="tags__title">@lang('Skills')</h6>
            <div class="tags-list">
                @foreach ($productDetails->skill ?? [] as $skill)
                    <a class="tags-list__tag"
                        href="{{ route('job') }}?skill={{ $skill }}">{{ __($skill) }}</a>
                @endforeach
            </div>
        </div>
    @else
        <!-- Image Slider -->
        <div class="jss-details-slider">
            <div class="jss-details-thumb-slider">
                <div class="jss-details-thumb-slider__slide">
                    <a href="{{ getImage(getFilePath($type) . '/' . $productDetails->image) }}"
                        data-rel="lightcase:my-slideshow">
                        <img src="{{ getImage(getFilePath($type) . '/' . $productDetails->image, getFileSize($type)) }}"
                            alt="{{ ucFirst($type) }} Main Image" />
                    </a>
                </div>

                @if ($productDetails->extra_image)
                    @foreach ($productDetails->extra_image as $extraImage)
                        <div class="jss-details-thumb-slider__slide">
                            <a href="{{ getImage(getFilePath('extraImage') . '/' . $extraImage) }}"
                                data-rel="lightcase:my-slideshow">
                                <img src="{{ getImage(getFilePath('extraImage') . '/' . $extraImage, getFileSize('extraImage')) }}"
                                    alt="{{ ucFirst($type) }} Extra Image" />
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="jss-details-preview-slider">
                <div class="jss-details-preview-slider__slide">
                    <img src="{{ getImage(getFilePath($type) . '/' . $productDetails->image, getFileSize($type)) }}"
                        alt="{{ ucFirst($type) }} Main Image" />
                </div>

                @if ($productDetails->extra_image)
                    @foreach ($productDetails->extra_image as $extraImage)
                        <div class="jss-details-preview-slider__slide">
                            <img src="{{ getImage(getFilePath('extraImage') . '/' . $extraImage, getFileSize('extraImage')) }}"
                                alt="{{ ucFirst($type) }} Extra Image" />
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endif
</div>

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/lightcase.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/lightcase.min.js') }}"></script>
@endpush

@if (!app()->offsetExists('slick_script'))
    @push('style-lib')
        <link href="{{ asset(activeTemplate(true) . 'css/slick.css') }}" rel="stylesheet">
    @endpush

    @push('script-lib')
        <script src="{{ asset(activeTemplate(true) . 'js/slick.min.js') }}"></script>
    @endpush

    @php app()->offsetSet('slick_script',true) @endphp
@endif


@push('script')
    <script>
        (function($) {
            "use strict";


            $('a[data-rel^=lightcase]').lightcase();

            $(".jss-details-thumb-slider").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: false,
                arrows: false,
                asNavFor: ".jss-details-preview-slider",
            });

            $(".jss-details-preview-slider").slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: false,
                arrows: true,
                focusOnSelect: true,
                asNavFor: ".jss-details-thumb-slider",
                prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
                responsive: [{
                    breakpoint: 425,
                    settings: {
                        slidesToShow: 3,
                    },
                }, ],
            });

        })(jQuery);
    </script>
@endpush
