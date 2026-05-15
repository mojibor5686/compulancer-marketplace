@php
    if ($chat->user_id == 0) {
        $senderName = 'System';
        $senderImage = siteFavicon();
    } else {
        $senderName = $chat->user->username ?? 'Unknown';
        $senderImage = getImage(getFilePath('userProfile') . '/' . @$chat->user?->image, isAvatar: true);
    }

    $right = $chat->user_id == auth()->id();
@endphp

<div class="single-message @if ($right) message--right @else message--left @endif mb-3">
    <div class="message-content-outer">
        <div class="message-content">
            @if ($chat->message)
                <p class="message-text mb-1 @if ($right) text-end @else text-start @endif">
                    {{ $chat->message }}</p>
            @endif
            @if ($chat->file)
                <div
                    class="message-attachment @if (!$chat->message) mt-0 @endif @if ($right) text-end @else text-start @endif">
                    <p class=""><a href="{{ route('file.download', [encrypt($chat->file), 'chatFile']) }}"><i
                                class="fa fa-file"></i> @lang('Attachment')</a></p>
                </div>
            @endif
        </div>
        <span
            class="message-time d-block @if ($right) text-end @else text-start @endif mt-2">{{ showDateTime($chat->created_at) }}</span>
    </div>
    <div class="message-author">
        <img src="{{ $senderImage }}" alt="image" class="thumb">
    </div>
</div>
