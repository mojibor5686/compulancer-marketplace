<div class="single-chat chat--right">
    <div class="content">
        <div class="message">
            <h6 class="mb-2 fs--16px">@lang('System')</h6>
            <p>{{ $chat->message }}</p>
            @if ($chat->file)
                <div class="chat-attachment">
                    <a href="{{ asset(getFilePath('chatFile') . '/' . $chat->file) }}" class="single-attachment">
                        <i class="fas fa-download"></i> {{ $chat->file }}
                    </a>
                </div>
            @endif
        </div>
        <p class="chat-time"><i class="far fa-clock"></i> {{ showDateTime($chat->created_at, 'Y-m-d h:i A') }}</p>
    </div>
</div>
