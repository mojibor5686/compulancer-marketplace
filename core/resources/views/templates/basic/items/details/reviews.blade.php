@php
    $reviews = $productDetails->reviews()->latest()->with('user')->get();
@endphp

<div class="reviews">
    <div class="reviews-top">
        <div class="reviews-top__left">
            <h5 class="reviews__tip">
                @if ($productDetails->total_review)
                    {{ round(($productDetails->total_rating / $productDetails->total_review) * 2) / 2 }}
                @else
                    0.00
                @endif

            </h5>
            <div class="reviews__ratings">
                @php echo starRating($productDetails->total_review, $productDetails->total_rating) @endphp
            </div>
            <span class="reviews__total">
                @if ($productDetails->total_review)
                    {{ $productDetails->total_review }}
                    @lang('Reviews')
                @else
                    0 @lang('Review')
                @endif
            </span>
        </div>
        <div class="reviews-top__right">
            <h5 class="mb-4">@lang('Rating Breakingdown')</h5>
            <ul class="reviews-info">
                <li class="reviews-info__item">
                    <div class="wrapper">
                        <i class="far fa-thumbs-up"></i>
                        <span class="label">@lang('Total Likes')</span>
                    </div>
                    <span class="total">{{ __($productDetails->likes) }}</span>
                </li>
                <li class="reviews-info__item">
                    <div class="wrapper">
                        <i class="far fa-thumbs-down"></i>
                        <span class="label">@lang('Total Dislikes')</span>
                    </div>
                    <span class="total">{{ __($productDetails->dislike) }}</span>
                </li>
            </ul>
        </div>
    </div>

    @php
        // Check if the user has permission to submit a review
        $statusCol = $type == 'software' ? 'status' : 'working_status';
        $status = $type == 'software' ? Status::BOOKING_PAID : Status::WORKING_COMPLETED;

        $reviewPermission =
            $productDetails
                ->bookings()
                ->where('buyer_id', auth()->id())
                ->where($statusCol, $status)
                ->exists() &&
            !$productDetails
                ->bookings()
                ->where('buyer_id', auth()->id())
                ->where($statusCol, $status)
                ->where('review_status', Status::YES)
                ->exists();
    @endphp

    @if ($reviewPermission)
        <div class="comment-form-area mb-40">
            <form class="comment-form" action="{{ route('user.review.store') }}" method="POST">
                @csrf
                <input name="product_id" type="hidden" value="{{ $productDetails->id }}">
                <input name="type" type="hidden" value="{{ $type }}">

                <div class="comment-ratings-area d-flex flex-wrap align-items-center justify-content-between">
                    <div class="rating">
                        @for ($i = 5; $i >= 1; $i--)
                            <input id="star{{ $i }}" name="rating" type="radio"
                                value="{{ $i }}" />
                            <label for="star{{ $i }}">&nbsp;</label>
                        @endfor
                    </div>

                    <div class="like-dislike">
                        <div class="d-flex flex-wrap align-items-center justify-content-sm-end">
                            <div class="like-dislike me-4">
                                <input id="review-like" name="like" type="radio" value="1">
                                <label class="mb-0" for="review-like"><i class="far fa-thumbs-up"></i></label>
                            </div>
                            <div class="like-dislike">
                                <input id="review-dislike" name="like" type="radio" value="0">
                                <label class="mb-0" for="review-dislike"><i class="far fa-thumbs-down"></i></label>
                            </div>
                        </div>
                    </div>
                </div>

                <textarea class="form-control form--control review-textarea" name="review" placeholder="@lang('Write Review')"
                    rows="8" required></textarea>
                <button class="submit-btn mt-20 mt-3 review-submit" type="submit">@lang('Submit')</button>
            </form>
        </div>
    @endif

    <div class="reviews-bottom">
        <h6 class="reviews__total">{{ $productDetails->total_review }}
            @lang('Reviews')</h6>
        @include('Template::partials.reviews')
    </div>
</div>


@push('script')
    <script>
        (function($) {
            "use strict";

            $(document).ready(function() {
                // Check if the request has a review parameter
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('review')) {
                    // Activate the "Reviews" tab
                    $('[data-bs-target="#jss-details-tab-3"]').click();

                    // Scroll to the review submission form
                    const reviewForm = $('.reviews-top');
                    if (reviewForm.length) {
                        $('html, body').animate({
                            scrollTop: reviewForm.offset().top -
                                100 // Adjust the offset as needed
                        }, 500);
                    }
                }
            });

        })(jQuery);
    </script>
@endpush
