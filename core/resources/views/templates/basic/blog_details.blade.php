@extends('Template::layouts.frontend')
@section('content')
    <main class="page-wrapper pt-0">
        <section class="blog-detail pt-80 pb-0">
            <div class="container">
                <div class="row gy-4">
                    <!-- Main Blog Content -->
                    <div class="col-lg-8">
                        <div class="blog-details-card">
                            <div class="blog-details-card__header">
                                <img class="blog-details__thumb"
                                    src="{{ frontendImage('blog', $blog->data_values->image, '966x560') }}"
                                    alt="{{ __($blog->data_values->title) }}">
                                <div class="blog-details__date">
                                    <span class="day">{{ showDateTime($blog->created_at, 'd') }}</span>
                                    <span class="month">{{ showDateTime($blog->created_at, 'M') }}</span>
                                </div>
                            </div>

                            <div class="blog-details-card__body">
                                <h4 class="blog-details__title">{{ __($blog->data_values->title) }}</h4>
                                <div class="blog-details__desc">
                                    @php echo $blog->data_values->description @endphp
                                </div>
                            </div>

                            <div class="blog-details-card__footer">
                                <span class="title">@lang('Share this post')</span>
                                <ul class="social-list style-two">
                                    <li class="social-list__item">
                                        <a href="http://www.facebook.com/sharer.php?u={{ urlencode(url()->current()) }}&p[title]={{ slug(@$blog->data_values->title) }}"
                                            class="social-list__link" target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="http://twitter.com/share?text={{ slug(@$blog->data_values->title) }}&url={{ urlencode(url()->current()) }}"
                                            class="social-list__link" target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ slug(@$blog->data_values->title) }}"
                                            class="social-list__link" target="_blank">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ slug(@$blog->data_values->title) }}"
                                            class="social-list__link" target="_blank">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar for Latest Posts -->
                    <div class="col-lg-4">
                        <div class="blog-details-sidebar">
                            <div class="blog-details-sidebar__header">
                                <h6 class="blog-details-sidebar__title">@lang('Latest Posts')</h6>
                            </div>
                            <div class="blog-details-sidebar__body">
                                <ul class="blog-list">
                                    @foreach ($latestBlogs as $latestBlog)
                                        <li class="blog-list-item">
                                            <a class="blog-list-item__thumb"
                                                href="{{ route('blog.details', $latestBlog->slug) }}">
                                                <img src="{{ frontendImage('blog', $latestBlog->data_values->image, '320x190') }}"
                                                    alt="{{ __($latestBlog->data_values->title) }}">
                                            </a>
                                            <div class="blog-list-item__content">
                                                <h6 class="blog-list-item__title">
                                                    <a href="{{ route('blog.details', $latestBlog->slug) }}">
                                                        {{ strLimit(strip_tags($latestBlog->data_values->title), 55) }}
                                                    </a>
                                                </h6>
                                                <a class="blog-list-item__more"
                                                    href="{{ route('blog.details', $latestBlog->slug) }}">
                                                    <span>@lang('Read more')</span>
                                                    <i class="fa-solid fa-arrow-right-long"></i>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('Template::partials.down_ad')
@endsection

@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush


@push('style')
    <style>
        blockquote {
            font-style: italic;
            text-align: center;
            padding: 20px;
            background: hsl(var(--base)/0.1);
            font-weight: 500;
            font-size: 18px;
            border-left: 4px solid hsl(var(--base));
            border-radius: 4px 2px 2px 4px;
        }
    </style>
@endpush
