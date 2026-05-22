<article class="card jss--card jss--card-{{ $type }}"
    style="background: #ffffff !important; border: 1px solid #eef2f5 !important; border-radius: 4px !important; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04) !important; overflow: hidden !important; display: flex !important; flex-direction: column !important; height: 100% !important; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important; position: relative !important;">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@600;700;800&display=swap" rel="stylesheet">

    <div class="card-top-action-bar"
        style="display: flex !important; align-items: center !important; justify-content: space-between !important; padding: 12px 16px !important; border-bottom: 1px solid #eef2f5 !important; background: #fafbfc !important; flex-wrap: wrap !important; gap: 10px !important;">

        <div class="top-bar-left-buttons"
            style="display: flex !important; align-items: center !important; gap: 6px !important;">
            <a href="javascript:void(0)"
                style="font-size: 12px !important; font-weight: 600 !important; padding: 5px 12px !important; border-radius: 20px !important; text-decoration: none !important; transition: all 0.2s !important; 
                {{ $type == 'service' ? 'background: #3a84ff !important; color: #fff !important;' : 'background: #eef2f5 !important; color: #475569 !important;' }}">
                @lang('Services')
            </a>
            <a href="javascript:void(0)"
                style="font-size: 12px !important; font-weight: 600 !important; padding: 5px 12px !important; border-radius: 20px !important; text-decoration: none !important; transition: all 0.2s !important; 
                {{ $type == 'job' ? 'background: #3a84ff !important; color: #fff !important;' : 'background: #eef2f5 !important; color: #475569 !important;' }}">
                @lang('Jobs')
            </a>
            <a href="javascript:void(0)"
                style="font-size: 12px !important; font-weight: 600 !important; padding: 5px 12px !important; border-radius: 20px !important; text-decoration: none !important; transition: all 0.2s !important; 
                {{ $type == 'software' ? 'background: #3a84ff !important; color: #fff !important;' : 'background: #eef2f5 !important; color: #475569 !important;' }}">
                @lang('Softwares')
            </a>
        </div>

        <div class="page-top__right">
            <div class="layout-toggle-btns"
                style="display: flex !important; align-items: center !important; gap: 5px !important;">
                <button class="layout-toggle-btn grid-layout active" type="button"
                    style="border: 1px solid #cbd5e1 !important; background: #fff !important; padding: 4px 8px !important; border-radius: 4px !important; cursor: pointer !important;">
                    @include('Template::partials.icons.grid')
                </button>
                <button class="layout-toggle-btn list-layout" type="button"
                    style="border: 1px solid #cbd5e1 !important; background: #fff !important; padding: 4px 8px !important; border-radius: 4px !important; cursor: pointer !important;">
                    @include('Template::partials.icons.list')
                </button>
                <button class="layout-toggle-btn toggle-sidebar d-lg-none" type="button"
                    data-toggle="offcanvas-sidebar" data-target="#jss-offcanvas-sidebar"
                    style="border: 1px solid #cbd5e1 !important; background: #fff !important; padding: 4px 10px !important; border-radius: 4px !important; color: #475569 !important; cursor: pointer !important;">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <div
        style="position: relative !important; display: block !important; width: 100% !important; aspect-ratio: 16 / 10 !important; overflow: hidden !important; background: #f8f9fa !important;">
        <a href="{{ route("$type.details", [slug($product->name), $product->id]) }}"
            style="display: block !important; width: 100% !important; height: 100% !important;">
            <img src="{{ getImage(getFilePath($type) . '/' . $product->image, getFileSize($type)) }}"
                alt="{{ $product->name }}"
                style="width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important;">
        </a>
    </div>

    <div
        style="padding: 12px 16px !important; display: flex !important; flex-direction: column !important; flex-grow: 1 !important; justify-content: space-between !important; background: #ffffff !important;">
        <div style="width: 100% !important;">
            <div
                style="display: flex !important; align-items: center !important; justify-content: space-between !important; margin-bottom: 12px !important; padding-bottom: 2px !important;">

                <div onclick="window.open('{{ route('public.profile', ['username' => $product->user->username, 'contact' => 'true']) }}', '_blank')"
                    style="display: flex !important; align-items: center !important; gap: 8px !important; cursor: pointer !important;">
                    <img src="{{ $product->user && $product->user->image ? getImage(getFilePath('userProfile') . '/' . $product->user->image) : asset('assets/images/default.png') }}"
                        alt="Seller"
                        style="width: 32px !important; height: 32px !important; border-radius: 50% !important; object-fit: cover !important; display: block !important; border: 1px solid #e1e4e6 !important;">

                    <div
                        style="display: flex !important; flex-direction: column !important; line-height: 1.2 !important;">
                        <span
                            style="font-size: 13px !important; text-transform: capitalize !important; font-weight: 700 !important; color: #404145 !important; display: block !important; max-width: 110px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;"
                            title="{{ $product->user ? $product->user->username : $product->username ?? 'babsmart_' }}">
                            {{ $product->user ? $product->user->username : $product->username ?? 'babsmart_' }}
                        </span>
                        <span
                            style="font-size: 11px !important; color: #74767e !important; font-weight: 400 !important; text-transform: capitalize;">
                            {{ __($type) }}
                        </span>
                    </div>
                </div>

                @php
                    $cardAvgRating =
                        $product->total_review > 0
                            ? number_format($product->total_rating / $product->total_review, 1)
                            : '0.0';
                @endphp

                <div
                    style="display: flex !important; align-items: center !important; gap: 3px !important; font-size: 12px !important; font-weight: 700 !important; color: #ffb33e !important;">
                    <span style="font-size: 14px !important; line-height: 1 !important;">★</span>
                    <span style="color: #404145 !important;">{{ $cardAvgRating }}</span>
                    <span
                        style="color: #b5b6ba !important; font-weight: 400 !important; font-size: 11px !important;">({{ $product->total_review }})</span>
                </div>
            </div>

            <h6
                style="margin: 0 0 16px 0 !important; text-transform: capitalize; font-size: 14px !important; font-weight: 400 !important; line-height: 1.4 !important; height: 38px !important; overflow: hidden !important; display: -webkit-box !important; -webkit-line-clamp: 2 !important; -webkit-box-orient: vertical !important;">
                <a href="{{ route("$type.details", [slug($product->name), $product->id]) }}"
                    style="color: #404145 !important; text-decoration: none !important; display: block !important; transition: color 0.1s ease !important;"
                    onmouseover="this.style.color='#3C88EE'" onmouseout="this.style.color='#404145'">
                    {{ __($product->name) }}
                </a>
            </h6>
        </div>

        <div
            style="border-top: 1px solid #e4e5e7 !important; padding-top: 10px !important; width: 100% !important; background: #ffffff !important; margin-top: auto !important;">
            <div
                style="text-align: right !important; display: flex !important; flex-direction: row !important; justify-content: space-between; line-height: 1.1 !important;">
                <div
                    style="display: flex; flex-direction: column; justify-content: start; align-items: baseline; gap:5px;">
                    <span
                        style="display: inline-flex !important; align-items: center !important; gap: 4px !important; font-weight: 800 !important; color: #23c366 !important; font-size: 16px !important;">
                        <span
                            style="font-family: 'Roboto', sans-serif !important; font-size: 15px !important; font-weight: 600 !important; margin-right: 1px !important;">৳</span>
                        {{ number_format($product->price, 2) }}
                    </span>
                    <span
                        style="display: block !important; font-size: 10px !important; color: #74767e !important; text-transform: uppercase !important; font-weight: 600 !important; letter-spacing: 0.3px !important; margin-bottom: 2px !important;">@lang('Starting at')</span>
                </div>
                <span style="color: #2b2b2b !important; font-size: 16px !important; font-weight: 700 !important;">
                    <x-item view="item-footer-right" :product="$product" :type="$type" />
                </span>
            </div>
        </div>
    </div>
</article>
