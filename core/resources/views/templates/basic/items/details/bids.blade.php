@if ($productDetails->jobBidings->count())
    <div class="reviews-bottom mt-30">
        <h6 class="reviews__total" id="bidsTotal">
            {{ $productDetails->jobBidings->count() }} @lang('Bids')
        </h6>
        <ul class="reviews-list" id="bidsList">
            @foreach ($productDetails->jobBidings->take(5) as $biding)
                @include('Template::partials.bid_item', ['biding' => $biding])
            @endforeach
        </ul>
    </div>

    @if ($productDetails->jobBidings->count() > 5)
        <div class="text-center mt-4">
            <button type="button" class="btn btn--base loadMoreBids" data-job-id="{{ $productDetails->id }}">
                @lang('View More')
                <i class="fas fa-spinner fa-spin mx-1 loading-spinner d-none"></i>
            </button>
        </div>
    @endif
@else
    <x-basic-empty-message />
@endif


@push('script')
    <script>
        (function($) {
            "use strict";

            var showBids = 5; // Initial number of bids loaded

            $('.loadMoreBids').on('click', function(e) {
                e.preventDefault();

                var $button = $(this);
                var $spinner = $button.find('.loading-spinner'); // Select the spinner inside the button

                $button.addClass('btn-disabled').attr("disabled", true);
                $spinner.removeClass('d-none'); // Show spinner

                var jobId = $button.data('job-id');
                var jobSlug = "{{ slug($productDetails->name) }}"; // Get the dynamically generated slug
                var skip = showBids;

                $.ajax({
                    type: 'get',
                    url: '{{ route('job.details', [':slug', ':id']) }}'
                        .replace(':slug', jobSlug)
                        .replace(':id', jobId),
                    data: {
                        skip: skip,
                        _token: "{{ csrf_token() }}" // CSRF protection
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $('#bidsList').append(response.html);
                            showBids += 5;

                            if (response.last) {
                                $button.hide();
                            } else {
                                $button.removeClass('btn-disabled').attr("disabled", false);
                            }

                            notify('success', 'More bids loaded successfully');
                        } else {
                            notify('error', response.error || "@lang('Something went wrong.')");
                        }
                    },
                    error: function(xhr) {
                        notify('error', xhr.responseJSON.message || "@lang('An error occurred.')");
                    },
                    complete: function() {
                        $spinner.addClass('d-none'); // Hide spinner after request
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
