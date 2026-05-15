<div class="modal fade" id="disputeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h4 class="modal-title fw-bold" id="ModalLabel">@lang('Dispute')</h4>
                <span class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>

            <form method="POST">
                @csrf
                <div class="modal-body pb-0">
                    <input type="hidden" name="dispute_type">
                    <div class="form-group">
                        <label class="form-label form--label" for="reason">@lang('Dispute Reason')</label>
                        <textarea class="form-control form--control" name="reason" rows="5" maxlength="500"
                            placeholder="@lang('Describe Your Dispute Reason')" required></textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 mt-0 pt-0">
                    <button type="submit" class="btn btn-danger w-100 h-45 pb-0">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('style')
    <style>
        /* Modal Styling */
        #disputeModal .modal-content {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        #disputeModal .modal-header {
            padding: 1rem 1.5rem;
        }

        #disputeModal .modal-title {
            font-weight: bold;
            font-size: 1.25rem;
            color: #333;
        }

        #disputeModal .form-label {
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        #disputeModal .form-control {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        #disputeModal .modal-footer {
            padding: 1rem;
        }

        #disputeModal .btn-danger {
            background-color: hsl(var(--base));
            border: none;
            font-size: 1rem;
            height: 45px;
            font-weight: bold;
        }

        #disputeModal .btn-close {
            font-size: 0.7rem;
            padding: 0.5rem;
            margin-top: -0.25rem;
            opacity: 0.8;
        }

        /* Additional Styling */
        .form-group {
            margin-bottom: 1.5rem;
        }
    </style>
@endpush

@push('script')
    <script>
        'use strict';

        (function($) {
            $('.disputeBtn').on('click', function() {
                var modal = $('#disputeModal');
                var disputeType = $(this).data('type');
                var route = $(this).data('route');

                modal.find('[name=dispute_type]').val(disputeType);
                modal.find('form').attr('action', route);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
