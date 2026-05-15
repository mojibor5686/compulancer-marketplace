<div class="item-card-thumb">
    <img src=" {{ poster(@$product->image ? getFilePath($type) . '/' . @$product->image : null, false) }}" alt="@lang('Poster')">
    @if ($product->featured)
        <div class="item-level">@lang('Featured')</div>
    @endif
</div>
