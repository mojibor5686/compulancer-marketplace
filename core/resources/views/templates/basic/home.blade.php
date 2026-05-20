@extends('Template::layouts.frontend') @section('content')
    <main class="page-wrapper">
        <section class="jss-section pt-40 pb-80">
            <div class="container">
                <section class="kwork-catalog-section py-5">
                    <div class="container">
                        <h2 class="catalog-main-title mb-4">@lang("Explore Kwork's Evergrowing Catalog")</h2>

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
                    <div class="row">
                        <div class="col-lg-8 col-xl-9 productList"> @include('Template::partials.product_list') </div>
                        <div class="col-lg-4 col-xl-3">
                            @include('Template::partials.filter')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
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
                width: 160px;
                height: 60px;
                bottom: -30px;
                right: -80px;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 162 58' fill='none'%3E%3Cpath d='M1 1C30 35 110 55 155 15' stroke='%23b2eccf' stroke-width='2' stroke-dasharray='4 4'/%3E%3Cpath d='M155 15L146 12M155 15L153 24' stroke='%23b2eccf' stroke-width='2'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                z-index: 1;
            }

            .step-arrow-up {
                position: absolute;
                width: 160px;
                height: 60px;
                top: -20px;
                right: -80px;
                background-image: url("data:https://cdn.kwork.com/images/index/steps-pay-arrow.svg?ver=2");
                background-repeat: no-repeat;
                z-index: 1;
            }

            .step-arrow-loop {
                position: absolute;
                width: 200px;
                height: 110px;
                bottom: -60px;
                left: -100px;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 210 100' fill='none'%3E%3Cpath d='M10 10C50 90 160 90 190 20' stroke='%23b2eccf' stroke-width='2'/%3E%3Cpath d='M190 20L181 22M190 20L195 29' stroke='%23b2eccf' stroke-width='2'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                z-index: 1;
            }
        </style>
    @endpush

    <section class="cta-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="cta-title">Start saving with freelance services today</h2>
                    <p class="cta-subtitle">Speed, quality, and affordability: you can have it all!</p>
                    <a href="#" class="btn btn-signup">Sign up for Free</a>
                </div>
            </div>
        </div>
    </section>
@endsection
