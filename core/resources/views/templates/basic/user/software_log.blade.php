@extends('Template::layouts.master')
@section('content')
    <div class="row gy-4">
        <!-- Filter Section -->
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
                            <!-- Search Filter (Order Number / Buyer/Seller) -->
                            <div class="flex-grow-1">
                                <label class="form-label form--label">
                                    @if (request()->routeIs('user.seller.sale.software.log'))
                                        @lang('Order Number / Buyer / Software Name')
                                    @else
                                        @lang('Order Number / Seller / Software Name')
                                    @endif
                                </label>
                                <input class="form-control form--control" type="text" name="search"
                                    value="{{ request()->search }}">

                                <input type="hidden" name="type"
                                    value="{{ request()->routeIs('user.seller.sale.software.log') ? 'buyer' : 'seller' }}">
                            </div>

                            <!-- Sort By Filter (Price) -->
                            <div class="flex-grow-1 min-w-150">
                                <label class="form-label form--label">@lang('Sort By')</label>
                                <select class="form-select form--select select2-basic" name="sort_by">
                                    <option value="">@lang('Default')</option>
                                    <option value="price_asc" @selected(request()->sort_by == 'price_asc')>
                                        @lang('Price: Low to High')
                                    </option>
                                    <option value="price_desc" @selected(request()->sort_by == 'price_desc')>
                                        @lang('Price: High to Low')
                                    </option>
                                </select>
                            </div>

                            <!-- Filter Button -->
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--base w-100 h-100 h-50 ">
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
                                <th>@lang('Software')</th>
                                <th>@lang('Order Number')</th>
                                @if (request()->routeIs('user.buyer.software.log'))
                                    <th>@lang('Seller')</th>
                                @else
                                    <th>@lang('Buyer')</th>
                                @endif
                                <th>@lang('Price')</th>
                                <th>@lang('Status')</th>
                                @if (request()->routeIs('user.buyer.software.log'))
                                    <th>@lang('Action')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($softwareLog as $log)
                                <tr>
                                    <td class="text-start">
                                        <div class="author-info">
                                            <div class="thumb">
                                                <img src="{{ poster(@$log->software->image ? getFilePath('software') . '/' . @$log->software->image : 'assets/images/default.png', false) }}"
                                                    alt="@lang('Software Image')">
                                            </div>
                                            <div class="content">
                                                <a href="{{ route('software.details', [slug($log->software->name), $log->software->id]) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __($log->software->name) }}">
                                                    <span>{{ __(strLimit($log->software->name, 30)) }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ __($log->order_number) }}</td>

                                    @if (request()->routeIs('user.buyer.software.log'))
                                        <td>
                                            <div>
                                                <span class="fw-bold">{{ __($log->seller->fullname) }}</span>
                                                <br>
                                                <span class="text--info">
                                                    <a href="{{ route('public.profile', $log->seller->username) }}">
                                                        <span>@</span>{{ $log->seller->username }}
                                                    </a>
                                                </span>
                                            </div>
                                        </td>
                                    @else
                                        <td>
                                            <div>
                                                <span class="fw-bold">{{ __($log->buyer->fullname) }}</span>
                                                <br>
                                                <span class="text--info">
                                                    <a href="{{ route('public.profile', $log->buyer->username) }}">
                                                        <span>@</span>{{ $log->buyer->username }}
                                                    </a>
                                                </span>
                                            </div>
                                        </td>
                                    @endif

                                    <td class="text-md-center">
                                        <div>
                                            @if ($log->discount > 0)
                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="@lang('Price')">{{ showAmount($log->price) }}</span>
                                                - <span class="text--danger" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="@lang('Discount')">{{ showAmount($log->discount) }}</span>
                                                <br>
                                                <strong data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="@lang('Final Price')">
                                                    {{ showAmount($log->price - $log->discount) }}
                                                </strong>
                                            @else
                                                <strong data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="@lang('Price')">
                                                    {{ showAmount($log->price) }}
                                                </strong>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        @if ($log->status == Status::BOOKING_PAID)
                                            <div>
                                                <span class="badge badge--success">@lang('Paid')</span>
                                                <br>
                                                <span>{{ diffforhumans($log->updated_at) }}</span>
                                            </div>
                                        @else
                                            <span class="badge badge--warning">@lang('N/A')</span>
                                        @endif
                                    </td>

                                    @if (request()->routeIs('user.buyer.software.log'))
                                        @if ($log->status == Status::BOOKING_PAID)
                                            <td>
                                                <a href="{{ route('software.details', [slug($log->software->name), $log->software->id]) }}?review=true"
                                                    class="btn btn--warning text-white btn-sm ms-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="@lang('Write a review')">
                                                    <i class="las la-star"></i>
                                                </a>
                                                <button class="btn btn--base text-white btn-sm ms-1 details-btn"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-url-software="{{ route('file.download', [encrypt($log->software->software_file), 'file']) }}"
                                                    data-url-documentation="{{ route('file.download', [encrypt($log->software->document_file), 'documentation']) }}"
                                                    title="@lang('Download')">
                                                    <i class="las la-desktop"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td><span class="badge badge--warning">@lang('N/A')</span></td>
                                        @endif
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">
                                        @include('Template::partials.empty', [
                                            'message' => 'No software sales yet!',
                                        ])
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    @if ($softwareLog->hasPages())
                        {{ paginateLinks($softwareLog) }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (request()->routeIs('user.buyer.software.log'))
        <!-- Details Modal -->
        <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Download')</h5>
                        <span class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </span>
                    </div>
                    <div class="modal-body">
                        <div id="detailsModalContent" class="row">
                            <!-- Software Section -->
                            <div class="col-md-6">
                                <div class="software-section mb-4">
                                    <h6 class="text--title mb-0">@lang('Software')</h6>
                                    <p class="small text-muted my-2">@lang('Download the software you purchased.')</p>
                                    <a href="#" id="softwareDownloadLink" class="btn btn--base btn--sm">
                                        <i class="las la-download"></i> @lang('Download Software')
                                    </a>
                                </div>
                            </div>

                            <!-- Documentation Section -->
                            <div class="col-md-6">
                                <div class="documentation-section mb-4">
                                    <h6 class="text--title mb-0">@lang('Documentation')</h6>
                                    <p class="small text-muted my-2">@lang('Get the documentation to understand usage and setup.')</p>
                                    <a href="#" id="documentationDownloadLink" class="btn btn--base btn--sm">
                                        <i class="las la-download"></i> @lang('Download Documentation')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection

@push('script')
    @if (request()->routeIs('user.buyer.software.log'))
        <script>
            (function($) {
                "use strict";

                $('.details-btn').on('click', function() {
                    // Get the URLs from data attributes
                    var urlSoftware = $(this).data('url-software');
                    var urlDocumentation = $(this).data('url-documentation');

                    // Populate the modal links
                    $('#softwareDownloadLink').attr('href', urlSoftware);
                    $('#documentationDownloadLink').attr('href', urlDocumentation);

                    // Show the modal
                    $('#detailsModal').modal('show');
                });
            })(jQuery);
        </script>
    @endif
@endpush
