@forelse ($messages->sortBy('id') as $message)
    @include('Template::partials.single_message', ['message' => $message])
@empty
    <div class="empty-message-box text-center">
        <i class="las la-comments icon"></i>
        <p class="caption">@lang('No messages in the conversation yet.')</p>
    </div>
@endforelse
