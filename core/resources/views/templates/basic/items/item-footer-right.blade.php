<div class="card-footer__btn">
    @if ($type == 'service')
        <a class="btn btn--sm btn--base" href="{{ route('service.details', [slug($product->name), $product->id]) }}">
            @include('Template::partials.icons.cart')
            <span>@lang('Order Now')</span>
        </a>
    @elseif ($type == 'software')
        <a class="btn btn--sm btn-outline--base" href="{{ $product->demo_url }}" target="_blank" data-bs-toggle="tooltip"
            title="@lang('Live Url')">
            @include('Template::partials.icons.monitor')
        </a>
        <a class="btn btn--sm btn--base" href="{{ route('software.details', [slug($product->name), $product->id]) }}">
            @include('Template::partials.icons.cart')
            <span>@lang('Buy Now')</span>
        </a>
    @elseif ($type == 'job')
        <a class="btn btn--base" href="{{ route('job.details', [slug($product->name), $product->id]) }}">
            @include('Template::partials.icons.bid')
            <span>@lang('Bid Now')</span>
        </a>
    @endif
</div>
