@extends('Template::layouts.frontend')
@section('content')
    @php
        $forLoadMoreReviewId = $user->id;
    @endphp
    <section class="all-sections pt-60 pb-60">
        <div class="container-fluid p-max-sm-0">
            <div class="sections-wrapper">
                <article class="main-section">
                    <div class="section-inner">
                        <div class="item-section item-overview-section">
                            <div class="container">
                                <div class="row justify-content-end">
                                    <div class="col-xl-3 col-lg-3 mb-4 d-block d-lg-none">
                                        @include('Template::partials.sidebar_profile')
                                    </div>
                                    <div class="col-xl-9 col-lg-9">
                                        <div class="page-top">
                                            <div class="page-top__wrapper">
                                                <ul class="nav nav-tabs custom--tab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link {{ $maxKey == 'service' ? 'active' : '' }}"
                                                            data-bs-toggle="tab" data-bs-target="#service" type="button"
                                                            role="tab"
                                                            aria-selected="{{ $maxKey == 'service' ? 'true' : 'false' }}">
                                                            @lang('Services')
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link {{ $maxKey == 'software' ? 'active' : '' }}"
                                                            data-bs-toggle="tab" data-bs-target="#software" type="button"
                                                            role="tab"
                                                            aria-selected="{{ $maxKey == 'software' ? 'true' : 'false' }}">
                                                            @lang('Softwares')
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link {{ $maxKey == 'job' ? 'active' : '' }}"
                                                            data-bs-toggle="tab" data-bs-target="#job" type="button"
                                                            role="tab"
                                                            aria-selected="{{ $maxKey == 'job' ? 'true' : 'false' }}">
                                                            @lang('Jobs')
                                                        </button>
                                                    </li>
                                                </ul>

                                                <div class="layout-toggle-btns">
                                                    <button class="layout-toggle-btn grid-layout active" type="button">
                                                        @include('Template::partials.icons.grid')
                                                    </button>
                                                    <button class="layout-toggle-btn list-layout" type="button">
                                                        @include('Template::partials.icons.list')
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center mb-30-none">
                                    <div class="col-xl-3 col-lg-3 mb-30 d-none d-lg-block">
                                        @include('Template::partials.sidebar_profile')
                                    </div>


                                    <div class="col-xl-9 col-lg-9 mb-30">
                                        <div class="item-details-area">
                                            @include('Template::partials.basic_card')

                                            <div class="product-reviews-content mt-5">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="section-header">
                                                            <h4 class="section-title">@lang('Reviews')</h4>
                                                        </div>
                                                        @include('Template::partials.reviews')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
    @include('Template::partials.contact_modal')
@endsection


@push('style')
    <style>
        .page-content {
            margin-top: 0;
        }

        .page-top {
            border-bottom: unset;
            padding-bottom: 14px;
        }

        .custom--tab {
            border-bottom: unset;
            margin-bottom: unset;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            "use strict";

            @if (request()->contact)

                @guest
                $('#loginModal').modal('show');
            @else
                $('.contactBtn').trigger('click');
            @endguest
        @endif
        });
    </script>
@endpush
