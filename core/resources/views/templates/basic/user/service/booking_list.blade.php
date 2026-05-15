@extends('Template::layouts.master')
@section('content')

    <div class="row gy-4">

        <div class="col-12">
            <div class="show-filter text-end">
                <button type="button" class="btn btn--base showFilterBtn btn-sm">
                    <i class="las la-filter"></i> @lang('Filter')
                </button>
            </div>
            <div class="card responsive-filter-card custom--card mt-4 mt-md-0">
                <div class="card-body p-3">
                    <form action="" method="GET">
                        <div class="d-flex flex-wrap row-gap-3 column-gap-4">
                            <!-- Order Number Filter -->
                            <div class="flex-grow-1">
                                <label class="form-label form--label">
                                    @if (request()->routeIs('user.seller.booking.service.list'))
                                        @lang('Order Number / Buyer')
                                    @else
                                        @lang('Order Number / Seller')
                                    @endif
                                </label>
                                <input class="form-control form--control" type="text" name="search"
                                    value="{{ request()->search }}">

                                <input type="hidden" name="type"
                                    value="{{ request()->routeIs('user.seller.booking.service.list') ? 'buyer' : 'seller' }}">
                            </div>


                            <!-- Booking Status Filter -->
                            <div class="flex-grow-1 min-w-150">
                                <label class="form-label form--label">@lang('Booking Status')</label>
                                <select class="form-select form--select select2-basic" name="status">
                                    <option value="">@lang('All')</option>
                                    <option value="{{ Status::BOOKING_PENDING }}" @selected((string) request()->status == (string) Status::BOOKING_PENDING)>
                                        @lang('Pending')
                                    </option>
                                    <option value="{{ Status::BOOKING_APPROVED }}" @selected((string) request()->status == (string) Status::BOOKING_APPROVED)>
                                        @lang('Approved')
                                    </option>
                                    <option value="{{ Status::BOOKING_CANCELED }}" @selected((string) request()->status == (string) Status::BOOKING_CANCELED)>
                                        @lang('Canceled')
                                    </option>
                                    <option value="{{ Status::BOOKING_REFUNDED }}" @selected((string) request()->status == (string) Status::BOOKING_REFUNDED)>
                                        @lang('Refunded')
                                    </option>
                                    <option value="{{ Status::BOOKING_EXPIRED }}" @selected((string) request()->status == (string) Status::BOOKING_EXPIRED)>
                                        @lang('Expired')
                                    </option>
                                </select>
                            </div>

                            <!-- Working Status Filter -->
                            <div class="flex-grow-1 min-w-150">
                                <label class="form-label form--label">@lang('Working Status')</label>
                                <select class="form-select form--select select2-basic" name="working_status">
                                    <option value="">@lang('All')</option>
                                    <option value="{{ Status::WORKING_INPROGRESS }}" @selected((string) request()->working_status == (string) Status::WORKING_INPROGRESS)>
                                        @lang('In Progress')
                                    </option>
                                    <option value="{{ Status::WORKING_DELIVERED }}" @selected((string) request()->working_status == (string) Status::WORKING_DELIVERED)>
                                        @lang('Delivered')
                                    </option>
                                    <option value="{{ Status::WORKING_COMPLETED }}" @selected((string) request()->working_status == (string) Status::WORKING_COMPLETED)>
                                        @lang('Completed')
                                    </option>
                                    <option value="{{ Status::WORKING_EXPIRED }}" @selected((string) request()->working_status == (string) Status::WORKING_EXPIRED)>
                                        @lang('Expired')
                                    </option>
                                    <option value="{{ Status::WORKING_DISPUTED }}" @selected((string) request()->working_status == (string) Status::WORKING_DISPUTED)>
                                        @lang('Disputed')
                                    </option>
                                </select>
                            </div>

                            <!-- Filter Button -->
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--base w-100 h-100 h-50">
                                    <i class="las la-filter"></i> @lang('Filter')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="table-section">
                <div class="table-area">
                    <table class="table table--custom table-responsive--xl">
                        <thead>
                            <tr>
                                <th>@lang('Service')</th>
                                <th>@lang('Order Number')</th>
                                @if (request()->routeIs('user.seller.booking.service.list'))
                                    <th>@lang('Buyer')</th>
                                @else
                                    <th>@lang('Seller')</th>
                                @endif
                                <th>@lang('Amount')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Working Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookedServices as $booking)
                                <tr>
                                    <td class="text-start">
                                        <div class="author-info">
                                            <div class="thumb">
                                                <a
                                                    href="{{ route('service.details', ['slug' => slug(@$booking->service->name), 'id' => $booking->service->id]) }}">
                                                    <img src="{{ poster($booking->service->image ? getFilePath('service') . '/' . @$booking->service->image : 'assets/images/default.png', false) }}"
                                                        alt="@lang('Service Image')">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <a href="{{ route('service.details', [slug($booking->service->name), $booking->service->id]) }}?review=true"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="@lang('Write a review for :service', ['service' => $booking->service->name])">
                                                    <span>{{ strLimit(__($booking->service->name)) }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ __($booking->order_number) }}</td>
                                    <td>
                                        <div>
                                            @if (request()->routeIs('user.seller.booking.service.list'))
                                                <span class="fw-bold">{{ __($booking->buyer->fullname) }}</span>
                                                <br>
                                                <span class="text--info">
                                                    <a
                                                        href="{{ route('public.profile', $booking->buyer->username) }}"><span>@</span>{{ $booking->buyer->username }}</a>
                                                </span>
                                            @else
                                                <span class="fw-bold">{{ __($booking->seller->fullname) }}</span>
                                                <br>
                                                <span class="text--info">
                                                    <a
                                                        href="{{ route('public.profile', $booking->seller->username) }}"><span>@</span>{{ $booking->seller->username }}</a>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-md-center">
                                        <div>
                                            @if ($booking->discount > 0)
                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="@lang('Price')">{{ showAmount($booking->price) }}</span>
                                                - <span class="text--danger" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="@lang('Discount')">{{ showAmount($booking->discount) }}</span>
                                                <br>
                                                <strong data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="@lang('Final Price')">
                                                    {{ showAmount($booking->final_price) }}
                                                </strong>
                                            @else
                                                <strong data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="@lang('Final Price')">
                                                    {{ showAmount($booking->final_price) }}
                                                </strong>
                                            @endif
                                        </div>
                                    </td>
                                    <td>@php echo $booking->bookingStatusBadge @endphp</td>
                                    <td>@php echo $booking->workingStatusBadge @endphp</td>
                                    <td>
                                        <div class="dropdown dropdown-custom">
                                            <button class="btn btn--base btn--sm" id="actionButton"
                                                data-bs-toggle="dropdown" aria-label="Actions" title="Actions">
                                                <i class="las la-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu p-0">
                                                @if ($booking->status == Status::BOOKING_PENDING && request()->routeIs('user.seller.booking.service.list'))
                                                    <button class="dropdown-item confirmationBtn"
                                                        data-question="@lang('Are you sure to approve this booking?')"
                                                        data-action="{{ route('user.seller.booking.service.confirm', $booking->order_number) }}">
                                                        <i class="las la-check"></i> @lang('Approve')
                                                    </button>
                                                    <button class="dropdown-item confirmationBtn"
                                                        data-question="@lang('Are you sure to cancel this booking?')"
                                                        data-action="{{ route('user.seller.booking.service.cancel', $booking->order_number) }}">
                                                        <i class="las la-ban"></i> @lang('Cancel')
                                                    </button>
                                                @elseif($booking->working_status == Status::WORKING_INPROGRESS || $booking->working_status == Status::WORKING_DELIVERED)
                                                    @if (request()->routeIs('user.buyer.booked.services'))
                                                        <button class="dropdown-item confirmationBtn"
                                                            data-question="@lang('Are you sure to complete this booking?')"
                                                            data-action="{{ route('user.buyer.booked.completed', $booking->order_number) }}">
                                                            <i class="las la-check-circle"></i> @lang('Complete')
                                                        </button>
                                                    @endif
                                                    <button class="dropdown-item disputeBtn" data-type="service"
                                                        data-route="{{ route('user.dispute', $booking->order_number) }}">
                                                        <i class="las la-bug"></i> @lang('Dispute')
                                                    </button>
                                                    <button class="dropdown-item workUploadBtn"
                                                        data-route="{{ route('user.work.upload', $booking->order_number) }}"
                                                        data-worktype="service">
                                                        <i class="las la-truck-loading"></i>
                                                            @if (request()->routeIs('user.buyer.booked.services'))
                                                                @lang('Document File')
                                                            @else
                                                                @lang('Work File')
                                                            @endif
                                                    </button>
                                                @endif
                                                @if (request()->routeIs('user.seller.booking.service.list'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.seller.booking.service.details', $booking->order_number) }}">
                                                        <i class="las la-desktop"></i> @lang('Details')
                                                    </a>
                                                @else
                                                    @if ($booking->working_status == Status::WORKING_COMPLETED)
                                                        <a href="{{ route('service.details', ['slug' => slug(@$booking->service->name), 'id' => $booking->service->id]) }}?review=true"
                                                            class="dropdown-item">
                                                            <i class="las la-star"></i> @lang('Review')
                                                        </a>
                                                    @endif
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.buyer.booked.details', $booking->order_number) }}">
                                                        <i class="las la-desktop"></i> @lang('Details')
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">
                                        @include('Template::partials.empty', [
                                            'message' => 'No service booking yet!',
                                        ])
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    @if ($bookedServices->hasPages())
                        {{ paginateLinks($bookedServices) }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modals for Confirmation, Dispute, and Work Delivery -->
    <x-confirmation-modal class="frontend" />
    @include('Template::partials.dispute_reason_modal')
    @include('Template::partials.dispute_modal')
    @include('Template::partials.work_delivery_modal', [
        'type' => request()->routeIs('user.buyer.booked.services') ? 'buyer' : 'seller',
    ])
@endsection
