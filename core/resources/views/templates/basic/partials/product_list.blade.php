<div class="row gy-4 jss-row">
    @include('Template::partials.loader')

    @forelse(@$products ?? [] as $product)
        <div class="col-md-6 col-xxl-4 productListCol">
            <x-item :product="$product" :type="$type" />
        </div>
    @empty
        <x-basic-empty-message />
    @endforelse
</div>

@if (@$products && @$products->hasPages())
    <div class="mt-4">
        {{ paginateLinks(@$products) }}
    </div>
@endif
