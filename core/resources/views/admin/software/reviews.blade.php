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
                                    <th>@lang('User')</th>
                                    <th>@lang('Software')</th>
                                    <th>@lang('Rating')</th>
                                    <th>@lang('Review')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reviews as $review)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ @$review->user->fullname }}</span>
                                            @can('admin.users.detail')
                                                <br>
                                                <span class="small">
                                                    <a
                                                        href="{{ route('admin.users.detail', $review->user_id) }}"><span>@</span>{{ @$review->user->username }}</a>
                                                </span>
                                            @endcan
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ __(@$review->software->name) }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text--warning">
                                                @for ($i = 0; $i < $review->rating; $i++)
                                                    <i class="las la-star"></i>
                                                @endfor
                                            </span>
                                        </td>
                                        <td>{{ __($review->review) }}</td>
                                        <td>
                                            @can('admin.software.reviews.delete')
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                    data-action="{{ route('admin.software.reviews.delete', $review->id) }}"
                                                    data-question="@lang('Are you sure to delete this review?')">
                                                    <i class="la la-trash"></i> @lang('Delete')
                                                </button>
                                            @endcan
                                        </td>
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
