@php
    $categoryTaglines = [
        'Website' => 'Get your professional website built by expert developers.',
        'Digital Marketing' => 'Grow your brand online with data-driven marketing strategies.',
        'Facebook Ads' => 'Maximize your ROI with high-converting Facebook ad campaigns.',
        'Web Design & Development' => 'Stunning layouts and robust development tailored for your business.',
        'Seo Optimization' => 'Rank higher on Google and drive organic traffic to your site.',
        'Video Editing' => 'Your very own production company at the click of a button.',
        'Graphic Design' => 'Custom visuals, logos, and branding assets from top designers.',
        'Writing & Translation' => 'Professional content writing and flawless translations.',
        'Business' => 'Expert business consulting, planning, and virtual assistance.',
        'Consultancy' => 'Get strategic guidance and mentorship from industry specialists.',
    ];

    $currentCategory = isset($category) ? trim($category->name) : '';

    $subTitle = isset($categoryTaglines[$currentCategory])
        ? $categoryTaglines[$currentCategory]
        : 'Find the perfect freelance services for your business projects.';
@endphp

<section class="kwork-clean-breadcrumb py-4 text-center bg-white border-bottom">
    <div class="container">
        <h1 class="kwork-title mb-2">{{ __(@$pageTitle ?? '') }}</h1>

        <p class="kwork-subtitle text-muted mb-0">{{ __($subTitle) }}</p>
    </div>
</section>

<style>
    .kwork-clean-breadcrumb {
        background-color: #ffffff !important;
        padding-top: 35px !important;
        padding-bottom: 35px !important;
        border-bottom: 1px solid #eef2f5;
    }

    .kwork-title {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: #222222;
        letter-spacing: -0.5px;
        line-height: 1.2;
    }

    .kwork-subtitle {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        font-size: 15px;
        font-weight: 400;
        color: #555555 !important;
        max-width: 650px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.4;
    }

    @media (max-width: 575.98px) {
        .kwork-clean-breadcrumb {
            padding-top: 25px !important;
            padding-bottom: 25px !important;
        }

        .kwork-title {
            font-size: 22px;
        }

        .kwork-subtitle {
            font-size: 13px;
            padding-0 15px;
        }
    }
</style>
