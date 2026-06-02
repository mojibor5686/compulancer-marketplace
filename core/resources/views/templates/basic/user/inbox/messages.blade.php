@extends('Template::layouts.master')

@section('content')
    <div class="card-area">
        <div class="row g-0 rounded shadow-sm overflow-hidden bg-white" style="height: 87vh;">

            <button type="button" class="btn btn-primary shadow-sm chat-sidebar-toggle d-lg-none" id="toggle-chat-sidebar">
                <i class="las la-comments fs-4"></i>
            </button>

            <div class="col-lg-4 col-xl-3 border-end d-flex flex-column bg-light chat-sidebar-slider"
                id="chat-sidebar-wrapper">

                <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-dark">@lang('Chats')</h5>
                    <button type="button" class="btn-close d-lg-none" id="close-chat-sidebar"></button>
                </div>

                <div class="flex-grow-1 overflow-auto custom-sidebar-scroll">
                    <div class="list-group list-group-flush">
                        @forelse($inboxes as $item)
                            @php
                                $sidebarUser = $item->sender_id == auth()->id() ? $item->receiver : $item->sender;
                                $isActive = isset($inbox) && $inbox->unique_id === $item->unique_id;
                            @endphp
                            <a href="{{ route('user.inbox.messages', $item->unique_id) }}"
                                class="list-group-item list-group-item-action p-3 d-flex align-items-center gap-3 border-0 transition-all {{ $isActive ? 'text-white fw-semibold shadow-sm' : '' }}"
                                style="{{ $isActive ? 'background-color: #3a84ff !important; margin-left: 0;' : '' }}">

                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$sidebarUser->image, isAvatar: true) }}"
                                    class="rounded-circle object-fit-cover"
                                    style="width: 48px; height: 48px; {{ $isActive ? 'border: 2px solid rgba(255,255,255,0.6);' : '' }}"
                                    alt="image">

                                <div class="w-100 overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="m-0 text-truncate text-capitalize {{ $isActive ? 'text-white' : 'text-dark' }}"
                                            style="font-size: 14px;">
                                            {{ $sidebarUser->username ?? 'User' }}
                                        </h6>
                                    </div>
                                    <small class="d-block text-truncate {{ $isActive ? 'text-white-50' : 'text-muted' }}"
                                        style="font-size: 12px;">
                                        @lang('Subject'): {{ strLimit($item->subject, 25) }}
                                    </small>
                                </div>
                            </a>
                        @empty
                            <div class="text-center p-4 text-muted">
                                <i class="las la-comments fs-1 d-block mb-2"></i>
                                @lang('No active conversations')
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="chat-sidebar-backdrop d-lg-none" id="chat-sidebar-backdrop"></div>

            <div class="col-lg-8 col-xl-9 d-flex flex-column bg-white h-100">

                @if ($inbox)
                    @php
                        $user = $inbox->sender_id == auth()->id() ? $inbox->receiver : $inbox->sender;
                    @endphp
                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between bg-white h-stack">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                                class="rounded-circle object-fit-cover" style="width: 42px; height: 42px;" alt="image">
                            <div>
                                <h6 class="m-0 fw-bold text-dark text-capitalize">{{ $user->username }}</h6>
                                <small class="text-success" style="font-size: 11px;">
                                    <i class="fas fa-circle fs-small" style="font-size: 8px;"></i>
                                    @lang('Active Thread')
                                </small>
                            </div>
                        </div>
                        <div class="trade-status">
                            @php
                                $pusherService = new App\Lib\PusherService();
                                $isPusherActive = $pusherService->initializePusher();
                            @endphp
                            @if (!$isPusherActive)
                                <button type="button" class="btn btn-sm btn-outline-secondary refresh">
                                    <i class="las la-sync-alt"></i> @lang('Refresh')
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="flex-grow-1 overflow-auto p-4 bg-light custom-chat-thread chat-box__thread" id="chat-thread"
                        data-last-chat-id="{{ $lastChatId }}">
                        @include('Template::partials.chat_thread_inbox', [
                            'messages' => $messages,
                        ])
                    </div>

                    <div class="chat-box__footer bg-light p-3 border-top h-stack">
                        <div id="chat-file-preview-container" class="d-none" style="margin-bottom: 10px;">
                            <div class="preview-inner"
                                style="display: flex; align-items: center; gap: 10px; position: relative; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; width: fit-content; max-width: 250px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                                <div id="preview-content" style="display: flex; align-items: center; gap: 10px;"></div>
                                <button type="button" id="remove-preview-btn" class="btn-close" aria-label="Close"
                                    style="position: absolute; top: 5px; right: 5px; width: 14px; height: 14px; font-size: 10px; padding: 0;"></button>
                            </div>
                        </div>
                        <form id="chat-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="unique_id" value="{{ $inbox->unique_id }}">
                            <input type="hidden" name="receiver_id" value="{{ encrypt($user->id) }}">

                            <div class="chat-send-area">
                                <div class="chat-send-field w-100">
                                    <div class="d-flex flex-column-reverse flex-md-row gap-3 alignment-wrapper">

                                        <div class="flex-grow-1 w-100">
                                            <input type="text" name="message" id="chat-message-field"
                                                placeholder="@lang('Type a message')" class="form-controls form--control w-100"
                                                style="height: 48px; border-radius: 6px; padding: 0 15px; border:none;">
                                        </div>

                                        <div
                                            class="d-flex align-items-center justify-content-between flex-md-row gap-2 custom-btn-group">

                                            <button type="submit" class="btn send-btn m-0"
                                                style="display: inline-flex; font-size: 18px; align-items: center; justify-content: center; height: 48px; padding: 0 2rem; min-width: 6rem; border-radius: 5rem; background-color: #3a84ff !important; color: #ffffff; border: none; font-weight: 500;">
                                                <i class="las la-paper-plane"></i>
                                            </button>

                                            <div class="chat-send-file btn w-fit m-0" data-bs-toggle="tooltip"
                                                title="Attach a file" data-bs-offset="0,8"
                                                style="display: inline-flex; width: 48px !important; font-size:11px; background: #e1e1e1; align-items: center; justify-content: center; padding:12px; height: 48px !important; border-radius: 50%; cursor: pointer;">
                                                <label for="file" class="file-label"
                                                    style="cursor: pointer; margin: 0;">
                                                    <i class="fas fa-images attachment-icon"></i>
                                                </label>
                                                <input type="file" id="file" name="file" class="d-none"
                                                    accept=".jpg, .png, .jpeg, .pdf">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div
                        class="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-muted bg-light">
                        <i class="las la-sms" style="font-size: 70px; color: #ced4da;"></i>
                        <h5 class="mt-3 fw-semibold">@lang('No Conversation Selected')</h5>
                        <p class="text-center px-4" style="font-size: 13px; max-width: 350px;">
                            @lang('Please choose a user from the chat list on the left to start messaging.')
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset(activeTemplate(true) . 'css/chat.css') }}">
@endpush

@push('style')
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .chat-send-area {
            padding-left: 0;
            padding-right: 0;
        }

        .custom-sidebar-scroll::-webkit-scrollbar,
        .custom-chat-thread::-webkit-scrollbar {
            width: 5px;
        }

        .custom-sidebar-scroll::-webkit-scrollbar-thumb,
        .custom-chat-thread::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }

        .attached {
            color: #3a84ff !important;
        }

        /* নতুন কোড: প্রিভিউ ইমেজ ও আইকনের সাইজ রেগুলেশন */
        #chat-file-preview-container img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
        }

        #chat-file-preview-container .file-preview-icon-box {
            width: 50px;
            height: 50px;
            background: #f1f5f9;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-size: 24px;
            border: 1px solid #cbd5e1;
        }

        #chat-file-preview-container .file-preview-name {
            font-size: 12px;
            color: #334155;
            word-break: break-all;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }


        @media (max-width: 767px) {
            .alignment-wrapper {
                flex-direction: column-reverse !important;
            }

            .custom-btn-group {
                width: 100% !important;
                display: flex !important;
                flex-direction: row-reverse !important;
                justify-content: space-between !important;
            }
        }

        @media (min-width: 768px) {
            .alignment-wrapper {
                flex-direction: row !important;
                align-items: center !important;
                background: #fff;
                border: 1px solid #cbd5e1;
                border-radius: 30px;
                padding: 4px 6px 4px 12px;
            }

            .custom-btn-group {
                flex-direction: row-reverse !important;
                gap: 10px !important;
            }

            #chat-message-field {
                border: none !important;
                padding: 0 !important;
                height: 40px !important;
            }

            #chat-message-field:focus {
                outline: none !important;
                box-shadow: none !important;
            }
        }

        @media (max-width: 991px) {
            .chat-sidebar-slider {
                position: fixed;
                top: 0;
                left: -300px;
                width: 300px;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease-in-out;
                box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            }

            .chat-sidebar-slider.active {
                left: 0;
            }

            .chat-sidebar-toggle {
                position: fixed;
                top: 50%;
                left: 10px;
                transform: translateY(-50%);
                z-index: 1040;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .chat-sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.4);
                z-index: 1045;
                display: none;
            }

            .chat-sidebar-backdrop.show {
                display: block;
            }
        }
    </style>
@endpush

@push('script')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#toggle-chat-sidebar, #chat-sidebar-backdrop').on('click', function() {
                $('#chat-sidebar-wrapper').toggleClass('active');
                $('#chat-sidebar-backdrop').toggleClass('show');
            });

            $('#close-chat-sidebar').on('click', function() {
                $('#chat-sidebar-wrapper').removeClass('active');
                $('#chat-sidebar-backdrop').removeClass('show');
            });

            // নতুন কোড: ক্রস বাটনে ক্লিক করলে ফাইল রিমুভ ও প্রিভিউ হাইড করার লজিক
            $(document).on('click', '#remove-preview-btn', function() {
                $('#file').val(''); // মেইন ফাইল ইনপুট খালি করা হলো
                handleFileAttachment([]); // খালি অ্যারে পাঠিয়ে প্রিভিউ ক্লোজ করা হলো
            });
        });
    </script>
    <script>
        (function($) {
            "use strict";

            let userId = Number("{{ auth()->id() }}");
            Pusher.logToConsole = false;

            let pusher = new Pusher("{{ gs('pusher_config')?->app_key }}", {
                cluster: "{{ gs('pusher_config')?->cluster }}",
                authEndpoint: "{{ route('pusher.auth') }}",
                auth: {
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}"
                    }
                }
            });

            // Helper to establish a Pusher connection
            const pusherConnection = (channelName, eventName, callback) => {
                let channel = pusher.subscribe(channelName);

                channel.bind('pusher:subscription_succeeded', function() {
                    channel.bind(eventName, function(data) {
                        callback(data);
                    });
                });

                channel.bind('pusher:subscription_error', function(status) {
                    console.error(`Subscription error: ${status}`);
                });
            };

            // Subscribe to chat-message events
            @if ($inbox)
                pusherConnection('private-inbox-channel.' + "{{ $inbox->unique_id }}", 'chat-message',
                    handleChatMessage);
            @endif

            {{-- blade-formatter-disable --}}
            // Handle incoming chat messages
            function handleChatMessage(data) {
                if (data.uniqueId === "{{ @$inbox->unique_id }}" && data.sender.id !== userId) {
                    // Hide empty message box if exists
                    $('.empty-message-box').addClass('d-none');

                    let messageHtml = `
                        <div class="single-message ${data.sender.id == userId ? 'message--right' : 'message--left'}">
                            <div class="message-content-outer">
                                <div class="message-content">
                                    <p class="message-text">${data.message ?? ''}</p>
                                    ${data.attachment ? `
                                        <div class="message-attachment ${data.message ? '' : 'mt-0'}">
                                            <p class=""><a href="${data.attachment}" class="me-3"><i class="fa fa-file"></i> @lang('Attachment')</a></p>
                                        </div>
                                        ` : ''}
                                </div>
                                <span class="message-time d-block text-end mt-2">${data.createdAt}</span>
                            </div>
                            <div class="message-author">
                                <img src="${data.sender.image}" class="thumb">
                            </div>
                        </div>`;
                    $('.chat-box__thread').append(messageHtml);
                    scrollToBottom();
                }
            }
            {{-- blade-formatter-enable --}}

            // Initialize tooltip
            $('[data-bs-toggle="tooltip"]').tooltip();

            function handleFileAttachment(files) {
                const attachmentIcon = $('.chat-send-file');
                const previewContainer = $('#chat-file-preview-container');
                const previewContent = $('#preview-content');

                if (files.length > 0) {
                    const file = files[0];
                    attachmentIcon.find('.attachment-icon').addClass('attached');
                    attachmentIcon.attr('data-bs-original-title', file.name).tooltip('show');

                    // FileReader দিয়ে ফাইলটি ব্রাউজারে রিড করা হচ্ছে
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        let previewHtml = '';

                        // যদি সিলেক্ট করা ফাইলটি ইমেজ বা ছবি হয়
                        if (file.type.match('image.*')) {
                            previewHtml = `<img src="${e.target.result}" alt="preview">
                               <span class="file-preview-name">${file.name}</span>`;
                        }
                        // যদি পিডিএফ ফাইল হয়
                        else if (file.type === 'application/pdf') {
                            previewHtml = `<div class="file-preview-icon-box"><i class="far fa-file-pdf text-danger"></i></div>
                               <span class="file-preview-name">${file.name}</span>`;
                        }
                        // অন্য যেকোনো সাধারণ ফাইল হলে
                        else {
                            previewHtml = `<div class="file-preview-icon-box"><i class="far fa-file"></i></div>
                               <span class="file-preview-name">${file.name}</span>`;
                        }

                        previewContent.html(previewHtml);
                        previewContainer.removeClass('d-none'); // প্রিভিউ এরিয়া শো করবে
                    }

                    reader.readAsDataURL(file);
                    notify('success', 'File attached successfully');
                } else {
                    // ফাইল না থাকলে প্রিভিউ হাইড হয়ে যাবে
                    attachmentIcon.find('.attachment-icon').removeClass('attached');
                    attachmentIcon.attr('data-bs-original-title', 'Attach a file');
                    previewContainer.addClass('d-none');
                    previewContent.html('');
                }
            }

            // Handle file input change
            $('#file').on('change', function() {
                handleFileAttachment(this.files);
            });

            // Scroll chat to the bottom
            function scrollToBottom() {
                var chatThread = document.querySelector('.chat-box__thread');
                chatThread.scrollTop = chatThread.scrollHeight;
            }

            // Scroll to bottom on page load
            scrollToBottom();

            // Handle form submission via Ajax
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var hasMessage = $('#message').val().trim() !== '';
                var hasFile = $('#file')[0].files.length > 0;

                handleFileAttachment([]);

                if (!hasMessage && !hasFile) {
                    notify('error', '@lang('Please provide a message or attach a file.')');
                    return;
                }

                $.ajax({
                    url: "{{ route('user.inbox.message.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Hide empty message box if exists
                        $('.empty-message-box').addClass('d-none');

                        // Append the new message to the chat thread
                        $('.chat-box__thread').append(response.html);

                        // Clear the message input field and file input
                        $('#message').val('');
                        $('#file').val('');
                        $('#chat-form')[0].reset();

                        // Reset file attachment UI
                        handleFileAttachment([]);

                        // Scroll to bottom
                        scrollToBottom();
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            notify('error', xhr.responseJSON.error);
                        } else {
                            notify('error', '@lang('An unexpected error occurred. Please try again later.')');
                        }
                        console.error(xhr.responseText);
                    }
                });

            });

            // Refresh chat messages via Ajax
            $('.refresh').on('click', function() {
                $.ajax({
                    url: "{{ $inbox ? route('user.inbox.messages.refresh', $inbox->unique_id) : '#' }}",
                    type: 'GET',
                    success: function(response) {
                        $('.chat-box__thread').html(response.html);
                        scrollToBottom();
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            notify('error', xhr.responseJSON.error);
                        } else {
                            notify('error', '@lang('Failed to refresh messages. Please try again later.')');
                        }
                        console.error(xhr.responseText);
                    }
                });
            });

            // Fetch chat messages
            const chatThread = $('#chat-thread');
            let isFetching = false; // Flag to prevent multiple AJAX requests

            function fetchChats() {
                if (isFetching) return; // Prevent multiple AJAX requests
                isFetching = true; // Set flag when request starts

                const lastChatId = chatThread.find('.single-message:first').data(
                    'chat-id'); // Get the top visible chat's ID
                const chatUrl = window.location.href;

                // Save the scroll position relative to the top chat
                const lastChatElement = chatThread.find(`[data-chat-id="${lastChatId}"]`);
                const lastChatScrollPosition = lastChatElement.length ? lastChatElement.offset().top - chatThread
                    .offset().top : 0;

                $.ajax({
                    url: chatUrl,
                    type: 'GET',
                    data: {
                        last_chat_id: lastChatId // Send the ID of the first message in the chat
                    },
                    success: function(response) {
                        if (response.success) {
                            // Prepend the new chats to the chat thread
                            chatThread.prepend(response.html);

                            // Scroll back to the original top chat after new messages are loaded
                            const newLastChatElement = chatThread.find(`[data-chat-id="${lastChatId}"]`);
                            if (newLastChatElement.length) {
                                const newScrollPosition = newLastChatElement.offset().top - chatThread
                                    .offset().top;
                                chatThread.scrollTop(chatThread.scrollTop() + newScrollPosition -
                                    lastChatScrollPosition);
                            }
                        } else if (response.last) {
                            notify('info', '@lang('No more messages to load.')');
                            chatThread.off('scroll'); // Remove scroll event if no more chats are available
                        }
                    },
                    error: function() {
                        notify('error', '@lang('Failed to load older messages. Please try again.')');
                    },
                    complete: function() {
                        isFetching = false; // Reset the flag when the request completes
                    }
                });
            }

            // Handle scrolling to the top
            chatThread.on('scroll', function() {
                if ($(this).scrollTop() === 0 && !isFetching) {
                    fetchChats();
                }
            });

        })(jQuery);
    </script>
@endpush
