<div class="table-section">
    <div class="table-area">
        <table class="table table--custom table-responsive--xl">
            <thead>
                <tr>
                    <th>@lang('Trx')</th>
                    <th>@lang('Transacted')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Post Balance')</th>
                    <th>@lang('Detail')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr>
                        <td data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Transaction Number')">
                            <strong class="text--base">{{ $trx->trx }}</strong>
                        </td>
                        <td>
                            <small>
                                {{ showDateTime($trx->created_at) }}
                                <br>
                                {{ diffForHumans($trx->created_at) }}
                            </small>
                        </td>
                        <td>
                            <span
                                class="text-nowrap fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                                {{ $trx->trx_type }} {{ showAmount($trx->amount) }}
                            </span>
                        </td>
                        <td>
                            <span class="text-nowrap">{{ showAmount($trx->post_balance) }}</span>
                        </td>
                        <td>
                            <span class="trx_details">

                                {{ __($trx->details) }}
                            </span>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="100%">
                            @include('Template::partials.empty', [
                                'message' => 'No transactions yet!',
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if (request()->routeIs('user.transactions'))
            @if ($transactions->hasPages())
                {{ paginateLinks($transactions) }}
            @endif
        @endif
    </div>
</div>

@push('style')
    <style>
        /* @media (min-width: 1400px) { */
        .trx_details {
            max-width: 250px;
        }

        /* } */
    </style>
@endpush
