@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
            <div class="row gy-4">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body">
                            <a href="{{ getImage(getFilePath('job') . '/' . $job->image, getFileSize('job')) }}"
                                data-rel="lightcase">
                                <img src="{{ getImage(getFilePath('job') . '/' . $job->image, getFileSize('job')) }}"
                                    alt="@lang('job image')" class="w-100">
                            </a>
                            <h5 class="mt-3">{{ __($job->name) }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card ">
                        <div class="card-header">
                            <h5>@lang('User Information')</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Name')
                                    <span class="fw-bold">{{ $job->user->fullname }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Username')
                                    <span class="fw-bold"><a
                                            href="{{ route('admin.users.detail', $job->user->id) }}">{{ $job->user->username }}</a></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Status')
                                    @if ($job->user->status)
                                        <span class="badge badge--success">@lang('Active')</span>
                                    @else
                                        <span class="badge badge--danger">@lang('Banned')</span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Balance')
                                    <span class="fw-bold">{{ showAmount($job->user->balance) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5>@lang('Tags')</h5>
                        </div>
                        <div class="card-body">
                            <div class="tag-list {{ !@$job->skill ? 'd-flex justify-content-center flex-wrap' : '' }}">
                                @forelse (@$job->skill ?? [] as $skill)
                                    <span class="tag-item">
                                        <i class="las la-check"></i>
                                        {{ __($skill) }}
                                    </span>
                                @empty
                                    <div class="text-center text-muted">
                                        <i class="las la-check empty-tag"></i>
                                        <p>@lang('No tags found')</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12">
            <div class="row gy-4">
                <div class="col-12">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5>@lang('Job Information')</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Category')
                                    <span class="fw-bold">{{ __(@$job->category->name) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Subcategory')
                                    <span class="fw-bold">{{ __(@$job->subCategory->name) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Price')
                                    <span class="fw-bold">{{ showAmount($job->price) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Estimated Delivery Time')
                                    <span class="fw-bold">{{ $job->delivery_time }} @lang('Day(s)')</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Total Bid(s)')
                                    <span class="fw-bold">{{ $job->total_bid }} @lang('Day(s)')</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Status')
                                    <span class="fw-bold">@php echo $job->customStatusBadge @endphp</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Last Update')
                                    <span class="fw-bold">{{ diffforhumans($job->updated_at) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>@lang('Description')</h5>
                        </div>
                        <div class="card-body">
                            @php echo $job->description @endphp
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <h5 class="card-header">@lang('Requirements')</h5>
                        <div class="card ">
                            <div class="card-body p-3">
                                @php echo $job->requirements @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    @can('admin.job.status.change')
        @if ($job->status == Status::PENDING)
            <button class="btn btn-sm btn-outline--success confirmationBtn"
                data-action="{{ route('admin.job.status.change', [$job->id, 'approve']) }}"
                data-question="@lang('Are you sure to Approve this job')?">

                <i class="las la-check-circle"></i>@lang('Approve')
            </button>
            <button class="btn btn-sm btn-outline--danger confirmationBtn"
                data-action="{{ route('admin.job.status.change', [$job->id, 'cancel']) }}" data-question="@lang('Are you sure to reject this job')?">
                <i class="lar la-times-circle"></i>@lang('Reject')
            </button>
        @endif
    @endcan

    @can('admin.job.featured')
        @if ($job->status == Status::APPROVED)
            @if ($job->featured)
                <button type="button" class="btn btn-sm btn-outline--warning confirmationBtn"
                    data-action="{{ route('admin.job.featured', [$job->id, 'unfeatured']) }}"
                    data-question="@lang('Are you sure to make unfeatured this job')?">
                    <i class="las la-star-half-alt"></i>@lang('Unfeature Job')
                </button>
            @else
                <button type="button" class="btn btn-sm btn-outline--primary confirmationBtn"
                    data-action="{{ route('admin.job.featured', [$job->id, 'featured']) }}"
                    data-question="@lang('Are you sure to make featured this job')?">
                    <i class="las la-star"></i>@lang('Feature Job')
                </button>
            @endif
        @endif
    @endcan

    @can('admin.job.all')
        <x-back route="{{ route('admin.job.all') }}" />
    @endcan
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/lightcase.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/lightcase.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('a[data-rel^=lightcase]').lightcase();
        })(jQuery);
    </script>
@endpush
