@php
    $type = $type ?? (request()->route('type') ?? '');

    $activeLevels = \App\Models\Level::active()->get();

    $activeFeatures = collect();
    if (in_array($type, ['service', 'software'])) {
        $activeFeatures = \App\Models\Feature::active()->orderBy('name')->get();
    }

    $skill = request('skill');
@endphp

<style>
    /* মেইন সাইডবার কন্টেইনার */
    .mp-filter-sidebar {
        background: #ffffff !important;
        border: 1px solid #eef2f5 !important;
        border-radius: 6px !important;
        padding: 20px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
    }

    /* ফিল্টার ব্লকের স্পেসিং ও বর্ডার */
    .mp-filter-block {
        border-bottom: 1px solid #eef2f5;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    .mp-filter-block:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    /* ফিল্টার টাইটেল (মার্কেটপ্লেস বোল্ড লুক) */
    .mp-filter-title {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: #222222;
        margin-bottom: 14px;
        display: block;
        text-transform: capitalize;
    }

    /* ক্যাটাগরি এবং ফিল্টার লিস্ট */
    .mp-filter-list {
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 240px;
        overflow-y: auto;
    }

    /* স্ক্রলবার ক্লিন ডিজাইন */
    .mp-filter-list::-webkit-scrollbar {
        width: 4px;
    }

    .mp-filter-list::-webkit-scrollbar-thumb {
        background: #e0e0e0;
        border-radius: 4px;
    }

    .mp-filter-item {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .mp-filter-item:last-child {
        margin-bottom: 0;
    }

    /* ক্যাটাগরি লিঙ্ক ডিজাইন (টেক্সট ওভারফ্লো হ্যান্ডেলসহ) */
    .mp-category-link {
        font-size: 14px;
        color: #555555 !important;
        text-decoration: none !important;
        display: flex;
        align-items: center;
        transition: color 0.2s ease;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .mp-category-link:hover {
        color: #10c469 !important;
        /* মার্কেটপ্লেস সিগনেচার গ্রিন */
    }

    .mp-category-link i {
        font-size: 10px;
        margin-right: 8px;
        color: #999999;
    }

    /* কাস্টম চেকবক্স ও লেবেল ডিজাইন */
    .mp-checkbox-label {
        font-size: 14px;
        color: #444444;
        cursor: pointer;
        user-select: none;
        padding-left: 6px;
        line-height: 1.3;
    }

    .mp-form-check input[type="checkbox"] {
        accent-color: #10c469;
        /* মডার্ন ব্রাউজারে অটো গ্রিন চেকবক্স */
        width: 15px;
        height: 15px;
        cursor: pointer;
        border: 1px solid #cbd5e1;
        border-radius: 3px;
    }

    /* লোড মোর / সি মোর বোতাম */
    .mp-see-more-btn {
        background: none !important;
        border: none !important;
        color: #0066ff !important;
        font-size: 13px;
        font-weight: 600;
        padding: 0 !important;
        margin-top: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .mp-see-more-btn:hover {
        text-decoration: underline !important;
    }

    /* প্রাইস ইনপুট বক্স প্রফেশনাল ভিউ */
    .mp-price-input {
        background-color: #f8f9fa !important;
        border: 1px solid #e2e8f0 !important;
        color: #333333 !important;
        font-size: 14px;
        font-weight: 600;
        border-radius: 4px;
        padding: 6px 12px;
        width: 100%;
        text-align: center;
        margin-top: 12px;
    }

    /* UI-উইজেট স্লাইডার হ্যান্ডেল কাস্টমাইজেশন */
    .range-slider {
        border-height: 4px !important;
        border-color: #e2e8f0 !important;
        background-color: #e2e8f0 !important;
        height: 5px !important;
        border-radius: 10px;
        margin-top: 10px;
    }

    .ui-slider-range {
        background-color: #10c469 !important;
        /* স্লাইডার ট্র্যাক গ্রিন */
    }

    .ui-slider-handle {
        background: #ffffff !important;
        border: 2px solid #10c469 !important;
        border-radius: 50% !important;
        width: 16px !important;
        height: 16px !important;
        cursor: pointer !important;
        top: -6px !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<aside id="jss-offcanvas-sidebar" class="mp-filter-sidebar">
    <button type="button" class="btn--close d-md-none"
        style="position: absolute; right: 15px; top: 15px; background: none; border: none; font-size: 18px; color: #999;">
        <i class="fas fa-times"></i>
    </button>

    <div class="sidebar-body">
        <div class="mp-filter-block">
            <span class="mp-filter-title">@lang('Categories')</span>
            <div id="offcanvas-sidebar-block-btn-1-content">
                <ul class="mp-filter-list">
                    @foreach ($categories as $category)
                        <li class="mp-filter-item">
                            <a class="mp-category-link"
                                href="{{ route('category.wise.product', [slug($category->name), $category->id]) }}">
                                <i class="fas fa-chevron-right"></i>
                                <span>{{ __($category->name) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <button id="offcanvas-sidebar-block-btn-1" class="mp-see-more-btn" type="button">
                <span>@lang('See more')</span>
                <i class="fas fa-angle-down"></i>
            </button>
        </div>

        <form action="{{ route('filter') }}" method="GET">
            <input name="type" type="hidden" value="{{ $type }}">

            <div class="mp-filter-block">
                <span class="mp-filter-title">@lang('Filter by Level')</span>
                <div>
                    <ul class="mp-filter-list">
                        @foreach ($activeLevels as $level)
                            <li class="mp-filter-item">
                                <div class="d-flex align-items-center mp-form-check">
                                    <input id="level-{{ $level->id }}" name="level[]" type="checkbox"
                                        value="{{ $level->id }}" @if (!empty($levels) && in_array($level->id, $levels)) checked @endif>
                                    <label class="mp-checkbox-label"
                                        for="level-{{ $level->id }}">{{ __(ucFirst($level->name)) }}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <button id="offcanvas-sidebar-block-btn-2" class="mp-see-more-btn" type="button">
                    <span>@lang('See more')</span>
                    <i class="fas fa-angle-down"></i>
                </button>
            </div>

            @if ($type == 'service' || $type == 'software')
                <div class="mp-filter-block">
                    <span class="mp-filter-title">@lang('Features')</span>
                    <div>
                        <ul class="mp-filter-list">
                            @foreach ($activeFeatures as $feature)
                                <li class="mp-filter-item">
                                    <div class="d-flex align-items-center mp-form-check">
                                        <input id="feature-{{ $feature->id }}" name="feature[]" type="checkbox"
                                            value="{{ $feature->id }}"
                                            @if (!empty($features) && in_array($feature->id, $features)) checked @endif>
                                        <label class="mp-checkbox-label"
                                            for="feature-{{ $feature->id }}">{{ __($feature->name) }}</label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <button id="offcanvas-sidebar-block-btn-3" class="mp-see-more-btn" type="button">
                        <span>@lang('See more')</span>
                        <i class="fas fa-angle-down"></i>
                    </button>
                </div>
            @endif

            <div class="mp-filter-block">
                <span class="mp-filter-title">@lang('Filter by Price')</span>
                <div style="padding: 0 5px;">
                    <div class="range-slider" data-min="{{ $priceRange[0] ?? 1 }}"
                        data-max="{{ $priceRange[1] ?? 100 }}" data-min-default="25" data-max-default="50"></div>
                    <input id="price" name="price" class="mp-price-input" type="text" readonly="" />
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

                    $('.productListCol').addClass('d-none');
                    $('.productListLoader').removeClass('d-none');
                    $('.empty-message-box').addClass('d-none');

                    $.ajax({
                        url: url.toString(),
                        type: 'GET',
                        success: function(data) {
                            if (firstLoad && data.priceRange) {
                                firstLoad =
                                    false;
                                initializeSlider(data.priceRange[0], data.priceRange[1]);
                            }

                            $('.productList').html(data.html);

                            {{-- blade-formatter-disable --}}
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

                            setTimeout(function() {
                                performAjaxRequest(page);
                            }, 500);
                        }
                    });
                }

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
