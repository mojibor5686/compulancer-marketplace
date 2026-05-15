@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        @if (gs('default_service') == 'service')
            <div class="col-md-12 mb-30">
                <div class="card bl--5 border--primary">
                    <div class="card-body">
                        <p class="text--primary">
                            @lang('To display a service on the home page, you must manually set it as a featured service. Ensure
                                                                                                        the selected service is marked as featured for it to appear prominently.')
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
                                    <th>@lang('Estimated Delivery Time')</th>
                                    <th>@lang('Step')</th>
                                    <th>@lang('Status')</th>
                                    @canAny('admin.service.details', 'admin.service.reviews', 'admin.service.comments')
                                        <th>@lang('Action')</th>
                                    @endcanAny
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('service') . '/' . $service->image, getFileSize('service')) }}"
                                                        alt="@lang('image')">
                                                </div>
                                                <span>&nbsp{{ strLimit(__($service->name), 20) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $service->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                @can('admin.users.detail')
                                                    <a
                                                        href="{{ route('admin.users.detail', $service->user->id) }}"><span>@</span>{{ $service->user->username }}</a>
                                                @endcan
                                            </span>
                                        </td>
                                        <td>
                                            {{ strLimit(__(@$service->category->name), 20) }} <br>
                                            {{ strLimit(__(@$service->subCategory->name), 20) }}
                                        </td>
                                        <td><span class="fw-bold">{{ showAmount($service->price) }}</span></td>
                                        <td><span class="fw-bold">{{ $service->delivery_time }} @lang('Day(s)')</span>
                                        </td>
                                        <td> @php echo $service->stepBadge @endphp </td>
                                        <td> @php echo $service->customStatusBadge @endphp </td>

                                        @canAny('admin.service.details', 'admin.service.reviews', 'admin.service.comments')
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline--primary @if ($service->step < 4) disabled @endif"
                                                        id="actionButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="las la-ellipsis-v"></i>@lang('Action')
                                                    </button>
                                                    <div class="dropdown-menu p-0">
                                                        @can('admin.service.details')
                                                            <a href="{{ route('admin.service.details', $service->id) }}"
                                                                class="dropdown-item">
                                                                <i class="la la-desktop"></i> @lang('Details')
                                                            </a>
                                                        @endcan

                                                        @can('admin.service.reviews')
                                                            <a href="{{ route('admin.service.reviews', $service->id) }}"
                                                                class="dropdown-item">
                                                                <i class="las la-star"></i> @lang('Reviews')
                                                            </a>
                                                        @endcan
                                                        @can('admin.service.comments')
                                                            <a href="{{ route('admin.service.comments', $service->id) }}"
                                                                class="dropdown-item">
                                                                <i class="las la-comments"></i> @lang('Comments')
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        @endcanAny
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
                @if ($services->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($services) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search..." />
@endpush
