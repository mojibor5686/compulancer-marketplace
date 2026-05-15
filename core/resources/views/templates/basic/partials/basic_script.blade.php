@push('style')
    <style>
        .select2Tag input {
            background-color: transparent !important;
            padding: 0 !important;
        }
    </style>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        (function($) {


            $('.addExtra').on('click', function() {
                let length = $(document).find('.extraServiceRemove').length;
                var html = `<div class="col-lg-12 extraServiceRemove">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="text" name="extra_service[${length+1}][name]" maxlength="255" class="form-control" placeholder="@lang('Enter service name')" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group mb-3">
                                            <input type="number" step="any" class="form-control" name="extra_service[${length+1}][price]" placeholder="@lang('Enter Price')" required>
                                            <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn--danger removeBtn w-100">
                                            @lang('Remove')
                                        </button>
                                    </div>
                                </div>
                            </div>`;
                $('.addExtraService').append(html);
            });

            bkLib.onDomLoaded(function() {
                $(".nicEdit").each(function(index) {
                    $(this).attr("id", "nicEditor" + index);
                    new nicEditor({
                        fullPanel: true
                    }).panelInstance('nicEditor' + index, {
                        hasPanel: true
                    });
                });
            });

            $(document).on("change", ".custom-file-input", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            $(document).on('click', '.removeExtraImage', function() {
                $(this).closest('.removeImage').remove();
            });

            $(document).on('click', '.removeBtn', function() {
                $(this).closest('.extraServiceRemove').remove();
            });

            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });

            $('.select2').select2({
                tags: true
            });

        })(jQuery);
    </script>
@endpush
