@php
    // Fetch the comments with their replies and associated users
    $comments = $productDetails
        ->comments()
        ->latest()
        ->with(['user', 'replies', 'replies.user']);

    $count = $comments->count();
    $comments = $comments->limit(6)->get();
@endphp

<div class="comments">
    <!-- Comment Form -->
    @if ($productDetails->user_id != auth()->id())
        <div class="comment-form-area">
            @auth
                <form class="comment-form" id="commentForm" method="POST" action="{{ route('user.comment.store') }}">
                    @csrf
                    <input name="product_id" type="hidden" value="{{ $productDetails->id }}">
                    <input name="type" type="hidden" value="{{ $type }}">

                    <textarea class="form-control form--control review-textarea" name="comment" placeholder="@lang('Enter your Comment')"
                        rows="8" required></textarea>
                    <button class="btn btn--base mt-3" type="submit">@lang('Submit')</button>
                </form>
            @endauth
        </div>
    @endif

    <!-- Comments List -->
    <h6 class="comments__total mt-3" id="commentsTotal">
        {{ $count }} @lang('Comments')
    </h6>

    <ul class="comments-list" id="commentsList">
        @forelse($comments as $comment)
            @include('Template::partials.comment_item', ['comment' => $comment])
        @empty
            <div class="empty-message-box">
                <i class="las la-comments icon"></i>
                <p class="caption">@lang('No comments available yet.')</p>
            </div>
        @endforelse
    </ul>

    <!-- Load More Button -->
    @if ($productDetails->comments()->count() > 6)
        <div class="view-more-btn text-center mt-4">
            <button class="btn btn--base loadMoreComments" data-type="{{ $type }}">
                @lang('Load More')
                <i class="fas fa-spinner fa-spin mx-1 loading-spinner d-none"></i>
            </button>
        </div>
    @endif
</div>

@push('script')
    <script>
        (function($) {
            "use strict";

            // Toggle Reply Form
            $(document).on('click', '.reply-btn', function() {
                var commentId = $(this).data('comment-id');
                $('#reply-form-' + commentId).toggle();
            });

            // Load More Comments
            var showComments = 6;
            $('.loadMoreComments').on('click', function(e) {
                e.preventDefault();

                var $button = $(this);
                var $spinner = $button.find('.loading-spinner'); // Select the spinner inside the button

                $button.addClass('btn-disabled').attr("disabled", true);
                $spinner.removeClass('d-none'); // Show spinner

                var type = $button.data('type');
                var skip = showComments;

                $.ajax({
                    type: 'get',
                    url: '{{ route('fetch.comments', $productDetails->id) }}',
                    data: {
                        type: type,
                        skip: skip
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $('.comments-list').append(response.html);
                            showComments += 6;

                            if (response.last) {
                                $button.hide(); // Hide button when no more comments
                            } else {
                                $button.removeClass('btn-disabled').attr("disabled", false);
                            }

                            notify('success', 'More comments loaded successfully');
                        } else {
                            notify('error', response.error || "@lang('Something went wrong.')");
                        }
                    },
                    error: function(xhr) {
                        notify('error', xhr.responseJSON.message || "@lang('An error occurred.')");
                    },
                    complete: function() {
                        $spinner.addClass('d-none'); // Hide spinner after request
                    }
                });
            });

            // Submit Comment Form via AJAX
            $('#commentForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Prepend new comment using rendered partial HTML
                            $('#commentsList').prepend(response.html);

                            // Update comments count
                            $('#commentsTotal').text(`${response.totalComments} @lang('Comments')`);

                            // Clear the form
                            $('#commentForm')[0].reset();

                            $('#commentsList .empty-message-box').remove();

                            // Notify success
                            notify('success', 'Comment added successfully');
                        } else {
                            notify('error', response.message || "@lang('Something went wrong.')");
                        }
                    },
                    error: function(xhr) {
                        notify('error', xhr.responseJSON.message || "@lang('An error occurred.')");
                    }
                });
            });


            // Submit Reply Form via AJAX
            $(document).on('submit', '.reply-form-area form', function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#reply-form-' + response.commentId).hide(); // Hide reply form

                            // Find the last reply for this comment and append after it
                            let lastReply = $('#reply-form-' + response.commentId)
                                .closest('.comments-list-item')
                                .nextUntil(':not(.comment-reply)')
                                .last();

                            if (lastReply.length) {
                                lastReply.after(`
                                    <li class="comments-list-item comment-reply">
                                        <img class="comments-list-item__thumb" src="${response.userImage}" alt="${response.username}">
                                        <div class="comments-list-item__content">
                                            <p class="comments-list-item__name">${response.username}</p>
                                            <span class="comments-list-item__date">${response.date}</span>
                                            <p class="comments-list-item__desc">${response.reply}</p>
                                        </div>
                                    </li>
                                `);
                            } else {
                                // If no replies exist, append directly after the main comment
                                $('#reply-form-' + response.commentId)
                                    .closest('.comments-list-item')
                                    .after(`
                                        <li class="comments-list-item comment-reply">
                                            <img class="comments-list-item__thumb" src="${response.userImage}" alt="${response.username}">
                                            <div class="comments-list-item__content">
                                                <p class="comments-list-item__name">${response.username}</p>
                                                <span class="comments-list-item__date">${response.date}</span>
                                                <p class="comments-list-item__desc">${response.reply}</p>
                                            </div>
                                        </li>
                                    `);
                            }

                            // Clear the reply form
                            form[0].reset();

                            // Notify success
                            notify('success', 'Reply added successfully');
                        } else {
                            notify('error', response.message || "@lang('Something went wrong.')");
                        }
                    },
                    error: function(xhr) {
                        notify('error', xhr.responseJSON.message || "@lang('An error occurred.')");
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
