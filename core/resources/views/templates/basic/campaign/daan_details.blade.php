<?php
use Illuminate\Support\Str;
?>
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

        .campaign-hero-image .event-details-thumb {
            display: flex;
            justify-content: center;
        }

        .campaign-hero-image .event-details-thumb img {
            height: 500px;
            width: 100%;
            object-fit: cover;
            object-position: center;
        }

        .donation-sidebar {
            position: sticky;
            top: 60px
        }

        .daan-details .slider { position: relative; overflow: hidden; }
        .daan-details .slide { display: none; transition: opacity 0.5s ease; }
        .daan-details .slide.active { display: block; }
        .daan-details .slider-controls { display: flex; justify-content: center; align-items: center; margin-top: 10px; }
        .daan-details .prev-btn, .daan-details .next-btn { background: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; margin: 0 10px; }
        .daan-details .slider-dots { display: flex; justify-content: center; }
        .daan-details .dot { width: 10px; height: 10px; border-radius: 50%; background: #ccc; margin: 0 5px; cursor: pointer; }
        .daan-details .dot.active { background: #333; }

    </style>
@endpush
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pt-90 pb-120 daan-details">
        <div class="container">
            <div class="row">
                <div class="mb-4">
                    <h2>{{ $campaign->campaign_title }}</h2>
                </div>
                <div class="col-lg-8">

                    <div class="event-details-wrapper border--radius campaign-hero-image">
                        <div class="event-details-thumb">
                            <img class="border--radius"
                                src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}"
                                alt="image">
                        </div>
                        <div class="event-details__user">
                            <span class="icon border--radius heart-icon favoriteBtn " data-id="27"
                                title="Make Favourite?">
                                <i class="fas fa-heart"></i>
                            </span>
                        </div>
                    </div>
                    {{-- <div class="scrollable-images mt-4">
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
                    </div> --}}
                    <div class="event-details-area mt-50">
                        <ul class="nav nav-tabs custom--tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" href="#description" role="tab"
                                    aria-controls="description" aria-selected="true"><span
                                        class="las la-desktop d-block text-center mb-1"></span>PROJECT</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products"
                                    href="#products" role="tab" aria-controls="products" aria-selected="true"><span
                                        class="las la-desktop d-block text-center mb-1"></span>PRODUCTS</a>
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
                                <p class="text-justify">{{ $campaign->campaign_description }}</p>
                            </div><!-- tab-pane end -->
                            <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
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
                                                        <td>{{ $product->price_per_unit * $product->required_quantity }}
                                                        </td>
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
                                            <button class="btn btn-outline-primary px-4 py-2">₹
                                                {{ number_format($total_amount * 0.1, 2) }}</button>
                                            <button class="btn btn-outline-primary px-4 py-2"
                                                style="border: 2px solid #FF5F1F; position: relative;">
                                                👏 ₹ {{ number_format($total_amount * 0.2, 2) }}
                                                <span class="badge bg-orange text-white"
                                                    style="position: absolute; top: 100%; left: 50%; transform: translateX(-50%); background: #FF5F1F; padding: 5px 10px; border-radius: 5px;">
                                                    Most Donated
                                                </span>
                                            </button>
                                            <button class="btn btn-outline-primary px-4 py-2">₹
                                                {{ number_format($total_amount * 0.5, 2) }}</button>
                                            {{-- <button class="btn btn-outline-primary px-4 py-2">Enter Amount</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
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


                    <div class="container mt-5">
                        <h2 class="fw-bold text-center mb-4">Support by Donating Essentials</h2>
                        <div class="row g-4">
                            @foreach ($campaign->products as $product)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card p-3 shadow-sm">
                                        <h5 class="fw-bold">{{ $product->product_name }}</h5>
                                        <img src="https://dkprodimages.gumlet.io/catalogue/1065250136grocery%20kit%202024%20dec%2018-01.jpg?format=webp&w=160&dpr=1.3"
                                            class="img-fluid mb-2" alt="Groceries Kit">
                                        <p>{{ $product->sold_quantity }} of {{ $product->required_quantity }} Quantity
                                            Obtained</p>
                                        <h5 class="text-primary">₹{{ $product->price_per_unit }}/unit</h5>
                                        <div class="d-flex align-items-center justify-content-between mt-2">
                                            <div class="quantity-control" data-product-id="{{ $product->id }}"
                                                data-product-price="{{ $product->price_per_unit }}">
                                                <button class="btn btn-sm btn-outline-secondary decrease-quantity"
                                                    data-product-id="{{ $product->id }}">-</button>
                                                <span class="mx-2 product-quantity"
                                                    id="quantity-{{ $product->id }}">0</span>
                                                <button class="btn btn-sm btn-outline-secondary increase-quantity"
                                                    data-product-id="{{ $product->id }}">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @push('script')
                        <script>
                            function initializeSlider() {
                                const sliders = document.querySelectorAll('.slider');
                                sliders.forEach(slider => {
                                    const slides = slider.querySelectorAll('.slide');
                                    const dots = slider.closest('.image-slider-container').querySelectorAll('.dot');
                                    const prevBtn = slider.closest('.image-slider-container').querySelector('.prev-btn');
                                    const nextBtn = slider.closest('.image-slider-container').querySelector('.next-btn');
                                    let currentIndex = 0;
                                    let interval;

                                    function showSlide(index) {
                                        slides.forEach(slide => slide.classList.remove('active'));
                                        dots.forEach(dot => dot.classList.remove('active'));
                                        
                                        slides[index].classList.add('active');
                                        dots[index].classList.add('active');
                                        currentIndex = index;
                                    }

                                    function nextSlide() {
                                        currentIndex = (currentIndex + 1) % slides.length;
                                        showSlide(currentIndex);
                                    }

                                    function prevSlide() {
                                        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                                        showSlide(currentIndex);
                                    }

                                    function startAutoRotate() {
                                        interval = setInterval(nextSlide, 5000);
                                    }

                                    function stopAutoRotate() {
                                        clearInterval(interval);
                                    }

                                    // Event listeners
                                    if (prevBtn) {
                                        prevBtn.addEventListener('click', function() {
                                            prevSlide();
                                            stopAutoRotate();
                                            startAutoRotate();
                                        });
                                    }

                                    if (nextBtn) {
                                        nextBtn.addEventListener('click', function() {
                                            nextSlide();
                                            stopAutoRotate();
                                            startAutoRotate();
                                        });
                                    }

                                    dots.forEach((dot, index) => {
                                        dot.addEventListener('click', function() {
                                            showSlide(index);
                                            stopAutoRotate();
                                            startAutoRotate();
                                        });
                                    });

                                    // Start auto rotation
                                    startAutoRotate();
                                });
                            }
                            $(document).ready(function() {
                                const cart = [];
                                // Increase quantity
                                $('.increase-quantity').on('click', function() {
                                    const productId = $(this).data('product-id');
                                    const productPrice = $(this).closest('.quantity-control').data('product-price');
                                    const quantityElement = $(`#quantity-${productId}`);
                                    let quantity = parseInt(quantityElement.text());
                                    quantityElement.text(quantity + 1);

                                    // Check if product already exists in cart
                                    const existingProductIndex = cart.findIndex(item => item.productId === productId);
                                    if (existingProductIndex !== -1) {
                                        // Update existing product quantity
                                        cart[existingProductIndex].quantity = quantity + 1;
                                    } else {
                                        // Add new product to cart
                                        cart.push({
                                            productId: productId,
                                            quantity: quantity + 1,
                                            price: productPrice
                                        });
                                    }
                                    updateCartAmount();
                                });

                                // Decrease quantity
                                $('.decrease-quantity').on('click', function() {
                                    const productId = $(this).data('product-id');
                                    const quantityElement = $(`#quantity-${productId}`);
                                    let quantity = parseInt(quantityElement.text());
                                    if (quantity > 0) {
                                        quantityElement.text(quantity - 1);

                                        // Check if product already exists in cart
                                        const existingProductIndex = cart.findIndex(item => item.productId === productId);
                                        if (existingProductIndex !== -1) {
                                            // Update existing product quantity
                                            cart[existingProductIndex].quantity = quantity - 1;

                                            // Remove product from cart if quantity becomes 0
                                            if (cart[existingProductIndex].quantity === 0) {
                                                cart.splice(existingProductIndex, 1);
                                            }
                                        }
                                    }
                                    updateCartAmount();
                                });

                                // Add to cart
                                function updateCartAmount() {
                                    let totalAmount = 0;
                                    cart.forEach(item => {
                                        totalAmount += item.quantity * item.price;
                                    });
                                    $('#donateAmount').val(totalAmount);
                                }

                                initializeSlider();
                            });
                        </script>
                    @endpush

                    @if ($campaign->sections)
                        <section class="video-text-image-section">
                            @foreach ($campaign->sections as $section)
                                @if ($section->type == 'heading')
                                    <h2 class="fw-bold text-center mb-4">{!! $section->content !!}</h2>
                                @elseif($section->type == 'video' || $section->type == 'video_url')
                                    <section class="video-text-image-section">
                                        <div class="video-container">
                                            <video autoplay muted loop playsinline
                                                style="width: 100%; height: auto; display: block;">
                                                <source src="{{ $section->content }}" type="video/mp4">
                                            </video>
                                        </div>
                                    </section>
                                @elseif($section->type == 'image' || $section->type == 'image_url')
                                    <div class="image-container">
                                        <img src="{!! $section->content !!}" alt="Image Description" width="100%">
                                    </div>
                                @elseif($section->type == 'document_url')
                                    <div class="document-container">
                                        <div class="mb-4">
                                            <iframe class="iframe-inside" src="{!! $section->content !!}" height="800"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                @elseif($section->type == 'paragraph')
                                    <div class="text-container">
                                        <p>{!! $section->content !!}</p>
                                    </div>
                                @elseif($section->type == 'subheading')
                                    <h3 class="fw-bold text-center mb-4">{!! $section->content !!}</h3>
                                @elseif($section->type == 'image_slider')
                                    <div class="image-slider-container">
                                        <div class="slider">
                                            @foreach ($section->content as $key => $image)
                                                <div class="slide {{ $key === 0 ? 'active' : '' }}">
                                                    <img src="{{ $image }}" alt="Image Description" width="100%">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="slider-controls">
                                            <button class="prev-btn">&lt;</button>
                                            <div class="slider-dots">
                                                @foreach ($section->content as $key => $image)
                                                    <span class="dot {{ $key === 0 ? 'active' : '' }}" data-index="{{ $key }}"></span>
                                                @endforeach
                                            </div>
                                            <button class="next-btn">&gt;</button>
                                        </div>
                                    </div>
                                @elseif($section->type == 'faq')
                                    <div class="faq-container mb-4">
                                        <h3 class="section-title">FAQ</h3>
                                        <div class="accordion custom--accordion">
                                            @foreach ($section->content as $faq)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#campaign-details-faq-item-{{ Str::slug($faq->question) }}"
                                                            type="button">
                                                            {{ $faq->question }}
                                                        </button>
                                                    </h2>
                                                    <div class="accordion-collapse collapse"
                                                        id="campaign-details-faq-item-{{ Str::slug($faq->question) }}">
                                                        <div class="accordion-body">
                                                            {{ $faq->answer }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($section->type == 'youtube')
                                    {{-- embed youtube video --}}
                                    <div class="video-container">
                                        <section class="video-text-image-section">
                                            <div class="video-container">
                                                <iframe src="{{ $section->content }}" width="100%" height="315"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        </section>
                                @endif
                            @endforeach
                        </section>
                    @endif
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
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-lg-0 mt-5">
                    <div class="donation-sidebar">
                        <div class="donation-widget">
                            <span class="cam_deadline"> <i class="las la-spinner"></i> Continuous</span>
                            <h4 class="title py-3"><i class="las la-thumbtack"></i>
                                {{ $campaign->category ? $campaign->category->name : 'Campaign' }} Initiative:
                                {{ $campaign->campaign_title }}
                            </h4>
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
                                    <p class="number">{{ number_format($total_amount, 2) }} INR</p>
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
                                        {{ number_format($total_amount, 2) }} INR
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
                                            {{ $campaign->campaigner_name }}
                                        </span>
                                    </a>
                                </div>
                            </div><!-- donation-widget end -->
                            <div class="donation-widget-2">
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
                                        {{-- <div class="col-12 form-group donated-amount">
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
                                    </div> --}}
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
                                    <input class="copyURL" id="profile" name="profile" type="text"
                                        value="https://daankart.com/campaign/details/{{ $campaign->id }}" readonly>
                                    <span class="copy" data-id="profile">
                                        <i class="las la-copy"></i> <strong class="copyText">Copy</strong>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <button class="btn cmn-outline-btn w-100" id="copyButton"
                                        data-profile="https://daankart.com/campaign/details/{{ $campaign->id }}"
                                        data-url="https://daankart.com/campaign/widget/{{ $campaign->id }}"
                                        type="button">
                                        Copy Widget for WebPage <i class="far fa-copy"></i>
                                    </button>
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control form--control mt-3 mb-2" id="embedCode" readonly><iframe src="https://daankart.com/campaign/details/{{ $campaign->id }}" width="768" height="415"></iframe></textarea>
                                    <button class="btn cmn-outline-btn w-100 copyEmbed">
                                        Copy Embed Code
                                    </button>
                                </div>
                                <ul class="social-links mt-2 d-flex justify-content-center">
                                    @php
                                        $shareUrl = urlencode("https://daankart.com/campaign/details/{$campaign->id}");
                                        $title = urlencode($campaign->title);
                                        $image = urlencode(asset("assets/images/campaign/{$campaign->image}"));
                                    @endphp

                                    <li class="facebook face">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                            target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li class="twitter twi">
                                        <a href="https://twitter.com/intent/tweet?text={{ $title }}&url={{ $shareUrl }}"
                                            target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="linkedin lin">
                                        <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}"
                                            target="_blank">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li class="whatsapp what">
                                        <a href="https://wa.me/?text={{ $shareUrl }}" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </li>
                                    <li class="telegram">
                                        <a href="https://t.me/share/url?url={{ $shareUrl }}&text={{ $title }}"
                                            target="_blank">
                                            <i class="fab fa-telegram"></i>
                                        </a>
                                    </li>
                                    <li class="pinterest">
                                        <a href="https://pinterest.com/pin/create/button/?url={{ $shareUrl }}&media={{ $image }}&description={{ $title }}"
                                            target="_blank">
                                            <i class="fab fa-pinterest"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
