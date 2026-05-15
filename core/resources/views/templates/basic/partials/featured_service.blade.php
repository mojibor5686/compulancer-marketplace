@php
    $modelName = 'App\\Models\\' . ucfirst($type);
    $productItems = $modelName::active()->featured()->userActiveCheck()->checkData()->latest()->with('user')->limit(6)->get();
@endphp

@if (count($productItems))
    <div class="widget mb-30">
        <h3 class="widget-title">@lang('Featured '){{ ucfirst($type) }}</h3>
        <ul class="small-item-list load-more-featured-services">
            @foreach ($productItems->take(5) as $fItem)
                @include('Template::partials.basic_featured_service')
            @endforeach
        </ul>
    </div>
    <div class="widget-btn text-center mb-30">
        @if (count($productItems) > 5)
            <button class="btn--base loadMoreFeaturedServices">@lang('Show More')</button>
        @endif
    </div>
@endif

@if (count($productItems) > 5)
    @push('script')
        <script>
            (function($) {
                "use strict";
                var showServices = 5;
                $('.loadMoreFeaturedServices').on('click', function(e) {
                    e.preventDefault();

                    var btnAfterSubmit = `<div class="spinner-border"></div> @lang('Loading')...`;
                    var btnName = `@lang('Show More')`;
                    var btn = $(this);
                    btn.html(btnAfterSubmit);
                    btn.attr('disabled', true);

                    var type = "{{ $type }}";
                    var skip = showServices;

                    $.ajax({
                        type: 'get',
                        url: '{{ route('fetch.featured.services') }}',
                        data: {
                            type: type,
                            skip: skip
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                $('.load-more-featured-services').append(response.html);
                                showServices += 5;
                                btn.html(btnName);
                                btn.removeAttr('disabled');
                            } else {
                                notify('error', response.error);
                                btn.html(btnName);
                                btn.hide();
                            }
                        },
                    });
                });
            })(jQuery);
        </script>
    @endpush
@endif
