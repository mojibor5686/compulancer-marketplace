@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">

                @can('admin.report.transaction')
                    <div class="col-xxl-3 col-sm-6">
                        <x-widget style="7" link="{{ route('admin.report.transaction', $user->id) }}" title="Balance"
                            icon="las la-money-bill-wave-alt" value="{{ showAmount($user->balance) }}" bg="indigo"
                            type="2" />
                    </div>
                @endcan

                @can('admin.deposit.list')
                    <div class="col-xxl-3 col-sm-6">
                        <x-widget style="7" link="{{ route('admin.deposit.list', $user->id) }}" title="Deposits"
                            icon="las la-wallet" value="{{ showAmount($totalDeposit) }}" bg="8" type="2" />
                    </div>
                @endcan


                @can('admin.withdraw.data.all')
                    <div class="col-xxl-3 col-sm-6">
                        <x-widget style="7" link="{{ route('admin.withdraw.data.all', $user->id) }}" title="Withdrawals"
                            icon="la la-bank" value="{{ showAmount($totalWithdrawals) }}" bg="6" type="2" />
                    </div>
                @endcan

                @can('admin.report.transaction')
                    <div class="col-xxl-3 col-sm-6">
                        <x-widget style="7" link="{{ route('admin.report.transaction', $user->id) }}" title="Transactions"
                            icon="las la-exchange-alt" value="{{ $totalTransaction }}" bg="17" type="2" />
                    </div>
                @endcan


                @can('admin.software.all')
                    <div class="col-xxl-3 col-sm-6">
                        <x-widget style="6" link="{{ route('admin.software.all') }}?user_id={{ $user->id }}"
                            title="Total Software" icon="las la-money-bill-wave-alt"
                            value="{{ getAmount($widgetCount['total_software']) }}" bg="indigo" />
                    </div>
                @endcan

                @can('admin.job.all')
                    <div class="col-xxl-3 col-sm-6">
                        <x-widget style="6" link="{{ route('admin.job.all') }}?user_id={{ $user->id }}"
                            title="Total Job" icon="las la-wallet" value="{{ getAmount($widgetCount['total_job']) }}"
                            bg="8" />
                    </div>
                @endcan


                @can('admin.service.all')
                    <div class="col-xxl-3 col-sm-6">
                        <x-widget style="6" link="{{ route('admin.service.all') }}?user_id={{ $user->id }}"
                            title="Total Service" icon="la la-bank" value="{{ getAmount($widgetCount['total_service']) }}"
                            bg="6" />
                    </div>
                @endcan

                @can('admin.booking.service.all')
                    <div class="col-xxl-3 col-sm-6">
                        <x-widget style="6" link="{{ route('admin.booking.service.all') }}?buyer_id={{ $user->id }}"
                            title="Total Service Booking" icon="las la-exchange-alt"
                            value="{{ getAmount($widgetCount['total_service_booking']) }}" bg="17" />
                    </div>
                @endcan


            </div>

            <div class="d-flex flex-wrap gap-3 mt-4">
                @can('admin.users.add.sub.balance')
                    <div class="flex-fill">
                        <button data-bs-toggle="modal" data-bs-target="#addSubModal"
                            class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                            <i class="las la-plus-circle"></i> @lang('Balance')
                        </button>
                    </div>


                    <div class="flex-fill">
                        <button data-bs-toggle="modal" data-bs-target="#addSubModal"
                            class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" data-act="sub">
                            <i class="las la-minus-circle"></i> @lang('Balance')
                        </button>
                    </div>
                @endcan

                @can('admin.report.login.history')
                    <div class="flex-fill">
                        <a href="{{ route('admin.report.login.history') }}?search={{ $user->username }}"
                            class="btn btn--primary btn--shadow w-100 btn-lg">
                            <i class="las la-list-alt"></i>@lang('Logins')
                        </a>
                    </div>
                @endcan


                @can('admin.users.notification.log')
                    <div class="flex-fill">
                        <a href="{{ route('admin.users.notification.log', $user->id) }}"
                            class="btn btn--secondary btn--shadow w-100 btn-lg">
                            <i class="las la-bell"></i>@lang('Notifications')
                        </a>
                    </div>
                @endcan

                @can('admin.users.kyc.details')
                    @if ($user->kyc_data)
                        <div class="flex-fill">
                            <a href="{{ route('admin.users.kyc.details', $user->id) }}" target="_blank"
                                class="btn btn--dark btn--shadow w-100 btn-lg">
                                <i class="las la-user-check"></i>@lang('KYC Data')
                            </a>
                        </div>
                    @endif
                @endcan


                <div class="flex-fill">
                    @if ($user->status == Status::USER_ACTIVE)
                        <button type="button" class="btn btn--warning btn--shadow w-100 btn-lg userStatus"
                            data-bs-toggle="modal" data-bs-target="#userStatusModal">
                            <i class="las la-ban"></i>@lang('Ban User')
                        </button>
                    @else
                        <button type="button" class="btn btn--success btn--shadow w-100 btn-lg userStatus"
                            data-bs-toggle="modal" data-bs-target="#userStatusModal">
                            <i class="las la-undo"></i>@lang('Unban User')
                        </button>
                    @endif
                </div>
            </div>


            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Information of') {{ $user->fullname }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" type="text" name="firstname" required
                                        value="{{ $user->firstname }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required
                                        value="{{ $user->lastname }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number')</label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code">+{{ $user->dial_code }}</span>
                                        <input type="number" name="mobile" value="{{ $user->mobile }}" id="mobile"
                                            class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address"
                                        value="{{ $user->address }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city"
                                        value="{{ $user->city }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state"
                                        value="{{ $user->state }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip"
                                        value="{{ $user->zip }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Country') <span class="text--danger">*</span></label>
                                    <select name="country" class="form-control select2">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $key }}" @selected($user->country_code == $key)>
                                                {{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('Email Verification')</label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success"
                                        data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')"
                                        data-off="@lang('Unverified')" name="ev"
                                        @if ($user->ev) checked @endif>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('Mobile Verification')</label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success"
                                        data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')"
                                        data-off="@lang('Unverified')" name="sv"
                                        @if ($user->sv) checked @endif>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12">
                                <div class="form-group">
                                    <label>@lang('2FA Verification') </label>
                                    <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success"
                                        data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')"
                                        data-off="@lang('Disable')" name="ts"
                                        @if ($user->ts) checked @endif>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12">
                                <div class="form-group">
                                    <label>@lang('KYC') </label>
                                    <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success"
                                        data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')"
                                        data-off="@lang('Unverified')" name="kv"
                                        @if ($user->kv == Status::KYC_VERIFIED) checked @endif>
                                </div>
                            </div>
                            @can('admin.users.update')
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Balance')</span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.add.sub.balance', $user->id) }}"
                    class="balanceAddSub disableSubmission" method="POST">
                    @csrf
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control"
                                    placeholder="@lang('Please provide positive amount')" required>
                                <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea class="form-control" placeholder="@lang('Remark')" name="remark" rows="4" required></textarea>
                        </div>
                    </div>
                    @can('admin.users.add.sub.balance')
                        <div class="modal-footer">
                            <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>


    <div id="userStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($user->status == Status::USER_ACTIVE)
                            @lang('Ban User')
                        @else
                            @lang('Unban User')
                        @endif
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($user->status == Status::USER_ACTIVE)
                            <div class="alert alert-warning border-warning p-4" role="alert">
                                <div class="d-flex align-items-start">
                                    <i class="la la-exclamation-triangle fs-2 me-3 mt-1"></i>
                                    <div class="flex-grow-1">
                                        <h5 class="alert-heading mb-3">@lang('Important Notice')</h5>
                                        <p>@lang('If you ban this user, they will be unable to access their dashboard, make any transactions or access any services.')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <label class="fw-bold mb-2">@lang('Specify Ban Reason')</label>
                                <textarea class="form-control" name="reason" rows="4" required></textarea>
                            </div>
                        @else
                            <div class="alert alert-info border-info p-4">
                                <div class="d-flex align-items-start">
                                    <i class="la la-info-circle fs-2 me-3 mt-1"></i>
                                    <div class="flex-grow-1">
                                        <h5 class="alert-heading mb-3">@lang('Current Ban Reason')</h5>
                                        <p class="text-muted mb-0">{{ $user->ban_reason }}</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center mt-4 fw-bold">@lang('Are you sure you want to unban this user?')</p>
                        @endif
                    </div>
                    @can('admin.users.status')
                        <div class="modal-footer">
                            @if ($user->status == Status::USER_ACTIVE)
                                <button type="submit" class="btn btn--primary h-45 w-100">@lang('Ban User')</button>
                            @else
                                <button type="button" class="btn btn--dark"
                                    data-bs-dismiss="modal">@lang('No')</button>
                                <button type="submit" class="btn btn--primary">@lang('Yes, Unban')</button>
                            @endif
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .alert {
            border-width: 2px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .alert-warning {
            background-color: rgba(255, 243, 205, 0.5);
        }

        .alert-info {
            background-color: rgba(209, 236, 241, 0.5);
        }

        .list-unstyled li {
            position: relative;
            padding-left: 5px;
        }

        .modal-body {
            padding: 1.5rem;
        }
    </style>
@endpush

@can('admin.users.login')
    @push('breadcrumb-plugins')
        <a href="{{ route('admin.users.login', $user->id) }}" target="_blank" class="btn btn-sm btn-outline--primary"><i
                class="las la-sign-in-alt"></i>@lang('Login as User')</a>
    @endpush
@endcan

@push('script')
    <script>
        (function($) {
            "use strict"


            $('.bal-btn').on('click', function() {

                $('.balanceAddSub')[0].reset();

                var act = $(this).data('act');
                $('#addSubModal').find('input[name=act]').val(act);
                if (act == 'add') {
                    $('.type').text('Add');
                } else {
                    $('.type').text('Subtract');
                }
            });

            let mobileElement = $('.mobile-code');
            $('select[name=country]').on('change', function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

        })(jQuery);
    </script>
@endpush
