@extends('Template::layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-title"><i class="las la-id-card me-2"></i>@lang('KYC Documents')</h5>
                    </div>
                    <div class="card-body">
                        @if ($user->kyc_data)
                            <ul class="kyc-list">
                                @foreach ($user->kyc_data as $val)
                                    @continue(!$val->value)
                                    <li class="kyc-item">
                                        <div class="kyc-label">
                                            <i class="las la-check-circle me-2"></i>
                                            {{ __($val->name) }}
                                        </div>
                                        <div class="kyc-value">
                                            @if ($val->type == 'checkbox')
                                                <span class="kyc-text">{{ implode(', ', $val->value) }}</span>
                                            @elseif($val->type == 'file')
                                                <a href="{{ route('user.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fa-regular fa-file me-1"></i>
                                                    @lang('Download Attachment')
                                                </a>
                                            @else
                                                <span class="kyc-text">{{ __($val->value) }}</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="no-data">
                                <i class="las la-folder-open"></i>
                                <h5>@lang('KYC data not found')</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .kyc-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .kyc-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .kyc-item:last-child {
            border-bottom: none;
        }

        .kyc-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .kyc-label {
            font-weight: 500;
            color: #555;
        }

        .kyc-value {
            display: flex;
            align-items: center;
        }

        .kyc-text {
            color: #666;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        .no-data {
            text-align: center;
            padding: 2rem;
            color: #666;
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .btn-outline-primary {
            border-color: #6e00ff;
            color: #6e00ff;
        }

        .btn-outline-primary:hover {
            background-color: #6e00ff;
            color: white;
        }

        .badge {
            padding: 0.5rem 1rem;
            font-weight: 500;
        }
    </style>
@endpush
