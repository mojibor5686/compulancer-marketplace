<article class="card jss--card jss--card-{{ $type }}">
    <a class="card-thumb" href="{{ route("$type.details", [slug($product->name), $product->id]) }}">
        <img src="{{ getImage(getFilePath($type) . '/' . $product->image, getFileSize($type)) }}"
            alt="{{ $product->name }}">
    </a>
    <div class="card-body">
        <div class="card-body__wrapper">
            <div class="card-body__block">
                <img class="card-mobile-thumb"
                    src="{{ getImage(getFilePath($type) . '/' . $product->image, getFileSize($type)) }}"
                    alt="{{ $product->name }}">

                <div>
                    <h6 class="card-title" data-bs-toggle="tooltip" title="{{ $product->name }}">
                        <a
                            href="{{ route("$type.details", [slug($product->name), $product->id]) }}">{{ __($product->name) }}</a>
                    </h6>

                    @if ($type == 'service' || $type == 'software')
                        <ul class="card-meta mt-1">
                            <li class="card-meta__item">
                                <p class="text"><span class="favorite-count">{{ __($product->favorite) }}</span>
                                    @lang('Favorites')</p>
                            </li>

                            <li class="card-meta__item">
                                {{ $product->likes }} @lang('Likes')
                            </li>
                        </ul>
                    @endif

                    @if ($type == 'job')
                        <ul class="card-meta mt-1">
                            <li class="card-meta__item">{{ $product->delivery_time }} @lang('Days')</li>
                            <li class="card-meta__item">{{ $product->total_bid }} @lang('Total Bids')</li>
                        </ul>
                    @endif
                </div>
            </div>

            <x-item view="item-tags" :product="$product" :type="$type" />
            <x-item view="item-top-left" :product="$product" :type="$type" />
            <x-item view="item-top-right" :product="$product" :type="$type" />
        </div>

        <div class="card-footer">
            <x-item view="item-footer-left" :product="$product" :type="$type" />
            <x-item view="item-footer-right" :product="$product" :type="$type" />
        </div>
    </div>
</article>
