@php
    $campaignContent = getContent('campaign.content', true);
    $campaigns = App\Models\Campaign::running()
        ->boundary()
        ->with(['user.organization', 'category', 'donations'])
        ->orderBy('id', 'DESC')
        ->take(3)
        ->get();
@endphp
<br/><br/>
<section class="campaign-section pt-120 pb-120 position-relative base--bg">
    <div class="section-img"><img src="{{ getImage($activeTemplateTrue . 'images/texture-3.jpg') }}" alt="section-img">
    </div>
    <!--<div class="bottom-shape"><img src="{{ asset($activeTemplateTrue . 'images/top-shape.png') }}" alt="bottom-shape">-->
    <!--</div>-->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-8">
                <div class="section-header text-center">
                    <h2 class="section-title text-white">{{ __(@$campaignContent->data_values->title) }}</h2>
                    <p class="text-white">{{ __(@$campaignContent->data_values->description) }}</p>
                </div>
            </div>
        </div><!-- row end -->
        <div class="row gy-4 gy-4 justify-content-center">

            @include($activeTemplate . 'partials.campaign')

            @if (count($campaigns) > 3)
                <div class="col-md-12 my-5 text-center">
                    <a class="cmn-btn" href="{{ route('campaign.index') }}">@lang('SHOW ALL CAMPAIGNS')</a>
                </div>
            @endif
        </div>
    </div>
</section>
