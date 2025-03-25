@php
    $content = getContent('category.content', true);
    $categories = App\Models\Category::active()
        ->orderByDesc('id')
        ->withCount([
            'campaigns' => function ($query) {
                $query->active()->running()->boundary();
            },
        ])
        ->get();

    // Define icons that match specific categories
    $icons = [
        'Education' => 'fa-graduation-cap',
        'Hunger' => 'fa-utensils',
        'Elderly' => 'fa-user-nurse',
        'Children' => 'fa-child',
        'Animal' => 'fa-paw',
        'Urgent' => 'fa-exclamation-triangle',
        'Health' => 'fa-briefcase-medical',
        'Environment' => 'fa-tree',
        'Disaster Relief' => 'fa-hands-helping',
        'Community' => 'fa-users',
        'Charity' => 'fa-hand-holding-heart',
        'Memorial' => 'fa-monument',
        'Others' => 'fa-hand-holding-medical',
    ];

    // Define "Why Daankart?" features
    $whyFeatures = [
        ["icon" => "fa-hand-holding-heart", "text" => "Transparent Fund Allocation"],
        ["icon" => "fa-people-carry", "text" => "Community-Driven Initiatives"],
        ["icon" => "fa-chart-line", "text" => "Impactful Fundraising Tools"],
        ["icon" => "fa-money-check-alt", "text" => "Secure Payment Modes"],
        ["icon" => "fa-headset", "text" => "24/7 Expert Support"],
        ["icon" => "fa-globe", "text" => "Global Reach & Support"],
        ["icon" => "fa-user-shield", "text" => "Donor Privacy Protection"],
        ["icon" => "fa-hands-helping", "text" => "Verified Charitable Campaigns"],
    ];
@endphp

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Category Section Styles */
        .category-card {
            background-color: #ff7f00;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease-in-out;
            /*width: 160px;*/
            /*height: 160px;*/
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.2);
        }
        .category-icon {
            font-size: 45px;
            color: white;
            margin-bottom: 10px;
        }
        .category-text {
            font-size: 16px;
            font-weight: bold;
            color: white;
        }
        /* "Why Daankart?" Section Styles */
        .why-section {
            padding: 50px 20px;
            /*background-color: #f9f9f9;*/
            text-align: center;
        }
        .why-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .why-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            max-width: 1100px;
            margin: auto;
            justify-items: center;
        }
        .why-item {
            text-align: center;
            /*background: #fff;*/
            padding: 20px;
            border-radius: 8px;
            /*box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);*/
        }
        .why-icon {
            font-size: 50px;
            color: #ff7f00;
            margin-bottom: 10px;
        }
        .why-text {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .why-underline {
            width: 40px;
            height: 4px;
            background-color: #ff7f00;
            margin: 8px auto;
        }
    </style>
</head>

<!-- Category Section -->
<section>
    <div class="banner-slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section-header mb-2">
                        <h2 class="section-title">{{ __(@$content->data_values->heading) }}</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($categories as $category)
                    @php
                        $iconClass = $icons[$category->name] ?? 'fa-star';
                    @endphp
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4 text-center">
                        <div class="category-card">
                            <i class="fas {{ $iconClass }} category-icon"></i>
                            <div class="category-text">{{ __($category->name) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- "Why Daankart?" Section -->
<section class="why-section">
    <h2 class="why-title">Why Daankart?</h2>
    <div class="why-grid">
        @foreach ($whyFeatures as $feature)
            <div class="why-item">
                <i class="fa-solid {{ $feature['icon'] }} why-icon"></i>
                <div class="why-underline"></div>
                <p class="why-text">{{ $feature['text'] }}</p>
            </div>
        @endforeach
    </div>
</section>