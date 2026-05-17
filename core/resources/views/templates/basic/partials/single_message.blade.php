<div class="single-message @if ($message->receiver_id == auth()->id()) message--left @else message--right @endif"
    data-chat-id="{{ $message->id }}">
    <div class="message-content-outer">
        <div class="message-content">
            @if ($message->message)
                <p class="message-text">{{ $message->message }}</p>
            @endif

            @if ($message->file)
                @php
                    $extension = pathinfo($message->file, PATHINFO_EXTENSION);
                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    $fileUrl = getImage(getFilePath('messageFile') . '/' . $message->file);
                    $downloadUrl = route('file.download', [encrypt($message->file), 'messageFile']);
                @endphp

                <div class="message-attachment @if (!$message->message) mt-0 @endif mt-2">
                    @if (in_array(strtolower($extension), $imageExtensions))
                        <div class="chat-image-preview">
                            <a href="{{ $downloadUrl }}" target="_blank" class="d-block chat-img-link">
                                <img src="{{ $fileUrl }}" alt="attachment"
                                    class="img-fluid rounded chat-responsive-img"
                                    style="object-fit: cover; border: 1px solid #e5e7eb;">
                            </a>
                        </div>
                    @else
                        <p class="m-0">
                            <a href="{{ $downloadUrl }}" class="me-3 d-inline-flex align-items-center gap-2">
                                @if (strtolower($extension) == 'pdf')
                                    <i class="fas fa-file-pdf text-danger" style="font-size: 18px;"></i>
                                @else
                                    <i class="fas fa-file-alt text-secondary" style="font-size: 18px;"></i>
                                @endif
                                <span>@lang('Attachment') (.{{ $extension }})</span>
                            </a>
                        </p>
                    @endif
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
<style>
    .chat-responsive-img {
        width: 220px;
        height: 160px;
    }

    @media (max-width: 575px) {
        .chat-responsive-img {
            width: 140px;
            height: 110px;
        }

        .chat-img-link {
            max-width: 100%;
        }
    }
</style>
