@php
    $campaignContent = getContent('feature_campaign.content', true);
    $campaigns = App\Models\Campaign::where('featured', Status::YES)
        ->running()
        ->boundary()
        ->with(['user.organization', 'category', 'donations'])
        ->orderBy('id', 'DESC')
        ->take(6)
        ->get();

@endphp

<section class="campaign-section pt-120 pb-150 position-relative base--bg">
    <div class="section-img">
        <img src="{{ getImage($activeTemplateTrue . 'images/texture-3.jpg') }}" alt="@lang('section-img')">
    </div>
    <!--<div class="top-shape">-->
    <!--    <img src="{{ getImage($activeTemplateTrue . 'images/top_texture.png') }}" alt="@lang('top-shape')">-->
    <!--</div>-->
    <!--<div class="bottom-shape">-->
    <!--    <img src="{{ asset($activeTemplateTrue . 'images/top-shape.png') }}" alt="@lang('bottom-shape')">-->
    <!--</div>-->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-header my-5">
                    <h2 class="section-title text-white">{{ __(@$campaignContent->data_values->heading) }}</h2>
                    <p class="text-white">{{ __(@$campaignContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @include($activeTemplate . 'partials.campaign')
            @if ($campaigns->count() > 6)
                <div class="col-md-12 my-5 text-center">
                    <a class="cmn-btn" href="{{ route('campaign.index') }}">@lang('Show All Campaigns')</a>
                </div>
            @endif
        </div>
    </div>
</section>
