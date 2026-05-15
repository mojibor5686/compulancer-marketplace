@forelse ($chats->sortBy('id') as $chat)
    @php
        $senderName = null;
        $idToCheck = null;

        if (
            request()->routeIs('user.seller.booking.service.details') ||
            request()->routeIs('user.buyer.booked.details')
        ) {
            $idToCheck = $details->seller_id;
            $image = $details->seller->image;
            $senderName = $details->seller->username;
        } elseif (request()->routeIs('user.seller.job.details') || request()->routeIs('user.buyer.hiring.details')) {
            $idToCheck = $details->user_id;
            $image = $details->user->image;
            $senderName = $details->user->username;
        }

        if ($chat->user_id == $idToCheck) {
            $senderImage = getImage(
                getFilePath('userProfile') . '/' . @$image,
                getFileSize('userProfile'),
                isAvatar: true,
            );
        } elseif ($chat->user_id == $details->buyer_id) {
            $senderImage = getImage(
                getFilePath('userProfile') . '/' . @$details->buyer->image,
                getFileSize('userProfile'),
                isAvatar: true,
            );
            $senderName = $details->buyer->username;
        } else {
            $senderName = 'System';
            $senderImage = siteFavicon();
        }
    @endphp

    <div class="single-message @if ($chat->user_id == auth()->id()) message--right @else message--left @endif @if ($senderName == 'System') admin-message @endif mb-3"
        data-chat-id="{{ $chat->id }}">
        <div class="message-content-outer">
            <div class="message-content">
                @if ($chat->message)
                    <p class="message-text mb-1 @if ($chat->user_id == auth()->id()) text-end @else text-start @endif">
                        {{ $chat->message }}</p>
                @endif
                @if ($chat->file)
                    <div
                        class="message-attachment @if (!$chat->message) mt-0 @endif @if ($chat->user_id == auth()->id()) text-end @else text-start @endif">
                        <p class=""><a href="{{ route('file.download', [encrypt($chat->file), 'chatFile']) }}"><i
                                    class="fa fa-file"></i> @lang('Attachment')</a></p>
                    </div>
                @endif
            </div>
            <span
                class="message-time d-block @if ($chat->user_id == auth()->id()) text-end @else text-start @endif mt-2">{{ showDateTime($chat->created_at) }}</span>
        </div>
        <div class="message-author">
            <img src="{{ $senderImage }}" class="thumb">
        </div>
    </div>
@empty
    <div class="empty-message-box">
        <i class="las la-comments icon"></i>
        <p class="caption">@lang('No messages in the conversation yet.')</p>
    </div>
@endforelse
