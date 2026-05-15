<li class="comments-list-item">
    <img class="comments-list-item__thumb"
        src="{{ getImage(getFilePath('userProfile') . '/' . @$comment->user->image, isAvatar: true) }}"
        alt="{{ @$comment->user->username }}">
    <div class="comments-list-item__content">
        <p class="comments-list-item__name">{{ @$comment->user->username }}</p>
        <span class="comments-list-item__date">{{ showDateTime($comment->created_at, 'd M Y') }}</span>
        <p class="comments-list-item__desc">{{ __($comment->comment) }}</p>

        <!-- Reply Button -->
        @auth
            <button class="comments-list-item__reply reply-btn mt-2" data-comment-id="{{ $comment->id }}">
                <i class="las la-reply"></i>
                <span>@lang('Reply')</span>
            </button>

            <!-- Reply Form -->
            <div class="reply-form-area mt-30 mb-40" id="reply-form-{{ $comment->id }}" style="display: none;">
                <form class="comment-form" method="POST" action="{{ route('user.comment.reply.store') }}">
                    @csrf
                    <input type="hidden" name="comment_id" value="{{ encrypt($comment->id) }}">
                    <textarea class="form-control form--control h-auto review-textarea" name="reply" placeholder="@lang('Your Reply')"
                        rows="4" required></textarea>
                    <button type="submit" class="btn btn--base mt-3">@lang('Post Reply')</button>
                </form>
            </div>
        @endauth
    </div>
</li>

@foreach ($comment->replies as $reply)
    <li class="comments-list-item comment-reply">
        <img class="comments-list-item__thumb"
            src="{{ getImage(getFilePath('userProfile') . '/' . @$reply->user->image, isAvatar: true) }}"
            alt="{{ @$reply->user->username }}">
        <div class="comments-list-item__content">
            <p class="comments-list-item__name">{{ @$reply->user->username }}</p>
            <span class="comments-list-item__date">{{ showDateTime($reply->created_at, 'd M Y') }}</span>
            <p class="comments-list-item__desc">{{ __($reply->reply) }}</p>
        </div>
    </li>
@endforeach
