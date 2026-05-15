<div class="page-top">
    <div class="row gy-3">
        {{-- Left Column with Sorting and Results Display --}}
        <div class="col-lg-8 col-xl-9">
            <div class="page-top__wrapper">
                <div class="page-top__left">
                    {{-- Sorting Dropdown Form --}}
                    <select class="form-select form--select select2-basic sortBy" name="sorting"
                        data-minimum-results-for-search="-1">
                        <option value="">@lang('Sort By (Default)')</option>
                        <option value="high">@lang('Higher to Lower')</option>
                        <option value="low">@lang('Lower to Higher')</option>
                    </select>
                    {{-- Displaying Results Count --}}
                    <p class="page-top__results"></p>
                </div>
                <div class="page-top__right">
                    {{-- View Toggle Buttons --}}
                    <div class="layout-toggle-btns">
                        <button class="layout-toggle-btn grid-layout active" type="button">
                            @include('Template::partials.icons.grid')
                        </button>
                        <button class="layout-toggle-btn list-layout" type="button">
                            @include('Template::partials.icons.list')
                        </button>
                        <button class="layout-toggle-btn toggle-sidebar d-lg-none" type="button"
                            data-toggle="offcanvas-sidebar" data-target="#jss-offcanvas-sidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column with Search Form --}}
        <div class="col-lg-4 col-xl-3">
            <form class="search-form" action="{{ route('search') }}" method="GET">
                <div class="input-group">
                    <input class="form-control form--control" name="search" type="text"
                        placeholder="@lang('Search...')" />
                    <button class="btn btn--base" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
