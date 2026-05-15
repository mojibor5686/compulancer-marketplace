@php
    $comments = $itemDetails
        ->comments()
        ->latest()
        ->with(['user', 'replies', 'replies.user'])
        ->limit(6)
        ->get();
@endphp

<div class="tab-pane" id="comment" role="tabpanel">
    <div>
        <div class="mb-40 P-3">
            @auth
                <form method="POST" action="{{ route('user.comment.store') }}">
                    @csrf
                    <input name="product_id" type="hidden" value="{{ $itemDetails->id }}">
                    <input name="type" type="hidden" value="{{ $type }}">

                    <textarea class="form-control" name="comment" placeholder="@lang('Enter your Comment')" rows="5" required></textarea>
                    <button class="submit-btn mt-20" type="submit">@lang('Submit')</button>
                </form>
            @else
                <div class="text-center">
                    <a class="btn btn--base submit-btn mt-4" href="{{ route('user.login') }}">@lang('Login to comment')</a>
                </div>
            @endauth
        </div>

        <div>
            <h3>{{ $comments->count() }} @lang('comments')</h3>
            <ul class="comment-list load-comments">
                @forelse($comments->take(5) as $comment)
                    @include('Template::partials.basic_comment_reply')
                @empty
                    <x-basic-empty-message />
                @endforelse
            </ul>

            @if ($comments->count() > 5)
                <div class="text-center mt-4">
                    <button class="loadMoreComments"
                        data-type="@if (request()->routeIs('service.details')) service @elseif(request()->routeIs('software.details')) software @else job @endif">
                        @lang('Load More')</button>
                </div>
            @endif
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";

            var showComments = 5;

            $('.loadMoreComments').on('click', function(e) {
                e.preventDefault();
                $(this).addClass('btn-disabled').attr("disabled", true);

                var type = $(this).data('type');
                var skip = showComments;

                $.ajax({
                    type: 'get',
                    url: '{{ route('fetch.comments', $itemDetails->id) }}',
                    data: {
                        type: type,
                        skip: skip
                    },
                    dataType: "json",

                    success: function(response) {
                        if (response.success) {
                            $('.load-comments').append(response.html);
                            showComments += 5;
                            $('.loadMoreComments').removeClass('btn-disabled').attr("disabled",
                                false);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
