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
@extends($activeTemplate . 'layouts.frontend')
@section('content')
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
                                src="https://daankart.com/assets/images/campaign/67c918cdda4da1741232333.jpg" alt="image">
                        </div>
                        <div class="event-details__user">
                            <span class="icon border--radius heart-icon favoriteBtn " data-id="27"
                                title="Make Favourite?">
                                <i class="fas fa-heart"></i>
                            </span>
                        </div>
                    </div>
                    <div class="scrollable-images mt-4">
                        <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3"
                            alt="Small Image 1">
                        <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3"
                            alt="Small Image 2">
                        <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3"
                            alt="Small Image 3">
                        <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3"
                            alt="Small Image 4">
                        <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3"
                            alt="Small Image 5">
                        <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3"
                            alt="Small Image 5">
                        <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3"
                            alt="Small Image 5">
                        <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3"
                            alt="Small Image 5">


                    </div>
                    <div class="event-details-area mt-50">
                        <ul class="nav nav-tabs custom--tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" href="#description" role="tab"
                                    aria-controls="description" aria-selected="true"><span
                                        class="las la-desktop d-block text-center mb-1"></span>PRODUCTS</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" href="#description" role="tab"
                                    aria-controls="description" aria-selected="true"><span
                                        class="las la-desktop d-block text-center mb-1"></span>PROJECT</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="update-tab" data-bs-toggle="tab" data-bs-target="#update"
                                    href="#update" role="tab" aria-controls="update" aria-selected="false"><span
                                        class="las la-info-circle d-block text-center mb-1"></span>UPDATE</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <p class="text-justify">Thanks to your generosity, over 1 lakh abandoned elderly
                                    have found safety, care, and dignity — no longer left to survive on the streets.
                                    Together, let’s reach and transform the lives of 10 lakh more</p>
                            </div><!-- tab-pane end -->
                            <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                                <div class="row gy-4">

                                    <span class="empty-slip-message">
                                        <span class="d-flex justify-content-center align-items-center">
                                            <img src="https://daankart.com/assets/templates/basic//images/empty_list.png"
                                                alt="image">
                                        </span>
                                        Gallery image not found!
                                    </span>


                                </div>
                            </div><!-- tab-pane end -->
                            <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                                <iframe class="iframe-inside"
                                    src="https://daankart.com/assets/images/campaign/proof/67c918cdee23d1741232333.pdf"
                                    height="800"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>

                            </div><!-- tab-pane end -->
                            <div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                                <div class="mb-60">
                                    <div class="accordion custom--accordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                                    data-bs-target="#campaign-details-faq-item-1" type="button"
                                                    aria-expanded="false">
                                                    What is the Elders Initiative?
                                                </button>
                                            </h2>
                                            <div class="accordion-collapse collapse" id="campaign-details-faq-item-1"
                                                data-bs-parent="#campaign-details-faq">
                                                <div class="accordion-body">
                                                    The Elders Initiative is a campaign designed to empower and
                                                    support seniors in our community. We provide resources, raise
                                                    awareness about senior issues, and work toward building a more
                                                    inclusive, supportive environment for older adults.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                                    data-bs-target="#campaign-details-faq-item-2" type="button"
                                                    aria-expanded="false">
                                                    How can I get involved in the campaign?
                                                </button>
                                            </h2>
                                            <div class="accordion-collapse collapse" id="campaign-details-faq-item-2"
                                                data-bs-parent="#campaign-details-faq">
                                                <div class="accordion-body">
                                                    Volunteer: Help seniors by assisting with tasks or providing
                                                    companionship.
                                                    Donate: Contribute financial resources or items to help seniors
                                                    in need.
                                                    Mentor: Share your experiences and knowledge with an elder
                                                    through one-on-one interactions.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                                    data-bs-target="#campaign-details-faq-item-3" type="button"
                                                    aria-expanded="false">
                                                    Who can participate in the Elders Initiative?
                                                </button>
                                            </h2>
                                            <div class="accordion-collapse collapse" id="campaign-details-faq-item-3"
                                                data-bs-parent="#campaign-details-faq">
                                                <div class="accordion-body">
                                                    Anyone can get involved! The initiative is open to individuals
                                                    of all ages, as we encourage intergenerational connections and
                                                    collaboration.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- tab-pane end -->
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="review-tab">
                                <ul class="review-list mb-50">
                                    <span class="empty-slip-message">
                                        <span class="d-flex justify-content-center align-items-center">
                                            <img src="https://daankart.com/assets/templates/basic//images/empty_list.png"
                                                alt="image">
                                        </span>
                                        There are no reviews yet!
                                    </span>

                                </ul>
                                <form action="https://daankart.com/campaign/comment" method="POST">
                                    <input type="hidden" name="_token" value="P4REKm8kmGAh2i7hyCBT5gIb0pZlt2TT7WgsLTLm"
                                        autocomplete="off">
                                    <div class="row">
                                        <input name="campaign" type="hidden" value="27">

                                        <div class="form-group col-lg-6">
                                            <input class="form-control" name="reviewer_name" type="text"
                                                value="{{ $campaign->campaigner_name }}" placeholder="Enter name" disabled required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input class="form-control" name="reviewer_email" type="email"
                                                value="anilkumarkrishna027@gmail.com" placeholder="Enter email" disabled
                                                required>
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <textarea class="form-control" name="review" placeholder="Enter Review" required> </textarea>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="text-end">
                                                <button class="cmn-btn w-50" type="submit">SUBMIT REVIEW</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- tab-pane end -->
                            <div class="tab-pane fade" id="update" role="tabpanel" aria-labelledby="update-tab">
                                <span class="empty-slip-message">
                                    <span class="d-flex justify-content-center align-items-center">
                                        <img src="https://daankart.com/assets/templates/basic//images/empty_list.png"
                                            alt="image">
                                    </span>
                                    No update yet!
                                </span>

                            </div><!-- tab-pane end -->
                        </div>
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
                                    @foreach ($campaign->products as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->price_per_unit }}</td>
                                        <td>{{ $product->required_quantity }}</td>
                                        <td>{{ $product->price_per_unit * $product->required_quantity }}</td>
                                        <td>{{ $product->comments }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <?php
                            $total_amount = $campaign->products->sum('price_per_unit') * $campaign->products->sum('required_quantity');
                        ?>
                        <!-- Donation Section -->
                        <div class="p-4 text-center" style="background-color: #f0f0f5; border-radius: 10px;">
                            <h4 class="fw-bold mb-3">
                                Total Campaign Goal 
                                <span style="float:right;">
                                    ₹ {{ number_format($total_amount, 2) }}
                                </span>
                            </h4>
                            <div class="d-flex justify-content-center gap-3">
                                <button class="btn btn-outline-primary px-4 py-2">₹ {{ number_format($total_amount * 0.1, 2) }}</button>
                                <button class="btn btn-outline-primary px-4 py-2"
                                    style="border: 2px solid #FF5F1F; position: relative;">
                                    👏 ₹ {{ number_format($total_amount * 0.2, 2) }}
                                    <span 
                                        class="badge bg-orange text-white"
                                        style="position: absolute; top: 100%; left: 50%; transform: translateX(-50%); background: #FF5F1F; padding: 5px 10px; border-radius: 5px;"
                                        >
                                        Most Donated
                                    </span>
                                </button>
                                <button class="btn btn-outline-primary px-4 py-2">₹ {{ number_format($total_amount * 0.5, 2) }}</button>
                                {{-- <button class="btn btn-outline-primary px-4 py-2">Enter Amount</button> --}}
                            </div>
                        </div>
                    </div>

                    <div class="container mt-5">
                        <h2 class="fw-bold text-center mb-4">Support by Donating Essentials</h2>
                        <div class="row g-4">
                            @foreach ($campaign->products as $product)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card p-3 shadow-sm">
                                        <h5 class="fw-bold">{{ $product->product_name }}</h5>
                                        <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3"
                                            class="img-fluid mb-2" alt="Groceries Kit">
                                            <p>{{ $product->sold_quantity }} of {{ $product->required_quantity }} Quantity Obtained</p>
                                        <h5 class="text-primary">₹{{ $product->price_per_unit }}/unit</h5>
                                        <button class="btn btn-outline-primary w-100">ADD +</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <section class="video-text-image-section">
                        <!-- Video Section -->
                        <div class="video-container">
                            <video autoplay muted loop playsinline style="width: 100%; height: auto; display: block;">
                                <source src="https://daankart.com/core/public/videos/eldercare.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <!-- Text Section -->
                        <div class="text-container">
                            <p>
                                Fasting during the holy month of Ramadan means different things to different people.
                                To some, it is an act of devotion, to others, it is an exercise in gratitude, to the
                                underprivileged, it is an endurance test.
                            </p>
                        </div>

                        <!-- Image Section -->
                        <div class="image-container">
                            <img src="https://dkprodimages.gumlet.io/campaign/13173/atp%205-01%20(1)%20(1).jpg?format=webp&w=700&dpr=1.0"
                                alt="Image Description" width="100%">
                        </div>

                        <!-- Another Text Section -->
                        <div class="text-container">
                            <p>
                                Due to the children in the slums across India, Ramadan is a time of desperation,
                                hope, and heart-wrenching hunger. A meal, their first, stopped shocking their veins
                                for all too brief that their heart had to forget the taste.
                            </p>
                        </div>

                        <!-- Another Image Section -->
                        <div class="image-container">
                            <img src="https://dkprodimages.gumlet.io/campaign/13173/atp%205-01%20(1)%20(1).jpg?format=webp&w=700&dpr=1.0"
                                alt="Image Description" width="100%">
                        </div>

                        <!-- More Text Sections and Images in Alternating Pattern -->
                        <div class="text-container">
                            <p>
                                Many children have no parents and are left to fend for themselves and rely on odd
                                jobs. The food they get is hardly enough to sustain them.
                            </p>
                        </div>

                        <div class="image-container">
                            <img src="https://dkprodimages.gumlet.io/campaign/13173/atp%205-01%20(1)%20(1).jpg?format=webp&w=700&dpr=1.0"
                                alt="Image Description" width="100%">
                        </div>
                    </section>

                    <style>
                        .video-container,
                        .text-container,
                        .image-container {
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
                                <h3 class="section-title">FAQ</h3>
                                <div class="accordion custom--accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#campaign-details-faq-item-1" type="button">
                                                What is the Elders Initiative?
                                            </button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="campaign-details-faq-item-1">
                                            <div class="accordion-body">
                                                The Elders Initiative is a campaign designed to empower and support
                                                seniors in our community. We provide resources, raise awareness
                                                about senior issues, and work toward building a more inclusive,
                                                supportive environment for older adults.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#campaign-details-faq-item-2" type="button">
                                                How can I get involved in the campaign?
                                            </button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="campaign-details-faq-item-2">
                                            <div class="accordion-body">
                                                Volunteer: Help seniors by assisting with tasks or providing
                                                companionship.
                                                Donate: Contribute financial resources or items to help seniors in
                                                need.
                                                Mentor: Share your experiences and knowledge with an elder through
                                                one-on-one interactions.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#campaign-details-faq-item-3" type="button">
                                                Who can participate in the Elders Initiative?
                                            </button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="campaign-details-faq-item-3">
                                            <div class="accordion-body">
                                                Anyone can get involved! The initiative is open to individuals of
                                                all ages, as we encourage intergenerational connections and
                                                collaboration.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h3 class="section-title">REVIEW</h3>
                                <ul class="review-list mb-50">
                                    <span class="empty-slip-message">
                                        <span class="d-flex justify-content-center align-items-center">
                                            <img src="https://daankart.com/assets/templates/basic//images/empty_list.png"
                                                alt="image">
                                        </span>
                                        There are no reviews yet!
                                    </span>

                                </ul>
                                <form action="https://daankart.com/campaign/comment" method="POST">
                                    <input type="hidden" name="_token" value="P4REKm8kmGAh2i7hyCBT5gIb0pZlt2TT7WgsLTLm"
                                        autocomplete="off"> <input name="campaign" type="hidden" value="27">
                                    <div class="form-group">
                                        <textarea class="form-control" name="review" placeholder="Enter Review" required></textarea>
                                    </div>
                                    <div class="text-end">
                                        <button class="cmn-btn w-50" type="submit">SUBMIT REVIEW</button>
                                    </div>
                                </form>
                            </div>
                            <div class="mb-4">
                                <h3 class="section-title">UPDATE</h3>
                                <span class="empty-slip-message">
                                    <span class="d-flex justify-content-center align-items-center">
                                        <img src="https://daankart.com/assets/templates/basic//images/empty_list.png"
                                            alt="image">
                                    </span>
                                    No update yet!
                                </span>

                            </div>

                            <div class="mb-4">
                                <h3 class="section-title">DOCUMENT</h3>
                                <iframe class="iframe-inside"
                                    src="https://daankart.com/assets/images/campaign/proof/67c918cdee23d1741232333.pdf"
                                    height="800" allowfullscreen></iframe>
                            </div>


                            <!-- Review Section -->

                            <!-- Update Section -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-lg-0 mt-5">
                    <div class="donation-sidebar">
                        <div class="donation-widget">
                            <span class="cam_deadline"> <i class="las la-spinner"></i> Continuous</span>
                            <h4 class="title py-3"><i class="las la-thumbtack"></i> Elders Initiative: Empowering,
                                Supporting, and Celebrating Our Seniors</h4>
                            <div class="skill-bar mt-2">

                                <div class="progressbar" data-perc="0%">
                                    <div class="bar"></div>
                                    <span class="label">0.00%</span>
                                </div>
                            </div>

                            <div class="donation-wrapper">
                                <div class="donation-content">
                                    <div>
                                        <span class="icon"><i class="lab la-telegram-plane"></i></span>
                                        <span class="text">Goal</span>
                                    </div>
                                    <p class="number">10,000,000.00 INR</p>
                                </div>
                                <div class="donation-content">
                                    <div>
                                        <span class="icon"><i class="las la-balance-scale-right"></i></span>
                                        <span class="text">Raised</span>
                                    </div>
                                    <p class="number">0.00 INR</p>
                                </div>
                                <div class="donation-content">
                                    <div>
                                        <span class="icon"><i class="las la-bullseye"></i></span>
                                        <span class="text">Also To Go</span>
                                    </div>
                                    <p class="number">
                                        10,000,000.00 INR
                                    </p>
                                </div>
                                <div class="donation-content">
                                    <div>
                                        <span class="icon"><i class="las la-clock"></i></span>
                                        <span class="text">Not Yet Completed</span>
                                    </div>

                                    <p class="number">13 days to go</p>
                                </div>
                            </div>
                            <div class="donation-wrapper">
                                <div class="event-cart__top">
                                    <p class="mb-0">Organized By &#8599;</p>
                                    <a class="user-profile" href="https://daankart.com/profile/daankart_organization">
                                        <div class="user-profile__thumb">
                                            <img src="https://daankart.com/assets/images/user/avatar.png"
                                                alt="user-avatar">
                                        </div>
                                        <span class="name">
                                            admin Daankart
                                        </span>
                                    </a>
                                </div>
                            </div><!-- donation-widget end -->

                            <div class="donation-widget-2 my-3">
                                <form class="vent-details-form" method="POST"
                                    action="https://daankart.com/campaign/donation/elders-initiative-empowering-supporting-and-celebrating-our-seniors/27">
                                    <input type="hidden" name="_token" value="P4REKm8kmGAh2i7hyCBT5gIb0pZlt2TT7WgsLTLm"
                                        autocomplete="off">
                                    <h3 class="mb-3">Donation Amount</h3>
                                    <div class="form-row align-items-center">
                                        <div class="col-lg-12 form-group donate-amount">
                                            <div class="input-group mr-sm-2">
                                                <div class="input-group-text">₹</div>
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
                                                    ₹100 </label>
                                            </div>
                                            <div class="form--radio form-check-inline">
                                                <input class="form-check-input donation-radio-check"
                                                    id="customRadioInline2" name="customRadioInline1" type="radio"
                                                    value="200">
                                                <label class="form-check-label" for="customRadioInline2">
                                                    ₹200 </label>
                                            </div>
                                            <div class="form--radio form-check-inline">
                                                <input class="form-check-input donation-radio-check"
                                                    id="customRadioInline3" name="customRadioInline1" type="radio"
                                                    value="300">
                                                <label class="form-check-label" for="customRadioInline3">
                                                    ₹300 </label>
                                            </div>
                                            <div class="form--radio form-check-inline">
                                                <input class="form-check-input donation-radio-check custom-donation"
                                                    id="flexRadioDefault4" name="customRadioInline1" type="radio">
                                                <label class="form-check-label" for="flexRadioDefault4">
                                                    Custom </label>
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="mb-4 mt-30">Personal Information</h3>


                                    <div class="form-row">
                                        <div class="form-group col-lg-12">
                                            <label>Full Name</label>
                                            <input class="form-control checktoggle" name="name" type="text"
                                                value="{{ $campaign->campaigner_name }}" required>
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <label>Email</label>
                                            <input class="form-control checktoggle" name="email" type="text"
                                                value="{{ $campaign->email }}" required>
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <label>Mobile: </label>
                                            <input class="form-control checktoggle" name="mobile" type="number"
                                                value="{{ $campaign->mobile_number }}" required>
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <label>Location</label>
                                            <input class="form-control checktoggle" name="location" type="text"
                                                value="{{ $campaign->beneficiary_location }}" required>
                                        </div>
                                        <div class="col-lg-12">
                                            <input name="campaign_id" type="hidden" value="27">
                                            <button class="cmn-btn w-100" type="submit">MAKE YOUR DONATION</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="donation-widget-2 my-3">
                                <h3>Share Campaign</h3>
                                <div class="form-group copy-link">


                                    <input class="copyURL" class="form-control form--control" id="profile"
                                        name="profile" type="text"
                                        value="https://daankart.com/campaign/details/copy/27" readonly="">
                                    <span class="copy" data-id="profile">
                                        <i class="las la-copy"></i> <strong class="copyText">Copy</strong>
                                    </span>

                                </div>

                                <div class="form-group">
                                    <button class="btn cmn-outline-btn w-100" id="copyButton"
                                        data-profile="https://daankart.com/campaign/details/copy/27"
                                        data-url="https://daankart.com/campaign/widget/27" type="button">Copy Widget
                                        for WebPage&nbsp;<i class="far fa-copy"></i></span></button>
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control form--control mt-3 mb-2" id="embedCode" readonly><iframe src="https://daankart.com/campaign/details/copy/27" width="768" height="415"></iframe></textarea>
                                    <button class="btn cmn-outline-btn w-100 copyEmbed" data-embed="">Copy Embed
                                        Code</button>
                                </div>

                                <ul class="social-links mt-2 d-flex justify-content-center">
                                    <li class="facebook face"><a
                                            href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdaankart.com%2Fcampaign%2Fdetails%2Fcopy%2F27"
                                            target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="twitter twi"><a
                                            href="https://twitter.com/intent/tweet?text=Elders Initiative: Empowering, Supporting, and Celebrating Our Seniors&amp;url=https%3A%2F%2Fdaankart.com%2Fcampaign%2Fdetails%2Fcopy%2F27"
                                            target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    <li class="linkedin lin"><a
                                            href="http://www.linkedin.com/shareArticle?mini=true&amp;url=https%3A%2F%2Fdaankart.com%2Fcampaign%2Fdetails%2Fcopy%2F27"
                                            target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li class="whatsapp what"><a
                                            href="https://wa.me/?text=https%3A%2F%2Fdaankart.com%2Fcampaign%2Fdetails%2Fcopy%2F27"
                                            target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                                    <li class="telegram"><a
                                            href="https://t.me/share/url?url=https%3A%2F%2Fdaankart.com%2Fcampaign%2Fdetails%2Fcopy%2F27&text=Elders+Initiative%3A+Empowering%2C+Supporting%2C+and+Celebrating+Our+Seniors"
                                            target="_blank"><i class="fab fa-telegram"></i></a></li>
                                    <li class="pinterest"><a
                                            href="https://pinterest.com/pin/create/button/?url=https%3A%2F%2Fdaankart.com%2Fcampaign%2Fdetails%2Fcopy%2F27&media=https%3A%2F%2Fdaankart.com%2Fassets%2Fimages%2Fcampaign%2F67c918cdda4da1741232333.jpg&description=Thanks+to+your+generosity%2C+over+1+lakh+a..."
                                            target="_blank"><i class="fab fa-pinterest"></i></a></li>
                                </ul>
                            </div><!-- donation-widget end -->
                            <div class="my-3">
                                <div class="mb-4 d-flex d-inline"><span class="milestone-icon"><i
                                            class="lab la-gratipay"></i></span>
                                    <h4>Donation milestone reached: For successful contributions.</h4>
                                </div>
                                <ul class="donor-small-list">
                                    <span class="empty-slip-message">
                                        <span class="d-flex justify-content-center align-items-center">
                                            <img src="https://daankart.com/assets/templates/basic//images/empty_list.png"
                                                alt="image">
                                        </span>
                                        No donations raised yet
                                    </span>


                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
