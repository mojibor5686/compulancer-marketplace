<div class="row">
    @foreach ($formData as $data)
        <div class="form--group-lg">
            <label class="form-label form--label @if ($data->is_required == 'required') required @endif">
                {{ __($data->name) }}
                @if (@$data->instruction)
                    <span data-bs-toggle="tooltip" data-bs-title="{{ __($data->instruction) }}">
                        <i class="fas fa-info-circle"></i>
                    </span>
                @endif
            </label>

            @if ($data->type == 'text')
                <input type="text" class="form-control form--control" name="{{ $data->label }}"
                    value="{{ old($data->label) }}" @if ($data->is_required == 'required') required @endif>
            @elseif($data->type == 'url')
                <input type="url" class="form-control form--control" name="{{ $data->label }}"
                    value="{{ old($data->label) }}" @if ($data->is_required == 'required') required @endif>
            @elseif($data->type == 'email')
                <input type="email" class="form-control form--control" name="{{ $data->label }}"
                    value="{{ old($data->label) }}" @if ($data->is_required == 'required') required @endif>
            @elseif($data->type == 'datetime')
                <input type="datetime-local" class="form-control form--control" name="{{ $data->label }}"
                    value="{{ old($data->label) }}" @if ($data->is_required == 'required') required @endif>
            @elseif($data->type == 'date')
                <input type="date" class="form-control form--control" name="{{ $data->label }}"
                    value="{{ old($data->label) }}" @if ($data->is_required == 'required') required @endif>
            @elseif($data->type == 'time')
                <input type="time" class="form-control form--control" name="{{ $data->label }}"
                    value="{{ old($data->label) }}" @if ($data->is_required == 'required') required @endif>
            @elseif($data->type == 'number')
                <input type="number" class="form-control form--control" name="{{ $data->label }}"
                    value="{{ old($data->label) }}" step="any" @if ($data->is_required == 'required') required @endif>
            @elseif($data->type == 'textarea')
                <textarea class="form-control form--control" name="{{ $data->label }}"
                    @if ($data->is_required == 'required') required @endif>{{ old($data->label) }}</textarea>
            @elseif($data->type == 'select')
                <select class="form-select form--control select2-basic" data-minimum-results-for-search="-1"
                    name="{{ $data->label }}" @if ($data->is_required == 'required') required @endif>
                    <option value="">@lang('Select One')</option>
                    @foreach ($data->options as $item)
                        <option value="{{ $item }}" @selected($item == old($data->label))>{{ __($item) }}</option>
                    @endforeach
                </select>
            @elseif($data->type == 'checkbox')
                <div class="form--group">
                    <div class="d-flex gap-3 flex-wrap">
                        @foreach ($data->options as $option)
                            <div class="form-group custom-check-group">
                                <input id="{{ $data->label }}_{{ titleToKey($option) }}"
                                    name="{{ $data->label }}[]" type="checkbox" value="{{ $option }}"
                                    @checked($option == old($data->label))>
                                <label
                                    for="{{ $data->label }}_{{ titleToKey($option) }}">{{ $option }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="checkbox-required-error text--danger"></div>
                </div>
            @elseif($data->type == 'radio')
                <div class="form--group">
                    <div class="d-flex gap-3 flex-wrap">
                        @foreach ($data->options as $option)
                            <div class="form-group custom-check-group">
                                <input id="{{ $data->label }}_{{ titleToKey($option) }}" name="{{ $data->label }}"
                                    type="radio" value="{{ $option }}" @checked($option == old($data->label))>
                                <label
                                    for="{{ $data->label }}_{{ titleToKey($option) }}">{{ $option }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif($data->type == 'file')
                <div class="custom-file-wrapper">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="{{ titleToKey($data->label) }}"
                            name="{{ $data->label }}" @if ($data->is_required == 'required') required @endif
                            accept="@foreach (explode(',', $data->extensions) as $ext) .{{ $ext }}, @endforeach">
                        <label class="custom-file-label" for="{{ titleToKey($data->label) }}">@lang('Choose file')</label>
                    </div>
                    <p class="mt-1">@lang('Supported mimes'): {{ $data->extensions }}</p>
                </div>
            @endif

            @if (@$data->instruction)
                <p class="fs-14 mt-1">{{ __($data->instruction) }}</p>
            @endif
        </div>
    @endforeach
</div>

@push('script')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endpush

@push('style')
    <style>
        .custom-file-wrapper {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
            position: relative;
        }

        .custom-file {
            display: flex;
            align-items: center;
        }

        .custom-file-input {
            display: none;
        }

        .custom-file-label {
            display: inline-block;
            color: #555;
            cursor: pointer;
            font-weight: bold;
            margin: 0;
            background-color: #e9ecef;
            padding: 8px 15px;
            border-radius: 5px;
            flex-grow: 1;
            text-align: center;
        }
    </style>
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";

            $('input[type="file"]').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                if (fileName) {
                    $(this).siblings('.custom-file-label').text(fileName);
                } else {
                    $(this).siblings('.custom-file-label').text('@lang('Choose file')');
                }
            });

        })(jQuery);
    </script>
@endpush
