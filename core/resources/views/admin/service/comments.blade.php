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
                                    <th>@lang('Commenter')</th>
                                    <th>@lang('Comment')</th>
                                    <th>@lang('Date')</th>
                                    @can('admin.service.comments.delete')
                                        <th>@lang('Action')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($comments as $comment)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('service') . '/' . @$comment->service->image, getFileSize('service')) }}"
                                                        alt="@lang('image')">
                                                </div>
                                                <span>&nbsp{{ strLimit(__(@$comment->service->name), 20) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ @$comment->user->fullname }}</span>
                                            @can('admin.users.detail')
                                            <br>
                                            <span class="small">
                                                    <a href="{{ route('admin.users.detail', $comment->user_id) }}">
                                                        <span>@</span>{{ @$comment->user->username }}
                                                    </a>
                                                </span>
                                                @endcan
                                        </td>
                                        <td>{{ strLimit($comment->comment, 50) }}</td>
                                        <td>{{ showDateTime($comment->created_at) }}</td>

                                        @can('admin.service.comments.delete')
                                            <td>
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                    data-action="{{ route('admin.service.comments.delete', $comment->id) }}"
                                                    data-question="@lang('Are you sure to delete this comment?')">
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
