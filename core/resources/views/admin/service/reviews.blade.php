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
                                    <th>@lang('Service')</th>
                                    <th>@lang('Reviewer')</th>
                                    <th>@lang('Rating')</th>
                                    <th>@lang('Review')</th>
                                    <th>@lang('Date')</th>
                                    @can('admin.service.reviews.delete')
                                        <th>@lang('Action')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reviews as $review)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('service') . '/' . @$review->service->image, getFileSize('service')) }}"
                                                        alt="@lang('image')">
                                                </div>
                                                <span>&nbsp{{ strLimit(__(@$review->service->name), 20) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ @$review->user->fullname }}</span>
                                            @can('admin.users.detail')
                                            <br>
                                            <span class="small">
                                                    <a href="{{ route('admin.users.detail', $review->user_id) }}">
                                                        <span>@</span>{{ @$review->user->username }}
                                                    </a>
                                                </span>
                                                @endcan
                                        </td>
                                        <td>
                                            <span class="fw-bold text--warning">
                                                {{ $review->rating }} <i class="las la-star"></i>
                                            </span>
                                        </td>
                                        <td>{{ strLimit($review->review, 50) }}</td>
                                        <td>{{ showDateTime($review->created_at) }}</td>

                                        @can('admin.service.reviews.delete')
                                            <td>
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                    data-action="{{ route('admin.service.reviews.delete', $review->id) }}"
                                                    data-question="@lang('Are you sure to delete this review?')">
                                                    <i class="la la-trash"></i> @lang('Delete')
                                                </button>
                                            </td>
                                        @endcan
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
                @if ($reviews->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($reviews) }}
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
