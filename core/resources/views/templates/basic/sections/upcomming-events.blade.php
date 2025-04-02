@php
    $campaignsChunks = \App\Models\Campaign::where('status', 1)->limit(12)->get()->chunk(3);
    $daanCampaigns = \App\Models\DaanCampaign::where([
        'status' => "Approved",
        'is_kyc_varified' => 1,
    ])->limit(1)->latest()->get();
    // dd($daanCampaigns);
@endphp
<div class="container py-4 upcomming-events">
    <div class="row">

        <!-- Upcoming Events -->
        <div class="col-md-6">
            <div class="row">
                <div class="col">
                    <h4 class="mb-4">Upcoming Event</h4>
                </div>
                <div class="col-md-4">
                    <div class="carousel-navigation">
                        <button class="carousel-control control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Event Slider -->
            <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
                
                <div class="carousel-inner">
                    @foreach ($campaignsChunks as $key => $campaigns)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        @foreach ($campaigns as $campaign)
                        <div class="event-card border-0 shadow-sm mb-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}" alt="Event Image" class="w-100 h-100">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="text-primary mb-2">{{ $campaign->title }}</h5>
                                    <p class="text-muted small">{!! $campaign->description !!}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                    </div>
                    @endforeach
                </div>
                
            </div>
        </div>

        <!-- Featured Causes -->
        <div class="col-md-6">
            <h4 class="mb-2">Featured Causes</h4>
            @foreach ($daanCampaigns as $daanCampaign)
            <div class="event-card border-0 shadow-sm mb-2">
                <div class="row">
                    <div class="col-md-12 position-relative">
                        <img src="{{ getImage(getFilePath('campaign') . '/' . $daanCampaign->image, getFileSize('campaign')) }}" alt="Event Image" class="w-100 h-100">
                        {{-- add progress bar --}}
                        <?php
                            $raised_amount = $daanCampaign->raised_amount ?? 100;
                            $goal = $daanCampaign->goal ?? 1000;

                            $raised_amount = 100;
                            $goal = 1000;

                            $percentage = ($raised_amount / $goal) * 100;
                        ?>
                        <div class="progress mt-2 position-absolute" style="bottom: 0; left: 0; right: 0;margin: 10px 20px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $raised_amount }}" aria-valuemin="0" aria-valuemax="{{ $goal }}"></div>
                            <span class="text-white position-relative translate-left-minus-full">{{ $percentage }}%</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h5 class="text-primary mt-2 mb-2">{{ $daanCampaign->campaign_title }}</h5>
                        <p class="text-muted small">{!! $daanCampaign->campaign_description !!}</p>
                        <div class="mb-2">
                            <a href="{{ route('campaign.daan_details_slug', ['slug' => $daanCampaign->slug]) }}">
                                <button class="btn btn-sm btn-primary me-2">Donate Now</button>
                            </a>
                            <a href="{{ route('campaign.daan_details_slug', ['slug' => $daanCampaign->slug]) }}">
                                <button class="btn btn-sm btn-outline-primary">Read More</button>
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
            @endforeach
        </div>
    </div>
</div>

@push('style')
<style>
    .upcomming-events .event-card {
        display: flex;
        flex-direction: row;
    }
    .upcomming-events .event-date {
      background-color: #ff4a00;
      color: white;
      text-align: center;
      padding: 10px;
      width: 60px;
      border-radius: 5px;
    }
    .upcomming-events .event-date .day {
      font-size: 1.25rem;
      font-weight: bold;
    }
    .upcomming-events .event-date .month {
      text-transform: uppercase;
    }
    .upcomming-events .donation-bar {
      background: rgba(255, 74, 0, 0.85);
      color: white;
      text-align: center;
      padding: 10px;
      border-bottom-left-radius: 0.5rem;
      border-bottom-right-radius: 0.5rem;
      width: 100%;
      position: absolute;
      bottom: 0;
      left: 0;
    }
    .upcomming-events .social-icons i {
      font-size: 1.2rem;
      margin-right: 10px;
      color: #ff4a00;
      cursor: pointer;
    }
    .upcomming-events .image-container {
        height: 250px;
        overflow: hidden;
        margin-right: 15px;
    }
    .upcomming-events .event-card-img {
        width: 100%;
        object-fit: contain;
        object-position: center;
        height: 100%;
    }
    .upcomming-events .carousel-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .upcomming-events .carousel-navigation .carousel-control  {
        background-color: #de7c00;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px 0px;
        border-radius: 5px;
    }
</style>
@endpush
