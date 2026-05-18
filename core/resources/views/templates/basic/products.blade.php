@extends('Template::layouts.frontend')
@section('content')
    <main class="page-wrapper pt-0">
        <section class="category pt-80 pb-80">
            <div class="container">
                @if (request()->routeIs('category.wise.product'))
                    <div class="category2-slider">
                        @foreach ($category->subCategories as $subcategory)
                            <div class="category2-slider__slide">
                                <div class="category2-item">
                                    <a
                                        href="{{ route('subcategory.wise.product', [slug($subcategory->name), $subcategory->id]) }}">
                                        <div class="category2-item__icon">
                                            <img src="{{ getImage(getFilePath('subcategory') . '/' . $subcategory->image, getFileSize('subcategory')) }}"
                                                alt="@lang('Subcategory Image')" />
                                        </div>
                                    </a>
                                    <a class="category2-item__name"
                                        href="{{ route('subcategory.wise.product', [slug($subcategory->name), $subcategory->id]) }}">
                                        {{ __($subcategory->name) }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @include('Template::partials.basic_card')

            </div>
        </section>
    </main>
@endsection

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

            $(".category2-slider").slick({
                slidesToShow: 8,
                slidesToScroll: 2,
                speed: 1500,
                dots: false,
                arrows: true,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>',
                responsive: [{
                        breakpoint: 1400,
                        settings: {
                            slidesToShow: 7,
                        },
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 6,
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 5,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 4,
                        },
                    },
                    {
                        breakpoint: 425,
                        settings: {
                            slidesToShow: 3,
                        },
                    },
                ],
            });

        })(jQuery);
    </script>
@endpush
