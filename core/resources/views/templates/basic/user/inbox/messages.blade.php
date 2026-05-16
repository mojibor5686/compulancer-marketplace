@extends('Template::layouts.master')

@section('content')
    <div class="card-area">
        <div class="row g-0 rounded shadow-sm overflow-hidden bg-white"
            style="min-height: 500px; height: calc(100vh - 160px);">

            <div class="col-lg-4 col-xl-3 border-end d-flex flex-column bg-light">
                <div class="p-3 border-bottom bg-white">
                    <h5 class="m-0 fw-bold text-dark">@lang('Chats')</h5>
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
                                            {{ $sidebarUser->username }}
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

            <div class="col-lg-8 col-xl-9 d-flex flex-column bg-white">
                @if ($inbox)
                    @php
                        $user = $inbox->sender_id == auth()->id() ? $inbox->receiver : $inbox->sender;
                    @endphp
                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between bg-white">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                                class="rounded-circle object-fit-cover" style="width: 42px; height: 42px;" alt="image">
                            <div>
                                <h6 class="m-0 fw-bold text-dark text-capitalize">{{ $user->username }}</h6>
                                <small class="text-success" style="font-size: 11px;"><i class="fas fa-circle fs-small"
                                        style="font-size: 8px;"></i> @lang('Active Thread')</small>
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
                        @include('Template::partials.chat_thread_inbox', ['messages' => $messages])
                    </div>

                    <div class="chat-box__footer bg-light p-3 border-top">
                        <form id="chat-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="unique_id" value="{{ $inbox->unique_id }}">
                            <input type="hidden" name="receiver_id" value="{{ encrypt($user->id) }}">

                            <div class="chat-send-area d-flex align-items-center">
                                <div class="chat-send-file" data-bs-toggle="tooltip" title="Attach a file"
                                    data-bs-offset="0,8">
                                    <label for="file" class="file-label">
                                        <i class="fas fa-paperclip attachment-icon"></i>
                                    </label>
                                    <input type="file" id="file" name="file" class="d-none"
                                        accept=".jpg, .png, .jpeg, .pdf">
                                </div>

                                <div class="chat-send-field flex-grow-1">
                                    <div class="input-group input--group">
                                        <input type="text" name="message" id="chat-message-field"
                                            placeholder="@lang('Send a message')" class="form-control form--control">
                                        <button type="submit" class="btn btn--lg btn--base send-btn">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
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
                        <p class="text-center px-4" style="font-size: 13px; max-width: 350px;">@lang('Please choose a user from the chat list on the left to start messaging.')</p>
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
        .chat-send-area {
            padding-left: 0;
            padding-right: 0;
        }

        .chat-send-area .input--group .form--control {
            padding-left: 15px;
            padding-right: 15px;
            height: 45px;
        }

        .chat-send-area .input--group .form--control:focus {
            background-color: #fff;
            box-shadow: none;
            border-color: #cbd5e1;
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
    </style>
@endpush

@push('script')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        (function($) {
            "use strict";

            @if ($inbox)
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

                pusherConnection('private-inbox-channel.' + "{{ $inbox->unique_id }}", 'chat-message',
                    handleChatMessage);

                function handleChatMessage(data) {
                    if (data.uniqueId === "{{ $inbox->unique_id }}" && data.sender.id !== userId) {
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

                $('[data-bs-toggle="tooltip"]').tooltip();

                function handleFileAttachment(files) {
                    const attachmentIcon = $('.chat-send-file');
                    if (files.length > 0) {
                        attachmentIcon.find('.attachment-icon').addClass('attached');
                        attachmentIcon.attr('data-bs-original-title', files[0].name).tooltip('show');
                        notify('success', 'File attached successfully');
                    } else {
                        attachmentIcon.find('.attachment-icon').removeClass('attached');
                        attachmentIcon.attr('data-bs-original-title', 'Attach a file');
                    }
                }

                $('#file').on('change', function() {
                    handleFileAttachment(this.files);
                });

                function scrollToBottom() {
                    var chatThread = document.getElementById('chat-thread');
                    if (chatThread) chatThread.scrollTop = chatThread.scrollHeight;
                }
                scrollToBottom();

                // Form Ajax Request (সম্পূর্ণ ফিক্সড আইডি সিলেক্টর দিয়ে)
                $('#chat-form').on('submit', function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    var hasMessage = $('#chat-message-field').val().trim() !== '';
                    var hasFile = $('#file')[0].files.length > 0;

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
                            $('.empty-message-box').addClass('d-none');
                            $('.chat-box__thread').append(response.html);

                            // সঠিক আইডি এলিমেন্ট ক্লিয়ার মেথড
                            $('#chat-message-field').val('');
                            $('#file').val('');
                            $('#chat-form')[0].reset();

                            handleFileAttachment([]);
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

                $('.refresh').on('click', function() {
                    $.ajax({
                        url: "{{ route('user.inbox.messages.refresh', $inbox->unique_id) }}",
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

                const chatThread = $('#chat-thread');
                let isFetching = false;

                function fetchChats() {
                    if (isFetching) return;
                    isFetching = true;

                    const lastChatId = chatThread.find('.single-message:first').data('chat-id');
                    const chatUrl = window.location.href;
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
                                chatThread.prepend(response.html);
                                const newLastChatElement = chatThread.find(
                                `[data-chat-id="${lastChatId}"]`);
                                if (newLastChatElement.length) {
                                    const newScrollPosition = newLastChatElement.offset().top - chatThread
                                        .offset().top;
                                    chatThread.scrollTop(chatThread.scrollTop() + newScrollPosition -
                                        lastChatScrollPosition);
                                }
                            } else if (response.last) {
                                notify('info', '@lang('No more messages to load.')');
                                chatThread.off('scroll');
                            }
                        },
                        error: function() {
                            notify('error', '@lang('Failed to load older messages. Please try again.')');
                        },
                        complete: function() {
                            isFetching = false;
                        }
                    });
                }

                chatThread.on('scroll', function() {
                    if ($(this).scrollTop() === 0 && !isFetching) {
                        fetchChats();
                    }
                });
            @endif
        })(jQuery);
    </script>
@endpush
