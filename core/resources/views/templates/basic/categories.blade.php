@extends('Template::layouts.frontend')
@section('content')
    <main class="page-wrapper pt-5" style="background-color: #fcfcfc;">
        <div class="container pb-5">

            <div class="text-center mb-5">
                <h1 class="fw-bold text-dark display-5 mb-2">{{ __($pageTitle) }}</h1>
                <p class="text-muted fs-5">You bring the idea. {{ __($pageTitle) }}'s specialists will make it a reality.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="card border-0 bg-transparent ps-2">
                        <h5 class="fw-bold text-dark mb-3">{{ __($pageTitle) }}</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="#"
                                    class="text-dark fw-bold text-decoration-none d-block py-1">{{ __($pageTitle) }}</a>
                            </li>
                            @forelse($subCategories as $subCategory)
                                <li class="mb-2">
                                    <a href="{{ route('subcategory.products', [slug($subCategory->name), $subCategory->id]) }}"
                                        class="text-secondary text-decoration-none d-block py-1 subcategory-link"
                                        style="font-size: 14px; transition: color 0.2s ease;">
                                        {{ __($subCategory->name) }}
                                    </a>
                                </li>
                            @empty
                                <li class="text-muted small">No subcategories found</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-lg-9">
                    <div class="row g-3 row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5">
                        @forelse($subCategories as $subCategory)
                            <div class="col">
                                <a href="#" class="text-decoration-none">
                                    <div class="card h-100 text-center p-3 border-0 rounded-4 sub-cat-card"
                                        style="background: #f4f6f8; transition: all 0.3s ease-in-out;">

                                        <div class="d-flex align-items-center justify-content-center mb-3"
                                            style="height: 70px;">
                                            <img src="{{ getImage(getFilePath('subcategory') . '/' . $subCategory->image, getFileSize('subcategory')) }}"
                                                alt="{{ $subCategory->name }}" class="img-fluid"
                                                style="max-height: 100%; object-fit: contain;">
                                        </div>

                                        <h6 class="text-dark fw-semibold text-capitalize m-0 p-1"
                                            style="font-size: 13px; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 34px;">
                                            {{ __($subCategory->name) }}
                                        </h6>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12 w-100 text-center py-5">
                                <span class="text-muted">No subcategories available at the moment.</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </main>

    <style>
        .sub-cat-card:hover {
            transform: translateY(-5px);
            background: #ffffff !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        }

        .subcategory-link:hover {
            color: #3C88EE !important;
            padding-left: 5px;
        }
    </style>
@endsection
