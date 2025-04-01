@php
    $content = getContent('feature.content', true);
    $featureElement = getContent('feature.element', null, false, true);
@endphp
<!-- feature section start -->
<section class="pt-120 position-relative">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 text-lg-left">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$content->data_values->heading) }}</h2>
                    <p class="text-black">{{ __(@$content->data_values->subheading) }}</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row gy-4">
                    @foreach ($featureElement as $feature)
                        <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <div class="feature-card">
                                <div class="feature-card__icon"><?php echo @$feature->data_values->icon; ?></div>
                                <div class="feature-card__content">
                                    <h4 class="title">{{ __(@$feature->data_values->title) }}</h4>
                                    <p class="text-black">{{ __(@$feature->data_values->description) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Added margin to separate feature section from tabs -->
        <div class="container" style="margin-top: 50px;">
            <div class="tabs">
                <a href="#" class="active" data-tab="donors">For Donors</a>
                <a href="#" data-tab="ngos">For NGOs</a>
            </div>

            <!-- Donors Section -->
            <div id="donors-content" class="steps row" style="display: flex;">
                <div class="step-card col-12 col-md-3">
                    <div class="step-number">1</div>
                    <div class="image-box">
                        <img src="assets/images/search.png" alt="Choose a Cause">
                    </div>
                    <h3>CHOOSE A CAUSE</h3>
                    <p>Browse different campaigns and select a cause.</p>
                </div>
                <div class="step-card col-12 col-md-3">
                    <div class="step-number">2</div>
                    <div class="image-box">
                        <img src="assets/images/step.png" alt="Select Products">
                    </div>
                    <h3>SELECT PRODUCTS</h3>
                    <p>Select products and quantity you wish to donate.</p>
                </div>
                <div class="step-card col-12 col-md-3">
                    <div class="step-number">3</div>
                    <div class="image-box">
                        <img src="assets/images/step2.avif" alt="Order Processing">
                    </div>
                    <h3>ORDER PROCESSING</h3>
                    <p>Checkout and pay for your contributions.</p>
                </div>
                <div class="step-card col-12 col-md-3">
                    <div class="step-number">4</div>
                    <div class="image-box">
                        <img src="assets/images/step5.jpg" alt="Delivery Report">
                    </div>
                    <h3>DELIVERY REPORT</h3>
                    <p>Donatekart delivers the products and the organisation updates about product utilization.</p>
                </div>
            </div>

            <!-- NGO Section -->
            <div id="ngo-content" class="steps row" style="display: none;">
                <div class="step-card col-md-3">
                    <div class="step-number">1</div>
                    <div class="image-box">
                        <img src="assets/images/step6.png" alt="Fill the Form">
                    </div>
                    <h3>FILL THE FORM</h3>
                    <p>Fill Start A Campaign form and send us your requirement.</p>
                </div>
                <div class="step-card col-md-3">
                    <div class="step-number">2</div>
                    <div class="image-box">
                        <img src="assets/images/step7.png" alt="Get in Touch">
                    </div>
                    <h3>GET IN TOUCH</h3>
                    <p>Our campaign manager will reach out based on the enquiry.</p>
                </div>
                <div class="step-card col-md-3">
                    <div class="step-number">3</div>
                    <div class="image-box">
                        <img src="assets/images/step8.png" alt="Campaign is Live">
                    </div>
                    <h3>CAMPAIGN IS LIVE</h3>
                    <p>Campaign goes live on Donatekart with content, images, and product.</p>
                </div>
                <div class="step-card col-md-3">
                    <div class="step-number">4</div>
                    <div class="image-box">
                        <img src="assets/images/step9.png" alt="Campaign Updates">
                    </div>
                    <h3>CAMPAIGN UPDATES</h3>
                    <p>Donors are updated using photos/videos of the distribution drive of products to the needy.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll(".tabs a");
            const donorContent = document.getElementById("donors-content");
            const ngoContent = document.getElementById("ngo-content");

            donorContent.style.display = "flex";
            ngoContent.style.display = "none";

            tabs.forEach(tab => {
                tab.addEventListener("click", function(event) {
                    event.preventDefault();

                    tabs.forEach(t => t.classList.remove("active"));
                    this.classList.add("active");

                    if (this.dataset.tab === "donors") {
                        donorContent.style.display = "flex";
                        ngoContent.style.display = "none";
                    } else {
                        donorContent.style.display = "none";
                        ngoContent.style.display = "flex";
                    }
                });
            });
        });
    </script>

    <style>
        .tabs {
            text-align: center;
            margin-bottom: 30px;
        }

        .tabs a {
            text-decoration: none;
            color: #333;
            padding: 10px 20px;
            margin: 0 10px;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            font-weight: bold;
        }

        .tabs a.active {
            border-bottom: 2px solid #f90;
            color: #f90;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 50px;
        }

        .step-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
            border: 1px solid transparent;
            margin: 10px;
            position: relative;
        }

        .step-card:hover {
            transform: scale(1.03);
            border-color: #f90;
        }

        .step-number {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: #f90;
            color: white;
            font-size: 14px;
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 50%;
        }
    </style>
</section>
