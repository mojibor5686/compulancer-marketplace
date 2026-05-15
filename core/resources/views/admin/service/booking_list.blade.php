@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Order Number') | @lang('Created')</th>
                                    @can('admin.service.details')
                                        <th>@lang('Service')</th>
                                    @endcan
                                    <th>@lang('Buyer')</th>
                                    <th>@lang('Seller')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Working Status')</th>
                                    <th>@lang('Payment Status')</th>
                                    @can('admin.booking.service.details')
                                        <th>@lang('Action')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $booking)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $booking->order_number }}</span>
                                            <br>
                                            <span class="small">
                                                {{ diffForHumans($booking->created_at) }}
                                            </span>
                                        </td>

                                        @can('admin.service.details')
                                            <td>
                                                <a
                                                    href="{{ route('admin.service.details', $booking->service->id) }}">{{ strLimit(__($booking->service->name), 20) }}</a>
                                            </td>
                                        @endcan
                                        <td>
                                            <span class="fw-bold">{{ $booking->buyer->fullname }}</span>
                                            @can('admin.users.detail')
                                                <br>
                                                <span class="small">
                                                    <a
                                                        href="{{ route('admin.users.detail', $booking->buyer->id) }}"><span>@</span>{{ $booking->buyer->username }}</a>
                                                </span>
                                            @endcan
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $booking->seller->fullname }}</span>
                                            @can('admin.users.detail')
                                                <br>
                                                <span class="small">
                                                    <a
                                                        href="{{ route('admin.users.detail', $booking->seller->id) }}"><span>@</span>{{ $booking->seller->username }}</a>
                                                </span>
                                            @endcan
                                        </td>
                                        <td>{{ showAmount($booking->final_price) }}</td>
                                        <td> @php echo $booking->bookingStatusBadge @endphp </td>
                                        <td> @php echo $booking->workingStatusBadge @endphp </td>
                                        <td> @php echo $booking->paymentStatusBadge @endphp </td>

                                        @can('admin.booking.service.details')
                                            <td>
                                                <a href="{{ route('admin.booking.service.details', $booking->id) }}"
                                                    class="btn btn-sm btn-outline--primary">
                                                    <i class="la la-info-circle"></i>@lang('Details')
                                                </a>
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($bookings->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($bookings) }}
                    </div>
                @endif
            </div>
        </div>
    </div>


    <div class="modal fade" id="disputeReasonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Dispute Reason')</h4>
                    <span class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="dispute-detail"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Order Number / Service Name" />
@endpush


@push('script')
    <script>
        'use strict';

        (function($) {
            $('.disputeShow').on('click', function() {
                var modal = $('#disputeReasonModal');
                var feedback = $(this).data('dispute');
                modal.find('.dispute-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
