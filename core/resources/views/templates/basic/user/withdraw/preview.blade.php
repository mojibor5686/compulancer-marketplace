@extends('Template::layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card custom--card">
                    <div class="card-header pt-3 pb-3">
                        <h5 class="card-title mb-0">@lang('Withdraw Via') {{ $withdraw->method->name }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Custom Styled Alert Box -->
                        <div class="alert d-flex align-items-center rounded p-3" role="alert"
                            style="background-color: #f1f6ff; border-left: 4px solid #5c6ac4;">
                            <span class="text-primary" style="color: #5c6ac4; font-size: 14px;">
                                <i class="las la-info-circle me-2 fs-5"></i>
                                @lang('You are requesting') <b>{{ showAmount($withdraw->amount) }}</b> @lang('for withdraw. The admin will send you')
                                <b>{{ showAmount($withdraw->final_amount, currencyFormat: false) . ' ' . $withdraw->currency }}</b>
                                @lang('to your account.')
                            </span>
                        </div>

                        <form action="{{ route('user.withdraw.submit') }}" class="disableSubmission" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                @php
                                    echo $withdraw->method->description;
                                @endphp
                            </div>
                            <x-viser-form identifier="id" identifierValue="{{ $withdraw->method->form_id }}" />

                            @if (auth()->user()->ts)
                                <div class="form-group mt-3 mb-4">
                                    <label>@lang('Google Authenticator Code')</label>
                                    <input type="text" name="authenticator_code" class="form-control form--control"
                                        required>
                                </div>
                            @endif

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn--base w-100 btn--lg">@lang('Submit')</button>
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
        .form-label {
            margin-bottom: .5rem;
            margin-top: 0.7rem;
        }
    </style>
@endpush
