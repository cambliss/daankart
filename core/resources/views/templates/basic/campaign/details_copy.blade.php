@php
    $donor = $campaign->donations->where('status', Status::DONATION_PAID);
    $donation = $donor->sum('donation');
    $percent = percent($donation, $campaign);
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- event details section start -->
    <section class="pt-90 pb-120">
        <div class="container">
            <div class="row">
                <div class="mb-4">
                    <h2>Help Chandni Feed Warm Meals To 3000+ Slum Kids In This Holy Month
</h3>
                </div>
                <div class="col-lg-8">
                   
                    <div class="event-details-wrapper border--radius">
                        <div class="event-details-thumb">
                            <img class="border--radius"
                                src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}"
                                alt="@lang('image')">
                        </div>
                        <div class="event-details__user">
                            @php
                                $isAuthenticated = auth()->check();
                                $isFavorite = $isAuthenticated && in_array($campaign->id, $myFavorites ?? []);
                                $favoriteClass = $isFavorite ? 'active' : '';
                                $favoriteTitle = $isFavorite ? __('Remove Favorite') : __('Make Favourite');
                            @endphp
                            <span class="icon border--radius heart-icon favoriteBtn {{ $favoriteClass }}"
                                data-id="{{ $campaign->id }}" title="{{ $favoriteTitle }}?">
                                <i class="fas fa-heart"></i>
                            </span>
                        </div>
                    </div>
                      <div class="scrollable-images mt-4">
                    <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" alt="Small Image 1">
                    <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" alt="Small Image 2">
                    <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" alt="Small Image 3">
                    <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" alt="Small Image 4">
                    <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" alt="Small Image 5">
                    <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" alt="Small Image 5">
                    <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" alt="Small Image 5">
                    <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" alt="Small Image 5">


                </div>
<div class="container mt-5 mb-5">
    <h2 class="mb-4 fw-bold text-center">Where Does All Your Money Go?</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead style="background-color: #FF5F1F; color: white;">
                <tr>
                    <th class="py-3">Product Name</th>
                    <th class="py-3">Price</th>
                    <th class="py-3">Quantity</th>
                    <th class="py-3">Total Cost</th>
                    <th class="py-3">Comments</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($products) && count($products) > 0)
                    @foreach ($products as $product)
                        <tr>
                            <td class="fw-semibold">{{ $product->product_name }}</td>
                            <td class="fw-bold" style="color: #FF5F1F;">Rs.{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td class="fw-bold" style="color: #FF5F1F;">Rs.{{ number_format($product->total_cost, 2) }}</td>
                            <td class="text-muted">{{ $product->comments }}<strong>/year</strong></td>
                        </tr>
                    @endforeach

                    <!-- Total Amount Row -->
                    <tr style="background-color: #333333; color: white;">
                        <td colspan="3" class="fw-bold text-end py-3" style="font-size: 1.2rem;">Total</td>
                        <td colspan="2" class="fw-bold py-3" style="font-size: 1.3rem; color: #FFD700;">Rs. 25,00,000.00 <strong>/year</strong></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="5" class="text-danger fw-bold py-4">No products found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Donation Section -->
    <div class="p-4 text-center" style="background-color: #f0f0f5; border-radius: 10px;">
        <h4 class="fw-bold mb-3">Total Campaign Goal <span style="float:right;">₹ 1,01,80,450</span></h4>
        <div class="d-flex justify-content-center gap-3">
            <button class="btn btn-outline-primary px-4 py-2">₹1100</button>
            <button class="btn btn-outline-primary px-4 py-2" style="border: 2px solid #FF5F1F; position: relative;">
                👏 ₹1500
                <span class="badge bg-orange text-white" style="position: absolute; top: 100%; left: 50%; transform: translateX(-50%); background: #FF5F1F; padding: 5px 10px; border-radius: 5px;">Most Donated</span>
            </button>
            <button class="btn btn-outline-primary px-4 py-2">₹3000</button>
            <button class="btn btn-outline-primary px-4 py-2">Enter Amount</button>
        </div>
    </div>
</div>
           
           <div class="container mt-5">
    <h2 class="fw-bold text-center mb-4">Support by Donating Essentials</h2>
    <div class="row g-4">
        <!-- Groceries Kit -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-3 shadow-sm">
                <h5 class="fw-bold">Groceries Kit</h5>
                <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" class="img-fluid mb-2" alt="Groceries Kit">
                <p>406 of 2000 Quantity Obtained</p>
                <h5 class="text-primary">₹640/unit</h5>
                <button class="btn btn-outline-primary w-100">ADD +</button>
            </div>
        </div>

        <!-- Fruit Kit -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-3 shadow-sm">
                <h5 class="fw-bold">Fruit Kit</h5>
                <img src="{{ asset('assets/images/campaignProducts/FruitsKit.png') }}" class="img-fluid mb-2" alt="Fruit Kit">
                <p>314 of 2000 Quantity Obtained</p>
                <h5 class="text-primary">₹540/unit</h5>
                <button class="btn btn-outline-primary w-100">ADD +</button>
            </div>
        </div>

        <!-- Milk Pack -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-3 shadow-sm">
                <h5 class="fw-bold">Milk Tetra Pack 1L</h5>
                <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" class="img-fluid mb-2" alt="Milk Tetra Pack">
                <p>103 of 2000 Quantity Obtained</p>
                <h5 class="text-primary">₹585/unit</h5>
                <button class="btn btn-outline-primary w-100">ADD +</button>
            </div>
        </div>

        <!-- Kimia Dates -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-3 shadow-sm">
                <h5 class="fw-bold">Kimia Dates 1.5Kg</h5>
                <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" class="img-fluid mb-2" alt="Kimia Dates">
                <p>106 of 1500 Quantity Obtained</p>
                <h5 class="text-primary">₹600/unit</h5>
                <button class="btn btn-outline-primary w-100">ADD +</button>
            </div>
        </div>

        <!-- Kurta Pajama -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-3 shadow-sm">
                <h5 class="fw-bold">Kurta Pajama Set</h5>
                <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" class="img-fluid mb-2" alt="Kurta Pajama">
                <p>59 of 1500 Quantity Obtained</p>
                <h5 class="text-primary">₹650/unit</h5>
                <button class="btn btn-outline-primary w-100">ADD +</button>
            </div>
        </div>

        <!-- Footwear -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-3 shadow-sm">
                <h5 class="fw-bold">Footwear (2 Pairs)</h5>
                <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" class="img-fluid mb-2" alt="Footwear">
                <p>58 of 1500 Quantity Obtained</p>
                <h5 class="text-primary">₹500/unit</h5>
                <button class="btn btn-outline-primary w-100">ADD +</button>
            </div>
        </div>

        <!-- Mix Dry Fruit -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-3 shadow-sm">
                <h5 class="fw-bold">Mix Dry Fruit 1Kg</h5>
                <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3" class="img-fluid mb-2" alt="Mix Dry Fruit">
                <p>49 of 1500 Quantity Obtained</p>
                <h5 class="text-primary">₹625/unit</h5>
                <button class="btn btn-outline-primary w-100">ADD +</button>
            </div>
        </div>
    </div>
</div>

<section class="video-text-image-section">
    <!-- Video Section -->
    <div class="video-container">
  <video autoplay muted loop playsinline style="width: 100%; height: auto; display: block;">
        <source src="{{ asset('core/public/'.$campaign->video_link) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>    </div>
    
    <!-- Text Section -->
    <div class="text-container">
        <p>
            Fasting during the holy month of Ramadan means different things to different people. To some, it is an act of devotion, to others, it is an exercise in gratitude, to the underprivileged, it is an endurance test.
        </p>
    </div>
    
    <!-- Image Section -->
    <div class="image-container">
        <img src="https://dkprodimages.gumlet.io/campaign/13173/atp%205-01%20(1)%20(1).jpg?format=webp&w=700&dpr=1.0" alt="Image Description" width="100%">
    </div>
    
    <!-- Another Text Section -->
    <div class="text-container">
        <p>
            Due to the children in the slums across India, Ramadan is a time of desperation, hope, and heart-wrenching hunger. A meal, their first, stopped shocking their veins for all too brief that their heart had to forget the taste.
        </p>
    </div>
    
    <!-- Another Image Section -->
    <div class="image-container">
        <img src="https://dkprodimages.gumlet.io/campaign/13173/atp%205-01%20(1)%20(1).jpg?format=webp&w=700&dpr=1.0" alt="Image Description" width="100%">
    </div>
    
    <!-- More Text Sections and Images in Alternating Pattern -->
    <div class="text-container">
        <p>
            Many children have no parents and are left to fend for themselves and rely on odd jobs. The food they get is hardly enough to sustain them.
        </p>
    </div>
    
    <div class="image-container">
        <img src="https://dkprodimages.gumlet.io/campaign/13173/atp%205-01%20(1)%20(1).jpg?format=webp&w=700&dpr=1.0" alt="Image Description" width="100%">
    </div>
</section>

<style>
    .video-container, .text-container, .image-container {
        max-width: 800px;
        margin: 20px auto;
        text-align: center;
    }
    .text-container p {
        font-size: 1.2rem;
        line-height: 1.6;
        color: #333;
    }
    .image-container img {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>
<div class="event-details-area mt-50">
    <div class="tab-content mt-4" id="myTabContent">
        <!-- Document Section -->
                <div class="mb-4">
            <h3 class="section-title">@lang('FAQ')</h3>
            @if ($campaign->faqs)
                <div class="accordion custom--accordion">
                    @foreach ($campaign->faqs->question as $key => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#campaign-details-faq-item-{{ $key + 1 }}" type="button">
                                    {{ __($campaign->faqs->question[$key]) }}
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="campaign-details-faq-item-{{ $key + 1 }}">
                                <div class="accordion-body">
                                    {{ __($campaign->faqs->answer[$key]) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'FAQ not found!'])
            @endif
        </div>
        <div class="mb-4">
            <h3 class="section-title">@lang('REVIEW')</h3>
            <ul class="review-list mb-50">
                @forelse($campaign->comments->where('status', Status::PUBLISHED) as $comment)
                    <li class="single-review">
                        <div class="thumb">
                            <img src="{{ avatar(@$comment->user->image ? getFilePath('userProfile') . '/' . @$comment->user->image : null, false) }}" alt="user-avatar">
                        </div>
                        <div class="content">
                            <p class="name">{{ __(@$comment->user->fullname ?? @$comment->user->username) }}</p>
                            <span class="date">{{ diffForHumans($comment->updated_at) }}</span>
                            <p class="review">{{ __($comment->review) }}</p>
                        </div>
                    </li>
                @empty
                    @include($activeTemplate . 'partials.empty', ['message' => 'There are no reviews yet!'])
                @endforelse
            </ul>
            <form action="{{ route('campaign.comment') }}" method="POST">
                @csrf
                <input name="campaign" type="hidden" value="{{ $campaign->id }}">
                <div class="form-group">
                    <textarea class="form-control" name="review" placeholder="@lang('Enter Review')" required>{{ old('review') }}</textarea>
                </div>
                <div class="text-end">
                    <button class="cmn-btn w-50" type="submit" @disabled(!auth()->user())>@lang('SUBMIT REVIEW')</button>
                </div>
            </form>
        </div>
        <div class="mb-4">
            <h3 class="section-title">@lang('UPDATE')</h3>
            @if ($campaign->campaignUpdate)
                <div class="org-update custom--card">
                    <p class="date"><span class="icon"><i class="las la-calendar"></i></span>{{ showDateTime(@$campaign->campaignUpdate->created_at, 'd F, Y') }} (@lang('updated:') {{ diffForHumans(@$campaign->campaignUpdate->updated_at) }})</p>
                    <div class="org-update__content">
                        <p class="text"> <span class="icon"><i class="lab la-slack-hash"></i></span> @php echo strip_tags(@$campaign->campaignUpdate->updation) @endphp</p>
                    </div>
                </div>
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'No update yet!'])
            @endif
        </div>

        <div class="mb-4">
            <h3 class="section-title">@lang('DOCUMENT')</h3>
            @php $foundPdf = false; @endphp
            @foreach ($campaign->proof_images as $pdfFiles)
                @if (explode('.', @$pdfFiles)[1] == 'pdf')
                    @php $foundPdf = true; @endphp
                    <iframe class="iframe-inside" src="{{ asset(getFilePath('proof') . '/' . @$pdfFiles) }}" height="800" allowfullscreen></iframe>
                @endif
            @endforeach
            @if (!$foundPdf)
                @include($activeTemplate . 'partials.empty', ['message' => 'Document not found!'])
            @endif
        </div>

    
        <!-- Review Section -->

        <!-- Update Section -->
    </div>
</div>
                    <div class="event-details-area mt-50">
                        <ul class="nav nav-tabs custom--tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" href="#description" role="tab"
                                    aria-controls="description" aria-selected="true"><span
                                        class="las la-desktop d-block text-center mb-1"></span>@lang('DESCRIPTION')</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery"
                                    href="#gallery" role="tab" aria-controls="gallery" aria-selected="false"><span
                                        class="las la-image d-block text-center mb-1"></span>@lang('GALLERY')</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="video-tab" data-bs-toggle="tab" data-bs-target="#document"
                                    href="#document" role="tab" aria-controls="document" aria-selected="false"><span
                                        class="las la-file-pdf d-block text-center mb-1"></span>@lang('DOCUMENT')</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq" href="#faq"
                                    role="tab" aria-controls="faq" aria-selected="false"><span
                                        class="las la-question-circle d-block text-center mb-1"></span>@lang('FAQ')</a>
                            </li>
                            <li class="nav-item" role="presentation">

                                <a class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                    href="#reviews" role="tab" aria-controls="review" aria-selected="false"><span
                                        class="las la-comment d-block text-center mb-1"></span>@lang('REVIEW')</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="update-tab" data-bs-toggle="tab" data-bs-target="#update"
                                    href="#update" role="tab" aria-controls="update" aria-selected="false"><span
                                        class="las la-info-circle d-block text-center mb-1"></span>@lang('UPDATE')</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <p class="text-justify">@php echo $campaign->description @endphp</p>
                            </div><!-- tab-pane end -->
                            @php
                                $foundImg = false;
                                $foundPdf = false;
                            @endphp
                            <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                                <div class="row gy-4">
                                    @foreach ($campaign->proof_images as $images)
                                        @if (explode('.', $images)[1] != 'pdf')
                                            @php
                                                $foundImg = true;
                                            @endphp
                                            <div class="col-lg-4 col-sm-6 mb-30">
                                                <div class="gallery-card">
                                                    <a class="view-btn" data-rel="lightcase:myCollection"
                                                        href="{{ asset(getFilePath('proof') . '/' . $images) }}"><i
                                                            class="las la-plus"></i></a>
                                                    <div class="gallery-card__thumb">
                                                        <img src="{{ getImage(getFilePath('proof') . '/' . $images) }}"
                                                            alt="@lang('proof-image')">
                                                    </div>
                                                </div><!-- gallery-card end -->
                                            </div>
                                        @endif
                                    @endforeach

                                    @if (!$foundImg)
                                        @include($activeTemplate . 'partials.empty', [
                                            'message' => 'Gallery image not found!',
                                        ])
                                    @endif

                                </div>
                            </div><!-- tab-pane end -->
                            <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                                @foreach ($campaign->proof_images as $pdfFiles)
                                    @if (explode('.', @$pdfFiles)[1] == 'pdf')
                                        @php
                                            $foundPdf = true;
                                        @endphp
                                        <iframe class="iframe-inside"
                                            src="{{ asset(getFilePath('proof') . '/' . @$pdfFiles) }}" height="800"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                    @endif
                                @endforeach

                                @if (!$foundPdf)
                                    @include($activeTemplate . 'partials.empty', [
                                        'message' => 'Document not found!',
                                    ])
                                @endif
                            </div><!-- tab-pane end -->
                            <div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                                @if ($campaign->faqs)
                                    <div class="mb-60">
                                        <div class="accordion custom--accordion">
                                            @foreach ($campaign->faqs->question as $key => $faq)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#campaign-details-faq-item-{{ $key + 1 }}"
                                                            type="button" aria-expanded="false">
                                                            {{ __($campaign->faqs->question[$key]) }}
                                                        </button>
                                                    </h2>
                                                    <div class="accordion-collapse collapse"
                                                        id="campaign-details-faq-item-{{ $key + 1 }}"
                                                        data-bs-parent="#campaign-details-faq">
                                                        <div class="accordion-body">
                                                            {{ __($campaign->faqs->answer[$key]) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    @include($activeTemplate . 'partials.empty', [
                                        'message' => 'FAQ not found!',
                                    ])
                                @endif
                            </div><!-- tab-pane end -->
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="review-tab">
                                <ul class="review-list mb-50">
                                    @forelse($campaign->comments->where('status',Status::PUBLISHED) as $comment)
                                        <li class="single-review">
                                            <div class="thumb">
                                                <img src="{{ avatar(@$comment->user->image ? getFilePath('userProfile') . '/' . @$comment->user->image : null, false) }}"
                                                    alt="user-avatar">
                                            </div>
                                            <div class="content">
                                                <p class="name mb-0">
                                                    {{ __(@$comment->user->fullname ?? @$comment->user->username) }}</p>
                                                <span class="date mb-2">{{ diffForHumans($comment->updated_at) }}</span>
                                                <p class="review mb-0">{{ __($comment->review) }}</p>
                                            </div>
                                        </li>
                                    @empty
                                        @include($activeTemplate . 'partials.empty', [
                                            'message' => 'There are no reviews yet!',
                                        ])
                                    @endforelse
                                </ul>
                                <form action="{{ route('campaign.comment') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <input name="campaign" type="hidden" value="{{ $campaign->id }}">

                                        <div class="form-group col-lg-6">
                                            <input class="form-control" name="reviewer_name" type="text"
                                                value="{{ old('fullname', auth()->user()->fullname ?? '') }}"
                                                placeholder="@lang('Enter name')" disabled required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input class="form-control" name="reviewer_email" type="email"
                                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                                placeholder="@lang('Enter email')" disabled required>
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <textarea class="form-control" name="review" placeholder="@lang('Enter Review')" required> {{ old('review') }}</textarea>
                                        </div>
                                        <div class="col-lg-12">
                                            @if (!auth()->user())
                                                <div>
                                                    <code>@lang('Login is required for campaign review!')</code>
                                                </div>
                                            @endif
                                            <div class="text-end">
                                                <button class="cmn-btn w-50" type="submit"
                                                    @disabled(!auth()->user())>@lang('SUBMIT REVIEW')</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- tab-pane end -->
                            <div class="tab-pane fade" id="update" role="tabpanel" aria-labelledby="update-tab">
                                @if ($campaign->campaignUpdate)
                                    <div class="org-update custom--card">
                                        <p class="date"><span class="icon"><i
                                                    class="las la-calendar"></i></span>{{ showDateTime(@$campaign->campaignUpdate->created_at, 'd F, Y') }}
                                            (@lang('updated:')
                                            {{ diffForHumans(@$campaign->campaignUpdate->updated_at) }})</p>
                                        <div class="org-update__content">
                                            <p class="text"> <span class="icon"><i
                                                        class="lab la-slack-hash"></i></span> @php echo strip_tags(@$campaign->campaignUpdate->updation) @endphp</p>
                                        </div>
                                    </div>
                                @else
                                    @include($activeTemplate . 'partials.empty', [
                                        'message' => 'No update yet!',
                                    ])
                                @endif
                            </div><!-- tab-pane end -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-lg-0 mt-5">
                    <div class="donation-sidebar">
                        <div class="donation-widget">
                            @if ($campaign->goal_type == Status::AFTER_DEADLINE)
                                <span class="days-left" data-deadline={{ $campaign->deadline }}>
                                    <span class="day"></span>
                                    <span class="hour"></span>
                                    <span class="minute"></span>
                                    <span class="sec"></span>
                                </span>
                            @elseif($campaign->goal_type == Status::CONTINUOUS)
                                <span class="cam_deadline"> <i class="las la-spinner"></i> @lang('Continuous')</span>
                            @else
                                <span class="cam_deadline"> <i class="las la-trophy"></i> @lang('Achieve Goal ') </span>
                            @endif
                            <h4 class="title py-3"><i class="las la-thumbtack"></i> {{ __($campaign->title) }}</h4>
                            <div class="skill-bar mt-2">

                                <div class="progressbar"
                                    data-perc="{{ progressPercent($percent > 100 ? '100' : $percent) }}%">
                                    <div class="bar"></div>
                                    <span
                                        class="label">{{ showAmount(progressPercent($percent > 100 ? '100' : $percent), currencyFormat: false) }}%</span>
                                </div>
                            </div>

                            <div class="donation-wrapper">
                                <div class="donation-content">
                                    <div>
                                        <span class="icon"><i class="lab la-telegram-plane"></i></span>
                                        <span class="text">@lang('Goal')</span>
                                    </div>
                                    <p class="number">{{ showAmount($campaign->goal) }}</p>
                                </div>
                                <div class="donation-content">
                                    <div>
                                        <span class="icon"><i class="las la-balance-scale-right"></i></span>
                                        <span class="text">@lang('Raised')</span>
                                    </div>
                                    <p class="number">{{ showAmount($donation) }}</p>
                                </div>
                                <div class="donation-content">
                                    <div>
                                        <span class="icon"><i class="las la-bullseye"></i></span>
                                        <span class="text">@lang('Also To Go')</span>
                                    </div>
                                    <p class="number">
                                        @if ($campaign->goal > $donation)
                                            {{ showAmount($campaign->goal - $donation) }}
                                        @else
                                            + {{ showAmount($donation - $campaign->goal) }}
                                        @endif
                                    </p>
                                </div>
                                <div class="donation-content">
                                    <div>
                                        <span class="icon"><i class="las la-clock"></i></span>
                                        <span class="text">@lang('Not Yet Completed')</span>
                                    </div>

                                    @php
                                        $today = new DateTime();
                                        $interval = $today->diff($campaign->created_at);
                                    @endphp
                                    <p class="number">{{ $interval->days }} @lang('days to go')</p>
                                </div>
                            </div>
                            <div class="donation-wrapper">
                                <div class="event-cart__top">
                                    <p class="mb-0">@lang('Organized By') &#8599;</p>
                                    <a class="user-profile"
                                        href="{{ route('profile.index', $campaign->user->username) }}">
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
                                            @if ($campaign->user->enable_org)
                                                {{ __($campaign->user->Organization->name) }}
                                            @else
                                                {{ __($campaign->user->fullname) }}
                                            @endif
                                        </span>
                                    </a>
                                </div>
                            </div><!-- donation-widget end -->

                            @if (@auth()->user()->id != $campaign->user_id)
                                <div class="donation-widget-2 my-3">
                                    <form class="vent-details-form" method="POST"
                                        action="{{ route('campaign.donation.process', [$campaign->slug, $campaign->id]) }}">
                                        @csrf
                                        <h3 class="mb-3">@lang('Donation Amount')</h3>
                                        <div class="form-row align-items-center">
                                            <div class="col-lg-12 form-group donate-amount">
                                                <div class="input-group mr-sm-2">
                                                    <div class="input-group-text">{{ gs('cur_sym') }}</div>
                                                    <input class="form-control" id="donateAmount" name="amount"
                                                        type="number" value="0" step="any" required>
                                                </div>
                                            </div>
                                            <div class="col-12 form-group donated-amount">
                                                <div class="form--radio form-check-inline">
                                                    <input class="form-check-input donation-radio-check"
                                                        id="customRadioInline1" name="customRadioInline1" type="radio"
                                                        value="100">
                                                    <label class="form-check-label" for="customRadioInline1">
                                                        {{ gs('cur_sym') }}@lang('100')
                                                    </label>
                                                </div>
                                                <div class="form--radio form-check-inline">
                                                    <input class="form-check-input donation-radio-check"
                                                        id="customRadioInline2" name="customRadioInline1" type="radio"
                                                        value="200">
                                                    <label class="form-check-label" for="customRadioInline2">
                                                        {{ gs('cur_sym') }}@lang('200')
                                                    </label>
                                                </div>
                                                <div class="form--radio form-check-inline">
                                                    <input class="form-check-input donation-radio-check"
                                                        id="customRadioInline3" name="customRadioInline1" type="radio"
                                                        value="300">
                                                    <label class="form-check-label" for="customRadioInline3">
                                                        {{ gs('cur_sym') }}@lang('300')
                                                    </label>
                                                </div>
                                                <div class="form--radio form-check-inline">
                                                    <input class="form-check-input donation-radio-check custom-donation"
                                                        id="flexRadioDefault4" name="customRadioInline1" type="radio">
                                                    <label class="form-check-label" for="flexRadioDefault4">
                                                        @lang('Custom')
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <h3 class="mb-4 mt-30">@lang('Personal Information')</h3>

                                        @if (gs('anonymous_donation'))
                                            <div class="form--check mb-4">
                                                <input class="form-check-input" id="checkdon" name="anonymous"
                                                    type="checkbox" value="1">
                                                <label class="form-check-label" for="checkdon">@lang('Donate Anonymously')</label>
                                            </div>
                                        @endif

                                        @php
                                            $user = auth()->user();
                                        @endphp
                                        <div class="form-row">
                                            <div class="form-group col-lg-12">
                                                <label>@lang('Full Name')</label>
                                                <input class="form-control checktoggle" name="name" type="text"
                                                    value="{{ old('name', @$user->fullname) }}" required>
                                            </div>

                                            <div class="form-group col-lg-12">
                                                <label>@lang('Email')</label>
                                                <input class="form-control checktoggle" name="email" type="text"
                                                    value="{{ old('email', @$user->email) }}" required>
                                            </div>

                                            <div class="form-group col-lg-12">
                                                <label>@lang('Mobile'): </label>
                                                <input class="form-control checktoggle" name="mobile" type="number"
                                                    value="{{ old('mobile', @$user->mobile) }}" required>
                                            </div>

                                            <div class="form-group col-lg-12">
                                                <label>@lang('Country')</label>
                                                <input class="form-control checktoggle" name="country" type="text"
                                                    value="{{ old('country', @$user->country_name) }}" required>
                                            </div>
                                            <div class="col-lg-12">
                                                <input name="campaign_id" type="hidden" value="{{ $campaign->id }}">
                                                <button class="cmn-btn w-100" type="submit"
                                                    @if (@auth()->user()->id == $campaign->user_id) disabled @endif>@lang('MAKE YOUR DONATION')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            <div class="donation-widget-2 my-3">
                                <h3>@lang('Share Campaign')</h3>
                                <div class="form-group copy-link">
                                    {{-- <div class="copy-link input-group">
                                        <input class="form-control form--control copy-input" type="text" value="{{ url()->current() }}" aria-label="" disabled>
                                        <span class="input-group-text flex-align copy-btn cursor-pointer" id="copyBtn" data-link="{{ url()->current() }}"><i class="far fa-copy"></i>&nbsp;@lang('Copy')</span>
                                    </div> --}}

                                    <input class="copyURL" class="form-control form--control" id="profile"
                                        name="profile" type="text" value="{{ url()->current() }}" readonly="">
                                    <span class="copy" data-id="profile">
                                        <i class="las la-copy"></i> <strong class="copyText">@lang('Copy')</strong>
                                    </span>

                                </div>

                                <div class="form-group">
                                    <button class="btn cmn-outline-btn w-100" id="copyButton"
                                        data-profile="{{ url()->current() }}"
                                        data-url="{{ route('campaign.widget', $campaign->id) }}"
                                        type="button">@lang('Copy Widget for WebPage')&nbsp;<i class="far fa-copy"></i></span></button>
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control form--control mt-3 mb-2" id="embedCode" readonly><iframe src="{{ url()->current() }}" width="768" height="415"></iframe></textarea>
                                    <button class="btn cmn-outline-btn w-100 copyEmbed"
                                        data-embed="">@lang('Copy Embed Code')</button>
                                </div>

                                <ul class="social-links mt-2 d-flex justify-content-center">
                                    <li class="facebook face"><a
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                            target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="twitter twi"><a
                                            href="https://twitter.com/intent/tweet?text={{ __(@$campaign->title) }}&amp;url={{ urlencode(url()->current()) }}"
                                            target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    <li class="linkedin lin"><a
                                            href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}"
                                            target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li class="whatsapp what"><a
                                            href="https://wa.me/?text={{ urlencode(url()->current()) }}"
                                            target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                                    <li class="telegram"><a
                                            href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($campaign->title) }}"
                                            target="_blank"><i class="fab fa-telegram"></i></a></li>
                                    <li class="pinterest"><a
                                            href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode(getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign'))) }}&description={{ urlencode(strLimit($campaign->description, 40)) }}"
                                            target="_blank"><i class="fab fa-pinterest"></i></a></li>
                                </ul>
                            </div><!-- donation-widget end -->
                            @if ($campaign->donor_visibility)
                                <div class="my-3">
                                    <div class="mb-4 d-flex d-inline"><span class="milestone-icon"><i
                                                class="lab la-gratipay"></i></span>
                                        <h4>@lang('Donation milestone reached: For successful contributions.')</h4>
                                    </div>
                                    <ul class="donor-small-list">
                                        @php
                                            $allDonors = $donor;
                                        @endphp
                                        @forelse($allDonors->take(4) as $donor)
                                            <li class="single">
                                                <div class="thumb feature-card__icon "><i class="fa fa-user"></i></div>
                                                <div class="content">
                                                    <h6>{{ $donor->fullname }}</h6>
                                                    <p>@lang('Amount') :{{ showAmount($donor->donation) }}</p>
                                                </div>
                                            </li>
                                        @empty
                                            @include($activeTemplate . 'partials.empty', [
                                                'message' => 'No donations raised yet',
                                            ])
                                        @endforelse

                                        @if ($allDonors->count() > 4)
                                            <li class="single">
                                                <button class="donarModal cmn-btn w-100" type="button">@lang('View All')
                                                    &#8594;</button>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- event details section end -->
    <!-- Modal -->
    @if ($campaign->donor_visibility)
        <div class="modal" id="modelId" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"
            tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('All Donors')</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="pb-5">
                            <ul class="donor-small-list">
                                @foreach ($allDonors as $donor)
                                    <li class="single">
                                        <div class="thumb feature-card__icon "><i class="fa fa-user"></i></div>
                                        <div class="content">
                                            <h6>{{ $donor->fullname }}</h6>
                                            <p>@lang('Amount') :
                                                {{ showAmount($donor->donation) }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal"
                            type="button">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('style')
    <style>
        .iframe-inside {
            width: 100%;
            border: none;
            border-radius: 5px;
        }

        .form-check-inline {
            margin-right: 5px !important;
        }

        .milestone-icon {
            font-size: 20px;
            margin-right: 5px;
            align-items: center;
            justify-content: center;
        }
         .scrollable-images {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            white-space: nowrap;
            padding: 10px;
            width: 100%;
        }
        .scrollable-images img {
            height: 100px;
            width: auto;
        }
    </style>
@endpush

@push('script')
    <script>
        'use strict';

        $('.copyEmbed').on('click', function() {
            var copyText = document.getElementById("embedCode");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            notify('success', 'Embed code copied to clipboard successfully');
        })

        $('#checkdon').on('change', function() {
            var status = this.checked;
            if (status) {
                $('.checktoggle').prop("disabled", true)
                $('input[name=name]').val('');
                $('input[name=email]').val('');
                $('input[name=mobile]').val('');
                $('input[name=country]').val('');
            } else {
                @if (@$user)
                    let user = @json($user);
                    $('input[name=name]').val(user.firstname + ' ' + user.lastname);
                    $('input[name=email]').val(user.email);
                    $('input[name=mobile]').val(user.mobile);
                    $('input[name=country]').val(user.address.country);
                @endif
                $('.checktoggle').prop("disabled", false)
            }
        })

        $(".progressbar").each(function() {
            $(this).find(".bar").animate({
                "width": $(this).attr("data-perc")
            }, 3000);
            $(this).find(".label").animate({
                "left": $(this).attr("data-perc")
            }, 3000);
        });

        //donation-checkbox
        $(".donation-radio-check").on('click', function(e) {
            $(".donation-radio-check").attr('checked', false);
            $(this).prop('checked', true);
            $("[name=amount]").val($(this).val())
        });

        $("#donateAmount").on('click', function(e) {
            $(".donation-radio-check").prop('checked', false);
            $(".custom-donation").prop('checked', true);
            $(this).val("");
        });

        $(".custom-donation").on('click', function(e) {
            $("[name=amount]").focus();
            $("[name=amount]").val();
        });

        //donor list
        $('.donarModal').click(function() {
            $('#modelId').modal('show')
        })

        $(document).ready(function() {

            //favourite-start//
            $('.favoriteBtn').on('click', function() {
                var isAuthenticated = @json(auth()->check());

                if (!isAuthenticated) {
                    notify('error', 'Login required for making favourite campaign!');
                    return 0;
                }
                var $this = $(this);
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('user.favorite.add') }}",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.action == 'add') {
                            $this.addClass('active');
                            notify('success', response.notification);
                        } else {
                            $this.removeClass('active');
                            notify('success', response.notification);
                        }
                    }
                });
            });
            //favourite-end//


            //Copy-widget-Start-Here//
            $("#copyButton").click(function() {
                var e = $("#copyButton").data("url"),
                    t = $("#copyButton").data("profile"),
                    n = "{{ gs('site_name') }}",
                    o = 'fetch("' + e +
                    '").then(response=>response.json()).then(data=>{let progressBar=\'<div style="background-color: rgb(0 0 0 / 10%);border-radius: 5px;height: 12px;max-width: 380px;margin: auto;"><div style="background-color: rgb(38 188 106);color: white;text-align: right;font-size: 12px;border-radius: inherit;padding: 0;line-height: 1.2; font-weight: 500; height: 100%; display: flex; align-items: center; justify-content: center; position: relative; width: \'+data.progress_percent+\'%;">...</div></div>\', poweredBy="<p>Powered By: ' +
                    n +
                    '</p>", sdon="&hearts; Send Donation to "+data.profile_name+"\'s Campaign", cimg=\'<img style="height: 100%; width: 100%; object-fit: cover;" src="\'+data.user_image+\'" alt="campaign Image"/>\', title=\'<h3 style="line-height: 1.2; font-size: 18px; font-weight: 600; margin-bottom: 6px;">\'+data.title+\'</h3>\', cdes=data.description, camWidgets=document.getElementsByClassName("campaign-widget"); for(let i=0; i<camWidgets.length; i++){ camWidgets[i].innerHTML=\'<div style="height: 100px; width: 136px; border-radius: 5px; margin: 0 auto 8px; padding: 4px; border: 1px solid rgb(0 0 0 / 10%); overflow: hidden;">\'+cimg+\'</div>\'+title+\'<p style="line-height: 1.4; font-size: 14px; max-width: 400px; margin: 0 auto 27px; color: rgb(0 0 0 / 50%); display: -webkit-box; -webkit-line-clamp: 2; overflow: hidden; -webkit-box-orient: vertical;">\'+cdes+\'</p>\'+progressBar+\'<button style="margin-top: 12px; background: white; color: #21c927; font-size: 12px; padding: 8px 16px; line-height: 1; border-radius: 4px; font-weight: 500; border: 1px solid rgb(0 0 0 / 10%);" class="cam-widget-btn" type="button">\'+sdon+\'</button><div style="font-size: 12px; margin-top: 6px; color: #696969; text-decoration: underline;">\'+poweredBy+\'</div>\'; } }).catch(function(error){ console.warn("Something went wrong.", error); let camWidgets=document.getElementsByClassName("campaign-widget"); for(let i=0; i<camWidgets.length; i++){ camWidgets[i].innerText="Failed to load widget."; } });',
                    i =
                    '<style>.campaign-widget-percent::after {content: ""; border: 4px solid #21c927; border-top-color: transparent; border-left-color: transparent; position: absolute; top: calc(100% - 8px); right: 4px; transform: rotate(45deg);}.campaign-widget:hover .cam-widget-btn {background-color: #21c927 ! important; color: white !important;}</style>',
                    a = '<a href="' + t +
                    '" class="campaign-widget" style="text-align: center; display: block; max-width: 450px; margin: 50px auto; padding: 16px; border-radius: 5px; background-color: #ffff; box-shadow: 0px 5px 30px rgb(0 0 0 / 10%)"  target="_blank"></a>',
                    r = i + a + ' <script> ' + o + ' <\/script>',
                    l = $("<textarea>").val(r).appendTo("body").select();
                try {
                    var c = document.execCommand("copy"),
                        s = c ? "successful" : "unsuccessful";
                    notify('success', "Script copied " + s)
                } catch (e) {
                    console.error("Oops, unable to copy", e)
                }
                l.remove()
            });
            //Copy-widget-end-Here//


        });
    </script>
@endpush
