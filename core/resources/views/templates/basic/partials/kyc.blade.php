@php
    $kyc = getContent('kyc_instructions.content', true);
    $user = auth()->user();
@endphp

@if ($user->kv == Status::KYC_UNVERIFIED && $user->kyc_rejection_reason)
    <div class="alert alert-custom alert-danger mb-4" role="alert">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="alert-heading mb-0"><i class="las la-exclamation-triangle me-2"></i>@lang('KYC Documents Rejected')</h4>
            <button class="btn btn--base btn-sm" data-bs-toggle="modal"
                data-bs-target="#kycRejectionReason">@lang('Show Reason')</button>
        </div>
        <hr>
        <p class="mb-0">
            {{ __(@$kyc->data_values->for_reject) }}
            <a href="{{ route('user.kyc.form') }}" class="text--primary fw-bold">@lang('Click Here to Re-submit Documents')</a>,
            <a href="{{ route('user.kyc.data') }}" class="text--primary fw-bold">@lang('See KYC Data')</a>
        </p>
    </div>
@elseif($user->kv == Status::KYC_UNVERIFIED)
    <div class="alert alert-custom alert-info mb-4" role="alert">
        <h4 class="alert-heading"><i class="las la-info-circle me-2"></i>@lang('KYC Verification required')</h4>
        <hr>
        <p class="mb-0">
            {{ __(@$kyc->data_values->for_verification) }}
            <a href="{{ route('user.kyc.form') }}" class="text-dark fw-bold">@lang('Click Here to Submit Documents')</a>
        </p>
    </div>
@elseif($user->kv == Status::KYC_PENDING)
    <div class="alert alert-custom alert-warning mb-4" role="alert">
        <h4 class="alert-heading"><i class="las la-clock me-2"></i>@lang('KYC Verification pending')</h4>
        <hr>
        <p class="mb-0">
            {{ __(@$kyc->data_values->for_verification) }}
            <a href="{{ route('user.kyc.data') }}" class="text-primary fw-bold">@lang('See KYC Data')</a>
        </p>
    </div>
@endif

@if ($user->kv == Status::KYC_UNVERIFIED && $user->kyc_rejection_reason)
    <div class="modal fade" id="kycRejectionReason">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><i class="las la-exclamation-circle me-2"></i>@lang('KYC Document Rejection Reason')</h6>
                    <span class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>

                </div>
                <div class="modal-body">
                    <p class="rejection-reason">{{ $user->kyc_rejection_reason }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

@push('style')
    <style>
        .alert-custom {
            border-left: 4px solid;
            border-radius: 8px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        }

        .alert-custom.alert-danger {
            border-left-color: #dc3545;
        }

        .alert-custom.alert-info {
            border-left-color: #0dcaf0;
        }

        .alert-custom.alert-warning {
            border-left-color: #ffc107;
        }

        .alert-custom .alert-heading {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .alert-custom hr {
            margin: 0.75rem 0;
            opacity: 0.15;
        }

        .alert-custom a {
            text-decoration: none;
            transition: all 0.3s;
        }

        .alert-custom a:hover {
            text-decoration: underline;
        }
    </style>
@endpush
