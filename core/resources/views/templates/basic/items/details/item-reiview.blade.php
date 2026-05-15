<div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
    <div class="product-reviews-content">

        <div class="item-review-widget-wrapper">
            <div class="left">
                <h2 class="title text-white">
                    @if ($itemDetails->total_review)
                        {{ showAmount($itemDetails->total_rating / $itemDetails->total_review) }}
                    @else
                        0.00
                    @endif
                </h2>
                <div class="ratings">
                    @php echo starRating($itemDetails->total_review, $itemDetails->total_rating) @endphp
                </div>
                <span class="sub-title text-white">{{ $itemDetails->total_review }} @lang('review(s)')</span>
            </div>
            <div class="right">
                <ul class="list">
                    <li>
                        <span class="caption">
                            <i class="fas fa-thumbs-up text--success"></i> @lang('Total Likes')
                        </span>
                        <span class="value">{{ __($itemDetails->likes) }}</span>
                    </li>
                    <li>
                        <span class="caption">
                            <i class="fas fa-thumbs-down text--danger"></i> @lang('Total Dislikes')
                        </span>
                        <span class="value">{{ __($itemDetails->dislike) }}</span>
                    </li>
                    <li>
                        <span class="caption">
                            <i class="fas fa-heart text--love"></i> @lang('Total Favorite')
                        </span>
                        <span class="value">{{ __($itemDetails->favorite) }}</span>
                    </li>
                </ul>
            </div>
        </div>

        @php
         $reviewPermission = $itemDetails
    ->bookings()
    ->where('buyer_id', auth()->id())
    ->when($itemDetails->service_id != 0, function ($query) {
        $query->where('working_status', Status::WORKING_COMPLETED);
    })
    ->where('review_status', Status::NO)
    ->first();

        @endphp

        @if ($reviewPermission)
            <div class="comment-form-area mb-40">
                <form class="comment-form" action="{{ route('user.review.store') }}" method="POST">
                    @csrf
                    <input name="type" type="hidden" value="{{ $type }}">
                    <input name="booking_id" type="hidden" value="{{ encrypt($reviewPermission->id) }}">
                    <input name="product_id" type="hidden" value="{{ $itemDetails->id }}">

                    <div class="comment-ratings-area d-flex flex-wrap align-items-center justify-content-between">
                        <div class="rating">
                            <input id="star1" name="rating" type="radio" value="5" /><label for="star1">&nbsp;</label>
                            <input id="star2" name="rating" type="radio" value="4" /><label for="star2">&nbsp;</label>
                            <input id="star3" name="rating" type="radio" value="3" /><label for="star3">&nbsp;</label>
                            <input id="star4" name="rating" type="radio" value="2" /><label for="star4">&nbsp;</label>
                            <input id="star5" name="rating" type="radio" value="1" /><label for="star5">&nbsp;</label>
                        </div>

                        <div class="like-dislike">
                            <div class="d-flex flex-wrap align-items-center justify-content-sm-end">
                                <div class="like-dislike me-4">
                                    <input id="review-like" name="like" type="radio" value="1">
                                    <label class="mb-0" for="review-like"><i class="fas fa-thumbs-up"></i></label>
                                </div>
                                <div class="like-dislike">
                                    <input id="review-dislike" name="like" type="radio" value="0">
                                    <label class="mb-0" for="review-dislike"><i class="fas fa-thumbs-down"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <textarea class="form-control h-auto" name="review" placeholder="@lang('Write Review')" rows="8" required></textarea>
                    <button class="submit-btn mt-20" type="submit">@lang('Submit')</button>
                </form>
            </div>
        @endif
        @php
            $forLoadMoreReviewId = $itemDetails->id;
        @endphp
        <div class="row">
            <div class="col-xl-12">
                <h3 class="reviews-title">{{ $itemDetails->total_review }} @lang('reviews')</h3>
                @include('Template::partials.reviews')
            </div>
        </div>
    </div>
</div>
