<div class="tab-pane active" id="des" role="tabpanel">
    <div>
        <p>
            @php echo $itemDetails->description @endphp
        </p>
    </div>

    @if ($type != 'job')
        <div class="tags">
            <h6 class="tags__title">@lang('Tags')</h6>
            <div class="tags-list">
                @foreach ($itemDetails->tag as $tag)
                    <a class="tags-list__tag" href="{{ route($type) }}?tag={{ $tag }}">{{ __($tag) }}</a>
                @endforeach
            </div>
        </div>
    @endif
</div>
