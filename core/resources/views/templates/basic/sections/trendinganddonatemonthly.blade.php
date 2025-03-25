
@php
    $campaignContent = getContent('campaign.content', true);
    $campaigns = App\Models\Campaign::running()
        ->boundary()
        ->with(['user.organization', 'category', 'donations'])
        ->orderBy('id', 'DESC')
        ->take(3)
        ->get();
@endphp

<section class="campaign-section pt-120 pb-120 position-relative base--bg">
    <div class="container">
        <div class="row">
            <!-- Left Side: Campaigns -->
            <div class="col-md-6">
                <h2>Donate Monthly</h2>
                
                @foreach ($campaigns as $campaign)
                    <a href="{{ route('campaign.details', $campaign->slug) }}" class="text-decoration-none">
                        <div class="campaign-item d-flex align-items-start mb-4 p-3 shadow-sm rounded">
                            <!-- Campaign Image -->
                            <div class="campaign-img me-3" style="width: 400px; height: 200px; overflow: hidden;">
                                <img class="w-100" src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}" alt="image">
                            </div>

                            <!-- Campaign Details -->
                            <div>
                                <h4 class="text-dark fw-bold">{{ $campaign->title }}</h4>
                                <p class="text-secondary">{{ Str::limit($campaign->description, 100) }}</p>
                                
                                <!-- Progress Bar -->
                                @php
                                    $progress = ($campaign->goal_amount > 0) 
                                        ? ($campaign->collected_amount / $campaign->goal_amount) * 100 
                                        : 0;
                                @endphp

                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $progress }}%;" 
                                        aria-valuenow="{{ $progress }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>

                                <p class="mt-2 text-muted">
                                    <strong>${{ number_format($campaign->collected_amount, 2) }}</strong> 
                                    raised of <strong>${{ number_format($campaign->goal_amount, 2) }}</strong>
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Right Side: Empty for now or place another section -->
           <div class="col-md-6">
                               <h2 class="mb-4">Featured Campaigns</h2>

    <div class="campaign-card">
                                        <img class="w-100" src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image) }}" alt="image">
        <div class="event-card__content">
            <div class="event-cart__top">
                <a class="user-profile" href="/profile/daankart_organization">
                    <div class="user-profile__thumb">
                        @if ($campaign->user->enable_org)
                            <img src="{{ avatar(@$campaign->user->organization->image ? getFilePath('orgProfile') . '/' . @$campaign->user->organization->image : null) }}" alt="org-cover-avatar">
                        @else
                            <img src="{{ avatar(@$campaign->user->image ? getFilePath('userProfile') . '/' . @$campaign->user->image : null) }}" alt="user-avatar">
                        @endif
                    </div>
                    <span class="name">{{ $campaign->user->firstname }}</span>
                </a>
                <p class="date">
                    <i class="las la-calendar"></i> {{ $campaign->created_at->format('d M Y') }}
                </p>
            </div>

            <h4 class="title pt-2">{{ $campaign->campaign_title }}</h4>

            <div class="event-bar-item">
                <div class="skill-bar">
                    <div class="progressbar" data-perc="0.072%">
                        <div class="bar" style="width: 0.072%;"></div>
                        <span class="label" style="left: 0.072%;">0.07%</span>
                    </div>
                </div>
            </div><!-- event-bar-item end -->

            <div class="amount-status">
                <div class="left">
                    <b>1,800 INR</b> Raised
                </div>
                <div class="right">
                    Goal <b>2,500,000 INR</b>
                </div>
            </div>
        </div>
    </div>
</div>


