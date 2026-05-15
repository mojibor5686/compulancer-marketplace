@php
    $imagePath = getImage(getFilePath($type) . '/' . $fItem->image, getFileSize($type));
@endphp
<li class="small-single-item">
    <div class="thumb">
        <img src="{{ $imagePath }}">
    </div>
    <div class="content">
        <h5 class="title">
            <a href="{{ route("$type.details", [slug($fItem->name), $fItem->id]) }}">{{ __($fItem->name) }}</a>
        </h5>
        <div class="ratings">
            @php echo starRating($fItem->total_review, $fItem->total_rating) @endphp
            <span class="rating">
                @if ($fItem->total_review)
                    ({{ $fItem->total_review }})
                @else
                    (0)
                @endif
            </span>
            <p class="author-like d-inline-flex flex-wrap align-items-center ms-2"><span
                    class="las la-thumbs-up text--base"></span> ({{ __($fItem->likes) }})</p>
        </div>
    </div>
</li>
