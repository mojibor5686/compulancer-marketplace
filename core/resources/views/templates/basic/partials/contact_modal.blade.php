<div id="contactModal" class="modal fade" tabindex="-1" role="dialog"
    style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content"
            style="border: none !important; border-radius: 16px !important; box-shadow: 0 15px 50px rgba(0,0,0,0.15) !important; overflow: hidden;">

            <div class="modal-header"
                style="background: #ffffff; border-bottom: 1px solid #edf1f4; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between;">
                <h5 class="modal-title"
                    style="font-size: 18px; font-weight: 700; color: #1d1e20; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="ri-chat-smile-3-line" style="color: #3C88EE; font-size: 22px;"></i> @lang('Start New Conversation')
                </h5>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close"
                    style="background: #f4f6f8; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #5e6267; cursor: pointer; transition: all 0.2s;">
                    <i class="ri-close-line" style="font-size: 18px; font-weight: bold;"></i>
                </button>
            </div>

            <form action="{{ route('user.inbox.create') }}" method="POST">
                @csrf

                <input name="receiver_id" type="hidden" value="{{ encrypt($user->id) }}">

                <div class="modal-body" style="padding: 24px;">

                    <div class="form-group mb-4">
                        <label class="form-label form--label" for="subject"
                            style="font-size: 13px; font-weight: 600; color: #404145; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">
                            @lang('Subject') <span class="text-danger">*</span>
                        </label>
                        <input class="form-control form--control modern-input" name="subject" type="text"
                            placeholder="@lang('What is this discussion about?')" maxlength="255" required
                            style="width: 100%; border: 1px solid #e4e8ec; border-radius: 8px; padding: 12px 16px; font-size: 14px; color: #1d1e20; background: #ffffff; outline: none; transition: all 0.2s;">
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label form--label" for="message"
                            style="font-size: 13px; font-weight: 600; color: #404145; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">
                            @lang('Message') <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control form--control modern-input" name="message" rows="5" maxlength="500"
                            placeholder="@lang('Type your requirements or queries here in detail...')" required
                            style="width: 100%; border: 1px solid #e4e8ec; border-radius: 8px; padding: 12px 16px; font-size: 14px; color: #1d1e20; background: #ffffff; outline: none; transition: all 0.2s; resize: none;"></textarea>
                    </div>
                    <div class="text-end">
                        <small style="color: #94a3b8; font-size: 11px;">@lang('Max 500 characters allowed')</small>
                    </div>

                </div>

                <div class="modal-footer"
                    style="background: #f8fafc; border-top: 1px solid #edf1f4; padding: 16px 24px;">
                    <button type="submit" class="btn btn--base w-100 btn--lg modern-submit-btn"
                        style="width: 100%; background-color: #3C88EE; border: none; color: #ffffff; border-radius: 50px; font-size: 15px; font-weight: 600; padding: 12px 24px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s ease-in-out; box-shadow: 0 4px 12px rgba(60, 136, 238, 0.15);">
                        <i class="ri-send-plane-fill"></i> @lang('Send Message')
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('style')
    <style>
        .modern-input:focus {
            border-color: #3C88EE !important;
            box-shadow: 0 0 0 4px rgba(60, 136, 238, 0.1) !important;
        }

        .modern-submit-btn:hover {
            background-color: #3C88EE !important;
            box-shadow: 0 6px 16px rgba(60, 136, 238, 0.25) !important;
        }

        .btn-close-custom:hover {
            background: #e4e8ec !important;
            color: #1d1e20 !important;
            transform: rotate(90deg);
        }
    </style>
@endpush
