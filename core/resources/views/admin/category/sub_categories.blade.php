@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Status')</th>
                                    @canAny('admin.subcategory.status', 'admin.subcategory.store')
                                        <th>@lang('Action')</th>
                                    @endcanAny
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subcategories as $subcategory)
                                    <tr>
                                        <td>{{ $loop->index + $subcategories->firstItem() }}</td>
                                        <td>{{ __($subcategory->name) }}</td>
                                        <td>
                                            <div class="user justify-content-center">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('subcategory') . '/' . $subcategory->image, getFileSize('subcategory')) }}"
                                                        alt="@lang('image')">
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ __(@$subcategory->category->name) }}</td>
                                        <td>
                                            @php echo $subcategory->statusBadge @endphp
                                        </td>
                                        @canAny('admin.subcategory.status', 'admin.subcategory.store')
                                            <td>
                                                @php
                                                    $subcategory->image_with_path = getImage(
                                                        getFilePath('subcategory') . '/' . $subcategory->image,
                                                        getFileSize('subcategory'),
                                                    );
                                                @endphp
                                                <div class="button--group">
                                                    @can('admin.subcategory.store')
                                                        <button class="btn btn-sm btn-outline--primary cuModalBtn"
                                                            data-resource="{{ $subcategory }}" data-modal_title="@lang('Edit Subcategory')"
                                                            data-has_status="1" type="button">
                                                            <i class="la la-pencil"></i>@lang('Edit')
                                                        </button>
                                                    @endcan
                                                    @can('admin.subcategory.status')
                                                        @if ($subcategory->status == Status::DISABLE)
                                                            <button class="btn btn-sm btn-outline--success confirmationBtn"
                                                                data-action="{{ route('admin.subcategory.status', $subcategory->id) }}"
                                                                data-question="@lang('Are you sure to enable this subcategory?')" type="button">
                                                                <i class="la la-eye"></i> @lang('Enable')
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                                data-action="{{ route('admin.subcategory.status', $subcategory->id) }}"
                                                                data-question="@lang('Are you sure to disable this subcategory?')" type="button">
                                                                <i class="la la-eye-slash"></i> @lang('Disable')
                                                            </button>
                                                        @endif
                                                    @endcan
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

                @if ($subcategories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($subcategories) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Create or Update Modal --}}
    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.subcategory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input class="form-control" name="name" type="text" value="{{ old('name') }}"
                                        placeholder="" required />
                                </div>
                                <div class="form-group">
                                    <label>@lang('Category')</label>
                                    <select class="form-control select2" name="category_id" required>
                                        <option value="" selected disabled>@lang('Select One')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Image')</label>
                                    <x-image-uploader class="w-100" type="subcategory" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @can('admin.subcategory.store')
                        <div class="modal-footer">
                            <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />

    @can('admin.subcategory.store')
        <button class="btn btn-sm btn-outline--primary cuModalBtn"
            data-image_path="{{ getImage(null, getFileSize('subcategory')) }}" data-modal_title="@lang('Add New Subcategory')"
            type="button">
            <i class="las la-plus"></i>@lang('Add New')
        </button>
    @endcan
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>
@endpush
