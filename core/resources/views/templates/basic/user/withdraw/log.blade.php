@extends('Template::layouts.master')
@section('content')
    <div class="dashboard-top mb-4">
        <form class="search-form" method="GET">
            <div class="input-group">
                <input class="form-control form--control bg-white" type="text" name="search" value="{{ request()->search }}"
                    placeholder="@lang('Search by transactions')" id="search">
                <button class="btn btn--base" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        <a href="{{ route('user.withdraw') }}" class="btn btn--base btn--lg" role="button">
            <i class="fas fa-plus"></i>
            <span>@lang('Withdraw Now')</span>
        </a>
    </div>
    <div class="table-section">
        <div class="table-area">
            <table class="table table--custom table-responsive--xl">
                <thead>
                    <tr>
                        <th>@lang('Gateway | Transaction')</th>
                        <th>@lang('Initiated')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Conversion')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Details')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdraws as $withdraw)
                        <tr>
                            <td>
                                <div>
                                    <span class="fw-bold"><span
                                            class="text--base">{{ __(@$withdraw->method->name) }}</span></span>
                                    <br>
                                    <small>{{ $withdraw->trx }}</small>
                                </div>
                            </td>
                            <td class="text-md-center">
                                <div>
                                    {{ showDateTime($withdraw->created_at) }} <br>
                                    {{ diffForHumans($withdraw->created_at) }}
                                </div>
                            </td>
                            <td class="text-md-center">
                                <div>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="@lang('Requested Amount')">{{ showAmount($withdraw->amount) }}</span> - <span
                                        class="text--danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="@lang('Charge')">{{ showAmount($withdraw->charge) }}</span>
                                    <br>
                                    <strong data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Amount after charge')">
                                        {{ showAmount($withdraw->amount - $withdraw->charge) }}
                                    </strong>
                                </div>
                            </td>
                            <td class="text-md-center">
                                <div>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Rate')">
                                        1 {{ __(gs('cur_text')) }} =
                                        {{ showAmount($withdraw->rate, currencyFormat: false) }}
                                        {{ __($withdraw->currency) }}
                                    </span>
                                    <br>
                                    <strong data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Final Amount')">
                                        {{ showAmount($withdraw->final_amount, currencyFormat: false) }}
                                        {{ __($withdraw->currency) }}
                                    </strong>
                                </div>
                            </td>
                            <td class="text-md-center">
                                <div>
                                    @php echo $withdraw->statusBadge @endphp
                                </div>
                            </td>
                            <td>
                                <div class="text-end">
                                    <button class="btn btn--base text-white btn-sm ms-1 detailBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-offset="0,8"
                                        data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                        title="@lang('Details')"
                                        @if ($withdraw->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $withdraw->admin_feedback }}" @endif>
                                        <i class="las la-desktop"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">

                                @include('Template::partials.empty', [
                                    'message' => 'No withdraw yet!',
                                ])

                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($withdraws->hasPages())
                {{ paginateLinks($withdraws) }}
            @endif
        </div>
    </div>

    {{-- APPROVE MODAL --}}
    <div class="modal fade" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData list-group-flush"></ul>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var userData = $(this).data('user_data');
                var html = ``;
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${element.name}</span>
                            <span>${element.value}</span>
                        </li>`;
                        }
                    });
                }
                modal.find('.userData').html(html);

                var adminFeedback = $(this).data('admin_feedback') ? `
                <div class="my-3">
                    <strong>@lang('Admin Feedback')</strong>
                    <p>${$(this).data('admin_feedback')}</p>
                </div>` : '';

                modal.find('.feedback').html(adminFeedback);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
