@extends('Template::layouts.master')
@section('content')
    <div class="card card--lg custom--card">
        <div class="card-body">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">{{ $pageTitle }}</h5>
            </div>

            <!-- Referral Link Section -->
            <div class="form--group-lg">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <label class="form-label form--label required">@lang('Referral Link')</label>
                    </div>
                    <div class="col-lg-9">
                        <div class="input-group input--group">
                            <input type="text" class="form-control form--control referralURL"
                                value="{{ route('home', ['reference' => $user->username]) }}" readonly>
                            <button type="button" class="input-group-text copytext" id="copyBoard"> <i
                                    class="fas fa-copy"></i> </button>
                        </div>
                        <p class="fs-14 mt-1">
                            @lang('Share this referral link to invite users. Every time they make a deposit, you will earn a commission of :commission% of total deposit.', ['commission' => gs()->referral_commission])
                        </p>
                    </div>
                </div>
            </div>

            <!-- Data Tables -->
            <div class="row mt-5">
                <!-- Referred Users Table -->
                <div class="col-xxl-3">
                    <div class="table-section mb-3">
                        <div class="table-area">
                            <h6 class="mb-3">@lang('Referred Users')</h6>
                            <table class="table table--custom table-responsive--xl">
                                <thead>
                                    <tr>
                                        <th>@lang('Name')</th>
                                        <th>@lang('Joined At')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($referredUsers as $referred)
                                        <tr>
                                            <td>
                                                <span class="fw-bold">{{ $referred->username }}</span>
                                            </td>
                                            <td>
                                                <small>
                                                    {{ showDateTime($referred->created_at, 'd M, Y') }}
                                                    <br>
                                                    <span
                                                        class="text-muted">{{ $referred->created_at->diffForHumans() }}</span>
                                                </small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                @lang('No referred users found.')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Referral Commissions Table -->
                <div class="col-xxl-9">
                    <div class="table-section">
                        <div class="table-area">
                            <h6 class="mb-3">@lang('Referral Commissions')</h6>
                            <table class="table table--custom table-responsive--xl">
                                <thead>
                                    <tr>
                                        <th>@lang('Transaction ID')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Details')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($referralCommissions as $transaction)
                                        <tr>
                                            <td>
                                                <span class="fw-bold">{{ $transaction->trx }}</span>
                                                <br>
                                                <small>{{ $transaction->created_at->format('d M, Y') }}</small>
                                            </td>
                                            <td>
                                                <span class="text-nowrap">{{ showAmount($transaction->amount) }}</span>
                                            </td>
                                            <td>
                                                <span>{{ $transaction->details }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                @lang('No referral commissions found.')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @if ($referralCommissions->hasPages())
                                <div class="mt-3">
                                    {{ paginateLinks($referralCommissions) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#copyBoard').on('click', function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush
