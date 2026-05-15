@extends('Template::layouts.master')
@section('content')
    @php
        $isPending = $details->status == Status::PENDING && request()->routeIs('user.buyer.hiring.details');
        $isApproved =
            ($details->status == Status::APPROVED && $details->working_status == Status::WORKING_INPROGRESS) ||
            ($details->status == Status::APPROVED && $details->working_status == Status::WORKING_DELIVERED);
        $showDiv = $isPending || $isApproved;
        $authId = auth()->id();
    @endphp

    <div class="d-flex justify-content-end gap-2 @if ($showDiv) d-block @else d-none @endif">
        @if ($isPending)
            <button class="btn btn--success confirmationBtn"
                data-question="@lang('Are you sure to approve this bid?') {{ showAmount($details->price) }} @lang('will be deducted from your account balance when approved, and the work will be in progress. The bidder will do the work for you, and once the work is marked as completed, the bidder will receive their payment.')"
                data-action="{{ route('user.buyer.job.bid.approve', $details->id) }}">
                <i class="las la-check-double"></i> @lang('Approve')
            </button>

            <button class="btn btn--danger confirmationBtn" data-question="@lang('Are you sure to cancel this bid?')"
                data-action="{{ route('user.buyer.job.bid.cancel', $details->id) }}">
                <i class="las la-ban"></i> @lang('Cancel')
            </button>
        @endif

        @if ($isApproved)
            @if ($authId == $details->buyer_id)
                <button class="btn btn--primary confirmationBtn" data-question="@lang('Are you sure to mark this bid as completed?')"
                    data-action="{{ route('user.buyer.hiring.completed', $details->id) }}">
                    <i class="las la-check-circle"></i> @lang('Complete')
                </button>
            @endif

            <button class="btn btn--info workUploadBtn" data-route="{{ route('user.work.upload', $details->id) }}"
                data-worktype="job">
                <i class="las la-truck-loading"></i>
                @if ($details->buyer_id == auth()->id())
                    @lang('Document File')
                @else
                    @lang('Work File')
                @endif

            </button>

            <button class="btn btn--danger disputeBtn" data-type="job"
                data-route="{{ route('user.dispute', $details->id) }}">
                <i class="las la-bug"></i> @lang('Dispute')
            </button>
        @endif
    </div>


    <div class="card custom--card details-card shadow-sm border-0">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @lang('Job')
                    <span class="fw-bold">{{ __($details->job?->name) }}</span>
                </li>
                @if ($authId == $details->buyer_id)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Bidder')
                        <span class="fw-bold">
                            <span>{{ __($details->user?->fullname) }}</span>
                            <br>
                            <span class="text--info float-end">
                                <a
                                    href="{{ route('public.profile', $details->user?->username) }}"><span>@</span>{{ $details->user?->username }}</a>
                            </span>
                        </span>
                    </li>
                @else
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Recruiter')
                        <span class="fw-bold">
                            <span>{{ __($details->buyer?->fullname) }}</span>
                            <br>
                            <span class="text--info float-end">
                                <a
                                    href="{{ route('public.profile', $details->buyer?->username) }}"><span>@</span>{{ $details->buyer?->username }}</a>
                            </span>
                        </span>
                    </li>
                @endif
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @lang('Title')
                    <span class="fw-bold">{{ __($details->title) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @lang('Budget')
                    <span class="fw-bold">{{ showAmount($details->price) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @lang('Delivery Date')
                    <span
                        class="fw-bold">{{ showDateTime($details->job->created_at->addDays($details->job->delivery_time), 'M, d - Y') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @lang('Status')
                    <div class="text-end">
                        @php echo $details->customStatusBadge @endphp
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @lang('Working Status')
                    <div class="text-end">
                        @php echo $details->workingStatusBadge @endphp
                    </div>
                </li>
                @if ($details->disputer_id)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Disputer')
                        <div class="text-center">
                            <span class="fw-bold">{{ __($details->disputer->fullname) }}</span>
                            <br>
                            <span class="text--info">
                                <a href="{{ route('public.profile', $details->disputer->username) }}">
                                    <span>@</span>{{ $details->disputer->username }}
                                </a>
                            </span>
                        </div>
                    </li>
                @endif
                <li class="list-group-item d-flex flex-column flex-wrap">
                    <span>@lang('Description')</span>
                    <div class="text-start fw-bold mt-3">
                        {{ $details->description }}
                    </div>
                </li>
            </ul>
        </div>
    </div>



    @include('Template::partials.work_file')
    @include('Template::partials.conversation')
    @if ($details->disputer_id)
        @include('Template::partials.dispute_reason_modal')
    @endif
    @include('Template::partials.details_modal')

    <x-confirmation-modal class="frontend" />
    @include('Template::partials.work_delivery_modal', ['type' => ($authId == $details->buyer_id? 'buyer' : 'seller')])
    @include('Template::partials.dispute_modal')
@endsection
