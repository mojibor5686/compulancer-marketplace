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
        <a href="{{ route('user.deposit.index') }}" class="btn btn--base btn--lg" role="button">
            <i class="fas fa-plus"></i>
            <span>@lang('Deposit Now')</span>
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
                    @forelse($deposits as $deposit)
                        <tr>
                            <td class="text-end text-lg-start">
                                <div>
                                    <span class="fw-bold text--base">{{ __($deposit->gateway?->name) }}</span><br>
                                    <small>{{ $deposit->trx }}</small>
                                </div>
                            </td>
                            <td class="text-md-center">
                                <div class="text-end">
                                    {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                </div>
                            </td>
                            <td class="text-md-center">
                                <div>
                                    {{ showAmount($deposit->amount) }} +
                                    <span class="text--danger" data-bs-toggle="tooltip" title="@lang('Charge')">
                                        {{ showAmount($deposit->charge) }}
                                    </span>
                                    <br>
                                    <strong data-bs-toggle="tooltip" title="@lang('Amount with charge')">
                                        {{ showAmount($deposit->amount + $deposit->charge) }}
                                    </strong>
                                </div>
                            </td>

                            <td class="text-md-center">
                                <div>
                                    <div>
                                        1 {{ __(gs('cur_text')) }} =
                                        {{ showAmount($deposit->rate, currencyFormat: false) }}
                                        {{ __($deposit->method_currency) }}<br>
                                        <strong>{{ showAmount($deposit->final_amount, currencyFormat: false) }}
                                            {{ __($deposit->method_currency) }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td class="text-md-center">
                                <div>
                                    @php echo $deposit->statusBadge @endphp
                                </div>
                            </td>
                            <td>
                                <div class="text-end">
                                    @if ($deposit->method_code >= 1000 && $deposit->method_code <= 5000)
                                        <a class="btn btn--base text-white btn-sm ms-1 detailBtn" data-bs-toggle="tooltip"
                                            disabled data-bs-placement="top" data-bs-offset="0,8" title="@lang('Details')"
                                            @if ($deposit->method_code >= 1000) data-info="{{ json_encode($deposit->detail) }}" @endif
                                            @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                            <i class="las la-desktop"></i>
                                        </a>
                                    @else
                                        <a class="btn btn--success text-white btn-sm ms-1" data-bs-toggle="tooltip"
                                            data-bs-offset="0,8" title="@lang('Automatically processed')">
                                            <i class="las la-check"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">

                                @include('Template::partials.empty', [
                                    'message' => 'No deposit found yet!',
                                ])

                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($deposits->hasPages())
                {{ paginateLinks($deposits) }}
            @endif
        </div>
    </div>

    <!-- Detail Modal -->
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
                    <ul class="list-group userData mb-2"></ul>
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
                var userData = $(this).data('info');
                var html = '';

                if (userData) {
                    Object.keys(userData).forEach(function(key) {
                        if (userData[key].type !== 'file') {
                            html += `
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>${userData[key].name}</span>
                                    <span>${userData[key].value}</span>
                                </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                var adminFeedback = $(this).data('admin_feedback') !== undefined ? `
                    <div class="my-3">
                        <strong>@lang('Admin Feedback')</strong>
                        <p>${$(this).data('admin_feedback')}</p>
                    </div>
                ` : '';

                modal.find('.feedback').html(adminFeedback);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
