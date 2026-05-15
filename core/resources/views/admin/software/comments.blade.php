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
                                    <th>@lang('Comment')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($comments as $comment)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ @$comment->user->fullname }}</span>
                                            @can('admin.users.detail')
                                                <br>
                                                <span class="small">
                                                    <a
                                                        href="{{ route('admin.users.detail', $comment->user_id) }}"><span>@</span>{{ @$comment->user->username }}</a>
                                                </span>
                                            @endcan
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ __(@$comment->software->name) }}</span>
                                        </td>
                                        <td>{{ __($comment->comment) }}</td>
                                        <td>
                                            @can('admin.software.comments.delete')
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                    data-action="{{ route('admin.software.comments.delete', $comment->id) }}"
                                                    data-question="@lang('Are you sure to delete this comment?')">
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
                @if ($comments->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($comments) }}
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
