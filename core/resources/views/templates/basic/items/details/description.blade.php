<p>
    @php echo $productDetails->description ?? __('No description available.'); @endphp
</p>

@if ($type != 'job')
    <div class="tags">
        <h6 class="tags__title">@lang('Tags')</h6>
        <div class="tags-list">
            @forelse ($productDetails->tag as $tag)
                <a class="tags-list__tag" href="{{ route('service') }}?tag={{ $tag }}">{{ __($tag) }}</a>

            @empty
                <span class="tags-list__tag">@lang('No tags available')</span>
            @endforelse
        </div>
    </div>
@endif
