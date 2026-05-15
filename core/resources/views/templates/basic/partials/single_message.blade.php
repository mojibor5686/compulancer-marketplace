<div class="single-message @if ($message->receiver_id == auth()->id()) message--left @else message--right @endif"
    data-chat-id="{{ $message->id }}">
    <div class="message-content-outer">
        <div class="message-content">
            <p class="message-text">{{ $message->message }}</p>
            @if ($message->file)
                <div class="message-attachment @if (!$message->message) mt-0 @endif">
                    <p class=""><a href="{{ route('file.download', [encrypt($message->file), 'messageFile']) }}"
                            class="me-3"><i class="fa fa-file"></i> @lang('Attachment')</a></p>
                </div>
            @endif
        </div>
        <span class="message-time d-block text-end mt-2">{{ showDateTime($message->created_at) }}</span>
    </div>
    <div class="message-author">
        <img src="{{ getImage(getFilePath('userProfile') . '/' . $message->sender->image, isAvatar: true) }}"
            class="thumb">
    </div>
</div>
