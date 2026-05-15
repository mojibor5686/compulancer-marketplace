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
                            <!-- Search Filter (Job Name / Recruiter / Bidder) -->
                            <div class="flex-grow-1">
                                <label class="form-label form--label">
                                    @if (request()->routeIs('user.buyer.hiring.list') || request()->routeIs('user.buyer.job.bidding.list'))
                                        @lang('Job Name / Bidder')
                                    @else
                                        @lang('Job Name / Recruiter')
                                    @endif
                                </label>
                                <input class="form-control form--control" type="text" name="search"
                                    value="{{ request()->search }}">

                                <input type="hidden" name="type"
                                    value="{{ request()->routeIs('user.buyer.hiring.list') || request()->routeIs('user.buyer.job.bidding.list') ? 'bidder' : 'buyer' }}">
                            </div>

                            <!-- Status Filter -->
                            <div class="flex-grow-1 min-w-150">
                                <label class="form-label form--label">@lang('Status')</label>
                                <select class="form-select form--select select2-basic" name="status">
                                    <option value="">@lang('All')</option>
                                    <option value="{{ Status::APPROVED }}" @selected((string) request()->status == (string) Status::APPROVED)>
                                        @lang('Approved')
                                    </option>
                                    <option value="{{ Status::PENDING }}" @selected((string) request()->status == (string) Status::PENDING)>
                                        @lang('Pending')
                                    </option>
                                    <option value="{{ Status::CLOSED }}" @selected((string) request()->status == (string) Status::CLOSED)>
                                        @lang('Closed')
                                    </option>
                                    <option value="{{ Status::REJECTED }}" @selected((string) request()->status == (string) Status::REJECTED)>
                                        @lang('Rejected')
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
                                <th>@lang('Job')</th>
                                @if (request()->routeIs('user.buyer.job.bidding.list') || request()->routeIs('user.buyer.hiring.list'))
                                    <th>@lang('Bidder')</th>
                                    <th>@lang('Title')</th>
                                @else
                                    <th>@lang('Recruiter')</th>
                                @endif
                                <th>@lang('Budget')</th>
                                <th>@lang('Delivery Date')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Working Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($biddingList as $bid)
                                <tr>
                                    <td class="text-start">
                                        <div class="author-info">
                                            <div class="thumb">
                                                <img src="{{ poster(@$bid->job->image ? getFilePath('job') . '/' . @$bid->job->image : 'assets/images/default.png', false) }}"
                                                    alt="@lang('Job Image')">
                                            </div>
                                            <div class="content">
                                                <span data-bs-toggle="tooltip" title="{{ __($bid->job->name) }}">
                                                    {{ __(strLimit($bid->job->name)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    @if (request()->routeIs('user.buyer.job.bidding.list') || request()->routeIs('user.buyer.hiring.list'))
                                        <td>
                                            <div>
                                                <span class="fw-bold">{{ __($bid->user->fullname) }}</span>
                                                <br>
                                                <span class="text--info">
                                                    <a
                                                        href="{{ route('public.profile', $bid->user->username) }}"><span>@</span>{{ $bid->user->username }}</a>
                                                </span>
                                            </div>
                                        </td>
                                        <td>{{ strLimit(__($bid->title)) }}</td>
                                    @else
                                        <td>
                                            <div>
                                                <span class="fw-bold">{{ __($bid->buyer->fullname) }}</span>
                                                <br>
                                                <span class="text--info">
                                                    <a
                                                        href="{{ route('public.profile', $bid->buyer->username) }}"><span>@</span>{{ $bid->buyer->username }}</a>
                                                </span>
                                            </div>
                                        </td>
                                    @endif
                                    <td>{{ showAmount($bid->price) }}</td>
                                    <td>{{ showDateTime($bid->job->created_at->addDays($bid->job->delivery_time), 'M, d - Y') }}
                                    </td>
                                    <td>
                                        <div>@php echo $bid->customStatusBadge @endphp</div>
                                    </td>
                                    <td>
                                        <div>@php echo $bid->workingStatusBadge @endphp</div>
                                    </td>
                                    <td>
                                        <div class="dropdown dropdown-custom">
                                            <button class="btn btn--base btn--sm" id="actionButton"
                                                data-bs-toggle="dropdown" aria-label="Actions" title="Actions">
                                                <i class="las la-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu p-0">
                                                @if ($bid->status == Status::PENDING && request()->routeIs('user.buyer.job.bidding.list'))
                                                    <button class="dropdown-item confirmationBtn"
                                                        data-question="@lang('Are you sure to approve this bid?') {{ showAmount($bid->price) }} @lang('will be deducted from your account balance when approved, and the work will be in progress. The bidder will do the work for you, and once the work is marked as completed, the bidder will receive their payment.')"
                                                        data-action="{{ route('user.buyer.job.bid.approve', $bid->id) }}">
                                                        <i class="las la-check-double"></i> @lang('Approve')
                                                    </button>

                                                    <button class="dropdown-item confirmationBtn"
                                                        data-question="@lang('Are you sure to cancel this bid?')"
                                                        data-action="{{ route('user.buyer.job.bid.cancel', $bid->id) }}">
                                                        <i class="las la-ban"></i> @lang('Cancel')
                                                    </button>
                                                @endif

                                                @if (
                                                    ($bid->status == Status::APPROVED && $bid->working_status == Status::WORKING_INPROGRESS) ||
                                                        ($bid->status == Status::APPROVED && $bid->working_status == Status::WORKING_DELIVERED))
                                                    @if (request()->routeIs('user.buyer.hiring.list'))
                                                        <button class="dropdown-item confirmationBtn"
                                                            data-question="@lang('Are you sure to mark this bid as completed?')"
                                                            data-action="{{ route('user.buyer.hiring.completed', $bid->id) }}">
                                                            <i class="las la-check-circle"></i> @lang('Complete')
                                                        </button>
                                                    @endif

                                                    <button class="dropdown-item workUploadBtn"
                                                        data-route="{{ route('user.work.upload', $bid->id) }}"
                                                        data-worktype="job">
                                                        <i class="las la-truck-loading"></i>
                                                        @if (request()->routeIs('user.buyer.hiring.list'))
                                                            @lang('Document File')
                                                        @else
                                                            @lang('Work File')
                                                        @endif
                                                    </button>

                                                    <button class="dropdown-item disputeBtn" data-type="job"
                                                        data-route="{{ route('user.dispute', $bid->id) }}">
                                                        <i class="las la-bug"></i> @lang('Dispute')
                                                    </button>
                                                @endif

                                                @if (request()->routeIs('user.buyer.job.bidding.list') || request()->routeIs('user.buyer.hiring.list'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.buyer.hiring.details', $bid->id) }}">
                                                        <i class="las la-desktop"></i> @lang('Details')
                                                    </a>
                                                @else
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.seller.job.details', $bid->id) }}">
                                                        <i class="las la-desktop"></i> @lang('Details')
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">
                                        @include('Template::partials.empty', [
                                            'message' => 'No job bidding yet!',
                                        ])
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($biddingList->hasPages())
                        {{ paginateLinks($biddingList) }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modals for Confirmation, Dispute, and Work Delivery -->
    <x-confirmation-modal class="frontend" />
    @include('Template::partials.work_delivery_modal', ['type' => (request()->routeIs('user.buyer.hiring.list')? 'buyer' : 'seller')])
    @include('Template::partials.dispute_modal')
    @include('Template::partials.dispute_reason_modal')
@endsection
