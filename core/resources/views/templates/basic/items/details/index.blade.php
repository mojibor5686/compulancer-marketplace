<div class="jss-details-main">
    <div class="jss-details-main__block one">
        <x-item-details view="item-slider" :itemDetails="$itemDetails" :type="$type" />
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>{{ __($itemDetails->name) }}</h2>
                <span>
                    @php echo starRating($itemDetails->total_review, $itemDetails->total_rating) @endphp
                    <span>
                        @if ($itemDetails->total_review)
                            ({{ $itemDetails->total_review }})
                        @endif
                    </span>
                </span>
            </div>
            <div class="d-flex mb-20-none">
                <x-item-details view="item-content-left" :itemDetails="$itemDetails" :type="$type" />
                <x-item-details view="item-content-right" :itemDetails="$itemDetails" :type="$type" />
            </div>
        </div>
    </div>
    <div class="jss-details-main__block two d-lg-none">
    </div>
    <div class="jss-details-main__block three">
        <x-item-details view="item-tab" :itemDetails="$itemDetails" :type="$type" />
    </div>
</div>
