<div class="jss-details-main__block three">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs custom--tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#des" type="button" role="tab"
                aria-selected="true">
                @lang('Description')
            </button>
        </li>
        @if ($type != 'job')
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab"
                    aria-selected="false" tabindex="-1">
                    @if ($itemDetails->total_review > 0)
                        @lang('Reviews') ({{ $itemDetails->total_review }})
                    @else
                        @lang('Reviews') (0)
                    @endif
                </button>
            </li>
        @else
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#req" type="button" role="tab"
                    aria-selected="false" tabindex="-1">
                    @lang('Requirements')
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bids" type="button" role="tab"
                    aria-selected="false" tabindex="-1">
                    @lang('Bids') ({{ $itemDetails->total_bid }})
                </button>
            </li>
        @endif
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#comment" type="button" role="tab"
                aria-selected="false" tabindex="-1">
                @lang('Comments')
            </button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content">
        <!-- Description Tab -->
        <div class="tab-pane active" id="des" role="tabpanel" tabindex="0">
            <x-item-details view="item-description" :itemDetails="$itemDetails" :type="$type" />
        </div>

        <!-- Reviews or Requirements & Bids Tabs -->
        @if ($type != 'job')
            <div class="tab-pane" id="review" role="tabpanel" tabindex="0">
                <x-item-details view="item-review" :itemDetails="$itemDetails" :type="$type" />
            </div>
        @else
            <div class="tab-pane" id="req" role="tabpanel" tabindex="0">
                <x-item-details view="item-requirements" :itemDetails="$itemDetails" type="job" />
            </div>
            <div class="tab-pane" id="bids" role="tabpanel" tabindex="0">
                <x-item-details view="item-bids" :itemDetails="$itemDetails" type="job" />
            </div>
        @endif

        <!-- Comments Tab -->
        <div class="tab-pane" id="comment" role="tabpanel" tabindex="0">
            <x-item-details view="item-comments" :itemDetails="$itemDetails" :type="$type" />
        </div>
    </div>
</div>
