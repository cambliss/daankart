@php
$donor = $campaign->donations->where('status', Status::DONATION_PAID);
$donation = $donor->sum('donation');
$percent = percent($donation, $campaign);
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
<!-- event details section start -->
<section class="pt-40 pb-120">
    <div class="container-fluid">


   @if($campaign->video_link)
<!-- Video Container -->
<div class="video-container" style="position: relative; width: 100%; max-height: 100vh; overflow: hidden;">

    <!-- Background Video -->
    <video autoplay muted loop playsinline style="width: 100%; height: auto; display: block;">
        <source src="{{ asset('core/public/'.$campaign->video_link) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Overlay on Video (for dark transparent effect) -->
    <div 
        style="
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); /* Dark transparent overlay */
            backdrop-filter: blur(2px); /* Optional: subtle blur */
        ">
    </div>

    <!-- Text Overlay (Mission & Campaign Text) -->
    <div 
        style="
            position: absolute;
            top: 70%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 40px;
            font-weight: bold;
            text-align: center;
            padding: 20px 30px;
            border-radius: 10px;
            max-width: 90%;
            box-sizing: border-box;
        ">
        <h5 style="color: #fff; margin: 0 0 1px 0; font-size: 28px;">Mission</h5>
        <div style="font-size: 40px;margin-bottom:15px">
            {{ $campaign->textonvideo }}
        </div>
        <h6 style="color: #fff;">{{ $campaign->campaign_subheading_video }}</h6>

       <div style="display: flex; gap: 10px;">

    <!-- First Text with Orange Border -->
<div style="
    display: flex;
    gap: 10px;
    margin-bottom:10px
">

    <!-- First Text with Orange Border -->
    <div style="
        border: 2px solid orange;
        padding: 8px 15px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 40px; /* Optional: fixed height */
        margin-top: 10px
    ">
        <h6 style="
            margin: 0;
            font-size: 14px;
            color: #fff !important;
            text-align: center;
        ">Pledge your support, monthly</h6>
    </div>

    <!-- Second Text with Green Border -->
    <div style="
        border: 2px solid green;
        padding: 8px 15px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
                margin-top: 10px"

    ">
        <h6 style="
            margin: 0;
            font-size: 14px;
            color: #fff !important;
            text-align: center;
        ">Tax Benefits Available</h6>
    </div>

</div>

</div>

    </div>
<div style="
background: rgba(255, 255, 255, 0.4); /* Whitish semi-transparent */
    border-radius: 10px;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #fff;
    gap: 20px;
    flex-wrap: wrap;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    max-width: 1100px;
    margin: auto;
    position: relative;
    top:87%;
">

    <!-- Left: Progress and Stats -->
    <div style="flex: 1; min-width: 260px;">
        @php
            $campDonation = $campaign->donations->where('status', Status::DONATION_PAID)->sum('donation');
            $percent = percent($campDonation, $campaign);
            $progress = progressPercent($percent > 100 ? '100' : $percent);
        @endphp

        <!-- Donors count -->
    

        <!-- Progress Bar -->
        <div style="
            background: rgba(255, 255, 255, 0.3);
            height: 8px;
            width: 100%;
            border-radius: 50px;
            overflow: hidden;
            position: relative;
            margin-bottom: 8px;
        ">
            <div style="
                height: 100%;
                width: {{ $progress }}%;
                background: linear-gradient(90deg, orange, red);
                border-radius: 50px;
                transition: width 0.5s ease;
            "></div>
        </div>

        <!-- Amount Status -->
        <div style="display: flex; justify-content: space-between; font-size: 14px;">
            <div>
                <b>{{ showAmount($campDonation, $decimal = 0) }}</b> @lang('Raised')
            </div>
            <div>
                @lang('Goal') <b>{{ showAmount($campaign->goal, $decimal = 0) }}</b>
            </div>
        </div>
    </div>

    <!-- Right: Donate Now Button -->
    <button type="button" class="btn cmn-btn openDonateModal"
        style="
            padding: 12px 30px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            border: none;
            border-radius: 30px;
            background: linear-gradient(90deg, orange, red);
            cursor: pointer;
            white-space: nowrap;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        ">
        DONATE NOW
    </button>

</div>


</div>
@endif




       


<div class="container py-5">
    <div class="row g-4 align-items-start">
        <!-- Left Column (6) - Title, Images, and Text -->
        <div class="col-lg-6">
            <h3 class="fw-bold mb-4">{{ $campaign->title2 }}</h3>

           <div class="d-flex align-items-center mb-4">
    <img src="{{ asset('core/public/'.$campaign->image1) }}" alt="Image 1" class="img-fluid me-3" width="80">
    <p>{!! $campaign->text1 !!}</p>
</div>

<div class="d-flex align-items-center mb-4">
    <img src="{{ asset('core/public/'.$campaign->image2) }}" alt="Image 2" class="img-fluid me-3" width="80">
    <p>{!! $campaign->text2 !!}</p>
</div>

<div class="d-flex align-items-center">
    <img src="{{ asset('core/public/'.$campaign->image3) }}" alt="Image 3" class="img-fluid me-3" width="80">
    <p>{!! $campaign->text3 !!}</p>
</div>

        </div>

        <!-- Right Column (6) - Donation Section -->
        <div class="col-lg-6 p-4 shadow rounded" style="background-color: white;">
            <h3 class="fw-bold text-start mb-4">@lang('Your Monthly Support Can Nourish Our Mission.')</h3>
            <p class="text-muted fs-5">@lang('"Your generosity makes a world of difference. Thank you for being a continuous source of hope!"')</p>

            <h3 class="fw-bold text-dark mb-3">@lang('Donation Amount')</h3>
            <div class="form-row align-items-center">
                <div class="col-lg-12 form-group donate-amount">
                    <div class="input-group">
                        <div class="input-group-text">{{ gs('cur_sym') }}</div>
                        <input class="form-control fs-5" id="donateAmount" name="amount" type="number" value="1500" step="any" required>
                    </div>
                </div>

                <div class="col-12 form-group donated-amount mt-3">
                    <div class="form--radio form-check-inline">
                        <input class="form-check-input donation-radio-check" id="customRadioInline1" name="customRadioInline1" type="radio" value="1000">
                        <label class="form-check-label fs-5" for="customRadioInline1">
                            {{ gs('cur_sym') }}@lang('1000')
                        </label>
                    </div>
                    <div class="form--radio form-check-inline">
                        <input class="form-check-input donation-radio-check" id="customRadioInline2" name="customRadioInline1" type="radio" value="1500">
                        <label class="form-check-label fs-5" for="customRadioInline2">
                            {{ gs('cur_sym') }}@lang('1500')
                        </label>
                    </div>
                    <div class="form--radio form-check-inline">
                        <input class="form-check-input donation-radio-check" id="customRadioInline3" name="customRadioInline1" type="radio" value="2000">
                        <label class="form-check-label fs-5" for="customRadioInline3">
                            {{ gs('cur_sym') }}@lang('2000')
                        </label>
                    </div>
                    <div class="form--radio form-check-inline">
                        <input class="form-check-input donation-radio-check custom-donation" id="flexRadioDefault4" name="customRadioInline1" type="radio">
                        <label class="form-check-label fs-5" for="flexRadioDefault4">
                            @lang('Custom')
                        </label>
                    </div>
                </div>
                <h3 style="color:#FF5F1F">"Your Donation will make a Difference"</h3>

<button class="btn cmn-btn w-100 mt-4 py-2 fs-5 openDonateModal">
    @lang('Donate Now')
</button>
                
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
<h2 class="text-center mb-4 fw-bold">{{ $campaign->campaign_reasons ?? 'Reasons For Malnutrition' }}</h2>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-lg border-0 p-3">
            <img src="{{ asset('core/public/'.$campaign->image1) }}" class="img-fluid rounded" alt="Impact Image 1">
            <div class="card-body text-center">
                <p class="mt-3 text-muted">{{ strip_tags($campaign->campaign_reasons_line1) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-lg border-0 p-3">
            <img src="{{ asset('core/public/'.$campaign->image2) }}" class="img-fluid rounded" alt="Impact Image 2">
            <div class="card-body text-center">
                <p class="mt-3 text-muted">{{ strip_tags($campaign->campaign_reasons_line2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-lg border-0 p-3">
            <img src="{{ asset('core/public/'.$campaign->image3) }}" class="img-fluid rounded" alt="Impact Image 3">
            <div class="card-body text-center">
                <p class="mt-3 text-muted">{{ strip_tags($campaign->campaign_reasons_line3) }}</p>
            </div>
        </div>
    </div>
</div>
</div>
<div class="container-fluid py-5 mt-5" style="background-color: hsl(var(--base)); color: white;">
    <div class="container text-center">
        <h2 class="fw-bold" style="color:#FFF !important"> Join Daankart's Monthly Mission To Break The Cycle Of Hunger</h2>
        <h4 class="mb-2" style="color:#FFF !important">Your monthly contribution ensures thousands of underprivileged families, children and communities.
</h4>
        <div class="row g-4">
            <div class="col-md-4">
<div class="p-4 rounded shadow-lg" style="background: linear-gradient(135deg, rgba(78, 91, 49, 0.8), rgba(78, 91, 49, 0.9)) !important; border-left: 5px solid #4e5b31 !important;">
                    <div class="mb-3">
                        <div class="d-inline-block p-3 rounded-circle" style="background: rgba(255, 255, 255, 0.2);">
                            <i class="fas fa-hand-holding-heart fa-3x"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-light">Provide nourishing meals</h4>
                    <p class="text-light opacity-75">Your contributions directly impact lives by providing food and essentials.</p>
                </div>
            </div>
            <div class="col-md-4">
<div class="p-4 rounded shadow-lg" style="background: linear-gradient(135deg, rgba(78, 91, 49, 0.6), rgba(78, 91, 49, 0.7)) !important; border-left: 5px solid #4e5b31 !important;">
                    <div class="mb-3">
                        <div class="d-inline-block p-3 rounded-circle" style="background: rgba(255, 255, 255, 0.2);">
                            <i class="fas fa-sync-alt fa-3x"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-light">Improve health, end malnutrition
</h4>
                    <p class="text-light opacity-75">Automate your donations to create long-term impact with ease.</p>
                </div>
            </div>
            <div class="col-md-4">
<div class="p-4 rounded shadow-lg" style="background: linear-gradient(135deg, rgba(78, 91, 49, 0.8), rgba(78, 91, 49, 0.9)) !important; border-left: 5px solid #4e5b31 !important;">
                    <div class="mb-3">
                        <div class="d-inline-block p-3 rounded-circle" style="background: rgba(255, 255, 255, 0.2);">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-light">Empower communities</h4>
                    <p class="text-light opacity-75">Be a part of a growing network of donors working towards change.</p>
                </div>
            </div>
        </div>
        <div class="mt-5">
<button type="button" class="btn cmn-btn openDonateModal" 
    style="
        color: #FF7C17; 
        background-color: #FFF;
        cursor: pointer;
        padding: 10px 20px;
        border: 2px solid #FF7C17;
        border-radius: 50px;
    ">
    DONATE NOW
</button>



    <button type="button" class="btn btn-outline-light btn-lg fw-bold px-4 shadow-sm" 
        style="border-radius: 50px;">
        Share a Mission
    </button>
</div>
    </div>
</div>
<div class="container-fluid py-5" style="background-color: #f8f9fa;">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">How Your Contribution Makes A Difference</h2>
        <p class="text-muted mb-4">Your generosity is creating real change in communities worldwide.</p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow overflow-hidden h-100">
                    <img src="{{ asset('core/public/'.$campaign->image4) }}" class="fixed-image" alt="Impact Image 4">
                    <div class="p-4">
                        <h5 class="fw-bold mb-2">{{ $campaign->contribution_card_title1 ?? 'Provide Ongoing Support' }}</h5>
                        <p class="mb-0">{{ $campaign->contribution_card_text1 ?? 'With your help, families can rely on receiving food every month.' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow overflow-hidden h-100">
                    <img src="{{ asset('core/public/'.$campaign->image5) }}" class="fixed-image" alt="Impact Image 5">
                    <div class="p-4">
                        <h5 class="fw-bold mb-2">{{ $campaign->contribution_card_title2 ?? 'Create a Bigger Impact Together' }}</h5>
                        <p class="mb-0">{{ $campaign->contribution_card_text2 ?? 'Small monthly contributions combine to change entire communities.' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow overflow-hidden h-100">
                    <img src="{{ asset('core/public/'.$campaign->image6) }}" class="fixed-image" alt="Impact Image 6">
                    <div class="p-4">
                        <h5 class="fw-bold mb-2">{{ $campaign->contribution_card_title3 ?? 'Break the Cycle of Hunger' }}</h5>
                        <p class="mb-0">{{ $campaign->contribution_card_text3 ?? 'When people have food, they can focus on building a brighter future.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid py-5" style="background-color: rgb(245, 245, 245);">
    <div class="container py-4" style="border-radius: 10px;">
        <div class="row g-4 align-items-center">
            <!-- Left Side: Title & Description -->
            <div class="col-lg-6">
                <h3 class="fw-bold mb-3">{{ $campaign->title }}</h3>
                <p style="line-height: 1.7; font-size: 1.1rem; background: none; margin-bottom: 1.5rem;max-width: 500px">
                    @php echo $campaign->description @endphp
                </p>

                <!-- Donation Help Section -->
                <!--<div class="mt-4">-->
                <!--    <h4 class="fw-bold text-dark mb-3">How Will Your Donation Help?</h4>-->
                <!--    <div class="row text-center">-->
                <!--        <div class="col-4">-->
                <!--            <div class="donation-item d-flex flex-column align-items-center">-->
                <!--                <div class="icon-wrapper rounded-circle bg-warning p-3">-->
                <!--                    <i class="fas fa-utensils  text-white"></i>-->
                <!--                </div>-->
                <!--                <p class="mt-2 fw-semibold">Food</p>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <div class="col-4">-->
                <!--            <div class="donation-item d-flex flex-column align-items-center">-->
                <!--                <div class="icon-wrapper rounded-circle bg-warning p-3">-->
                <!--                    <i class="fas fa-home text-white"></i>-->
                <!--                </div>-->
                <!--                <p class="mt-2 fw-semibold">Home</p>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <div class="col-4">-->
                <!--            <div class="donation-item d-flex flex-column align-items-center">-->
                <!--                <div class="icon-wrapper rounded-circle bg-warning p-3">-->
                <!--                    <i class="fas fa-bed text-white"></i>-->
                <!--                </div>-->
                <!--                <p class="mt-2 fw-semibold">Shelter</p>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
            </div>

            <!-- Right Side: Image -->
            <div class="col-lg-6 d-flex justify-content-center">
                <img class="img-fluid rounded shadow-lg"
                    src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}"
                    alt="@lang('image')" style="max-width: 100%;">
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-5 mb-3" style="background: linear-gradient(135deg, #FF5F1F, #FF9245);">
    <div class="container text-center text-white">
        <h2 class="fw-bold text-white">Join Daankart In Making a Difference</h2>
        <p class="mb-4">Be a part of the change! Your small monthly contribution can make a lasting impact.</p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4 p-4" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px);">
                    <div class="mb-3">
                        <i class="fas fa-utensils fa-3x text-white"></i>
                    </div>
                    <h5 class="fw-bold text-white">₹1000</h5>
                    <p class="text-white-75">Feeds 30 people every month</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4 p-4" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px);">
                    <div class="mb-3">
                        <i class="fas fa-hand-holding-heart fa-3x text-white"></i>
                    </div>
                    <h5 class="fw-bold text-white">₹3000</h5>
                    <p class="text-white-75">Feeds 90 people every month</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4 p-4" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px);">
                    <div class="mb-3">
                        <i class="fas fa-globe fa-3x text-white"></i>
                    </div>
                    <h5 class="fw-bold text-white">₹6000</h5>
                    <p class="text-white-75">Feeds 150 people every month</p>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <a href="#" class="btn btn-light btn-lg fw-bold px-4 rounded-pill openDonateModal">Donate Now</a>
            <a href="#" class="btn btn-outline-light btn-lg fw-bold px-4 rounded-pill">Share the Mission</a>
        </div>
    </div>
</div>

<style>
    /* Icon Wrapper */
    .icon-wrapper {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #FF5F15 !important; /* Pastel Orange */
    }

    /* Text Styling */
    .fw-semibold {
        font-size: 1.1rem;
        color: #333;
    }
</style>

<!--<div class="container mt-5 mb-5">-->
    <!-- Section Heading -->
<!--    <h2 class="mb-4 fw-bold text-center">Where Does All Your Money Go?</h2>-->

    <!-- Responsive Table -->
<!--    <div class="table-responsive">-->
<!--        <table class="table table-bordered table-striped text-center align-middle">-->
<!--            <thead style="background-color: #FF5F1F; color: white;">-->
<!--                <tr>-->
<!--                    <th class="py-3">Product Name</th>-->
<!--                    <th class="py-3">Price</th>-->
<!--                    <th class="py-3">Quantity</th>-->
<!--                    <th class="py-3">Total Cost</th>-->
<!--                    <th class="py-3">Comments</th>-->
<!--                </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--                @if(isset($products) && count($products) > 0)-->
<!--                    @foreach ($products as $product)-->
<!--                        <tr>-->
<!--                            <td class="fw-semibold">{{ $product->product_name }}</td>-->
<!--                            <td class="fw-bold" style="color: #FF5F1F;">Rs.{{ number_format($product->price, 2) }}</td>-->
<!--                            <td>{{ $product->quantity }}</td>-->
<!--                            <td class="fw-bold" style="color: #FF5F1F;">Rs.{{ number_format($product->total_cost, 2) }}</td>-->
<!--                            <td class="text-muted">{{ $product->comments }}<strong>/year</strong></td>-->
<!--                        </tr>-->
<!--                    @endforeach-->

                    <!-- Total Amount Row -->
<!--                    <tr style="background-color: #333333; color: white;">-->
<!--                        <td colspan="3" class="fw-bold text-end py-3" style="font-size: 1.2rem;">Total</td>-->
<!--                        <td colspan="2" class="fw-bold py-3" style="font-size: 1.3rem; color: #FFD700;">Rs. 25,00,000.00 <strong>/year</strong></td>-->
<!--                    </tr>-->

<!--                @else-->
<!--                    <tr>-->
<!--                        <td colspan="5" class="text-danger fw-bold py-4">No products found.</td>-->
<!--                    </tr>-->
<!--                @endif-->
<!--            </tbody>-->
<!--        </table>-->
<!--    </div>-->
<!--</div>-->

<style>
    .image-container {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
    }

    .image-container img {
        width: 100%;
        height: 250px; /* Ensuring uniform size */
        object-fit: cover; /* Maintain aspect ratio and fill container */
        transition: transform 0.3s ease-in-out;
    }

    .image-container:hover img {
        transform: scale(1.05); /* Subtle zoom effect */
    }

    .image-text {
        position: absolute;
        bottom: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        font-size: 1.1rem;
        font-weight: bold;
        padding: 10px;
        text-align: center;
    }
</style>

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #E0E0E0, #F5F5F5);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h3 class="fw-bold display-5 text-orange">@lang('Be Our Monthly Donor')</h3>
                <p class="text-muted">@lang('Help in donating the needs to the people')</p>

                <div class="card border-0 shadow-lg p-4 rounded-4" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px);">
                    <h4 class="fw-bold text-orange">@lang('Donation Amount')</h4>

                    <div class="form-group donate-amount mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 fw-bold">{{ gs('cur_sym') }}</span>
                            <input class="form-control text-center border-0 shadow-sm" id="donateAmount" name="amount" type="number"
                                value="1500" step="any" required>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-3 col-6">
                            <div class="form-check">
                                <input class="form-check-input donation-radio-check" id="customRadioInline1"
                                    name="customRadioInline1" type="radio" value="1000">
                                <label class="form-check-label fw-bold text-orange" for="customRadioInline1">
                                    {{ gs('cur_sym') }}@lang('1000')
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-check">
                                <input class="form-check-input donation-radio-check" id="customRadioInline2"
                                    name="customRadioInline1" type="radio" value="1500">
                                <label class="form-check-label fw-bold text-orange" for="customRadioInline2">
                                    {{ gs('cur_sym') }}@lang('1500')
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-check">
                                <input class="form-check-input donation-radio-check" id="customRadioInline3"
                                    name="customRadioInline1" type="radio" value="2000">
                                <label class="form-check-label fw-bold text-orange" for="customRadioInline3">
                                    {{ gs('cur_sym') }}@lang('2000')
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-check">
                                <input class="form-check-input donation-radio-check custom-donation"
                                    id="flexRadioDefault4" name="customRadioInline1" type="radio">
                                <label class="form-check-label fw-bold text-orange" for="flexRadioDefault4">
                                    @lang('Custom')
                                </label>
                            </div>
                        </div>
                    </div>

                    <button class="btn cmn-btn fw-bold w-100 mt-4 rounded-pill shadow-sm openDonateModal">@lang('DONATE NOW')</button>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($campaign->faqs)
    <div class="container my-5">
        <h2 class="fw-bold text-center mb-4">Frequently Asked Questions</h2>
        <div class="accordion custom--accordion">
            @foreach ($campaign->faqs->question as $key => $faq)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed"
                            data-bs-toggle="collapse"
                            data-bs-target="#campaign-faq-item-{{ $key + 1 }}"
                            type="button" aria-expanded="false">
                            {{ __($campaign->faqs->question[$key]) }}
                        </button>
                    </h2>
                    <div class="accordion-collapse collapse"
                        id="campaign-faq-item-{{ $key + 1 }}"
                        data-bs-parent="#campaign-faq">
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

<div class="event-details-area mt-50 container">
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
                            <!--<li class="nav-item" role="presentation">-->
                            <!--    <a class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq" href="#faq"-->
                            <!--        role="tab" aria-controls="faq" aria-selected="false"><span-->
                            <!--            class="las la-question-circle d-block text-center mb-1"></span>@lang('FAQ')</a>-->
                            <!--</li>-->
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

 <div class="tab-content mt-4" id="myTabContent">
                            <!--<div class="tab-pane fade show active" id="description" role="tabpanel"-->
                            <!--    aria-labelledby="description-tab">-->
                            <!--    <p class="text-justify">@php echo $campaign->description @endphp</p>-->
                            <!--</div>-->
                            <!-- tab-pane end -->
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


            <div class="col-lg-12 mt-lg-0 mt-5 show-modal" id="donate-modal" style="display: none;">
                <button type="button" class="close-modal" onclick="closeModal()">×</button>

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
                                <span class="label">{{ showAmount(progressPercent($percent > 100 ? '100' : $percent),
                                    currencyFormat: false) }}%</span>
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
                                <a class="user-profile" href="{{ route('profile.index', $campaign->user->username) }}">
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
                                            <input class="form-control" id="donateAmount" name="amount" type="number"
                                                value="1500" step="any" required>
                                        </div>
                                    </div>
                                    <div class="col-12 form-group donated-amount">
                                        <div class="form--radio form-check-inline">
                                            <input class="form-check-input donation-radio-check" id="customRadioInline1"
                                                name="customRadioInline1" type="radio" value="1000">
                                            <label class="form-check-label" for="customRadioInline1">
                                                {{ gs('cur_sym') }}@lang('1000')
                                            </label>
                                        </div>
                                        <div class="form--radio form-check-inline">
                                            <input class="form-check-input donation-radio-check" id="customRadioInline2"
                                                name="customRadioInline1" type="radio" value="2000">
                                            <label class="form-check-label" for="customRadioInline2">
                                                {{ gs('cur_sym') }}@lang('1500')
                                            </label>
                                        </div>
                                        <div class="form--radio form-check-inline">
                                            <input class="form-check-input donation-radio-check" id="customRadioInline3"
                                                name="customRadioInline1" type="radio" value="3000">
                                            <label class="form-check-label" for="customRadioInline3">
                                                {{ gs('cur_sym') }}@lang('2000')
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
                                    <input class="form-check-input" id="checkdon" name="anonymous" type="checkbox"
                                        value="1">
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
                                        <button class="cmn-btn w-100" type="submit" @if (@auth()->user()->id ==
                                            $campaign->user_id) disabled @endif>@lang('MAKE YOUR DONATION')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                        <div class="donation-widget-2 my-3">
                            <h3>@lang('Share Campaign')</h3>
                            <div class="form-group copy-link">
                                {{-- <div class="copy-link input-group">
                                    <input class="form-control form--control copy-input" type="text"
                                        value="{{ url()->current() }}" aria-label="" disabled>
                                    <span class="input-group-text flex-align copy-btn cursor-pointer" id="copyBtn"
                                        data-link="{{ url()->current() }}"><i
                                            class="far fa-copy"></i>&nbsp;@lang('Copy')</span>
                                </div> --}}

                                <input class="copyURL" class="form-control form--control" id="profile" name="profile"
                                    type="text" value="{{ url()->current() }}" readonly="">
                                <span class="copy" data-id="profile">
                                    <i class="las la-copy"></i> <strong class="copyText">@lang('Copy')</strong>
                                </span>

                            </div>

                            <div class="form-group">
                                <button class="btn cmn-outline-btn w-100" id="copyButton"
                                    data-profile="{{ url()->current() }}"
                                    data-url="{{ route('campaign.widget', $campaign->id) }}" type="button">@lang('Copy
                                    Widget for WebPage')&nbsp;<i class="far fa-copy"></i></span></button>
                            </div>

                            <div class="form-group">
                                <textarea class="form-control form--control mt-3 mb-2" id="embedCode"
                                    readonly><iframe src="{{ url()->current() }}" width="768" height="415"></iframe></textarea>
                                <button class="btn cmn-outline-btn w-100 copyEmbed" data-embed="">@lang('Copy Embed
                                    Code')</button>
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
                                        href="https://wa.me/?text={{ urlencode(url()->current()) }}" target="_blank"><i
                                            class="fab fa-whatsapp"></i></a></li>
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
<div class="modal" id="modelId" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" tabindex="-1">
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
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">@lang('Close')</button>
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
<script>
    document.getElementById('toggleButton').addEventListener('click', function () {
        const tableContainer = document.getElementById('tableContainer');
        const arrow = document.getElementById('arrow');

        if (tableContainer.style.display === 'none') {
            tableContainer.style.display = 'block';
            arrow.innerHTML = '&#9650;';
        } else {
            tableContainer.style.display = 'none';
            arrow.innerHTML = '&#9660;';
        }
    });
</script>
<script>
document.querySelectorAll('.openDonateModal').forEach(button => {
    button.addEventListener('click', function () {
        const donateModal = document.getElementById('donate-modal');

        // Show the modal
        donateModal.style.display = 'block';

        // Ensure scrolling to top
        setTimeout(() => {
            window.scrollTo({ top: 0, behavior: 'instant' });
        }, 0);
    });
});

function closeModal() {
    document.getElementById("donate-modal").style.display = "none"; // Correct element reference
}
</script>



</script>

<style>

#donate-modal {
    position: absolute; /* Allows scrolling */
    top: 1%;
    left: 50%;
    transform: translate(-50%, 0);
    z-index: 1000;
    display: none; /* Hide initially */
    background: white;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.5);
    width: 800px; /* Set a fixed width */
    max-width: 100%; /* Ensure responsiveness */
    max-height: 100vh; /* Limit height to 80% of viewport */
    overflow-y: auto; /* Enables vertical scrolling */
}


    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-image {
        max-width: 100%;
        height: 150px;
        object-fit: contain;
        border-radius: 8px;
        background-color: #f5f5f5;
    }

    .product-title {
        font-size: 18px;
        font-weight: bold;
        margin: 10px 0;
    }

    .progress-container {
        background: #ddd;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 10px;
    }

    .progress-bar {
        background: #6c63ff;
        height: 10px;
    }

    .product-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 10px 0;
    }

    .price {
        font-weight: bold;
        color: #333;
    }

    .add-button {
        background: #6c63ff;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .add-button:hover {
        background: #5845e3;
    }

    .video-container {
        position: relative;
        width: 100%;
        height: 100vh;
        /* Full viewport height */
        overflow: hidden;
    }

    .video-container video {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Ensures the video covers the screen without distortion */
        transform: translate(-50%, -50%);
    }
   .close-modal {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    background: none;
    border: none;
    cursor: pointer;
    color: #333;
}
.close-modal:hover {
    color: red;
}


p{
    p {
    background-color: none !important;
    box-shadow: none !important;
    border: none !important;
}

}
  
</style>

@endpush