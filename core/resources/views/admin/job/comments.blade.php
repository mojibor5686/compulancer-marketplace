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
                                    <th>@lang('Job')</th>
                                    <th>@lang('Comment')</th>
                                    <th>@lang('Date')</th>
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
                                                        href="{{ route('admin.users.detail', $comment->user->id) }}"><span>@</span>{{ $comment->user->username }}</a>
                                                </span>
                                            @endcan
                                        </td>
                                        <td>
                                            @can('admin.job.details')
                                                <span class="fw-bold">
                                                    <a
                                                        href="{{ route('admin.job.details', $comment->job->id) }}">{{ strLimit(__($comment->job->name), 30) }}</a>
                                                </span>
                                            @endcan
                                        </td>
                                        <td>
                                            {{ strLimit($comment->comment, 50) }}
                                        </td>
                                        <td>
                                            {{ showDateTime($comment->created_at) }}<br>
                                            {{ diffForHumans($comment->created_at) }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline--primary showCommentBtn"
                                                data-comment="{{ $comment->comment }}">
                                                <i class="las la-eye"></i> @lang('View')
                                            </button>

                                            @can('admin.job.comments.delete')
                                                <button type="button" class="btn btn-sm btn-outline--danger confirmationBtn"
                                                    data-action="{{ route('admin.job.comments.delete', $comment->id) }}"
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

    <!-- Comment Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Full Comment')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="fullComment"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex justify-content-end align-items-center flex-wrap gap-2">
        <x-search-form placeholder="Search..." />
    </div>
@endpush

@push('script')
    <script>
        $('.showCommentBtn').on('click', function() {
            var modal = $('#commentModal');
            var comment = $(this).data('comment');
            modal.find('#fullComment').text(comment);
            modal.modal('show');
        });
    </script>
@endpush
