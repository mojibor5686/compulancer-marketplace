@php
    if (request()->routeIs('admin.booking.service.details')) {
        $type = 'service_' . $details->id;
    } elseif (request()->routeIs('admin.hiring.job.details')) {
        $type = 'job_' . $details->id;
    }
@endphp

@if ($details->disputer)
    <div class="row mt-4">
        <div class="{{ $details->working_status == Status::WORKING_DISPUTED ? 'col-xl-6' : 'col-12' }}">
            <div class="card mb-3">
                <div class="card-header">
                    <h5>@lang('Conversations')</h5>
                </div>
                <div class="card-body">
                    <div class="chat-box">
                        <div class="chat-box__body" id="chat-thread" data-last-chat-id="{{ @$lastChatId }}">
                            @include('admin.partials.chat_messages', ['chats' => $chats])
                        </div>

                        @if ($details->working_status == Status::WORKING_DISPUTED)
                            <div class="chat-box__footer position-relative">
                                <div class="bg-el position-absolute"
                                    style="background-image: url({{ getImage(activeTemplate(true) . 'images/chat-pattern.png', '1380x930') }});">
                                </div>
                                <div class="chat-form">
                                    <form id="chat-form" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ encrypt($details->id) }}">
                                        <input type="hidden" name="type"
                                            value="{{ request()->routeIs('admin.booking.service.details') ? 'service' : 'job' }}">

                                        <textarea name="message" class="form--control" placeholder="@lang('Write message')"></textarea>

                                        <div class="bottom d-flex flex-wrap align-items-center">
                                            <div class="left">
                                                <div class="attach-file-upload">
                                                    <input type="file" name="file" id="file"
                                                        class="attach-file form-control"
                                                        accept=".jpg, .png, .jpeg, .pdf">
                                                    <button type="button"
                                                        class="attach-file-remove bg--danger text-white btn"><i
                                                            class="las la-times"></i></button>
                                                    <label for="file" class="attachment-icon">@lang('Attach file') <i
                                                            class="las la-paperclip attachment-icon"></i></label>
                                                </div>
                                            </div>
                                            <div class="right">
                                                @can('admin.chat.store')
                                                    <button type="submit" class="btn btn-sm btn--primary">@lang('Send')
                                                        <i class="lab la-telegram-plane"></i></button>
                                                @endcan
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($details->working_status == Status::WORKING_DISPUTED)
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('Disputed By') {{ $details->disputer->username }}</h5>
                    </div>
                    <div class="card-body">
                        <h6><i class="las la-info-circle"></i> @lang('Make Decision')</h6>
                        @php
                            $firstRoute = request()->routeIs('admin.booking.service.details')
                                ? route('admin.service.win.seller', $details->id)
                                : route('admin.job.win.bidder', $details->id);
                            $secondRoute = request()->routeIs('admin.booking.service.details')
                                ? route('admin.service.win.buyer', $details->id)
                                : route('admin.job.win.buyer', $details->id);
                        @endphp

                        <div class="d-flex flex-wrap gap-2 style--two text-center pt-3">
                            @canAny('admin.service.win.seller', 'admin.job.win.bidder')
                                <button class="btn btn-md btn--primary confirmationBtn flex-fill" type="button"
                                    data-question="@lang('Are you sure to give the amount to the ') {{ request()->routeIs('admin.booking.service.details') ? trans('seller') : trans('bidder') }}?"
                                    data-action="{{ $firstRoute }}"> <i class="las la-undo"></i>
                                    @lang('In Favor of ')
                                    {{ request()->routeIs('admin.booking.service.details') ? trans('Seller') : trans('Bidder') }}</button>
                            @endcanAny
                            @canAny('admin.service.win.buyer', 'admin.job.win.buyer')
                                <button class="btn btn-md btn--success confirmationBtn flex-fill" type="button"
                                    data-question="@lang('Are you sure to return the amount to the buyer')?" data-action="{{ $secondRoute }}"> <i
                                        class="la la-check-circle" aria-hidden="true"></i> @lang('In Favor of Buyer')</button>
                            @endcanAny
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('style-lib')
        <link rel="stylesheet" href="{{ asset('assets/admin/css/chat.css') }}">
    @endpush

    @push('script-lib')
        <script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
    @endpush

    @push('style')
        <style>
            .attachment-icon.attached {
                color: #4634ff;
                font-weight: bold;
            }
        </style>
    @endpush

    @push('script')
        <script>
            (function($) {
                "use strict";

                let userId = "{{ auth()->id() }}";

                // Function to scroll chat to the bottom
                function scrollToBottom() {
                    let chatBody = document.querySelector('.chat-box__body');
                    if (chatBody) {
                        chatBody.scrollTop = chatBody.scrollHeight;
                    }
                }

                // Scroll to bottom on page load
                $(document).ready(function() {
                    scrollToBottom();
                });

                // Handle file input change
                $('#file').on('change', function() {
                    if (this.files.length > 0) {
                        $('.attachment-icon').addClass('attached');
                    } else {
                        $('.attachment-icon').removeClass('attached');
                    }
                });

                // Pusher setup
                let pusher = new Pusher("{{ gs('pusher_config')?->app_key }}", {
                    cluster: "{{ gs('pusher_config')?->cluster }}",
                    authEndpoint: "{{ route('pusher.auth') }}",
                    auth: {
                        headers: {
                            'X-CSRF-Token': "{{ csrf_token() }}"
                        }
                    }
                });

                let channelName = 'private-chat-channel.{{ $type }}';

                let chatChannel = pusher.subscribe(channelName);

                {{-- blade-formatter-disable --}}
                // Bind to chat-message event
                chatChannel.bind('chat-message', function(data) {
                    let isAdmin = data.sender.id == null && data.receiver.id == null;
                    if (data.itemId == "{{ $details->id }}" && !isAdmin) {
                        $('.chat-box__body').append(`
                        <div class="single-chat chat--left">
                            <div class="content">
                                <div class="message">
                                    <h6>${data.sender.name}</h6>
                                    <p>${data.message}</p>
                                    ${
                                        data.attachment
                                            ? `<div class="chat-attachment">
                                                    <a href="${data.attachment}" class="single-attachment">
                                                        <i class="fas fa-download"></i> ${data.chatFileName}
                                                    </a>
                                                </div>`
                                            : ''
                                    }
                                </div>
                                <p class="chat-time"><i class="far fa-clock"></i> ${data.createdAt}</p>
                            </div>
                        </div>
                    `);
                        scrollToBottom(); // Scroll to the bottom after receiving a new message
                    }
                });
                {{-- blade-formatter-enable --}}

                // Handle chat form submission via AJAX
                $('#chat-form').on('submit', function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('admin.chat.store') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('.chat-box__body').append(response.html);
                            $('#chat-form')[0].reset(); // Clear form
                            $('.attachment-icon').removeClass('attached'); // Remove attached class
                            scrollToBottom(); // Scroll to the bottom after sending a new message
                        },
                        error: function() {
                            notify('error', 'Error sending message.');
                        }
                    });
                });


                // Fetch chat messages
                const chatThread = $('#chat-thread');
                let isFetching = false; // Prevent multiple AJAX requests

                function fetchChats() {
                    if (isFetching) return; // Avoid multiple requests
                    isFetching = true; // Set fetching flag

                    const lastChatId = chatThread.find('.single-chat:first').data('chat-id'); // Get top chat ID
                    const chatUrl = window.location.href;

                    // Save scroll position relative to top chat
                    const lastChatElement = chatThread.find(`[data-chat-id="${lastChatId}"]`);
                    const lastChatScrollPosition = lastChatElement.length ?
                        lastChatElement.offset().top - chatThread.offset().top :
                        0;

                    $.ajax({
                        url: chatUrl,
                        type: 'GET',
                        data: {
                            last_chat_id: lastChatId
                        },
                        success: function(response) {
                            if (response.success) {
                                // Prepend new messages to chat thread
                                chatThread.prepend(response.html);

                                // Restore scroll position after loading messages
                                const newLastChatElement = chatThread.find(`[data-chat-id="${lastChatId}"]`);
                                if (newLastChatElement.length) {
                                    const newScrollPosition =
                                        newLastChatElement.offset().top - chatThread.offset().top;
                                    chatThread.scrollTop(chatThread.scrollTop() + newScrollPosition -
                                        lastChatScrollPosition);
                                }
                            } else if (response.last) {
                                notify('info', '@lang('No more messages to load.')');
                                chatThread.off('scroll'); // Remove scroll if no more chats
                            }
                        },
                        error: function() {
                            notify('error', '@lang('Failed to load older messages. Please try again.')');
                        },
                        complete: function() {
                            isFetching = false; // Reset fetching flag
                        },
                    });
                }

                // Handle scroll event to fetch older messages
                chatThread.on('scroll', function() {
                    if ($(this).scrollTop() === 0 && !isFetching) {
                        fetchChats();
                    }
                });


            })(jQuery);
        </script>
    @endpush

@endif
