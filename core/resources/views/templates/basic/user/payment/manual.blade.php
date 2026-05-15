@extends('Template::layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card custom--card">
                    <div class="card-header card-header-bg">
                        <h5 class="card-title mb-0">{{ __($pageTitle) }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.deposit.manual.update') }}" method="POST" class="disableSubmission"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Styled Alert Box -->
                                    <div class="alert d-flex align-items-center rounded p-3" role="alert"
                                        style="background-color: #f1f6ff; border-left: 4px solid #5c6ac4;">
                                        <i class="las la-info-circle me-2 fs-5" style="color: #5c6ac4;"></i>
                                        <span style="color: #5c6ac4; font-size: 14px;">
                                            @lang('You are requesting') <b>{{ showAmount($data['amount']) }}</b> @lang('to deposit. Please pay')
                                            <b>{{ showAmount($data['final_amount'], currencyFormat: false) . ' ' . $data['method_currency'] }}</b>
                                            @lang('for successful payment.')
                                        </span>
                                    </div>

                                    <div class="mb-3">@php echo $data->gateway->description @endphp</div>
                                </div>

                                <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}" />

                                <div class="col-md-12 mt-1">
                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn btn--base w-100 btn--lg">@lang('Pay Now')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('style')
    <style>
        .form-group {
            margin-top: 15px;
        }
    </style>
@endpush
