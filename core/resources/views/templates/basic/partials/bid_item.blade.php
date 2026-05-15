<li class="reviews-list-item">
    <img class="reviews-list-item__thumb"
        src="{{ getImage(getFilePath('userProfile') . '/' . $biding->user->image, isAvatar: true) }}"
        alt="{{ @$biding->user->username }}">
    <div class="reviews-list-item__content">
        <p class="reviews-list-item__name">
            <a href="{{ route('public.profile', $biding->user->username) }}">{{ $biding->user->username }}</a>
        </p>
        <span class="reviews-list-item__date">{{ showDateTime($biding->created_at, 'd M Y') }}</span>
        <h6 class="reviews-list-item__title">
            {{ __($biding->title) }}</h6>
        <p class="reviews-list-item__desc">
            {{ __($biding->description) }}</p>
        <div class="reviews-list-item__price">
            <strong>@lang('Price'):</strong>
            <span class="highlighted-price">{{ showAmount($biding->price) }}</span>
        </div>
    </div>
</li>
