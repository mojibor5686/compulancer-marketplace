@extends('admin.layouts.app')
@section('panel')
    <div class="row">

        @if (gs('default_service') == 'software')
            <div class="col-md-12 mb-30">
                <div class="card bl--5 border--primary">
                    <div class="card-body">
                        <p class="text--primary">
                            @lang('To display a software on the home page, you must manually set it as a featured software. Ensure
                                                                                    the selected software is marked as featured for it to appear prominently.')
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
                                    <th>@lang('Step')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Software') | @lang('Documentation')</th>
                                    @canAny('admin.software.details', 'admin.software.reviews', 'admin.software.comments')
                                        <th>@lang('Action')</th>
                                    @endcanAny
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($softwares as $software)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('software') . '/' . $software->image, getFileSize('software')) }}"
                                                        alt="@lang('image')">
                                                </div>
                                                <span>&nbsp;{{ strLimit(__($software->name), 20) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $software->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                @can('admin.users.detail')
                                                    <a
                                                        href="{{ route('admin.users.detail', $software->user->id) }}"><span>@</span>{{ $software->user->username }}</a>
                                                @endcan
                                            </span>
                                        </td>
                                        <td>
                                            {{ strLimit(__($software->category->name), 20) }} <br>
                                            {{ strLimit(__($software->subCategory->name), 20) }}
                                        </td>
                                        <td><span class="fw-bold">{{ showAmount($software->price) }}</span></td>
                                        <td> @php echo $software->stepBadge @endphp </td>
                                        <td> @php echo $software->customStatusBadge @endphp </td>
                                        <td>
                                            <a class="btn btn-sm btn-outline--primary"data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                href="{{ route('file.download', [encrypt($software->software_file), 'file']) }}"
                                                title="@lang('Software File')">
                                                <i class="las la-download ms-1"></i>
                                            </a>
                                            &nbsp;|&nbsp;
                                            <a class="btn btn-sm btn-outline--primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                href="{{ route('file.download', [encrypt($software->document_file), 'documentation']) }}"
                                                title="@lang('Document File')">
                                                <i class="las la-download ms-1"></i>
                                            </a>
                                        </td>
                                        @canAny('admin.software.details', 'admin.software.reviews', 'admin.software.comments')
                                            <td>
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-sm btn-outline--primary @if ($software->step < 4) disabled @endif"
                                                        id="actionButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="las la-ellipsis-v"></i>@lang('Action')
                                                    </button>
                                                    <div class="dropdown-menu p-0">
                                                        @canAny('admin.software.details')
                                                            <a href="{{ route('admin.software.details', $software->id) }}"
                                                                class="dropdown-item">
                                                                <i class="la la-desktop"></i> @lang('Details')
                                                            </a>
                                                        @endcan
                                                        @canAny('admin.software.reviews')
                                                            <a href="{{ route('admin.software.reviews', $software->id) }}"
                                                                class="dropdown-item">
                                                                <i class="las la-star"></i> @lang('Reviews')
                                                            </a>
                                                        @endcan
                                                        @canAny('admin.software.comments')
                                                            <a href="{{ route('admin.software.comments', $software->id) }}"
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
                        </table>
                    </div>
                </div>
                @if ($softwares->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($softwares) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search..." />
@endpush
