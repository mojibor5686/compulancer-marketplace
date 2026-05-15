@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        @if (gs('default_service') == 'job')
            <div class="col-md-12 mb-30">
                <div class="card bl--5 border--primary">
                    <div class="card-body">
                        <p class="text--primary">
                            @lang('To display a job on the home page, you must manually set it as a featured job. Ensure
                                                                                                        the selected job is marked as featured for it to appear prominently.')
                        </p>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Category / SubCategory')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Delivery Time')</th>
                                    <th>@lang('Step')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jobs as $job)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb"><img
                                                        src="{{ getImage(getFilePath('job') . '/' . $job->image, getFileSize('job')) }}"
                                                        alt="@lang('image')"></div>
                                                <span>&nbsp{{ strLimit(__($job->name), 20) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ @$job->user->fullname }}</span>
                                            @can('admin.users.detail')
                                                <br>
                                                <span class="small">
                                                    <a
                                                        href="{{ route('admin.users.detail', $job->user->id) }}"><span>@</span>{{ $job->user->username }}</a>
                                                </span>
                                            @endcan
                                        </td>
                                        <td>
                                            {{ strLimit(__(@$job->category->name), 20) }} <br>
                                            {{ strLimit(__(@$job->subCategory->name), 20) }}
                                        </td>
                                        <td><span class="fw-bold">{{ showAmount($job->price) }}</span></td>
                                        <td><span class="fw-bold">{{ $job->delivery_time }} @lang('Day(s)')</span></td>
                                        <td> @php echo $job->stepBadge @endphp </td>
                                        <td> @php echo $job->customStatusBadge @endphp </td>
                                        <td>
                                            <div class="button--group">
                                                @can('admin.job.bidding.list')
                                                    @if ($job->status != Status::PENDING)
                                                        <a class="btn btn-sm btn-outline--info"
                                                            href="{{ route('admin.job.bidding.list', $job->id) }}">
                                                            <i class="la la-list"></i>@lang('Bidding List')
                                                        </a>
                                                    @endif
                                                @endcan
                                                @canAny('admin.job.details', 'admin.job.comments')
                                                    <div class="dropdown d-inline-block">
                                                        <button
                                                            class="btn btn-sm btn-outline--primary @if ($job->step < 4) disabled @endif"
                                                            id="actionButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="las la-ellipsis-v"></i>@lang('Action')
                                                        </button>
                                                        <div class="dropdown-menu p-0">
                                                            @can('admin.job.details')
                                                                <a href="{{ route('admin.job.details', $job->id) }}"
                                                                    class="dropdown-item">
                                                                    <i class="la la-desktop"></i> @lang('Details')
                                                                </a>
                                                            @endcan
                                                            @can('admin.job.comments')
                                                                <a href="{{ route('admin.job.comments', $job->id) }}"
                                                                    class="dropdown-item">
                                                                    <i class="las la-comments"></i> @lang('Comments')
                                                                </a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                @endcanAny
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>

                @if ($jobs->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($jobs) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>

    </style>
@endpush

@push('breadcrumb-plugins')
    <div class="d-flex justify-content-end align-items-center flex-wrap gap-2">
        <x-search-form placeholder="Search..." />
    </div>
@endpush
