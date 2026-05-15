@extends('Template::layouts.' . $layout)
@section('content')
    @guest
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    @endguest

                    <div class="card custom--card">
                        <div class="card-header card-header-bg py-3">
                            <div
                                class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    @php echo $myTicket->statusBadge; @endphp
                                    <h6 class="mb-0">
                                        [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                                    </h6>
                                </div>
                                @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                                    <button class="btn btn-danger btn-sm confirmationBtn" type="button"
                                        data-question="@lang('Are you sure to close this ticket?')"
                                        data-action="{{ route('ticket.close', $myTicket->id) }}">
                                        <i class="fas fa-times-circle me-1"></i>
                                        <span>@lang('Close Ticket')</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body ">
                            <form method="post" class="disableSubmission"
                                action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-md-12">
                                        <textarea name="message" placeholder="@lang('Your Reply')..." class="form-control form--control bg--gray" rows="4"
                                            required>{{ old('message') }}</textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                            <button type="button" class="btn btn--dark addAttachment h-50">
                                                <i class="fas fa-plus"></i>
                                                @lang('Add Attachment')
                                            </button>
                                            <button class="btn btn--base btn--lg h-50" type="submit">
                                                <i class="la la-fw la-lg la-reply"></i>
                                                @lang('Reply')
                                            </button>
                                        </div>

                                        <p class="text--info mt-2">@lang('Max 5 files can be uploaded') | @lang('Maximum upload size is')
                                            {{ convertToReadableSize(ini_get('upload_max_filesize')) }} |
                                            @lang('Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</p>
                                    </div>
                                    <div class="col-12">
                                        <div class="row gy-4 fileUploadsContainer"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            @forelse($messages as $message)
                                @if ($message->admin_id == 0)
                                    <div class="row border border--base border-radius-3 my-3 py-3 mx-2">
                                        <div class="col-md-3 border-end text-end">
                                            <h5 class="my-3">{{ $message->ticket->name }}</h5>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="text-muted fw-bold my-3">
                                                @lang('Posted on')
                                                {{ showDateTime($message->created_at, 'l, dS F Y @ h:i a') }}
                                            </p>
                                            <p>{{ $message->message }}</p>
                                            @if ($message->attachments->count() > 0)
                                                <div class="mt-2">
                                                    @foreach ($message->attachments as $k => $image)
                                                        <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                            class="me-3"><i class="fa-regular fa-file"></i>
                                                            @lang('Attachment')
                                                            {{ ++$k }} </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="row border border-warning border-radius-3 my-3 py-3 mx-2 reply-bg">
                                        <div class="col-md-3 border-end text-end">
                                            <h5 class="my-3">{{ $message->admin->name }}</h5>
                                            <p class="lead text-muted">@lang('Staff')</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="text-muted fw-bold my-3">
                                                @lang('Posted on')
                                                {{ showDateTime($message->created_at, 'l, dS F Y @ h:i a') }}
                                            </p>
                                            <p>{{ $message->message }}</p>
                                            @if ($message->attachments->count() > 0)
                                                <div class="mt-2">
                                                    @foreach ($message->attachments as $k => $image)
                                                        <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                            class="me-3"><i class="fa-regular fa-file"></i>
                                                            @lang('Attachment')
                                                            {{ ++$k }} </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="empty-message text-center">
                                    <img src="{{ asset('assets/images/empty_list.png') }}" alt="empty">
                                    <h5 class="text-muted">@lang('No replies found here!')</h5>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @guest
                    </div>
                </div>
        </section>
    @endguest

    <x-confirmation-modal class="frontend" />
@endsection
@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }

        .reply-bg {
            background-color: #ffd96729
        }

        .empty-message img {
            width: 120px;
            margin-bottom: 15px;
        }

        .input--group .input-group-text {
            border-radius: 4px;
            color: hsl(var(--white)) !important;
            background-color: hsl(var(--danger)) !important;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addAttachment').on('click', function() {
                fileAdded++;
                if (fileAdded == 5) {
                    $(this).attr('disabled', true)
                }
                $(".fileUploadsContainer").append(`
                    <div class="col-md-6 removeFileInput">
                        <div class="input-group input--group">
                            <input type="file" name="attachments[]" class="form-control form--control" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx" required>
                            <button type="button" class="input-group-text removeFile"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                `)
            });
            $(document).on('click', '.removeFile', function() {
                $('.addAttachment').removeAttr('disabled', true)
                fileAdded--;
                $(this).closest('.removeFileInput').remove();
            });
        })(jQuery);
    </script>
@endpush
