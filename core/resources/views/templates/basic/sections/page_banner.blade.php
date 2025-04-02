<?php
$mappedBanner = [
    'about' => 'assets/images/frontend/about_banner/aboutUs_banner.png',
    'contact' => 'assets/images/frontend/contact_banner/contact_banner.jpg',
];
?>
<section class="pb-120 pt-5 page-banner-section">
    @if (isset($pageSlug) && isset($mappedBanner[$pageSlug]))
        <img src="{{ asset($mappedBanner[$pageSlug]) }}" alt="explore_campaign" class="banner-image">
    @endif
</section>
@push('style')
    <style>
        .page-banner-section .banner-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
@endpush
