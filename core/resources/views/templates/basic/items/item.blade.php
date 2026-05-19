<article class="card jss--card jss--card-{{ $type }}"
    style="background: #ffffff; border: 1px solid #eef2f5; border-radius: 8px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04); overflow: hidden; display: flex; flex-direction: column; height: 100%; transition: transform 0.2s ease, box-shadow 0.2s ease; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; position: relative;">

    <div style="position: absolute; top: 10px; left: 10px; z-index: 3; display: flex; flex-direction: column; gap: 4px;">
        <x-item view="item-top-left" :product="$product" :type="$type" />
    </div>
    <div style="position: absolute; top: 10px; right: 10px; z-index: 3;">
        <x-item view="item-top-right" :product="$product" :type="$type" />
    </div>

    <a class="card-thumb" href="{{ route("$type.details", [slug($product->name), $product->id]) }}"
        style="display: block; width: 100%; aspect-ratio: 16 / 10; overflow: hidden; background-color: #f7f7f7; position: relative;">
        <img src="{{ getImage(getFilePath($type) . '/' . $product->image, getFileSize($type)) }}"
            alt="{{ $product->name }}"
            style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.3s ease;">
    </a>

    <div class="card-body"
        style="padding: 12px 16px; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;">
        <div class="card-body__wrapper" style="width: 100%;">

            <div style="display: flex; align-items: center; margin-bottom: 8px; font-size: 13px;">
                <x-item view="item-footer-left" :product="$product" :type="$type" />
            </div>

            <h6 class="card-title" data-bs-toggle="tooltip" title="{{ $product->name }}"
                style="margin: 0 0 10px 0; font-size: 14px; font-weight: 500; line-height: 1.4; height: 38px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                <a href="{{ route("$type.details", [slug($product->name), $product->id]) }}"
                    style="color: #222222; text-decoration: none; transition: color 0.2s ease;"
                    onmouseover="this.style.color='#3C88EE'" onmouseout="this.style.color='#222222'">
                    {{ __($product->name) }}
                </a>
            </h6>

            <div
                style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; border-bottom: 1px solid #f4f6f8; padding-bottom: 10px;">

                @if ($type == 'service' || $type == 'software')
                    <div style="display: flex; align-items: center; gap: 12px; font-size: 12px; color: #7a7d85;">
                        <span style="display: flex; align-items: center; gap: 4px;">
                            <svg width="12" height="12" fill="#7a7d85" viewBox="0 0 16 16"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                            </svg>
                            {{ $product->likes ?? 0 }}
                        </span>
                        <span style="display: flex; align-items: center; gap: 3px;">
                            <span style="color: #ffb33e; font-size: 14px; line-height: 1;">★</span>
                            <span style="font-weight: 600; color: #404145;">{{ __($product->favorite ?? 0) }}</span>
                        </span>
                    </div>
                @endif

                @if ($type == 'job')
                    <div style="display: flex; align-items: center; gap: 12px; font-size: 12px; color: #7a7d85;">
                        <span style="display: flex; align-items: center; gap: 4px;">
                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                            </svg>
                            {{ $product->delivery_time }} @lang('Days')
                        </span>
                        <span
                            style="font-weight: 500; color: #3C88EE; background: rgba(60, 136, 238, 0.1); padding: 2px 6px; border-radius: 3px;">
                            {{ $product->total_bid }} @lang('Bids')
                        </span>
                    </div>
                @endif

                <div style="font-size: 11px;">
                    <x-item view="item-tags" :product="$product" :type="$type" />
                </div>
            </div>
        </div>

        <div class="card-footer"
            style="background: none; border: none; padding: 0; display: flex; align-items: center; justify-content: space-between; width: 100%;">
            <div style="display: flex; align-items: center;">
                &nbsp;
            </div>

            <div
                style="text-align: right; font-size: 12px; color: #7a7d85; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                <span
                    style="display: block; font-size: 10px; color: #999999; margin-bottom: -2px; font-weight: 400; text-align: right;">@lang('Starting at')</span>
                <span style="color: #3C88EE;">
                    <x-item view="item-footer-right" :product="$product" :type="$type" />
                </span>
            </div>
        </div>
    </div>
</article>
