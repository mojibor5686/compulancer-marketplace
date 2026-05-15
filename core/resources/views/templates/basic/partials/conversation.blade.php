<div class="card custom--card mt-4">
    <div class="card-header bg-dark text-white px-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="chat-author align-items-center">
                <h6 class="mb-0 text-white">@lang('Chat Messages')</h6>
            </div>
            <div class="trade-status flex-shrink-0">

                @php
                    $pusherService = new App\Lib\PusherService();
                    $isPusherActive = $pusherService->initializePusher();
                @endphp

                @if (!$isPusherActive)
                    <button type="button" class="btn btn--base refresh-btn text-white refresh" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-original-title="@lang('Click here to refresh the chat and get the latest updates')">
                        <i class="las la-sync-alt me-2"></i> @lang('Refresh')
                    </button>
                @endif

            </div>
        </div>
    </div>
    @php
        if (
            request()->routeIs('user.seller.booking.service.details') ||
            request()->routeIs('user.buyer.booked.details')
        ) {
            $type = 'service_' . $details->id;
        } elseif (request()->routeIs('user.seller.job.details') || request()->routeIs('user.buyer.hiring.details')) {
            $type = 'job_' . $details->id;
        }
    @endphp
    <div class="card-body p-0">
        <div class="chat-box">
            <div class="chat-box__thread p-3" id="chat-thread" data-last-chat-id="{{ $lastChatId }}">
                @include('Template::partials.chat_messages', ['chats' => $chats])
            </div>


            <div class="chat-box__footer bg-light p-3 px-3">
                <form id="chat-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ encrypt($details->id) }}">

                    @if (request()->routeIs('user.seller.booking.service.details') || request()->routeIs('user.buyer.booked.details'))
                        <input type="hidden" name="type" value="service">
                    @else
                        <input type="hidden" name="type" value="job">
                    @endif

                    <div class="chat-send-area d-flex align-items-center">
                        <div class="chat-send-file" data-bs-toggle="tooltip" aria-label="Attach a file"
                            data-bs-original-title="Attach a file">
                            <label for="file" class="file-label">
                                <i class="fas fa-paperclip attachment-icon"></i>
                            </label>
                            <input type="file" id="file" name="file" class="d-none"
                                accept=".jpg, .png, .jpeg, .pdf">
                        </div>

                        <div class="chat-send-field flex-grow-1">
                            <div class="input-group input--group">
                                <input type="text" name="message" id="message" placeholder="@lang('Send a message')"
                                    class="form-control form--control">
                                <button type="submit" class="btn btn--lg btn--base send-btn">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>

@push('style-lib')
    <link rel="stylesheet" href="{{ asset(activeTemplate(true) . 'css/chat.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
@endpush

@push('style')
    <style>
        .chat-send-area {
            padding-left: 0;
            padding-right: 0;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            // Initialize Pusher
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
            pusherConnection('private-chat-channel.{{ $type }}', 'chat-message', handleChatMessage);

            {{-- blade-formatter-disable --}}
            // Handle incoming chat messages
            function handleChatMessage(data) {
                let currentChatId = "{{ $details->id }}";
                if ((data.itemId == currentChatId) && (data.sender.id != userId)) {
                    // Hide empty message box if exists
                    $('.empty-message-box').addClass('d-none');

                    // Build the message HTML
                    let messageHtml = `
                    <div class="single-message ${data.sender.id == userId ? 'message--right' : 'message--left'}
                        ${data.sender.name == 'System' ? 'admin-message' : ''} mb-3" data-chat-id="${data.chatId}">

                        <div class="message-content-outer">
                            <div class="message-content">
                                ${data.message ? `
                                    <p class="message-text mb-1 ${data.sender.id == userId ? 'text-end' : 'text-start'}">
                                        ${data.message}
                                    </p>` : ''
                                }

                                ${data.attachment ? `
                                    <div class="message-attachment ${!data.message ? 'mt-0' : ''}
                                        ${data.sender.id == userId ? 'text-end' : 'text-start'}">
                                        <p><a href="${data.attachment}"><i class="fa fa-file"></i> @lang('Attachment')</a></p>
                                    </div>` : ''
                                }
                            </div>

                            <span class="message-time d-block ${data.sender.id == userId ? 'text-end' : 'text-start'} mt-2">
                                ${data.createdAt}
                            </span>
                        </div>

                        <div class="message-author">
                            <img src="${data.sender.image}" alt="image" class="thumb">
                        </div>
                    </div>`;


                    $('#chat-thread').append(messageHtml);
                    scrollToBottom();
                }
            }
            {{-- blade-formatter-enable --}}

            // Scroll chat to the bottom
            function scrollToBottom() {
                var chatThread = document.querySelector('#chat-thread');
                chatThread.scrollTop = chatThread.scrollHeight;
            }

            // Scroll to bottom on page load
            scrollToBottom();

            // Handle file attachment UI
            function handleFileAttachment(files) {
                const attachmentIcon = $('.chat-send-file');
                if (files.length > 0) {
                    attachmentIcon.find('.attachment-icon').addClass('attached');
                    // Add tooltip with filename
                    notify('success', 'File attached successfully');
                    attachmentIcon
                        .attr('data-bs-original-title', files[0].name)
                        .tooltip('show');
                } else {
                    attachmentIcon.find('.attachment-icon').removeClass('attached');
                    // Reset tooltip to default
                    attachmentIcon.attr('data-bs-original-title', 'Attach a file');
                }
            }

            // Handle file input change
            $('#file').on('change', function() {
                handleFileAttachment(this.files);
            });

            // Handle form submission via Ajax
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var hasMessage = $('#message').val().trim() !== '';
                var hasFile = $('#file')[0].files.length > 0;

                if (!hasMessage && !hasFile) {
                    notify('error', '@lang('Please provide a message or attach a file.')');
                    return;
                }

                $.ajax({
                    url: "{{ route('user.chat.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.html) {
                            // Hide empty message box if exists
                            $('.empty-message-box').addClass('d-none');

                            // Append the new message to the chat thread
                            $('#chat-thread').append(response.html);

                            // Clear the message input field and file input
                            $('#message').val('');
                            $('#file').val('');

                            // Reset file attachment UI
                            handleFileAttachment([]);

                            // Scroll to bottom
                            scrollToBottom();
                        } else {
                            notify('error', '@lang('Unexpected error occurred. Please try again.')');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            notify('error', xhr.responseJSON.error);
                        } else {
                            notify('error', '@lang('An unexpected error occurred. Please try again later.')');
                        }
                    }
                });
            });

            // Auto-refresh chat messages via Ajax (Optional Fallback)
            function refreshChat() {
                $.ajax({
                    url: "{{ route('user.chat.refresh') }}",
                    type: 'GET',
                    data: {
                        id: "{{ encrypt($details->id) }}",
                        type: "{{ request()->routeIs('user.seller.booking.service.details') || request()->routeIs('user.buyer.booked.details') ? 'service' : 'job' }}"
                    },
                    success: function(response) {
                        if (response.html) {
                            $('#chat-thread').html(response.html);
                            scrollToBottom();
                        } else {
                            notify('error', '@lang('Unexpected error occurred while refreshing the chat.')');
                        }
                    },
                    error: function(xhr) {
                        notify('error', '@lang('Failed to refresh the chat. Please try again later.')');
                        console.error(xhr.responseText);
                    }
                });
            }

            // Handle refresh button click
            $('.refresh-btn').on('click', function() {
                refreshChat();
            });


            //fetch chat messages
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
                        last_chat_id: lastChatId
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
