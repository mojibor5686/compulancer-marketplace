<div class="page-content">
    <div class="tab-content">
        @foreach ($items as $key => $products)
            @php
                $take = request()->routeIs('public.profile') ? 9 : 8;
            @endphp
            <div class="tab-pane {{ $key == $maxKey ? 'active show' : '' }}" id="{{ $key }}" role="tabpanel"
                tabindex="0">
                <div class="row gy-4 jss-row row-list-layout">
                    @forelse(@$products->take($take) as $product)
                        <div
                            class="col-sm-6 col-lg-{{ request()->routeIs('public.profile') ? '6' : '4' }} col-xxl-{{ request()->routeIs('public.profile') ? '4' : '3' }}">
                            <x-item type="{{ $key }}" :product="$product" />
                        </div>
                    @empty
                        <x-basic-empty-message />
                    @endforelse
                </div>
                @if (@$products->take($take)->count() == $take)
                    <div class="mt-60 text-center loadMoreBtnDiv">
                        <button class="btn btn--base loadMoreBtn" type="button">@lang('Load more')</button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>



@push('script')
    <script>
        (function($) {
            "use strict";

            var defaultShowProducts = 8;

            var tabState = {
                services: {
                    skip: defaultShowProducts,
                    search: '{{ @$search }}'
                },
                softwares: {
                    skip: defaultShowProducts,
                    search: '{{ @$search }}'
                },
                jobs: {
                    skip: defaultShowProducts,
                    search: '{{ @$search }}'
                }
            };

            function initializeTabState(type) {
                if (!tabState[type]) {
                    tabState[type] = {
                        skip: defaultShowProducts,
                        search: '{{ @$search }}'
                    };
                }
            }

            $(document).on('click', '.loadMoreBtn', function(e) {
                e.preventDefault();

                var btn = $(this);
                var btnAfterSubmit =
                    `<div class="spinner-border spinner-border-sm me-2"></div> @lang('Load more')...`;
                var btnName = `Load more`;
                btn.html(btnAfterSubmit).prop('disabled', true);

                var type = $('.tab-pane.active').attr('id');
                initializeTabState(type);

                var search = tabState[type].search;
                var userId = '{{ @$user->id }}';
                var categoryId = '{{ @$category->id }}';
                var subcategoryId = '';

                if (@json(@$isSubcat)) {
                    subcategoryId = '{{ @$subcategory->id }}';
                }

                var skip = tabState[type].skip;


                $.ajax({
                    type: 'get',
                    url: '{{ route('fetch.products') }}',
                    data: {
                        skip: skip,
                        type: type,
                        search: search,
                        user_id: userId,
                        category_id: categoryId,
                        subcategory_id: subcategoryId,
                        route_name: '{{ Route::currentRouteName() }}'
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $('#' + type + ' .jss-row').append(response.html);
                            tabState[type].skip += defaultShowProducts;
                            btn.html(btnName).prop('disabled', false);
                        } else {
                            btn.remove();
                        }
                    }
                });
            });

            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
                var type = $(this).data('bs-target').replace('#', '');
                initializeTabState(type);
                $('.loadMoreBtnDiv').html(
                    '<button class="btn btn--base loadMoreBtn" type="button">Load more</button>');
            });

            var activeTab = '{{ request()->get('active_tab') }}';
            if (activeTab) {
                $('.nav-link').removeClass('active');
                $('[data-bs-target="#' + activeTab + '"]').addClass('active');
                $('.tab-content .tab-pane').removeClass('show active');
                $('#' + activeTab).addClass('show active');
            }

            @if (!request()->routeIs('public.profile'))
                $(document).ready(function() {
                    let loadMoreClicked = false;
                    let scrollTimeout;

                    function isLoadMoreVisible() {
                        const activeTab = $('.tab-pane.active');
                        const loadMoreBtn = activeTab.find('.loadMoreBtn');

                        if (loadMoreBtn.length) {
                            const rect = loadMoreBtn[0].getBoundingClientRect();
                            return (
                                rect.top >= 0 &&
                                rect.left >= 0 &&
                                rect.bottom <= (window.innerHeight || document.documentElement
                                    .clientHeight) &&
                                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                            );
                        }
                        return false;
                    }

                    $(window).on('scroll', function() {
                        clearTimeout(scrollTimeout);

                        scrollTimeout = setTimeout(function() {
                            if (isLoadMoreVisible() && !loadMoreClicked) {
                                loadMoreClicked = true;
                                $('.tab-pane.active .loadMoreBtn').trigger('click');

                                setTimeout(function() {
                                    loadMoreClicked = false;
                                }, 1000);
                            }
                        }, 100);
                    });
                });
            @endif

        })(jQuery);
    </script>
@endpush
