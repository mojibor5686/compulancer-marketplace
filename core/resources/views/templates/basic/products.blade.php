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

                <div class="page-top">
                    <div class="page-top__wrapper">
                        <ul class="nav nav-tabs custom--tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $maxKey == 'service' ? 'active' : '' }}" data-bs-toggle="tab"
                                    data-bs-target="#service" type="button" role="tab"
                                    aria-selected="{{ $maxKey == 'service' ? 'true' : 'false' }}">
                                    @lang('Services')
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $maxKey == 'software' ? 'active' : '' }}" data-bs-toggle="tab"
                                    data-bs-target="#software" type="button" role="tab"
                                    aria-selected="{{ $maxKey == 'software' ? 'true' : 'false' }}">
                                    @lang('Softwares')
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $maxKey == 'job' ? 'active' : '' }}" data-bs-toggle="tab"
                                    data-bs-target="#job" type="button" role="tab"
                                    aria-selected="{{ $maxKey == 'job' ? 'true' : 'false' }}">
                                    @lang('Jobs')
                                </button>
                            </li>
                        </ul>

                        <div class="layout-toggle-btns">
                            <button class="layout-toggle-btn grid-layout active" type="button">
                                @include('Template::partials.icons.grid')
                            </button>
                            <button class="layout-toggle-btn list-layout" type="button">
                                @include('Template::partials.icons.list')
                            </button>
                        </div>

                        <form class="search-form" action="{{ route('search') }}" method="GET">
                            <div class="input-group">
                                <input class="form-control form--control" name="search" type="text"
                                    placeholder="@lang('Search...')" value="{{ old('search', request('search')) }}" />
                                <button class="btn btn--base" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

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
