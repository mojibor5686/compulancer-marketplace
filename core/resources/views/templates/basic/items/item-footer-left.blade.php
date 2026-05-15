@if ($type == 'service' || $type == 'software')
    <a class="btn btn--sm btn-outline--base make-favorite {{ auth()->check() && $product->favorites->where('user_id', auth()->id())->count() ? 'active' : '' }}"
        href="javascript:void(0);" data-id="{{ $product->id }}" @auth data-auth="true" @endauth
        data-type="@if ($type == 'service') service @else software @endif"
        data-action="{{ route('user.buyer.favorite.store') }}" role="button">
        @include('Template::partials.icons.heart-2')
    </a>
@endif
