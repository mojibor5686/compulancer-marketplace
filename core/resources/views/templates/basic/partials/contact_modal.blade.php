<div id="contactModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Start New Conversation')</h5>
                <span class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <form action="{{ route('user.inbox.create') }}" method="POST">
                @csrf
                <input name="receiver_id" type="hidden" value="{{ encrypt($user->id) }}">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label form--label" for="subject">@lang('Subject')</label>
                        <input class="form-control form--control" name="subject" type="text"
                            placeholder="@lang('Enter Subject')" maxlength="255" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label form--label" for="message">@lang('Message')</label>
                        <textarea class="form-control form--control" name="message" rows="5" maxlength="500"
                            placeholder="@lang('Enter Message')" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base w-100 btn--lg">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
