<div class="card-body__block">
    <div class="card-user-info">
        <img class="card-user-info__thumb"
            src="{{ getImage(getFilePath('userProfile') . '/' . @$product->user->image, isAvatar: true) }}"
            alt="{{ $product->user->username }}">
        <div class="card-user-info__content">
            <a class="card-user-info__name"
                href="{{ route('public.profile', $product->user->username) }}">{{ __($product->user->username) }}</a>
            @if (@$product?->user?->level)
                <span class="badge badge--base">{{ __(ucFirst(@$product?->user?->level?->name)) }}</span>
            @endif
        </div>
    </div>
</div>
