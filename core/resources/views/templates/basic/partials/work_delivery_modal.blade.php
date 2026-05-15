<div id="workModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    @if($type == 'buyer')
                        @lang('Document File')
                    @else
                        @lang('Work Delivery')
                    @endif
                </h5>
                <span class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="work_type">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label form--label mb-2" for="file">
                            @if($type == 'buyer')
                                @lang('Document File')
                            @else
                                @lang('Work File')
                            @endif
                        </label>
                        <input class="form-control form--control" name="file" type="file" accept=".zip" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label form--label mb-2" for="details">
                            @if($type == 'buyer')
                                @lang('Work Details')
                            @else
                                @lang('Delivery Details')
                            @endif
                        </label>
                        <textarea class="form-control form--control" name="details" rows="5" maxlength="500"
                            placeholder="@if($type == 'buyer') @lang('Describe your work details') @else @lang('Describe your delivery details') @endif" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base w-100 btn--lg">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('script')
    <script>
        'use strict';

        (function($) {
            $('.workUploadBtn').on('click', function() {
                var modal = $('#workModal');
                var route = $(this).data('route');
                var workType = $(this).data('worktype');

                modal.find('[name=work_type]').val(workType);
                modal.find('form').attr('action', route);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
