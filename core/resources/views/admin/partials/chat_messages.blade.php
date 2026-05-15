<div class="chat-main position-relative">
    <div class="bg-el position-absolute"
        style="background-image: url({{ getImage(activeTemplate(true) . 'images/chat-pattern.png', '1380x930') }});">
    </div>

    @foreach ($chats->sortBy('id') as $chat)
        @php
            $seller_id = request()->routeIs('admin.booking.service.details') ? $details->seller_id : $details->user_id;

            if ($chat->user_id == $seller_id) {
                $senderName = request()->routeIs('admin.booking.service.details')
                    ? $details->seller?->username
                    : $details->user?->username;
            } elseif ($chat->user_id == $details->buyer_id) {
                $senderName = $details->buyer->username;
            } else {
                $senderName = 'System';
            }
        @endphp

        <div class="single-chat @if ($senderName == 'System') chat--right @else chat--left @endif"
            data-chat-id="{{ $chat->id }}">
            <div class="content">
                <div class="message">
                    <h6 class="mb-2 fs--16px">{{ $senderName }}</h6>
                    <p>{{ $chat->message }}</p>
                    <div class="chat-attachment">
                        @if ($chat->file)
                            <a href="{{ route('file.download', [encrypt($chat->file), 'chatFile']) }}"
                                class="single-attachment"><i class="fas fa-download"></i>
                                {{ $chat->file }} </a>
                        @endif
                    </div>
                </div>
                <p class="chat-time"><i class="far fa-clock"></i>
                    {{ showDateTime($chat->created_at, 'Y-m-d h:i A') }}</p>
            </div>
        </div>
    @endforeach
</div>
