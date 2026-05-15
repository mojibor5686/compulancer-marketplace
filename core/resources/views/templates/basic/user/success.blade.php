@extends('Template::layouts.frontend')
@section('content')
    <main class="page-wrapper">
        <section class="jss-section pt-60 pb-80">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="success-form card-section">
                            <div class="card-section__icon">
                                <svg class="checkmark" viewBox="0 0 52 52">
                                    <path class="checkmark-check" fill="none" stroke="#28a745" stroke-width="3"
                                        d="M14 26l7 7 16-16" />
                                </svg>
                            </div>
                            <div class="success-form__content text-center">
                                <h3>@lang('Order Placed Successfully')</h3>
                                <p>@lang('Your order has been placed successfully and is currently awaiting approval by the seller. You will be notified once the seller reviews your request').</p>
                                <a href="{{ route('user.buyer.booked.details', $orderNumber) }}"
                                    class="btn btn-primary mt-3">
                                    @lang('View Service Details')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('style')
    <style>
        .card-section {
            padding: 50px 40px;
            z-index: 1;
            border-radius: 15px;
            background-color: hsl(var(--white));
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 575px) {
            .card-section {
                padding: 40px 15px;
            }
        }

        .card-section__icon {
            text-align: center;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid hsl(var(--success));
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .card-section .complete {
            width: 250px;
            margin-bottom: 20px;
        }

        .success-form__content h3 {
            margin-bottom: 10px;
            color: hsl(var(--black-two));
        }

        .success-form__content p {
            margin-bottom: 0px;
            color: hsl(var(--black-two));
        }

        @keyframes draw-circle {
            0% {
                stroke-dasharray: 157;
                stroke-dashoffset: 157;
            }

            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes draw-check {
            0% {
                stroke-dasharray: 36;
                stroke-dashoffset: 36;
            }

            100% {
                stroke-dashoffset: 0;
            }
        }

        .checkmark-circle {
            stroke-dasharray: 157;
            stroke-dashoffset: 157;
            animation: draw-circle 0.6s ease-out forwards;
        }

        .checkmark-check {
            stroke-dasharray: 36;
            stroke-dashoffset: 36;
            animation: draw-check 0.4s ease-out 0.6s forwards;
        }
    </style>
@endpush
