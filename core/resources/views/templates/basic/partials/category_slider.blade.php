@php
    $bgImageContent = getContent('bg_image.content', true);
@endphp

<section class="breadcrumb bg-img"
    data-background-image="{{ frontendImage('bg_image', @$bgImageContent->data_values->image, '1920x140') }}">
    <div class="container">
        <div class="category-slider">
            @foreach ($categories as $category)
                <div class="category-slider__slide">
                    <a class="category-item"
                        href="{{ route('category.wise.product', [slug($category->name), $category->id]) }}">
                        <img class="category-item__thumb"
                            src="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}"
                            alt="{{ $category->name }}" />
                        <span class="category-item__name">{{ __($category->name) }}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>


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

            $(".category-slider").slick({
                slidesToShow: 6,
                slidesToScroll: 2,
                speed: 1500,
                dots: false,
                arrows: true,
                pauseOnHover: true,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>',
                responsive: [{
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 5,
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 4,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                        },
                    },
                    {
                        breakpoint: 425,
                        settings: {
                            slidesToShow: 2,
                        },
                    },
                ],
            });

        })(jQuery);
    </script>
@endpush
