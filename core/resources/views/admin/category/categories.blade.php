@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Subcategory Count')</th>
                                    <th>@lang('Status')</th>
                                    @canAny('admin.subcategory.index', 'admin.category.status', 'admin.category.store')
                                        <th>@lang('Action')</th>
                                    @endcanAny
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->index + $categories->firstItem() }}</td>

                                        <!-- Category Image -->
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}"
                                                        alt="{{ __($category->name) }}" class="plugin_bg">
                                                </div>
                                            </div>
                                        </td>

                                        <td>{{ __($category->name) }}</td>
                                        <td>{{ $category->subcategories_count }}</td>
                                        <td>@php echo $category->statusBadge @endphp</td>

                                        @canAny('admin.subcategory.index', 'admin.category.status', 'admin.category.store')
                                            <td>
                                                <div class="button--group">
                                                    @can('admin.subcategory.index')
                                                        <a href="{{ route('admin.subcategory.index') }}?category_id={{ $category->id }}"
                                                            class="btn btn-sm btn-outline--info">
                                                            <i class="las la-list"></i>@lang('Subcategories')
                                                        </a>
                                                    @endcan

                                                    @can('admin.category.store')
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline--primary editCategoryBtn"
                                                            data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                                            data-image="{{ $category->image }}"
                                                            data-status="{{ $category->status }}">
                                                            <i class="la la-pencil"></i>@lang('Edit')
                                                        </button>
                                                    @endcan

                                                    @can('admin.category.status')
                                                        @if ($category->status == Status::DISABLE)
                                                            <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                                data-action="{{ route('admin.category.status', $category->id) }}"
                                                                data-question="@lang('Are you sure to enable this category?')">
                                                                <i class="la la-eye"></i> @lang('Enable')
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                                data-action="{{ route('admin.category.status', $category->id) }}"
                                                                data-question="@lang('Are you sure to disable this category?')">
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
                        </table>
                    </div>
                </div>

                @if ($categories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($categories) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create or Edit Modal -->
    <div id="categoryModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add/Edit Category')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data"
                    id="categoryForm">
                    @csrf
                    <input type="hidden" name="id" id="categoryId" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label>@lang('Image')</label>
                                <x-image-uploader image="" class="w-100" type="category" :required=true />
                            </div>
                            <div class="col-lg-12 form-group mt-3">
                                <label>@lang('Name')</label>
                                <input type="text" class="form-control" name="name" id="categoryName" required />
                            </div>
                        </div>
                    </div>
                    @can('admin.category.store')
                        <div class="modal-footer">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')

    @can('admin.category.store')
        <button type="button" class="btn btn-sm btn-outline--primary me-2 addCategoryBtn">
            <i class="las la-plus"></i>@lang('Add New')
        </button>
    @endcan
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var modal = $('#categoryModal');

            const imagePath = @json(route('home') . '/' . getFilePath('category'));

            $('.addCategoryBtn').on('click', function() {
                $('#categoryForm')[0].reset();
                $('#categoryId').val('');
                $('.modal-title').text('@lang('Add Category')');
                $('.image-upload-preview').css('background-image',
                    `url('{{ getImage(null, getFileSize('category')) }}')`);

                $(".image-upload-input").prop("required", true);
                modal.modal('show');
            });

            $('.editCategoryBtn').on('click', function() {
                $('#categoryForm')[0].reset();
                var id = $(this).data('id');
                var name = $(this).data('name');
                var image = $(this).data('image');

                $('#categoryId').val(id);
                $('#categoryName').val(name);
                $('.modal-title').text('@lang('Edit Category')');


                if (image) {
                    var imageUrl = `${imagePath}/${image}`;
                } else {
                    var imageUrl = '{{ getImage(null, getFileSize('category')) }}';
                }

                $('.image-upload-preview').css('background-image',
                    `url('${imageUrl}')`);
                $(".image-upload-input").prop("required", false);
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
