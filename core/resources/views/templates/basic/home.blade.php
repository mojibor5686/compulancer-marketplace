@extends('Template::layouts.frontend') @section('content')
    <main class="page-wrapper">
        <section class="jss-section pt-120 pb-80">
            <div class="container"> @include('Template::partials.top_filter') <div class="page-content">
                    <div class="row">
                        <div class="col-lg-8 col-xl-9 productList"> @include('Template::partials.product_list') </div>
                        <div class="col-lg-4 col-xl-3"> @include('Template::partials.filter') </div>
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
            background-color: #28c76f;
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
            background-color: #21a35c;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 199, 111, 0.3);
        }

        @media (max-width: 768px) {
            .cta-title {
                font-size: 1.75rem;
            }

            .cta-section {
                padding: 60px 15px;
            }
        }
    </style>

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
