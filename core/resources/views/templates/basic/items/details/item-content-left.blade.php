<div class="jss-details__react-btns d-flex align-items-center gap-2">
    <button class="btn btn--sm btn--base d-flex align-items-center make-favorite" type="button"
        data-id="{{ $itemDetails->id }}" data-type="service">
        @include('Template::partials.icons.heart_two')
        <span class="ms-1">{{ __($itemDetails->favorite) }}</span>
    </button>
    <button class="btn btn--sm btn--success d-flex align-items-center" type="button">
        @include('Template::partials.icons.like_two')
        <span class="ms-1">{{ $itemDetails->likes }}</span>
    </button>

    @if (request()->routeIs('software.details'))
        <a href="{{ $itemDetails->demo_url }}" target="__blank"
            class="btn btn--sm btn--base d-flex align-items-center mt-2">
            <i class="las la-desktop me-1"></i> @lang('Preview')
        </a>
    @endif
</div>
