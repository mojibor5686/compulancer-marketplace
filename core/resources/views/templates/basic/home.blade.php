@extends('Template::layouts.frontend') @section('content')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">

    <main class="page-wrapper">
        <section class="jss-section pt-40 pb-80">
            <div class="container">

                <section class="kwork-catalog-section py-5">
                    <div class="container">
                        <h2 class="catalog-main-title mb-4">@lang("Explore Compulancer Work's Evergrowing Catalog")</h2>

                        <div class="row g-3 justify-content-center catalog-grid">
                            @foreach ($categories as $category)
                                <div class="col-6 col-sm-4 col-lg-3">
                                    <a href="{{ route('category.wise.product', [slug($category->name), $category->id]) }}"
                                        class="catalog-card-item">
                                        <div class="card-bg-watermark"></div>

                                        <div class="catalog-card-content text-center">
                                            <div class="catalog-icon-wrapper mb-3">
                                                <img src="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}"
                                                    alt="{{ $category->name }}" class="catalog-img" />
                                            </div>
                                            <h3 class="catalog-name">{{ __($category->name) }}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <div class="page-content">
                    <div class="card-top-action-bar"
                        style="display: flex !important; align-items: center !important; justify-content: space-between !important; padding: 12px 16px !important; border-bottom: 1px solid #eef2f5 !important; background: #fafbfc !important; flex-wrap: wrap !important; gap: 10px !important;">

                        <div class="top-bar-left-buttons" id="catalog-trigger-menu"
                            style="display: inline-flex !important; align-items: center !important; gap: 6px !important; border: none !important;">

                            <button class="custom-tab-btn active" data-target="service" type="button"
                                style="font-size: 12px !important; font-weight: 600 !important; padding: 6px 16px !important; border-radius: 20px !important; border: none !important; transition: all 0.2s !important;">
                                <i class="ri-briefcase-line me-1"></i> @lang('Services')
                            </button>

                            <button class="custom-tab-btn" data-target="job" type="button"
                                style="font-size: 12px !important; font-weight: 600 !important; padding: 6px 16px !important; border-radius: 20px !important; border: none !important; transition: all 0.2s !important;">
                                <i class="ri-search-eye-line me-1"></i> @lang('Jobs')
                            </button>

                            <button class="custom-tab-btn" data-target="software" type="button"
                                style="font-size: 12px !important; font-weight: 600 !important; padding: 6px 16px !important; border-radius: 20px !important; border: none !important; transition: all 0.2s !important;">
                                <i class="ri-terminal-window-line me-1"></i> @lang('Softwares')
                            </button>
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

                    <div class="row mt-3">
                        <div class="col-lg-8 col-xl-9 productList">

                            <div class="catalog-data-section jss-active-section" data-section="service">
                                <div class="row gy-4 jss-row">
                                    @php
                                        // কন্ট্রোলারের কনফ্লিক্ট এড়াতে সরাসরি মডেল থেকে লেটেস্ট বা একটিভ সার্ভিস ডেটা লোড
                                        $directServices = \App\Models\Service::with('user')
                                            ->where('status', 1)
                                            ->latest()
                                            ->take(12)
                                            ->get();
                                    @endphp

                                    @forelse($directServices as $product)
                                        <div class="col-md-6 col-xxl-4 productListCol">
                                            <article class="card jss--card jss--card-service"
                                                style="background: #ffffff !important; border: 1px solid #eef2f5 !important; border-radius: 4px !important; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04) !important; overflow: hidden !important; display: flex !important; flex-direction: column !important; height: 100% !important; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important; position: relative !important;">
                                                <link
                                                    href="https://fonts.googleapis.com/css2?family=Roboto:wght@600;700;800&display=swap"
                                                    rel="stylesheet">
                                                <div
                                                    style="position: relative !important; display: block !important; width: 100% !important; aspect-ratio: 16 / 10 !important; overflow: hidden !important; background: #f8f9fa !important;">
                                                    <a href="{{ route('service.details', [slug($product->name), $product->id]) }}"
                                                        style="display: block !important; width: 100% !important; height: 100% !important;">
                                                        <img src="{{ getImage(getFilePath('service') . '/' . $product->image, getFileSize('service')) }}"
                                                            alt="{{ $product->name }}"
                                                            style="width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important;">
                                                    </a>
                                                </div>
                                                <div
                                                    style="padding: 12px 16px !important; display: flex !important; flex-direction: column !important; flex-grow: 1 !important; justify-content: space-between !important; background: #ffffff !important;">
                                                    <div style="width: 100% !important;">
                                                        <div
                                                            style="display: flex !important; align-items: center !important; justify-content: space-between !important; margin-bottom: 12px !important; padding-bottom: 2px !important;">
                                                            <div onclick="window.open('{{ route('public.profile', ['username' => optional($product->user)->username ?? ($product->username ?? 'user'), 'contact' => 'true']) }}', '_blank')"
                                                                style="display: flex !important; align-items: center !important; gap: 8px !important; cursor: pointer !important;">
                                                                <img src="{{ $product->user && $product->user->image ? getImage(getFilePath('userProfile') . '/' . $product->user->image) : asset('assets/images/default.png') }}"
                                                                    alt="Seller"
                                                                    style="width: 32px !important; height: 32px !important; border-radius: 50% !important; object-fit: cover !important; display: block !important; border: 1px solid #e1e4e6 !important;">
                                                                <div
                                                                    style="display: flex !important; flex-direction: column !important; line-height: 1.2 !important;">
                                                                    <span
                                                                        style="font-size: 13px !important; text-transform: capitalize !important; font-weight: 700 !important; color: #404145 !important; display: block !important; max-width: 110px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;">{{ $product->user ? $product->user->username : $product->username ?? 'user' }}</span>
                                                                    <span
                                                                        style="font-size: 11px !important; color: #74767e !important; font-weight: 400 !important; text-transform: capitalize;">@lang('Service')</span>
                                                                </div>
                                                            </div>
                                                            @php $cardAvgRating = ($product->total_review ?? 0) > 0 ? number_format(($product->total_rating ?? 0) / $product->total_review, 1) : '0.0'; @endphp
                                                            <div
                                                                style="display: flex !important; align-items: center !important; gap: 3px !important; font-size: 12px !important; font-weight: 700 !important; color: #ffb33e !important;">
                                                                <span
                                                                    style="font-size: 14px !important; line-height: 1 !important;">★</span>
                                                                <span
                                                                    style="color: #404145 !important;">{{ $cardAvgRating }}</span>
                                                                <span
                                                                    style="color: #b5b6ba !important; font-weight: 400 !important; font-size: 11px !important;">({{ $product->total_review ?? 0 }})</span>
                                                            </div>
                                                        </div>
                                                        <h6
                                                            style="margin: 0 0 16px 0 !important; text-transform: capitalize; font-size: 14px !important; font-weight: 400 !important; line-height: 1.4 !important; height: 38px !important; overflow: hidden !important; display: -webkit-box !important; -webkit-line-clamp: 2 !important; -webkit-box-orient: vertical !important;">
                                                            <a href="{{ route('service.details', [slug($product->name), $product->id]) }}"
                                                                style="color: #404145 !important; text-decoration: none !important; display: block !important;">{{ __($product->name) }}</a>
                                                        </h6>
                                                    </div>
                                                    <div
                                                        style="border-top: 1px solid #e4e5e7 !important; padding-top: 10px !important; width: 100% !important; background: #ffffff !important; margin-top: auto !important;">
                                                        <div
                                                            style="text-align: right !important; display: flex !important; flex-direction: row !important; justify-content: space-between; line-height: 1.1 !important;">
                                                            <div
                                                                style="display: flex; flex-direction: column; justify-content: start; align-items: baseline; gap:5px;">
                                                                <span
                                                                    style="display: inline-flex !important; align-items: center !important; gap: 4px !important; font-weight: 800 !important; color: #23c366 !important; font-size: 16px !important;"><span
                                                                        style="font-family: 'Roboto', sans-serif !important; font-size: 15px !important; font-weight: 600 !important; margin-right: 1px !important;">৳</span>{{ number_format($product->price, 2) }}</span>
                                                                <span
                                                                    style="display: block !important; font-size: 10px !important; color: #74767e !important; text-transform: uppercase !important; font-weight: 600 !important; letter-spacing: 0.3px !important; margin-bottom: 2px !important;">@lang('Starting at')</span>
                                                            </div>
                                                            <span
                                                                style="color: #2b2b2b !important; font-size: 16px !important; font-weight: 700 !important;"><x-item
                                                                    view="item-footer-right" :product="$product"
                                                                    type="service" /></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    @empty
                                        <div class="col-12"><x-basic-empty-message /></div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="catalog-data-section" data-section="job">
                                <div class="row gy-4 jss-row">
                                    @php
                                        $directJobs = \App\Models\Job::with('user')
                                            ->where('status', 1)
                                            ->latest()
                                            ->take(12)
                                            ->get();
                                    @endphp

                                    @forelse($directJobs as $product)
                                        <div class="col-md-6 col-xxl-4 productListCol">
                                            <article class="card jss--card jss--card-job"
                                                style="background: #ffffff !important; border: 1px solid #eef2f5 !important; border-radius: 4px !important; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04) !important; overflow: hidden !important; display: flex !important; flex-direction: column !important; height: 100% !important; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important; position: relative !important;">
                                                <div
                                                    style="position: relative !important; display: block !important; width: 100% !important; aspect-ratio: 16 / 10 !important; overflow: hidden !important; background: #f8f9fa !important;">
                                                    <a href="{{ route('job.details', [slug($product->name), $product->id]) }}"
                                                        style="display: block !important; width: 100% !important; height: 100% !important;">
                                                        <img src="{{ getImage(getFilePath('job') . '/' . $product->image, getFileSize('job')) }}"
                                                            alt="{{ $product->name }}"
                                                            style="width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important;">
                                                    </a>
                                                </div>
                                                <div
                                                    style="padding: 12px 16px !important; display: flex !important; flex-direction: column !important; flex-grow: 1 !important; justify-content: space-between !important; background: #ffffff !important;">
                                                    <div style="width: 100% !important;">
                                                        <div
                                                            style="display: flex !important; align-items: center !important; justify-content: space-between !important; margin-bottom: 12px !important; padding-bottom: 2px !important;">
                                                            <div onclick="window.open('{{ route('public.profile', ['username' => optional($product->user)->username ?? ($product->username ?? 'user'), 'contact' => 'true']) }}', '_blank')"
                                                                style="display: flex !important; align-items: center !important; gap: 8px !important; cursor: pointer !important;">
                                                                <img src="{{ $product->user && $product->user->image ? getImage(getFilePath('userProfile') . '/' . $product->user->image) : asset('assets/images/default.png') }}"
                                                                    alt="Seller"
                                                                    style="width: 32px !important; height: 32px !important; border-radius: 50% !important; object-fit: cover !important; display: block !important; border: 1px solid #e1e4e6 !important;">
                                                                <div
                                                                    style="display: flex !important; flex-direction: column !important; line-height: 1.2 !important;">
                                                                    <span
                                                                        style="font-size: 13px !important; text-transform: capitalize !important; font-weight: 700 !important; color: #404145 !important; display: block !important; max-width: 110px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;">{{ $product->user ? $product->user->username : $product->username ?? 'user' }}</span>
                                                                    <span
                                                                        style="font-size: 11px !important; color: #74767e !important; font-weight: 400 !important; text-transform: capitalize;">@lang('Job')</span>
                                                                </div>
                                                            </div>
                                                            @php $cardAvgRating = ($product->total_review ?? 0) > 0 ? number_format(($product->total_rating ?? 0) / $product->total_review, 1) : '0.0'; @endphp
                                                            <div
                                                                style="display: flex !important; align-items: center !important; gap: 3px !important; font-size: 12px !important; font-weight: 700 !important; color: #ffb33e !important;">
                                                                <span
                                                                    style="font-size: 14px !important; line-height: 1 !important;">★</span>
                                                                <span
                                                                    style="color: #404145 !important;">{{ $cardAvgRating }}</span>
                                                                <span
                                                                    style="color: #b5b6ba !important; font-weight: 400 !important; font-size: 11px !important;">({{ $product->total_review ?? 0 }})</span>
                                                            </div>
                                                        </div>
                                                        <h6
                                                            style="margin: 0 0 16px 0 !important; text-transform: capitalize; font-size: 14px !important; font-weight: 400 !important; line-height: 1.4 !important; height: 38px !important; overflow: hidden !important; display: -webkit-box !important; -webkit-line-clamp: 2 !important; -webkit-box-orient: vertical !important;">
                                                            <a href="{{ route('job.details', [slug($product->name), $product->id]) }}"
                                                                style="color: #404145 !important; text-decoration: none !important; display: block !important;">{{ __($product->name) }}</a>
                                                        </h6>
                                                    </div>
                                                    <div
                                                        style="border-top: 1px solid #e4e5e7 !important; padding-top: 10px !important; width: 100% !important; background: #ffffff !important; margin-top: auto !important;">
                                                        <div
                                                            style="text-align: right !important; display: flex !important; flex-direction: row !important; justify-content: space-between; line-height: 1.1 !important;">
                                                            <div
                                                                style="display: flex; flex-direction: column; justify-content: start; align-items: baseline; gap:5px;">
                                                                <span
                                                                    style="display: inline-flex !important; align-items: center !important; gap: 4px !important; font-weight: 800 !important; color: #23c366 !important; font-size: 16px !important;"><span
                                                                        style="font-family: 'Roboto', sans-serif !important; font-size: 15px !important; font-weight: 600 !important; margin-right: 1px !important;">৳</span>{{ number_format($product->price, 2) }}</span>
                                                                <span
                                                                    style="display: block !important; font-size: 10px !important; color: #74767e !important; text-transform: uppercase !important; font-weight: 600 !important; letter-spacing: 0.3px !important; margin-bottom: 2px !important;">@lang('Starting at')</span>
                                                            </div>
                                                            <span
                                                                style="color: #2b2b2b !important; font-size: 16px !important; font-weight: 700 !important;"><x-item
                                                                    view="item-footer-right" :product="$product"
                                                                    type="job" /></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    @empty
                                        <div class="col-12"><x-basic-empty-message /></div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="catalog-data-section" data-section="software">
                                <div class="row gy-4 jss-row">
                                    @php
                                        $directSoftwares = \App\Models\Software::with('user')
                                            ->where('status', 1)
                                            ->latest()
                                            ->take(12)
                                            ->get();
                                    @endphp

                                    @forelse($directSoftwares as $product)
                                        <div class="col-md-6 col-xxl-4 productListCol">
                                            <article class="card jss--card jss--card-software"
                                                style="background: #ffffff !important; border: 1px solid #eef2f5 !important; border-radius: 4px !important; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04) !important; overflow: hidden !important; display: flex !important; flex-direction: column !important; height: 100% !important; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important; position: relative !important;">
                                                <div
                                                    style="position: relative !important; display: block !important; width: 100% !important; aspect-ratio: 16 / 10 !important; overflow: hidden !important; background: #f8f9fa !important;">
                                                    <a href="{{ route('software.details', [slug($product->name), $product->id]) }}"
                                                        style="display: block !important; width: 100% !important; height: 100% !important;">
                                                        <img src="{{ getImage(getFilePath('software') . '/' . $product->image, getFileSize('software')) }}"
                                                            alt="{{ $product->name }}"
                                                            style="width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important;">
                                                    </a>
                                                </div>
                                                <div
                                                    style="padding: 12px 16px !important; display: flex !important; flex-direction: column !important; flex-grow: 1 !important; justify-content: space-between !important; background: #ffffff !important;">
                                                    <div style="width: 100% !important;">
                                                        <div
                                                            style="display: flex !important; align-items: center !important; justify-content: space-between !important; margin-bottom: 12px !important; padding-bottom: 2px !important;">
                                                            <div onclick="window.open('{{ route('public.profile', ['username' => optional($product->user)->username ?? ($product->username ?? 'user'), 'contact' => 'true']) }}', '_blank')"
                                                                style="display: flex !important; align-items: center !important; gap: 8px !important; cursor: pointer !important;">
                                                                <img src="{{ $product->user && $product->user->image ? getImage(getFilePath('userProfile') . '/' . $product->user->image) : asset('assets/images/default.png') }}"
                                                                    alt="Seller"
                                                                    style="width: 32px !important; height: 32px !important; border-radius: 50% !important; object-fit: cover !important; display: block !important; border: 1px solid #e1e4e6 !important;">
                                                                <div
                                                                    style="display: flex !important; flex-direction: column !important; line-height: 1.2 !important;">
                                                                    <span
                                                                        style="font-size: 13px !important; text-transform: capitalize !important; font-weight: 700 !important; color: #404145 !important; display: block !important; max-width: 110px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;">{{ $product->user ? $product->user->username : $product->username ?? 'user' }}</span>
                                                                    <span
                                                                        style="font-size: 11px !important; color: #74767e !important; font-weight: 400 !important; text-transform: capitalize;">@lang('Software')</span>
                                                                </div>
                                                            </div>
                                                            @php $cardAvgRating = ($product->total_review ?? 0) > 0 ? number_format(($product->total_rating ?? 0) / $product->total_review, 1) : '0.0'; @endphp
                                                            <div
                                                                style="display: flex !important; align-items: center !important; gap: 3px !important; font-size: 12px !important; font-weight: 700 !important; color: #ffb33e !important;">
                                                                <span
                                                                    style="font-size: 14px !important; line-height: 1 !important;">★</span>
                                                                <span
                                                                    style="color: #404145 !important;">{{ $cardAvgRating }}</span>
                                                                <span
                                                                    style="color: #b5b6ba !important; font-weight: 400 !important; font-size: 11px !important;">({{ $product->total_review ?? 0 }})</span>
                                                            </div>
                                                        </div>
                                                        <h6
                                                            style="margin: 0 0 16px 0 !important; text-transform: capitalize; font-size: 14px !important; font-weight: 400 !important; line-height: 1.4 !important; height: 38px !important; overflow: hidden !important; display: -webkit-box !important; -webkit-line-clamp: 2 !important; -webkit-box-orient: vertical !important;">
                                                            <a href="{{ route('software.details', [slug($product->name), $product->id]) }}"
                                                                style="color: #404145 !important; text-decoration: none !important; display: block !important;">{{ __($product->name) }}</a>
                                                        </h6>
                                                    </div>
                                                    <div
                                                        style="border-top: 1px solid #e4e5e7 !important; padding-top: 10px !important; width: 100% !important; background: #ffffff !important; margin-top: auto !important;">
                                                        <div
                                                            style="text-align: right !important; display: flex !important; flex-direction: row !important; justify-content: space-between; line-height: 1.1 !important;">
                                                            <div
                                                                style="display: flex; flex-direction: column; justify-content: start; align-items: baseline; gap:5px;">
                                                                <span
                                                                    style="display: inline-flex !important; align-items: center !important; gap: 4px !important; font-weight: 800 !important; color: #23c366 !important; font-size: 16px !important;"><span
                                                                        style="font-family: 'Roboto', sans-serif !important; font-size: 15px !important; font-weight: 600 !important; margin-right: 1px !important;">৳</span>{{ number_format($product->price, 2) }}</span>
                                                                <span
                                                                    style="display: block !important; font-size: 10px !important; color: #74767e !important; text-transform: uppercase !important; font-weight: 600 !important; letter-spacing: 0.3px !important; margin-bottom: 2px !important;">@lang('Starting at')</span>
                                                            </div>
                                                            <span
                                                                style="color: #2b2b2b !important; font-size: 16px !important; font-weight: 700 !important;"><x-item
                                                                    view="item-footer-right" :product="$product"
                                                                    type="software" /></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    @empty
                                        <div class="col-12"><x-basic-empty-message /></div>
                                    @endforelse
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 col-xl-3">
                            @include('Template::partials.filter')
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <style>
        /* 🔴 ডাটা সেকশন কন্ট্রোল করার জন্য ১০০% সিকিউর সিএসএস লজিক */
        .catalog-data-section {
            display: none !important;
            /* ডিফল্ট সব সেকশন ফোর্স হাইড থাকবে */
        }

        .catalog-data-section.jss-active-section {
            display: block !important;
            /* শুধুমাত্র একটিভ সেকশনটি ফোর্স শো হবে */
        }

        /* বাটন স্টাইল */
        .custom-tab-btn {
            background-color: #eef2f5 !important;
            color: #475569 !important;
        }

        .custom-tab-btn:hover {
            background-color: #e2e8f0 !important;
            color: #1e293b !important;
        }

        .custom-tab-btn.active {
            background-color: #3a84ff !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(58, 132, 255, 0.25) !important;
        }

        .custom-tab-btn i {
            vertical-align: middle;
        }
    </style>

    <style>
        /* 🔴 নতুন এবং ১০০% বুলেটপ্রুফ হাইড/শো মেথড */
        .catalog-data-section {
            position: absolute !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            height: 0 !important;
            overflow: hidden !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .catalog-data-section.jss-active-section {
            position: relative !important;
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            height: auto !important;
            overflow: visible !important;
        }

        /* বাটন স্টাইল */
        .custom-tab-btn {
            background-color: #eef2f5 !important;
            color: #475569 !important;
            cursor: pointer !important;
        }

        .custom-tab-btn:hover {
            background-color: #e2e8f0 !important;
            color: #1e293b !important;
        }

        .custom-tab-btn.active {
            background-color: #3a84ff !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(58, 132, 255, 0.25) !important;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("🚀 Secure Catalog Script Loaded!");

            const triggerButtons = document.querySelectorAll('#catalog-trigger-menu .custom-tab-btn');
            const dataSections = document.querySelectorAll('.catalog-data-section');

            triggerButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const targetValue = this.getAttribute('data-target');

                    // ১. বাটন একটিভ টগল
                    triggerButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // ২. সেকশন শো/হাইড লজিক (CSS + HTML Attribute দুইটাই একসাথে হ্যান্ডেল করবে)
                    dataSections.forEach(function(section) {
                        if (section.getAttribute('data-section') === targetValue) {
                            section.classList.add('jss-active-section');
                            section.removeAttribute(
                            'hidden'); // ব্যাকআপ হিসেবে বুটস্ট্র্যাপ/এইচটিএমএল হিডেন রিমুভ
                        } else {
                            section.classList.remove('jss-active-section');
                            section.setAttribute('hidden', 'true'); // ফোর্স হাইড
                        }
                    });
                });
            });

            // পেজ লোডের সময় প্রথম ডিফ্লট সিলেকশন নিশ্চিত করা
            const activeBtn = document.querySelector('#catalog-trigger-menu .custom-tab-btn.active');
            if (activeBtn) {
                activeBtn.click();
            }
        });
    </script>
    <style>
        .cta-section {
            background-color: #e8f9ee;
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
            padding: 80px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-title {
            color: #333333;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .cta-subtitle {
            color: #555555;
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 40px;
        }

        .btn-signup {
            background-color: #3C88EE;
            color: #ffffff;
            font-weight: 600;
            padding: 14px 35px;
            border-radius: 8px;
            border: none;
            transition: all 0.3s ease;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(40, 199, 111, 0.2);
        }

        .btn-signup:hover {
            background-color: #3C88EE;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(60, 136, 238, 0.3);
        }

        .kwork-catalog-section {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        .catalog-main-title {
            font-size: 24px;
            font-weight: 700;
            color: #222222;
            letter-spacing: -0.3px;
        }

        .catalog-card-item {
            display: block;
            position: relative;
            background-color: #f6f6f6;
            border: 1px solid transparent;
            border-radius: 12px;
            padding: 24px 15px;
            text-decoration: none !important;
            overflow: hidden;
            height: 100%;
            min-height: 155px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.01);
        }

        .catalog-card-content {
            position: relative;
            z-index: 3;
            width: 100%;
        }

        .card-bg-watermark {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0l30 30-30 30L0 30z' fill='%23ededed' fill-opacity='0.5' fill-rule='evenodd'/%3E%3C/svg%3E");
            background-repeat: repeat;
            opacity: 0.7;
            z-index: 1;
            transition: opacity 0.25s ease;
        }

        .catalog-icon-wrapper {
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .catalog-img {
            max-height: 100%;
            max-width: 85px;
            object-fit: contain;
            transition: transform 0.25s ease;
        }

        .catalog-name {
            font-size: 14px;
            font-weight: 600;
            color: #222222;
            margin: 0;
            line-height: 1.3;
            transition: color 0.25s ease;
        }

        .catalog-card-item:hover {
            background-color: #ffffff;
            border-color: #3C88EE;
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(60, 136, 238, 0.08);
        }

        .catalog-card-item:hover .catalog-name {
            color: #3C88EE;
        }

        .catalog-card-item:hover .catalog-img {
            transform: scale(1.05);
        }

        .catalog-card-item:hover .card-bg-watermark {
            opacity: 0.3;
        }

        @media (max-width: 991.98px) {
            .catalog-main-title {
                font-size: 20px;
                text-align: left;
                margin-left: 5px;
            }

            .catalog-card-item {
                padding: 20px 10px;
                min-height: 140px;
            }

            .catalog-img {
                max-height: 50px;
            }

            .catalog-name {
                font-size: 13px;
            }
        }

        @media (max-width: 768px) {
            .cta-title {
                font-size: 1.75rem;
            }

            .cta-section {
                padding: 60px 15px;
            }
        }

        @media (max-width: 575.98px) {

            .catalog-grid {
                --bs-gutter-x: 0.5rem !important;
                --bs-gutter-y: 0.5rem !important;
            }

            .catalog-card-item {
                border-radius: 10px;
                padding: 16px 8px;
                min-height: 130px;
            }

            .catalog-img {
                max-height: 45px;
            }

            .catalog-name {
                font-size: 12px;
            }
        }
    </style>

    <section class="how-it-works-section"
        style="background-color: #f7f9fa; padding: 80px 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <div class="container">

            <div class="row mb-5">
                <div class="col-12 text-center text-lg-start">
                    <h2
                        style="font-size: 28px; font-weight: 700; color: #222222; margin-bottom: 8px; letter-spacing: -0.5px;">
                        @lang('Discover how easy it is to get things done')
                    </h2>
                    <p style="font-size: 16px; color: #404145; font-weight: 500; margin: 0;">
                        @lang('Perfect for your personal and business goals!')
                    </p>
                </div>
            </div>

            <div class="row justify-content-center" style="position: relative;">

                <div class="col-xl-4 col-lg-4 col-md-6 mb-4 position-relative text-center">
                    <div class="step-arrow-down d-none d-lg-block"></div>

                    <div class="step-card-wrapper">
                        <div class="icon-circle-box">
                            <i class="las la-search-dollar"></i>
                        </div>
                        <h4 class="step-title">@lang('Find a freelancer')</h4>
                        <p class="step-desc">
                            @lang('Explore thousands of professional services for every budget.')
                        </p>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6 mb-4 position-relative text-center">
                    <div class="step-arrow-up d-none d-lg-block"></div>

                    <div class="step-card-wrapper">
                        <div class="icon-circle-box">
                            <i class="las la-handshake"></i>
                        </div>
                        <h4 class="step-title">@lang('Shop with confidence')</h4>
                        <p class="step-desc">
                            @lang("Always know prices and deadlines upfront. Your payment isn't released until you approve the work.")
                        </p>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6 mb-4 position-relative text-center">
                    <div class="step-arrow-loop d-none d-lg-block"></div>

                    <div class="step-card-wrapper">
                        <div class="icon-circle-box">
                            <i class="las la-award"></i>
                        </div>
                        <h4 class="step-title">@lang('Get quality results')</h4>
                        <p class="step-desc">
                            @lang('Our 100% Money Back Guarantee ensures top-quality work delivered on time or your money back.')
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    @push('style')
        <style>
            .step-card-wrapper {
                padding: 0 25px;
                z-index: 2;
                position: relative;
            }

            .icon-circle-box {
                width: 110px;
                height: 110px;
                background: #ffffff;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 24px;
                box-shadow: 0 10px 30px rgba(60, 136, 238, 0.12);
                border: 1px solid rgba(60, 136, 238, 0.05);
                position: relative;
                transition: transform 0.3s ease;
            }

            .icon-circle-box:hover {
                transform: translateY(-5px);
            }

            .icon-circle-box i {
                font-size: 42px;
                color: #0073ec;
            }

            .step-title {
                font-size: 18px;
                font-weight: 700;
                color: #222222;
                margin-bottom: 12px;
            }

            .step-desc {
                font-size: 14px;
                color: #555555;
                line-height: 1.6;
                max-width: 290px;
                margin: 0 auto;
            }

            .step-arrow-down {
                position: absolute;
                width: 133px;
                height: 57px;
                top: 45px;
                right: -65px;
                background-repeat: no-repeat;
                background-size: contain;
                z-index: 1;
            }

            .step-arrow-up {
                position: absolute;
                width: 132px;
                height: 57px;
                top: 10px;
                right: -65px;
                background-repeat: no-repeat;
                background-size: contain;
                z-index: 1;
            }

            .step-arrow-loop {
                position: absolute;
                width: 270px;
                height: 112px;
                top: 75px;
                left: -135px;
                background-repeat: no-repeat;
                background-size: contain;
                z-index: 1;
            }

            @media (min-width: 1200px) {
                .row.justify-content-center {
                    max-width: 1140px;
                    margin: 0 auto;
                }
            }
        </style>
    @endpush

    <section class="portfolio-slider-section d-none d-lg-block">
        <div class="container-fluid" style="max-width: 1280px; padding: 0 30px;">

            <h2 class="section-title">@lang('Get inspired with projects created by our freelancers')</h2>

            <div class="slider-relative-wrapper">
                <div class="swiper portfolioSwiper">
                    <div class="swiper-wrapper">
                        @forelse($services as $product)
                            <div class="swiper-slide">
                                <div class="portfolio-card">
                                    <a href="{{ route('service.details', [slug($product->name), $product->id]) }}"
                                        class="portfolio-card-link">
                                        <div class="portfolio-img-box">
                                            <img src="{{ getImage(getFilePath('service') . '/' . $product->image, getFileSize(@$type)) }}"
                                                alt="{{ __($product->title) }}">
                                        </div>
                                    </a>

                                    <div class="card-footer-profile">
                                        <img src="{{ getImage(getFilePath('userProfile') . '/' . @$product->user->image, isAvatar: true) }}"
                                            class="freelancer-avatar" alt="Avatar">

                                        <div class="freelancer-info">
                                            <span>@lang('Freelancer:')</span>

                                            @if ($product->user)
                                                <a href="{{ route('public.profile', $product->user->username) }}"
                                                    class="freelancer-link">
                                                    {{ __($product->user->username) }}
                                                </a>
                                            @else
                                                <span class="text-muted">@lang('Unknown')</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <div class="text-center text-muted py-4">
                                    @lang('No portfolios available.')
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>

        </div>
    </section>

    @push('style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <style>
            .portfolio-slider-section {
                background-color: #ffffff;
                padding: 60px 0;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                position: relative;
            }

            .section-title {
                font-size: 24px;
                font-weight: 700;
                color: #222222;
                margin-bottom: 30px;
                letter-spacing: -0.5px;
            }

            .slider-relative-wrapper {
                position: relative;
                padding: 0px;
            }

            .portfolio-card-link {
                display: block;
                width: 100%;
            }

            .portfolio-card {
                background: #ffffff;
                border: 1px solid #eef1f3;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                height: 100%;
            }

            .portfolio-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            }

            .portfolio-img-box {
                width: 100%;
                height: 200px;
                overflow: hidden;
                background-color: #f7f9fa;
            }

            .portfolio-img-box img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .card-footer-profile {
                padding: 14px 16px;
                display: flex;
                align-items: center;
                gap: 10px;
                border-top: 1px solid #f4f6f8;
                background-color: #ffffff;
            }

            .freelancer-avatar {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                object-fit: cover;
            }

            .freelancer-info {
                font-size: 13px;
                color: #555555;
            }

            .freelancer-info span {
                color: #999999;
            }

            .freelancer-link {
                color: #0073ec;
                text-decoration: none;
                font-weight: 600;
                transition: color 0.2s;
                position: relative;
                z-index: 2;
                /* যেন ক্লিকেবল থাকে */
            }

            .freelancer-link:hover {
                text-decoration: underline;
                color: #0056b3;
            }

            .portfolio-slider-section .swiper-button-next,
            .portfolio-slider-section .swiper-button-prev {
                width: 40px;
                height: 40px;
                background: #ffffff;
                border: 1px solid #e4e8eb;
                border-radius: 50%;
                color: #333333;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
                transition: all 0.2s ease;
                z-index: 10;
            }

            .portfolio-slider-section .swiper-button-next:after,
            .portfolio-slider-section .swiper-button-prev:after {
                font-size: 14px;
                font-weight: bold;
            }

            .portfolio-slider-section .swiper-button-next:hover,
            .portfolio-slider-section .swiper-button-prev:hover {
                background: #f7f9fa;
                color: #0073ec;
                border-color: #ccd4da;
            }

            .portfolio-slider-section .swiper-button-prev {
                left: -20px;
            }

            .portfolio-slider-section .swiper-button-next {
                right: -20px;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var swiper = new Swiper(".portfolioSwiper", {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    loop: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2
                        },
                        992: {
                            slidesPerView: 3
                        },
                        1200: {
                            slidesPerView: 4
                        }
                    }
                });
            });
        </script>
    @endpush

    <section class="solutions-section"
        style="background-color: #ffffff; padding: 80px 0; padding-top:40px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 col-12 order-1">
                    <h2 class="solutions-heading">
                        @lang('Intelligent business solutions for entrepreneurs')
                    </h2>

                    <div class="solutions-list mt-4">
                        <div class="solution-item d-flex align-items-start gap-3">
                            <div class="check-icon-box">
                                <i class="las la-check"></i>
                            </div>
                            <div>
                                <h4 class="item-title">@lang('Scaling Made Easy')</h4>
                                <p class="item-desc">@lang('Find professional talent to boost your conversion, sales, and traffic.')</p>
                            </div>
                        </div>

                        <div class="solution-item d-flex align-items-start gap-3">
                            <div class="check-icon-box">
                                <i class="las la-check"></i>
                            </div>
                            <div>
                                <h4 class="item-title">@lang('Outsource & Save (up to 87%!)')</h4>
                                <p class="item-desc">@lang('Dramatically reduce your expenses with fixed-price freelance services for every budget.')</p>
                            </div>
                        </div>

                        <div class="solution-item d-flex align-items-start gap-3">
                            <div class="check-icon-box">
                                <i class="las la-check"></i>
                            </div>
                            <div>
                                <h4 class="item-title">@lang('Focus on Priorities')</h4>
                                <p class="item-desc">@lang('Spend up to 75% less time on business tasks and focus on what really matters for growth.')</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12 order-2 mt-4 mt-lg-0">
                    <div class="video-block-wrapper">
                        <div class="video-poster-layer"
                            style="background-image: url('https://cdn.kwork.com/images/index/video-preview.jpg');">
                            <div class="video-overlay">
                                <div class="video-logo-text" style="text-transform: uppercase">compulancer<span
                                        style="display:block; font-size:10px; font-weight:400; letter-spacing:2px; color:#ddd;">PROFESSIONAL
                                        SERVICES</span></div>

                                <button class="play-trigger-btn" data-bs-toggle="modal"
                                    data-bs-target="#kworkVideoModal">
                                    <i class="las la-play"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="kworkVideoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: transparent; border: none;">
                <div class="modal-header border-0 p-0 justify-content-end">
                    <button type="button" class="btn-close btn-close-white mb-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9" style="border-radius: 16px; overflow: hidden;">
                        <video controls id="kworkVideo">
                            <source src="YOUR_VIDEO_FILE_PATH_HERE.mp4" type="video/mp4">
                            @lang('Your browser does not support the video tag.')
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('style')
        <style>
            .solutions-heading {
                font-size: 28px;
                font-weight: 700;
                color: #222222;
                line-height: 1.3;
                letter-spacing: -0.5px;
                max-width: 480px;
            }

            .solution-item {
                margin-bottom: 28px;
            }

            .solution-item:last-child {
                margin-bottom: 0;
            }

            .check-icon-box {
                color: #1dbf73;
                font-size: 18px;
                font-weight: 900;
                margin-top: 2px;
            }

            .item-title {
                font-size: 16px;
                font-weight: 700;
                color: #222222;
                margin-bottom: 6px;
            }

            .item-desc {
                font-size: 14px;
                color: #555555;
                line-height: 1.5;
                margin: 0;
                max-width: 440px;
            }

            .video-block-wrapper {
                position: relative;
                width: 100%;
                padding-top: 56.25%;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            }

            .video-poster-layer {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            .video-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.15);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .video-logo-text {
                position: absolute;
                text-align: center;
                color: #ffffff;
                font-size: 32px;
                font-weight: 800;
                letter-spacing: 4px;
                opacity: 0.9;
                pointer-events: none;
                user-select: none;
            }

            .play-trigger-btn {
                width: 70px;
                height: 70px;
                background: rgba(0, 0, 0, 0.5);
                border: 2px solid rgba(255, 255, 255, 0.7);
                border-radius: 50%;
                color: #ffffff;
                font-size: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 3;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                padding-left: 5px;
            }

            .play-trigger-btn:hover {
                background: rgba(0, 0, 0, 0.7);
                transform: scale(1.1);
                border-color: #ffffff;
            }

            @media (max-width: 991px) {
                .solutions-heading {
                    font-size: 24px;
                    max-width: 100%;
                }

                .solutions-section {
                    padding: 40px 0;
                }

                .video-block-wrapper {
                    margin-top: 15px;
                }

                .video-logo-text {
                    font-size: 24px;
                }

                .play-trigger-btn {
                    width: 55px;
                    height: 55px;
                    font-size: 22px;
                }
            }
        </style>
    @endpush

    @push('script')
        <script>
            document.getElementById('kworkVideoModal').addEventListener('hidden.bs.modal', function() {
                document.getElementById('kworkVideo').pause();
            });
        </script>
    @endpush

    <section class="cta-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="cta-title">Start saving with freelance services today</h2>
                    <p class="cta-subtitle">Speed, quality, and affordability: you can have it all!</p>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#signUpModal"
                        class="btn btn-signup">Sign
                        up for Free</a>
                </div>
            </div>
        </div>
    </section>
@endsection
