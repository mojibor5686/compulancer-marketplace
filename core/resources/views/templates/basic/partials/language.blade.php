@php
    $language = App\Models\Language::all();
    $currentLang = $language->where('code', config('app.locale'))->first();
@endphp

@if (gs('multi_language'))
    <div class="dropdown lang--dropdown">
        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img class="dropdown-toggle__flag"
                src="{{ getImage(getFilePath('language') . '/' . @$currentLang->image, getFileSize('language')) }}"
                alt="{{ $currentLang->name }}" />
            <span class="dropdown-toggle__text">{{ __($currentLang->name) }}</span>
        </button>

        <div class="dropdown-menu">
            @foreach ($language as $lang)
                <a class="dropdown-item langSel" href="javascript:void(0);" data-value="{{ @$lang->code }}">
                    <img class="dropdown-item__flag"
                        src="{{ getImage(getFilePath('language') . '/' . @$lang->image, getFileSize('language')) }}"
                        alt="{{ __($lang->name) }}" />
                    <span>{{ __($lang->name) }}</span>
                </a>
            @endforeach
        </div>
    </div>

    @push('script')
        <script>
            (function($) {
                "use strict";
                // Handler for when a language is selected
                $(".langSel").on("click", function() {
                    var selectedLang = $(this).data('value');
                    window.location.href = "{{ route('home') }}/change/" + selectedLang;
                });
            })(jQuery)
        </script>
    @endpush
@endif
