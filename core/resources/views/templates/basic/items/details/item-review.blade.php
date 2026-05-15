<div class="tab-pane active" id="jss-details-tab-2" role="tabpanel" tabindex="0">
    <div class="reviews">
        <div class="reviews-top">
            <div class="reviews-top__left">
                <h5 class="reviews__tip">
                    @if ($itemDetails->total_review)
                        {{ showAmount($itemDetails->total_rating / $itemDetails->total_review) }}
                    @else
                        0.00
                    @endif
                </h5>
                <div class="reviews__ratings">
                    @php echo starRating($itemDetails->total_review, $itemDetails->total_rating) @endphp
                </div>
                <span class="reviews__total">
                    @if ($itemDetails->total_review)
                        {{ $itemDetails->total_review }} @lang('Reviews')
                    @else
                        0 @lang('Reviews')
                    @endif
                </span>
            </div>
            <div class="reviews-top__right">
                <ul class="reviews-info">
                    <li class="reviews-info__item">
                        <div class="wrapper">
                            <i class="far fa-thumbs-up"></i>
                            <span class="label">@lang('Total Likes')</span>
                        </div>
                        <span class="total">{{ __($itemDetails->likes) }}</span>
                    </li>
                    <li class="reviews-info__item">
                        <div class="wrapper">
                            <i class="far fa-thumbs-down"></i>
                            <span class="label">@lang('Total Dislikes')</span>
                        </div>
                        <span class="total">{{ __($itemDetails->dislike) }}</span>
                    </li>
                    <li class="reviews-info__item">
                        <div class="wrapper">
                            <i class="far fa-heart"></i>
                            <span class="label">@lang('Total Favorites')</span>
                        </div>
                        <span class="total">{{ __($itemDetails->favorite) }}</span>
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
                            @for ($i = 5; $i >= 1; $i--)
                                <input id="star{{ $i }}" name="rating" type="radio"
                                    value="{{ $i }}">
                                <label for="star{{ $i }}">&nbsp;</label>
                            @endfor
                        </div>

                        <div class="like-dislike">
                            <div class="d-flex flex-wrap align-items-center justify-content-end">
                                <div class="like-dislike me-4">
                                    <input id="review-like" name="like" type="radio" value="1">
                                    <label for="review-like"><i class="fas fa-thumbs-up"></i></label>
                                </div>
                                <div class="like-dislike">
                                    <input id="review-dislike" name="like" type="radio" value="0">
                                    <label for="review-dislike"><i class="fas fa-thumbs-down"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <textarea class="form-control form--control review-textarea" name="review" placeholder="@lang('Write Review')" rows="8"
                        required></textarea>
                    <button class="submit-btn mt-20 review-submit" type="submit">@lang('Submit')</button>
                </form>
            </div>
        @endif

        <div class="reviews-bottom">
            <h6 class="reviews__total">{{ $itemDetails->total_review }} @lang('Reviews')</h6>
            @include('Template::partials.reviews')
        </div>
    </div>
</div>
