<div class="tab-pane" id="bids" role="tabpanel">
    @if ($itemDetails->jobBidings->count())
        <div class="item-card-wrapper mt-30">
            @foreach ($itemDetails->jobBidings as $biding)
                <div class="item-card">
                    <div>
                        <div>
                            <div class="d-flex justify-content-between">
                                <h3>{{ __($biding->title) }}</h3>
                                <div>{{ showAmount($biding->price) }}</div>
                            </div>
                            <p>{{ __($biding->description) }}</p>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . $biding->user->image, isAvatar: true) }}"
                                        alt="@lang('bidder')">
                                    <div>
                                        <h5>
                                            <a
                                                href="{{ route('public.profile', $biding->user->username) }}">{{ $biding->user->username }}</a>
                                            <span>{{ $biding->user->level?->name }}</span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if (count($itemDetails->jobBidings) > 5)
            <div class="text-center mt-4">
                <button type="button">@lang('View More')</button>
            </div>
        @endif
    @else
        <x-basic-empty-message />
    @endif
</div>
