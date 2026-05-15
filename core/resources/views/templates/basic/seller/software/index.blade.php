@extends('Template::layouts.master')
@section('content')
    <!-- Dashboard Top Section with Search and Upload Button -->
    <div class="dashboard-top mb-4">
        <form class="search-form" method="GET">
            <div class="input-group">
                <input class="form-control form--control bg-white" type="text" name="search"
                    value="{{ request()->search ?? '' }}" placeholder="@lang('Search')...">
                <button class="btn btn--base" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        <a href="{{ route('user.seller.software.basic') }}" class="btn btn--base btn--lg" role="button">
            <i class="fas fa-plus"></i> <span>@lang('Upload Software')</span>
        </a>
    </div>

    <!-- Software Table Section -->
    <div class="table-section">
        <div class="table-area">
            <table class="table table--custom table-responsive--xl">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Step')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($softwares as $software)
                        <tr>
                            <td class="text-start">
                                <div class="author-info">
                                    <div class="thumb">
                                        <img src="{{ poster(@$software->image ? getFilePath('software') . '/' . @$software->image : 'assets/images/default.png', false) }}"
                                            alt="@lang('Software Image')">
                                    </div>
                                    <div class="content" data-bs-toggle="tooltip" title="{{ __($software->name) }}">
                                        {{ __(strLimit($software->name, 30)) }}
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div><span class="text-nowrap">{{ showAmount($software->price) }}</span></div>
                            </td>
                            <td>
                                <div>@php echo $software->stepBadge @endphp</div>
                            </td>
                            <td>
                                <div>@php echo $software->customStatusBadge @endphp</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-end justify-content-end gap-2">
                                    <!-- Show Details Button -->
                                    <button class="btn btn--base btn--sm show-details-btn" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="@lang('Show Details')"
                                        data-software='@json($software)'
                                        data-file="{{ encrypt($software->software_file) }}"
                                        data-document="{{ encrypt($software->document_file) }}">
                                        <i class="las la-desktop"></i>
                                    </button>

                                    <!-- Edit Button -->
                                    <a class="btn btn--base btn--sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-offset="0,8" href="{{ route('user.seller.software.basic', $software->id) }}"
                                        title="@lang('Edit')">
                                        <i class="las la-pencil-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="100%">
                                @include('Template::partials.empty', [
                                    'message' => 'No software uploaded yet!',
                                ])
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            @if ($softwares->hasPages())
                {{ paginateLinks($softwares) }}
            @endif
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="softwareDetailsModal" tabindex="-1" aria-labelledby="softwareDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="softwareDetailsModalLabel">@lang('Details')</h5>
                    <span class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <ul class="list-group userData list-group-flush" id="software-details-content">
                        <!-- Details will be dynamically inserted here -->
                    </ul>
                    <div class="feedback"></div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-end">
                    <a id="software-download-link" class="btn btn--base me-2">
                        <i class="las la-download me-1"></i>@lang('Download Software')
                    </a>
                    <a id="documentation-download-link" class="btn btn--base">
                        <i class="las la-download me-1"></i>@lang('Download Documentation')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            // Event listener for the Show Details button
            $('.show-details-btn').on('click', function() {
                var software = $(this).data('software');
                var fileEncrypted = $(this).data('file'); // Encrypted software file
                var documentEncrypted = $(this).data('document'); // Encrypted document file
                var modal = $('#softwareDetailsModal');

                // Get route with placeholders and replace them dynamically
                var downloadSoftwareRoute = "{{ route('file.download', [':file', 'file']) }}".replace(':file',
                    fileEncrypted);
                var downloadDocumentationRoute = "{{ route('file.download', [':file', 'documentation']) }}"
                    .replace(':file', documentEncrypted);

                // Use general settings for the currency symbol
                var currencySymbol = "{{ gs('cur_sym') }}";

                // Format the date
                const updatedAt = new Date(software.updated_at);
                const formattedDate = new Intl.DateTimeFormat('en-US', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }).format(updatedAt);

                // Build the list-group content
                var detailsHtml = `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ __('Name') }}</span>
                    <span>${software.name}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ __('Category') }}</span>
                    <span>${software.category.name}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ __('Price') }}</span>
                    <span>${currencySymbol}${parseFloat(software.price).toFixed(2)}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ __('Last Update') }}</span>
                    <span>${formattedDate}</span>
                </li>
            `;

                // Populate the modal content
                modal.find('#software-details-content').html(detailsHtml);

                // Update download links
                $('#software-download-link').attr('href', downloadSoftwareRoute);
                $('#documentation-download-link').attr('href', downloadDocumentationRoute);

                // Show the modal
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
