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
                                    <th>@lang('Code')</th>
                                    <th>@lang('Value')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Expiry')</th>
                                    <th>@lang('Uses Left')</th>
                                    <th>@lang('Status')</th>
                                    @canAny('admin.coupon.store', 'admin.coupon.status')
                                        <th>@lang('Action')</th>
                                    @endcanAny
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $loop->index + $coupons->firstItem() }}</td>
                                        <td>{{ __($coupon->name) }}</td>
                                        <td>{{ $coupon->code }}</td>
                                        <td>
                                            @php echo $coupon->valueData @endphp
                                        </td>
                                        <td>
                                            @php echo $coupon->typeBadge @endphp
                                        </td>
                                        <td>
                                            {{ $coupon->expiry_date ? date('Y-m-d', strtotime($coupon->expiry_date)) : 'Lifetime' }}
                                        </td>
                                        <td>
                                            {{ $coupon->usage_limit == -1 ? 'Unlimited' : $coupon->usage_limit }}
                                        </td>
                                        <td>
                                            @php echo $coupon->statusBadge @endphp
                                        </td>
                                        @canAny('admin.coupon.store', 'admin.coupon.status')
                                            <td>
                                                <div class="button--group">
                                                    @can('admin.coupon.store')
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline--primary cuModalBtn editBtn"
                                                            data-resource="{{ $coupon }}" data-modal_title="@lang('Edit Coupon')"
                                                            data-has_status="1">
                                                            <i class="la la-pencil"></i>@lang('Edit')
                                                        </button>
                                                    @endcan
                                                    @can('admin.coupon.status')
                                                        @if ($coupon->status == Status::DISABLE)
                                                            <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                                data-action="{{ route('admin.coupon.status', $coupon->id) }}"
                                                                data-question="@lang('Are you sure to enable this coupon')?" type="button">
                                                                <i class="la la-eye"></i> @lang('Enable')
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                                data-action="{{ route('admin.coupon.status', $coupon->id) }}"
                                                                data-question="@lang('Are you sure to disable this coupon')?" type="button">
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
                @if ($coupons->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($coupons) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- Create or Update Modal --}}
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.coupon.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="@lang('Enter Coupon Name')" value="{{ old('name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Code')</label>
                                    <input type="text" class="form-control" name="code"
                                        placeholder="@lang('Enter Code')" value="{{ old('code') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Type')</label>
                                    <select name="type" class="form-control select2" data-minimum-results-for-search="-1"
                                        required>
                                        <option value="1">@lang('Fixed')</option>
                                        <option value="2">@lang('Percentage')</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Discount Value')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="value"
                                            min="0" placeholder="@lang('Enter Discount Value')" value="{{ old('value') }}"
                                            required>
                                        <span class="input-group-text fixed-percentage">{{ __(gs('cur_text')) }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Expiry Type')</label>
                                    <select name="expiry_type" class="form-control select2"
                                        data-minimum-results-for-search="-1" required>
                                        <option value="lifetime">@lang('Lifetime')</option>
                                        <option value="date">@lang('Specific Date')</option>
                                    </select>
                                </div>
                                <div class="form-group expiry-date d-none">
                                    <label>@lang('Expiry Date')</label>
                                    <input type="date" class="form-control" name="expiry_date" min="{{ date('Y-m-d') }}"
                                        value="{{ old('expiry_date') }}">
                                </div>
                                <div class="form-group">
                                    <label>@lang('Usage Limit')</label>
                                    <input type="number" class="form-control" name="usage_limit"
                                        placeholder="@lang('Enter Usage Limit')" value="{{ old('usage_limit') ?? 0 }}" required>
                                    <p><small class="text-primary fw-bold text-center"><i
                                                class="las la-info-circle"></i><i>@lang('Enter -1 for unlimited usage')</i></small></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @can('admin.coupon.store')
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
    <x-search-form placeholder="Name / Code" />
    <button type="button" class="btn btn-sm btn-outline--primary me-2 cuModalBtn" data-modal_title="@lang('Add New Coupon')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('[name=type]').on('change', function() {
                var value = $(this).val();

                if (value == 1) {
                    $('#cuModal').find('.fixed-percentage').text("{{ __(gs('cur_text')) }}");
                } else {
                    $('#cuModal').find('.fixed-percentage').text('%');
                }
            });

            $('[name=expiry_type]').on('change', function() {
                var value = $(this).val();
                if (value == 'date') {
                    $('.expiry-date').removeClass('d-none');
                    $('[name=expiry_date]').prop('required', true);
                } else {
                    $('.expiry-date').addClass('d-none');
                    $('[name=expiry_date]').prop('required', false);
                }
            });

            $('.cuModalBtn').on('click', function() {
                $('#cuModal').find('.fixed-percentage').text("{{ __(gs('cur_text')) }}");
            });

            $('.editBtn').on('click', function() {
                var resource = $(this).data('resource');

                if (resource.type == 1) {
                    $('#cuModal').find('.fixed-percentage').text(`{{ __(gs('cur_text')) }}`);
                } else {
                    $('#cuModal').find('.fixed-percentage').text('%');
                }

                if (resource.expiry_date) {
                    $('[name=expiry_type]').val('date').trigger('change');
                    $('[name=expiry_date]').val(resource.expiry_date);
                } else {
                    $('[name=expiry_type]').val('lifetime').trigger('change');
                }
            });

            $('#cuModal').find('[name=code]').on('keyup', function(e) {
                var keyCode = e.keyCode || e.which;
                var regex = /^[A-Za-z0-9]+$/;
                var isValid = regex.test(String.fromCharCode(keyCode));
                if (e.keyCode == 32) {
                    $(this).val($(this).val().replace(/\s+/g, '-'));
                }
            });
        })(jQuery);
    </script>
@endpush
