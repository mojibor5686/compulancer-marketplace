@if (@$user)
    <div
        style="background-color: #ffffff; border: 1px solid #eef2f5; border-radius: 4px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.03); position: sticky; top: 20px;">

        @auth
            <button class="contactBtn" data-bs-toggle="modal" data-bs-target="#contactModal"
                style="width: 100%; display: flex; align-items: center; justify-content: center; background-color: #10c469; border: none; color: #ffffff; border-radius: 4px; font-size: 15px; font-weight: 600; padding: 11px 16px; cursor: pointer; transition: background 0.2s ease; margin-bottom: 24px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-send"
                    viewBox="0 0 16 16" style="margin-right: 8px;">
                    <path
                        d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                </svg>
                @lang('Contact me')
            </button>
        @else
            <button type="button" class="contactBtn" data-bs-toggle="modal" data-bs-target="#loginModal"
                style="width: 100%; display: flex; align-items: center; justify-content: center; background-color: #10c469; border: none; color: #ffffff; border-radius: 4px; font-size: 15px; font-weight: 600; padding: 11px 16px; cursor: pointer; transition: background 0.2s ease; margin-bottom: 24px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-send"
                    viewBox="0 0 16 16" style="margin-right: 8px;">
                    <path
                        d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                </svg>
                @lang('Contact me')
            </button>
        @endauth

        <div style="display: flex; flex-direction: column; gap: 14px;">

            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
                <span style="color: #74767e;">@lang("Seller's rating")</span>
                <span style="color: #404145; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                    <span style="color: #ffb33e; font-size: 15px;">★</span> 5.0
                </span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
                <span style="color: #74767e;">@lang('Completed orders')</span>
                <span
                    style="color: #404145; font-weight: 700;">{{ $user->services()->active()->count() + $user->softwares()->active()->count() }}</span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
                <span style="color: #74767e;">@lang('Total reviews')</span>
                <span style="color: #404145; font-weight: 700; display: flex; align-items: center; gap: 12px;">
                    <span style="display: inline-flex; align-items: center; gap: 4px;"><span
                            style="height: 8px; width: 8px; background-color: #10c469; border-radius: 50%;"></span>{{ $user->total_review ?? 0 }}</span>
                    <span style="display: inline-flex; align-items: center; gap: 4px;"><span
                            style="height: 8px; width: 8px; background-color: #ff5b5b; border-radius: 50%;"></span>0</span>
                </span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
                <span style="color: #74767e;">@lang('Orders in progress')</span>
                <span style="color: #404145; font-weight: 700;">{{ $user->jobBids()->inprogress()->count() }}</span>
            </div>

        </div>

    </div>
@endif
