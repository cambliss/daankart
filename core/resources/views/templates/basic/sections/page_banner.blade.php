<?php
$mappedBanner = [
    'about' => 'assets/images/frontend/about_banner/about_banner.jpg',
    'contact' => 'assets/images/frontend/contact_banner/contact_banner.jpg',
];
?>
<div class="page-banner-section banner-container">
    @if (isset($pageSlug) && isset($mappedBanner[$pageSlug]))
        <img src="{{ asset($mappedBanner[$pageSlug]) }}" alt="explore_campaign" class="banner-image">
    @endif
</div>
@push('style')
    <style>
        .page-banner-section.banner-container {
            padding-bottom: 120px;
            padding-top: 120px;
            width: 100%;
            height: 380px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .page-banner-section .banner-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush
