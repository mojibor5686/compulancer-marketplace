@extends('Template::layouts.master')
@section('content')
    @php
        $authId = auth()->id();
    @endphp
    <div class="row g-4">

        @if (request()->routeIs('user.buyer.booked.details') && $details->status == Status::BOOKING_PENDING)
            <div class="card bl--5 border--primary">
                <div class="card-body d-flex align-items-center">
                    <i class="las la-info-circle text--primary me-1"></i>
                    <p class="text--primary mb-0">@lang('Your order is waiting for approval by the seller')</p>
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-end gap-2">
            @if ($details->status == Status::BOOKING_PENDING && request()->routeIs('user.seller.booking.service.details'))
                <button class="btn btn--success confirmationBtn" data-question="@lang('Are you sure to approve this booking?')"
                    data-action="{{ route('user.seller.booking.service.confirm', $details->order_number) }}">
                    <i class="las la-check"></i> @lang('Approve')
                </button>

                <button class="btn btn--danger confirmationBtn" data-question="@lang('Are you sure to cancel this booking?')"
                    data-action="{{ route('user.seller.booking.service.cancel', $details->order_number) }}">
                    <i class="las la-ban"></i> @lang('Cancel')
                </button>
            @endif

            @if ($details->working_status == Status::WORKING_INPROGRESS || $details->working_status == Status::WORKING_DELIVERED)
                @if (request()->routeIs('user.buyer.booked.details'))
                    <button class="btn btn--primary confirmationBtn" data-question="@lang('Are you sure to complete this booking?')"
                        data-action="{{ route('user.buyer.booked.completed', $details->order_number) }}">
                        <i class="las la-check-circle"></i> @lang('Complete')
                    </button>
                @endif

                <button class="btn btn--danger disputeBtn" data-type="service"
                    data-route="{{ route('user.dispute', $details->order_number) }}">
                    <i class="las la-bug"></i> @lang('Dispute')
                </button>

                <button class="btn btn--info workUploadBtn"
                    data-route="{{ route('user.work.upload', $details->order_number) }}" data-worktype="service">
                    <i class="las la-truck-loading"></i>
                    @if ($authId == $details->buyer_id)
                        @lang('Document File')
                    @else
                        @lang('Work File')
                    @endif
                </button>
            @endif

            @if ($details->working_status == Status::WORKING_COMPLETED && request()->routeIs('user.buyer.booked.details'))
                <a href="{{ route('service.details', ['slug' => slug(@$details->service->name), 'id' => $details->service->id]) }}?review=true"
                    class="btn btn--warning">
                    <i class="las la-star"></i> @lang('Add Review')
                </a>
            @endif
        </div>


        <!-- First Card -->
        <div class="col-md-6">
            <div class="card custom--card details-card shadow-sm border-0">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Order Number')
                            <span class="fw-bold">{{ __($details->order_number) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Service Quantity')
                            <span class="fw-bold">{{ __($details->quantity) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Service Price')
                            <span class="fw-bold">{{ showAmount($details->service_price) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Extra Services Price')
                            <span class="fw-bold">{{ showAmount($details->extra_price) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Total Price')
                            <span class="fw-bold">{{ showAmount($details->price) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Discount')
                            <span class="fw-bold">{{ showAmount($details->discount) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Second Card -->
        <div class="col-md-6">
            <div class="card custom--card details-card shadow-sm border-0">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Grand Total')
                            <span class="fw-bold">{{ showAmount($details->final_price) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Booking Date')
                            <span class="fw-bold">{{ showDateTime($details->created_at, 'M, d - Y') }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Delivery Date')
                            <span class="fw-bold">
                                {{ showDateTime($details->created_at->addDays($details->service->delivery_time), 'M, d - Y') }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            <div class="text-center">
                                @php echo $details->bookingStatusBadge @endphp
                            </div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Working Status')
                            <div class="text-center">
                                @php echo $details->workingStatusBadge @endphp
                            </div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Payment Status')
                            <div class="text-center">
                                @php echo $details->paymentStatusBadge @endphp
                            </div>
                        </li>

                        @if ($details->disputer)
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
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Extra Services Section -->
    @if ($extraServices)
        <div class="card service-card mt-4">
            <div class="card-header bg-dark text-white px-3">
                <h6 class="mb-0 text-white ">@lang('Extra Services')</h6>
            </div>
            <div class="card-body">
                @foreach ($extraServices as $extraService)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">{{ __($extraService->name) }}</span>
                        <span class="fw-bold text-success">{{ showAmount($extraService->price) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Work File Section -->
    @include('Template::partials.work_file')



    @include('Template::partials.conversation')
    @include('Template::partials.dispute_reason_modal')
    @include('Template::partials.details_modal')

    <!-- Modals for Confirmation, Dispute, and Work Delivery -->
    <x-confirmation-modal class="frontend" />
    @include('Template::partials.dispute_modal')
    @include('Template::partials.work_delivery_modal', [
        'type' => $authId == $details->buyer_id ? 'buyer' : 'seller',
    ])
@endsection
