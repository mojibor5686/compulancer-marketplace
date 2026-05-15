@php
    $bgImageContent = getContent('bg_image.content', true);
@endphp

<section class="breadcrumb bg-img"
    data-background-image="{{ frontendImage('bg_image', @$bgImageContent->data_values->image, '1920x140') }}">
    <div class="container">
        <h4 class="breadcrumb__title">{{ __(@$pageTitle ?? '') }}</h4>
    </div>
</section>
