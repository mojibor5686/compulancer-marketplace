@php
    $activeLevels = \App\Models\Level::active()->get();
    if ($type == 'service' || $type == 'software') {
        $activeFeatures = \App\Models\Feature::active()->orderBy('name')->get();
    }
    $skill = request('skill');
@endphp
<aside id="jss-offcanvas-sidebar" class="offcanvas-sidebar offcanvas-sidebar--jss">
    <button type="button" class="btn--close">
        <i class="fas fa-times"></i>
    </button>

    <div class="offcanvas-sidebar__body">
        <!-- Categories Section -->
        <div class="offcanvas-sidebar-block">
            <div class="offcanvas-sidebar-block__header">
                <span class="offcanvas-sidebar-block__title">@lang('Categories')</span>
            </div>
            <div class="offcanvas-sidebar-block__content" data-toggle="overflow-content"
                data-target="#offcanvas-sidebar-block-btn-1">
                <ul class="offcanvas-sidebar-list">
                    @foreach ($categories as $category)
                        <li class="offcanvas-sidebar-list__item">
                            <a class="offcanvas-sidebar-list__link"
                                href="{{ route('category.wise.product', [slug($category->name), $category->id]) }}">
                                <svg width="8" height="9" viewBox="0 0 8 9" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.32079 4.33948L0.278356 0.262272C0.221281 0.229277 0.15048 0.229277 0.092658 0.262272C0.0355829 0.295266 0 0.356424 0 0.422759V8.57716C0 8.64351 0.0355829 8.70467 0.092658 8.73765C0.121204 8.75396 0.153451 8.76248 0.185316 8.76248C0.217563 8.76248 0.249445 8.75433 0.278356 8.73765L7.32079 4.66044C7.37787 4.62708 7.41309 4.56592 7.41309 4.49995C7.41309 4.43398 7.37787 4.37246 7.32079 4.33948Z"
                                        fill="#757575" />
                                </svg>
                                <span>{{ __($category->name) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <button id="offcanvas-sidebar-block-btn-1" class="offcanvas-sidebar-block__btn" type="button">
                <span>@lang('See more')</span>
                <i class="fas fa-angle-up"></i>
            </button>
        </div>

        <!-- Filter by Level Section -->
        <form action="{{ route('filter') }}" method="GET">
            <input name="type" type="hidden" value="{{ $type }}">
            <div class="offcanvas-sidebar-block">
                <div class="offcanvas-sidebar-block__header">
                    <span class="offcanvas-sidebar-block__title">@lang('Filter by Level')</span>
                </div>
                <div class="offcanvas-sidebar-block__content">
                    <ul class="offcanvas-sidebar-list">
                        @foreach ($activeLevels as $level)
                            <li class="offcanvas-sidebar-list__item">
                                <div class="form-check form--check">
                                    <input class="form-check-input" id="level-{{ $level->id }}" name="level[]"
                                        type="checkbox" value="{{ $level->id }}"
                                        @if (!empty($levels) && in_array($level->id, $levels)) checked @endif>
                                    <label class="form-check-label"
                                        for="level-{{ $level->id }}">{{ __(ucFirst($level->name)) }}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <button id="offcanvas-sidebar-block-btn-2" class="offcanvas-sidebar-block__btn" type="button">
                    <span>@lang('See more')</span>
                    <i class="fas fa-angle-up"></i>
                </button>
            </div>

            <!-- Features Section (conditional) -->
            @if ($type == 'service' || $type == 'software')
                <div class="offcanvas-sidebar-block">
                    <div class="offcanvas-sidebar-block__header">
                        <span class="offcanvas-sidebar-block__title">@lang('Features')</span>
                    </div>
                    <div class="offcanvas-sidebar-block__content">
                        <ul class="offcanvas-sidebar-list">
                            @foreach ($activeFeatures as $feature)
                                <li class="offcanvas-sidebar-list__item">
                                    <div class="form-check form--check">
                                        <input class="form-check-input" id="feature-{{ $feature->id }}"
                                            name="feature[]" type="checkbox" value="{{ $feature->id }}"
                                            @if (!empty($features) && in_array($feature->id, $features)) checked @endif>
                                        <label class="form-check-label"
                                            for="feature-{{ $feature->id }}">{{ __($feature->name) }}</label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <button id="offcanvas-sidebar-block-btn-3" class="offcanvas-sidebar-block__btn" type="button">
                        <span>@lang('See more')</span>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
            @endif

            <div class="offcanvas-sidebar-block">
                <span class="offcanvas-sidebar-block__title">
                    @lang('Filter by Price')
                </span>
                <div class="offcanvas-sidebar-block__content overflow-visible">
                    <div class="price-filter">
                        <div class="range-slider" data-min="{{ $priceRange[0] ?? 1 }}"
                            data-max="{{ $priceRange[1] ?? 100 }}" data-min-default="25" data-max-default="50"></div>
                        <div class="price-filter__wrapper">
                            <input id="price" name="price" type="text" readonly="" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</aside>


@push('script')
    <script>
        $(document).ready(function() {

            (function($) {
                "use strict";

                let firstLoad = true;

                // Function to perform AJAX request for filtering and pagination
                function performAjaxRequest(page = 1) {
                    let url = new URL("{{ route('filter') }}");

                    // Set page parameter
                    url.searchParams.set('page', page);


                    // Get sorting value from the select dropdown
                    let sortValue = $('.sortBy').val();
                    if (sortValue) {
                        url.searchParams.set('sorting', sortValue);
                    } else {
                        url.searchParams.delete('sorting');
                    }

                    // Add level filters to URL parameters
                    $('input[name="level[]"]:checked').each(function() {
                        url.searchParams.append('level[]', $(this).val());
                    });

                    // Add feature filters to URL parameters
                    $('input[name="feature[]"]:checked').each(function() {
                        url.searchParams.append('feature[]', $(this).val());
                    });

                    // Set or update price filter
                    let priceRange = $('#price').val();
                    if (priceRange) {
                        url.searchParams.set('price', priceRange);
                    } else {
                        url.searchParams.delete('price');
                    }

                    url.searchParams.set('type', '{{ $type }}');
                    url.searchParams.set('featured', '{{ @$featured ?? 'false' }}');
                    @if (request()->tag)
                        url.searchParams.set('tag', '{{ request()->tag }}');
                    @endif
                    @if (request()->skill)
                        url.searchParams.set('skill', '{{ request()->skill }}');
                    @endif

                    @if (@$skill)
                        url.searchParams.set('skill', '{{ @$skill }}');
                    @endif

                    // Display loader, hide current product list
                    $('.productListCol').addClass('d-none');
                    $('.productListLoader').removeClass('d-none');
                    $('.empty-message-box').addClass('d-none');

                    // Perform AJAX request
                    $.ajax({
                        url: url.toString(),
                        type: 'GET',
                        success: function(data) {
                            if (firstLoad && data.priceRange) {
                                firstLoad =
                                    false; // Ensure the slider is set only on the first load
                                initializeSlider(data.priceRange[0], data.priceRange[1]);
                            }

                            $('.productList').html(data.html);

                            {{-- blade-formatter-disable --}}
                            // Construct results message based on pagination data
                            let resultsText = '';
                            if (data.pagination) {
                                if (data.pagination.total > 0) {
                                    resultsText = `@lang('Showing') ${data.pagination.from} @lang('to') ${data.pagination.to} @lang('of') ${data.pagination.total} @lang('results')`;
                                } else {
                                    resultsText = `@lang('No results found')`;
                                }
                            } else {
                                resultsText = `@lang('No results found')`;
                            }
                            {{-- blade-formatter-enable --}}

                            $('.page-top__results').text(resultsText);

                            var viewType = localStorage.getItem('product_view_type') || 'grid-view';
                            $('.jss-row').removeClass('row-list-layout').addClass(viewType ===
                                'list-view' ? 'row-list-layout' : '');

                            $('.productListCol').removeClass('d-none');
                            $('.productListLoader').addClass('d-none');

                            var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                                '[data-bs-toggle="tooltip"]'));
                            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });
                        },
                        error: function() {
                            $('.productListCol').addClass('d-none');
                            $('.productListLoader').removeClass('d-none');

                            // Retry
                            setTimeout(function() {
                                performAjaxRequest(page);
                            }, 500);
                        }
                    });



                }

                // Event bindings
                $('.sortBy').on('change', function() {
                    performAjaxRequest();
                });

                $('input[type="checkbox"]').on('change', function() {
                    performAjaxRequest();
                });

                $('#price').on('change', function() {
                    performAjaxRequest();
                });

                function initializeSlider(minPrice, maxPrice) {

                    $('.range-slider').each((index, element) => {
                        let slider = $(element);

                        slider.slider({
                            range: true,
                            animate: false,
                            min: parseInt(minPrice),
                            max: parseInt(maxPrice),
                            values: [parseInt(minPrice), parseInt(maxPrice)],
                            change: (event, ui) => {
                                performAjaxRequest();
                            }
                        });
                    });

                    $('.price-filter').each((index, element) => {
                        let currency = '$';
                        let price = $(element).find('[name="price"]');
                        let rangeSlider = $(element).find('.range-slider');
                        let value0 = rangeSlider.slider('values', 0) || 0;
                        let value1 = rangeSlider.slider('values', 1) || 0;
                        price.val(
                            `${currency}${value0} - ${currency}${value1}`
                        );

                        rangeSlider.on('slide', (event, ui) => {
                            price.val(
                                `${currency}${ui.values[0]} - ${currency}${ui.values[1]}`);
                        });
                    });

                }



                // Intercept pagination link clicks
                $(document).on('click', '.pagination a', function(e) {
                    e.preventDefault();
                    let page = $(this).attr('href').split('page=')[1];
                    if (page) {
                        performAjaxRequest(page);
                    }

                    $('html, body').animate({
                        scrollTop: $('.page-top').offset().top - 100
                    }, 700);

                });

                performAjaxRequest();

            })(jQuery);

        });
    </script>
@endpush
