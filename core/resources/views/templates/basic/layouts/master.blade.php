@extends('Template::layouts.app')

@section('panel')
    @include('Template::partials.header', ['isUser' => true])

    @include('Template::partials.breadcrumb')

    <main class="page-wrapper">
        <section class="dashboard py-120">
            <div class="container">
                <div class="dashboard-inner">

                    @if (session('userType') === 'buyer' || (session('userType') === null && request()->routeIs('user.buyer.*')))
                        @include('Template::partials.buyer_sidebar')
                    @else
                        @include('Template::partials.seller_sidebar')
                    @endif

                    <div class="dashboard-content">
                        <button class="btn btn--base d-lg-none mb-4" type="button" data-toggle="offcanvas-sidebar"
                            data-target="#dashboard-offcanvas-sidebar">
                            <span class="d-inline-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-bars"></i>
                                <span>@lang('Menu')</span>
                            </span>
                        </button>
                        @yield('content')
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
