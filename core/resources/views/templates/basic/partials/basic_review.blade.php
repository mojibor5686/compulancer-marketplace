<li class="reviews-list-item @if (@$review?->user?->id == auth()->user()?->id) active @endif">
    <img class="reviews-list-item__thumb"
        src="{{ getImage(getFilePath('userProfile') . '/' . @$review->user->image, isAvatar: true) }}"
        alt="@lang('client')">
    <div class="reviews-list-item__content">
        <p class="reviews-list-item__name">{{ @$review->user->username }}</p>
        <span class="reviews-list-item__date">{{ showDateTime($review->created_at, 'd M Y') }}</span>
        <div class="reviews-list-item__ratings">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= intval($review->rating))
                    <i class="las la-star"></i>
                @else
                    <i class="lar la-star"></i>
                @endif
            @endfor
        </div>
        <p class="reviews-list-item__desc">{{ __($review->review) }}</p>
    </div>
    @if (@$authUser)
        <div class="reviews-list-item__dropdown">
            <div class="dropdown vertical--dropdown">
                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editReviewModal">
                        <i class="las la-edit fs-18"></i>
                        <span>@lang('Edit')</span>
                    </a>
                    <a class="dropdown-item delete confirmationBtn" href="#"
                        data-action="{{ route('user.review.delete', $review->id) }}" data-question="@lang('Are you sure you want to delete this review?')">
                        <i class="las la-trash fs-18"></i>
                        <span>@lang('Delete')</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
</li>
