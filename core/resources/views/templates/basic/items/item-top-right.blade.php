<div class="card-body__block">
    <div class="ratings">
        <div class="ratings-stars">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $product->total_rating)
                    <i class="las la-star"></i>
                @else
                    <i class="lar la-star"></i>
                @endif
            @endfor
        </div>
        @if ($product->total_rating)
            <span class="ratings__total">({{ getAmount($product->total_rating) }})</span>
        @endif
    </div>
    <span class="card-price">{{ gs('cur_sym') }}{{ showAmount($product->price, currencyFormat: false) }}</span>
</div>
