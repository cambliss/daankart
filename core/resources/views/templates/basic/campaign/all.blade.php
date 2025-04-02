@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pt-120 pb-120">
        <div class="banner-container">
           <img src="{{ asset('assets/images/frontend/exploreBanner/explore_compaign.jpg.jpg') }}" alt="explore_campaign" class="banner-image">
       </div>
       
       <div class="container-fluid custom-container explore-container">
            <div class="row">
                <div class="col-lg-12">
                    @include($activeTemplate . 'sections.search-filters');
                </div>
            </div>
            <div class="row">
                <!-- Left Sidebar - Filters 
                <div class="col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="mb-4">
                                <h5 class="text-orange">Search Campaign</h5>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" id="campaignSearch"
                                        placeholder="Enter Search..">
                                    <button class="btn btn-orange" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="text-orange">Filter By Category</h5>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="category_id" id="allCategory" value="" checked>
                                    <label class="form-check-label" for="allCategory">All</label>
                                </div>
                                @foreach ($categories as $category)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="category_id" id="{{ $category->id }}" value="{{ $category->id }}">
                                    <label class="form-check-label" for="{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-4">
                                <h5 class="text-orange">Filter By Date</h5>
                                <input type="text" class="form-control datepicker" placeholder="From Created Date..">
                            </div>
                        </div>
                    </div>
                </div>
                -->
                <!-- Right Content - Campaign Cards -->
                <div class="col-lg-12">
                    <div class="row g-4">
                        @forelse($campaigns as $campaign)
                            <div class="col-md-6 col-lg-4">
                                <div class="event-card has-link">
                                    @if ($campaign->category)
                                        <span class="feature">
                                            {{ $campaign->category->name }}
                                        </span>
                                    @endif
                                    <a class="item-link" href="{{ $campaign->slug ? route('campaign.daan_details_slug', ['slug' => $campaign->slug]) : '#' }}"></a>
                                    <div class="event-card__thumb">
                                        <span class="camp_deadline">
                                            <i class="las la-certificate"></i> Tax Verified
                                        </span>

                                        <img class="w-100" src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image) }}" alt="image">
                                    </div>

                                    <div class="event-card__content">
                                        <div class="event-cart__top">
                                            <a class="user-profile " href="/profile/daankart_organization">
                                                <div class="user-profile__thumb">
                                                    @if ($campaign->user->enable_org)
                                                        <img src="{{ avatar(@$campaign->user->organization->image ? getFilePath('orgProfile') . '/' . @$campaign->user->organization->image : null) }}"
                                                            alt="org-cover-avatar">
                                                    @else
                                                        <img src="{{ avatar(@$campaign->user->image ? getFilePath('userProfile') . '/' . @$campaign->user->image : null) }}"
                                                            alt="user-avatar">
                                                    @endif
                                                </div>
                                                <span class="name">
                                                    {{ $campaign->user->firstname }}
                                                </span>
                                            </a>
                                            <p class="date">
                                                <i class="las la-calendar"></i>
                                                {{ $campaign->created_at->format('d M Y') }}
                                            </p>
                                        </div>

                                        <h4 class="title pt-2">{{ $campaign->campaign_title }}</h4>
                                        @php
                                            $percentage = percent($campaign->raised_amount, $campaign);
                                        @endphp
                                        <div class="event-bar-item">
                                            <div class="skill-bar">
                                                <div class="progressbar" data-perc="{{ $percentage }}%">
                                                    <div class="bar" style="width: {{ $percentage }}%;"></div>
                                                    <span class="label" style="left: {{ $percentage }}%;">{{ $percentage }}%</span>
                                                </div>
                                            </div>
                                        </div><!-- event-bar-item end -->

                                        <div class="amount-status">
                                            <div class="left">
                                                <b>{{number_format($campaign->raised_amount)}} INR</b>
                                                Raised
                                            </div>
                                            <div class="right">
                                                Goal <b>{{number_format($campaign->goal)}} INR</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    No campaigns found
                                </div>
                            </div>
                        @endforelse
                    </div>
                    @if ($campaigns->hasPages())
                        <div class="mt-4">
                            {{ $campaigns->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .banner-container {
             background-image: url('your-image-url.jpg'); /* Replace with your image URL */
          background-size: cover;
          background-position: center;
          color: white;
          padding-bottom: 120px;
          text-align: center;
          width: 100%; /* Full width */
          height: 400px; /* Adjust height as needed */
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
        }
        
        .explore-container{
            padding-top: 50px;
        }
        .text-orange {
            color: #FF7c1f;
        }
        
        
        .bg-orange {
            background-color: #FF7c1f;
        }

        .btn-orange {
            background-color: #FF7c1f;
            color: white;
        }

        .btn-orange:hover {
            background-color: #e66c15;
            color: white;
        }

        .campaign-card {
            transition: transform 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .campaign-card:hover {
            transform: translateY(-5px);
        }

        .campaign-card img.card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/datepicker.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/datepicker.en.js') }}"></script>
@endpush

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/datepicker.min.css') }}" rel="stylesheet">
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";

            // Initialize datepicker
            $('.datepicker').datepicker({
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                autoClose: true
            });

            // Filter functionality
            $('#campaignSearch').on('keyup', function() {
                filterCampaigns();
            });

            $('input[name="category_id"]').on('change', function() {
                filterCampaigns();
            });

            $('.datepicker').on('change', function() {
                filterCampaigns();
            });

            function filterCampaigns() {
                let search = $('#campaignSearch').val();
                let category = $('input[name="category_id"]:checked').val();
                let date = $('.datepicker').val();

                $.ajax({
                    url: "{{ route('campaign.filter') }}",
                    method: 'GET',
                    data: {
                        search: search,
                        category_id: category,
                        date: date
                    },
                    success: function(response) {
                        // Update the campaign listing with filtered results
                        // You'll need to implement this part based on your backend response
                    }
                });
            }
        })(jQuery);
    </script>
@endpush
