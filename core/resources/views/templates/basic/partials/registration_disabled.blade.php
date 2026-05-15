@php
    $registrationDisabled = getContent('register_disable.content', true);
@endphp
<div class="register-disable">
    <div class="container">
        <div class="register-disable-content">
            <div class="register-disable-image">
                <img class="fit-image"
                    src="{{ frontendImage('register_disable', @$registrationDisabled->data_values->image, '280x280') }}"
                    alt="">
            </div>

            <div class="register-disable-text">
                <h3 class="register-disable-title">{{ __(@$registrationDisabled->data_values->heading) }}</h3>
                <p class="register-disable-desc">
                    {{ __(@$registrationDisabled->data_values->subheading) }}
                </p>
                <div class="text-center">
                    <a href="{{ @$registrationDisabled->data_values->button_url }}"
                        class="btn btn--base register-disable-btn">{{ __(@$registrationDisabled->data_values->button_name) }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')
    <style>
        .footer-section,
        .header-bottom-area,
        .header {
            display: none !important;
        }

        .register-disable {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            padding: 40px 0;
        }

        .register-disable-content {
            background: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
        }

        .register-disable-image {
            margin-bottom: 30px;
        }

        .fit-image {
            max-width: 200px;
            height: auto;
            border-radius: 10px;
        }

        .register-disable-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .register-disable-desc {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin-bottom: 30px;
        }

        .register-disable-btn {
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .register-disable-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 767px) {
            .register-disable {
                padding: 20px;
            }

            .register-disable-content {
                padding: 30px 20px;
            }

            .register-disable-title {
                font-size: 24px;
            }

            .register-disable-desc {
                font-size: 14px;
            }
        }
    </style>
@endpush
