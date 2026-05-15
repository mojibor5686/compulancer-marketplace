<div class="jss-details-main__block one">
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
                @foreach (($productDetails->skill ?? []) as $skill)
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

        <!-- Title and Ratings -->
        <h4 class="jss-details__title">
            {{ __($productDetails->name) }}
        </h4>

        <ul class="jss-details-meta">
            <li class="jss-details-meta__item">
                <div class="ratings">
                    <div class="ratings-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $productDetails->total_rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    @if ($productDetails->total_rating)
                        <span
                            class="ratings__total">({{ showAmount($productDetails->total_rating, currencyFormat: false) }})</span>
                    @endif
                </div>
            </li>
            <li class="jss-details-meta__item">
                <div class="d-flex align-items-center gap-1">
                    <i class="las la-thumbs-up fs-18"></i>
                    <span>{{ $productDetails->likes }}</span>
                </div>
            </li>
        </ul>

        <!-- React Buttons and Social Links -->
        <div class="mt-4 d-flex flex-wrap row-gap-3 align-items-center justify-content-between">
            <div class="jss-details__react-btns">
                <button
                    class="btn btn--sm btn-outline--base make-favorite {{ auth()->check() && $productDetails->favorites->where('user_id', auth()->id())->count() ? 'active' : '' }}"
                    type="button" data-id="{{ $productDetails->id }}" data-type="{{ $type }}"
                    data-action="{{ route('user.buyer.favorite.store') }}" @auth data-auth="true" @endauth>
                    <i class="las la-heart fs-16"></i>
                    <span class="favorite-count">{{ __($productDetails->favorite) }}</span>
                </button>
                @if ($type == 'software')
                    <a href="{{ $productDetails->demo_url }}" class="btn btn--sm btn--success" target="_blank">
                        @include('Template::partials.icons.screen')
                        <span>@lang('Preview')</span>
                    </a>
                @endif
            </div>

            <ul class="social-list style-two">
                <li class="social-list__item">
                    <a href="http://www.facebook.com/sharer.php?u={{ urlencode(url()->current()) }}&p[title]={{ slug($productDetails->name) }}"
                        class="social-list__link" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
                <li class="social-list__item">
                    <a href="http://twitter.com/share?text={{ slug($productDetails->name) }}&url={{ urlencode(url()->current()) }}"
                        class="social-list__link" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>
                <li class="social-list__item">
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ slug($productDetails->name) }}"
                        class="social-list__link" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </li>
                <li class="social-list__item">
                    <a href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ slug($productDetails->name) }}"
                        class="social-list__link" target="_blank">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                </li>
            </ul>
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
