@php
    $campaignsChunks = \App\Models\Campaign::where('status', 1)->limit(12)->get()->chunk(3);
    $daanCampaigns = \App\Models\DaanCampaign::where([
        'status' => 'Approved',
        'is_kyc_varified' => 1,
    ])
    ->limit(5)
    ->latest()
    ->get();
@endphp

<div class="container py-5 upcomming-events">
    <div class="row g-4 align-items-stretch">
        <!-- Donate Monthly -->
        <div class="col-md-6 d-flex flex-column">
            <div class="bg-light rounded-4 p-4 h-100 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold text-orange">Donate Monthly</h4>
                    <div class="carousel-navigation">
                        <button class="carousel-control control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
                <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($campaignsChunks as $key => $campaigns)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                @foreach ($campaigns as $campaign)
                                    <a href="{{ route('campaign.details', ['slug' => $campaign->slug]) }}" class="text-decoration-none">
                                        <div class="event-card d-flex border-0 bg-white rounded-3 shadow-sm mb-3 overflow-hidden">
                                            <img src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}"
                                                alt="Event Image" class="img-fluid" style="width: 120px; object-fit: cover;">
                                            <div class="ps-3 py-2">
                                                <h6 class="text-green fw-bold">{{ $campaign->title }}</h6>
                                                <p class="text-muted small mb-0">{!! Str::limit(strip_tags($campaign->description), 100) !!}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Discover Campaigns -->
        <div class="col-md-6 d-flex flex-column">
            <div class="bg-light rounded-4 p-4 h-100 shadow-sm">
                <h4 class="fw-bold text-orange mb-3">Discover Campaigns</h4>
                <div id="campaignCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        @foreach ($daanCampaigns as $index => $daanCampaign)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="event-card border-0 bg-white rounded-3 shadow-sm overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-md-6 position-relative">
                                            <img src="{{ getImage(getFilePath('campaign') . '/' . $daanCampaign->image, getFileSize('campaign')) }}"
                                                alt="Campaign Image" class="img-fluid w-100 h-100" style="object-fit: cover;">
                                            @php
                                                $raised_amount = $daanCampaign->raised_amount ?? 100;
                                                $goal = $daanCampaign->goal ?? 1000;
                                                $percentage = min(100, ($raised_amount / $goal) * 100);
                                            @endphp
                                            <div class="progress position-absolute w-100 bottom-0 start-0" style="height: 8px;">
                                                <div class="progress-bar bg-orange" style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 p-3 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="text-green fw-bold">{{ $daanCampaign->campaign_title }}</h6>
                                                <p class="text-muted small">{!! Str::limit(strip_tags($daanCampaign->campaign_description), 120) !!}</p>
                                            </div>
                                            <div>
                                                <a href="{{ route('campaign.daan_details_slug', ['slug' => $daanCampaign->slug]) }}">
                                                    <button class="btn btn-sm btn-orange me-2">Donate Now</button>
                                                </a>
                                                <a href="{{ route('campaign.daan_details_slug', ['slug' => $daanCampaign->slug]) }}">
                                                    <button class="btn btn-sm btn-outline-orange">Read More</button>
                                                </a>
                                            </div>
                                            <div class="social-icons mt-2">
                                                <i class="bi bi-facebook"></i>
                                                <i class="bi bi-twitter"></i>
                                                <i class="bi bi-instagram"></i>
                                                <i class="bi bi-share-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')
<style>
    .text-orange { color: #ff7c1f; }
    .bg-orange { background-color: #ff7c1f !important; }
    .btn-orange {
        background-color: #ff7c1f;
        color: #fff;
        border: none;
    }
    .btn-orange:hover {
        background-color: #e96b10;
    }
    .btn-outline-orange {
        border: 1px solid #ff7c1f;
        color: #ff7c1f;
    }
    .btn-outline-orange:hover {
        background-color: #ff7c1f;
        color: #fff;
    }
    .text-green { color: #4e5b31; }

    .carousel-control {
        background-color: #ff7c1f;
        padding: 5px;
        border-radius: 4px;
    }

    .social-icons i {
        color: #4e5b31;
        margin-right: 10px;
        cursor: pointer;
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .upcomming-events .event-card {
            flex-direction: column;
        }
    }
</style>
@endpush
