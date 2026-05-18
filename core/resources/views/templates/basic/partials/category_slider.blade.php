@php
    $freelancers = [
        [
            'name' => 'Lilith',
            'role' => 'Web Developer',
            'image' => 'https://cdn.kwork.com/images/index/banner-user-5.png?ver=6',
        ],
        [
            'name' => 'Eugene',
            'role' => 'Voice Actor',
            'image' => 'https://cdn.kwork.com/images/index/banner-user-6.png?ver=6',
        ],
        [
            'name' => 'Lilith',
            'role' => 'Web Developer',
            'image' => 'https://cdn.kwork.com/images/index/banner-user-5.png?ver=6',
        ],
        [
            'name' => 'Eugene',
            'role' => 'Voice Actor',
            'image' => 'https://cdn.kwork.com/images/index/banner-user-6.png?ver=6',
        ],
        [
            'name' => 'Lilith',
            'role' => 'Web Developer',
            'image' => 'https://cdn.kwork.com/images/index/banner-user-5.png?ver=6',
        ],
        [
            'name' => 'Eugene',
            'role' => 'Voice Actor',
            'image' => 'https://cdn.kwork.com/images/index/banner-user-6.png?ver=6',
        ],
    ];
    $randomFreelancer = $freelancers[array_rand($freelancers)];
@endphp
<style>
    .kwork-hero-section {
        background-color: #e4f7ee;
        height: 480px;
        position: relative;
    }

    .hero-bg-pattern {
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M40 0l40 40-40 40L0 40z' fill='%23d1eedf' fill-opacity='0.4' fill-rule='evenodd'/%3E%3C/svg%3E");
        background-repeat: repeat;
        opacity: 0.8;
        z-index: 1;
    }

    .z-index-2 {
        z-index: 2;
    }

    .hero-title {
        font-size: 38px;
        font-weight: 700;
        color: #222222 !important;
        line-height: 1.25;
    }

    .hero-search-wrapper {
        max-width: 600px;
        width: 100%;
    }

    .hero-search-wrapper .input-group {
        border-radius: 8px !important;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        border: 1px solid #dcdcdc;
    }

    .hero-search-wrapper .input-group-text {
        border: none;
        font-size: 16px;
    }

    .search-icon-main {
        color: #999999;
    }

    .hero-search-wrapper .form-control {
        border: none;
        font-size: 15px;
        color: #333;
        padding: 14px 10px;
    }

    .hero-search-wrapper .form-control::placeholder {
        color: #a0a0a0;
    }

    .btn-kwork-search {
        background-color: #10c469 !important;
        color: #ffffff !important;
        border: none;
        font-weight: 600;
        font-size: 15px;
        padding: 0 35px;
        transition: background-color 0.2s ease;
    }

    .btn-kwork-search:hover {
        background-color: #0eb35f !important;
    }

    .popular-title {
        font-size: 13px;
        font-weight: 600;
    }

    .tag-link {
        font-size: 12px;
        color: #444444;
        background-color: rgba(255, 255, 255, 0.7);
        border: 1px solid #ced4da;
        padding: 4px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .tag-link i {
        font-size: 10px;
        color: #888;
    }

    .tag-link:hover {
        background-color: #ffffff;
        border-color: #10c469;
        color: #10c469;
    }

    .freelancer-image-wrapper {
        position: absolute;
        bottom: 0;
        right: 15px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
    }

    .hero-freelancer-img {
        max-height: 440px;
        width: auto;
        object-fit: contain;
        display: block;
    }

    .freelancer-info-badge {
        position: absolute;
        bottom: 20px;
        text-align: center;
        width: 100%;
        z-index: 5;
    }

    .rating-stars i {
        font-size: 11px;
        margin: 0 1px;
    }

    .freelancer-meta {
        font-size: 12px;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.6);
        opacity: 0.95;
    }

    .hero-bottom-shadow {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 80px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.15) 0%, rgba(0, 0, 0, 0) 100%);
        pointer-events: none;
        z-index: 1;
    }

    @media (max-width: 991.98px) {
        .kwork-hero-section {
            height: auto;
            padding: 30px 0;
        }

        .hero-bg-pattern {
            width: 100%;
        }

        .hero-title {
            font-size: 26px;
            text-align: left;
        }

        .hero-search-wrapper .form-control {
            padding: 12px 8px;
            font-size: 14px;
        }

        .btn-kwork-search {
            padding: 0 20px;
            font-size: 14px;
        }
    }

    @media (max-width: 575.98px) {
        .hero-title {
            font-size: 22px;
        }

        .hero-search-wrapper .input-group {
            display: flex;
            flex-direction: column;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .hero-search-wrapper .input-group> :not(:last-child) {
            margin-bottom: 12px;
        }

        .hero-search-wrapper .input-group-text {
            display: none;
        }

        .hero-search-wrapper .form-control {
            border: 1px solid #ced4da !important;
            border-radius: 6px !important;
            width: 100%;
            padding: 12px 15px;
        }

        .btn-kwork-search {
            width: 100%;
            border-radius: 6px !important;
            padding: 12px 0;
            display: block;
        }

        .hero-popular-tags {
            display: none !important;
        }
    }
</style>
<section class="kwork-hero-section position-relative overflow-hidden">
    <div class="hero-bg-pattern"></div>

    <div class="container position-relative h-100 z-index-2">
        <div class="row align-items-center h-100">

            <div class="col-12 col-lg-7 text-start py-4 py-lg-0">
                <h1 class="hero-title text-dark mb-4">
                    @lang('Buy affordable freelance services <br class="d-none d-md-block"> on the go')
                </h1>

                <form action="#" method="GET" class="hero-search-wrapper mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 ps-3 text-muted">
                            <i class="fas fa-search search-icon-main"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 border-end-0 shadow-none ps-2"
                            placeholder='@lang('Try "social media design"')' required>
                        <button class="btn btn-kwork-search px-4 px-md-5" type="submit">
                            @lang('Search')
                        </button>
                    </div>
                </form>

                <div class="hero-popular-tags d-flex flex-wrap align-items-center gap-2">
                    <span class="popular-title text-secondary me-1">@lang('Popular:')</span>
                    <a href="#" class="tag-link"><i class="fas fa-search me-1"></i> @lang('Web Design')</a>
                    <a href="#" class="tag-link"><i class="fas fa-search me-1"></i> @lang('Logo Design')</a>
                    <a href="#" class="tag-link"><i class="fas fa-search me-1"></i> @lang('Social Media Design')</a>
                    <a href="#" class="tag-link"><i class="fas fa-search me-1"></i> @lang('WordPress')</a>
                </div>
            </div>

            <div class="col-lg-5 d-none d-lg-block position-relative align-self-end text-center h-100">
                <div class="freelancer-image-wrapper">
                    <img src="{{ $randomFreelancer['image'] }}" alt="{{ $randomFreelancer['name'] }}"
                        class="hero-freelancer-img">

                    <div class="freelancer-info-badge">
                        <div class="rating-stars text-warning mb-1">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="freelancer-meta text-white m-0">
                            <strong>{{ $randomFreelancer['name'] }}</strong>, {{ __($randomFreelancer['role']) }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="hero-bottom-shadow"></div>
</section>
