@forelse ($chats as $chat)
    @include('Template::partials.single_chat_message', ['chat' => $chat, 'details' => $details])
@empty
    <div class="empty-message-box">
        <i class="las la-comments icon"></i>
        <p class="caption">@lang('No messages in the conversation yet.')</p>
    </div>
@endforelse
