@php
    $campaignContent = getContent('recently_funded.content', true);

    $campaigns = App\Models\Campaign::whereHas('donations')
        ->with([
            'user.organization',
            'category',
            'donations' => function ($q) {
                $q->paid();
            },
        ])
        ->running()
        ->where(function ($query) {
            $query
                ->where(function ($q) {
                    $q->where('goal_type', Status::AFTER_DEADLINE)->whereDate('deadline', '>', now());
                })
                ->orWhere(function ($q) {
                    $q->where('goal_type', Status::GOAL_ACHIEVE)->whereHas('donations', function ($subQuery) {
                        $subQuery->select(DB::raw('SUM(donation) as total_donations'))->groupBy('campaign_id')->havingRaw('total_donations <= goal');
                    });
                })
                ->orWhere('goal_type', Status::CONTINUOUS);
        })
        ->withCount([
            'donations as total_donations' => function ($query) {
                $query->select(DB::raw('SUM(donation)'));
            },
        ])
        ->addSelect(['latest_donation_at' => App\Models\Donation::select('created_at')->whereColumn('campaign_id', 'campaigns.id')->latest()->limit(1)])
        ->orderBy('latest_donation_at', 'desc')
        ->groupBy('campaigns.id')
        ->get();
@endphp

@if (!blank($campaigns))
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
                        <h2 class="section-title text-white">{{ __($campaignContent->data_values->heading) }}</h2>
                        <p class="text-white">{{ __($campaignContent->data_values->subheading) }}</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4 gy-4 justify-content-center">

                @include($activeTemplate . 'partials.campaign')

                @if ($campaigns->count() > 6)
                    <div class="col-md-12 my-5 text-center">
                        <a class="cmn-btn" href="{{ route('campaign.index') }}">@lang('Show All Campaigns')</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
