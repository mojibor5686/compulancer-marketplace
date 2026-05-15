@extends('Template::layouts.frontend')
@section('content')
    <main class="page-wrapper pt-0">
        <section class="blogs pt-80 pb-80">
            <div class="container">
                <div class="row gy-4">
                    @foreach ($blogs as $blog)
                        <div class="col-xsm-6 col-sm-6 col-md-4 col-xl-3">
                            <article class="card blog--card">
                                <a class="card-thumb" href="{{ route('blog.details', $blog->slug) }}">
                                    <img src="{{ frontendImage('blog', 'thumb_' . $blog->data_values->image, '320x190') }}"
                                        alt="{{ __($blog->data_values->title) }}" />
                                </a>
                                <div class="card-body">
                                    <div class="card-date">
                                        <span class="day">{{ showDateTime($blog->created_at, 'd') }}</span>
                                        <span class="month">{{ showDateTime($blog->created_at, 'M') }}</span>
                                    </div>
                                    <h5 class="card-title">
                                        <a href="{{ route('blog.details', $blog->slug) }}">
                                            {{ strLimit(strip_tags(__($blog->data_values->title)), 55) }}
                                        </a>
                                    </h5>
                                    <p class="card-excerpt">
                                        {{ strLimit(strip_tags(@$blog->data_values->description), 115) }}
                                    </p>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                @if ($blogs->hasPages())
                    <div class="mt-60 text-center">
                        {{ paginateLinks($blogs) }}
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
