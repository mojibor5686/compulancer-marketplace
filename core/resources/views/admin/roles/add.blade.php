@extends('admin.layouts.app')
@section('panel')
    <form action="{{ route('admin.roles.save', @$role->id) }}" method="post">
        @csrf
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">@lang('Name')</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', @$role->name) }}">
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">@lang('Set Permissions')</h5>
                        <div>
                            <button type="button" class="btn btn-sm btn--primary select-all"><i
                                    class="las la-check-square"></i> @lang('Select All')</button>
                            <button type="button" class="btn btn-sm btn--danger deselect-all"><i class="las la-square"></i>
                                @lang('Deselect All')</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div class="row gy-4">
                                @foreach ($permissionGroups as $key => $permissionGroup)
                                    <div class="col-12">
                                        <div class="permission-item position-relative">
                                            <div class="row gy-2 justify-content-center align-items-center">
                                                <div class="col-12 col-sm-3 d-flex flex-column justify-content-between">
                                                    <span
                                                        class="fw-bold">{{ Str::replaceLast('Controller', '', $key) }}</span>
                                                    <div class="select-all-group mt-2">
                                                        <input type="checkbox" class="group-select-all"
                                                            data-group="{{ $key }}"
                                                            id="selectAll{{ $key }}">
                                                        <label for="selectAll{{ $key }}"
                                                            class="ms-1">@lang('Select All')</label>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-sm-9">
                                                    <div class="row g-3">
                                                        @foreach ($permissionGroup as $permission)
                                                            <div class="col-12 col-sm-6 col-xl-4">
                                                                <div
                                                                    class="custom-control custom-checkbox form-check-primary">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input group-checkbox-{{ $key }}"
                                                                        name="permissions[]" value="{{ $permission->id }}"
                                                                        id="customCheck{{ $permission->id }}">
                                                                    <label class="custom-control-label text-break"
                                                                        for="customCheck{{ $permission->id }}">{{ $permission->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @can('admin.roles.save')
                <div class="col-lg-12">
                    <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                </div>
            @endcan
        </div>
    </form>
@endsection

@push('style')
    @push('style')
        <style>
            .permission-item {
                background: #fafafa;
                border: 1px solid #f7f7f7;
                padding: 1rem;
                position: relative;
            }
        </style>
    @endpush

@endpush


@push('script')
    <script>
        (function($) {
            "use strict";

            // Set permissions if they exist
            @isset($permissions)
                $('input[name="permissions[]"]').val(@json($permissions));
            @endisset

            // Function to update "Select All" checkbox state for each group
            function updateSelectAllCheckbox() {
                $('.group-select-all').each(function() {
                    let group = $(this).data('group');
                    let totalCheckboxes = $('.group-checkbox-' + group).length;
                    let checkedCheckboxes = $('.group-checkbox-' + group + ':checked').length;

                    // If all checkboxes in a group are checked, check "Select All"
                    $(this).prop('checked', totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes);
                });
            }

            // Run the function on page load to check current selection state
            $(document).ready(function() {
                updateSelectAllCheckbox();
            });

            // Global Select All
            $('.select-all').on('click', function() {
                $('input[name="permissions[]"]').prop('checked', true);
                updateSelectAllCheckbox();
            });

            // Global Deselect All
            $('.deselect-all').on('click', function() {
                $('input[name="permissions[]"]').prop('checked', false);
                updateSelectAllCheckbox();
            });

            // Select All for Each Group
            $('.group-select-all').on('change', function() {
                let group = $(this).data('group');
                $('.group-checkbox-' + group).prop('checked', $(this).prop('checked'));
            });

            // Update "Select All" when any individual checkbox is changed
            $('input[name="permissions[]"]').on('change', function() {
                updateSelectAllCheckbox();
            });
        })(jQuery);
    </script>
@endpush
