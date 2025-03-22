@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pt-120 pb-120">
        <div class="container-fluid custom-container ">
            <div class="row">
                <!-- Left Sidebar - Filters -->
                <div class="col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Campaign Title Filter -->
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

                            <!-- Date Filter -->
                            <div class="mb-4">
                                <h5 class="text-orange">Filter By Date</h5>
                                <input type="text" class="form-control datepicker" placeholder="From Created Date..">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Campaign Cards -->
                <div class="col-lg-9">
                    <div class="row g-4">
                        @forelse($campaigns as $campaign)
                            <div class="col-md-6 col-lg-4">
                                <div class="event-card has-link">
                                    <span class="feature">
                                        {{ $campaign->category->name }}
                                    </span>
                                    <a class="item-link" href="{{ route('campaign.daan_details', $campaign->id) }}"></a>
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
                                                <b>1,800 INR</b>
                                                Raised
                                            </div>
                                            <div class="right">
                                                Goal <b>2,500,000 INR</b>
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

                    <!-- Pagination -->
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
