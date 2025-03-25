<section class="custom-stepper-section">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Side: Stepper -->
            <div class="col-lg-6">
                <div class="custom-stepper position-relative ps-4">
                    @foreach (
                   [
    ['number' => '01', 'title' => 'Register', 'desc' => 'Sign up on DaanKart by providing your basic details. Create your account in just a few clicks.'],
    ['number' => '02', 'title' => 'Verify Account', 'desc' => 'Confirm your email and complete the verification process. Ensuring security for seamless transactions.'],
    ['number' => '03', 'title' => 'Post a Campaign', 'desc' => 'Set up a campaign with all necessary details and start fundraising. Share your cause to reach potential donors.'],
    ['number' => '04', 'title' => 'Receive Support', 'desc' => 'Get donations and manage your campaign effortlessly. Withdraw funds securely and keep donors updated.'],
        ['number' => '05', 'title' => 'Receive Support', 'desc' => 'Get donations and manage your campaign effortlessly. Withdraw funds securely and keep donors updated.']

]

                    as $step)
                        <div class="custom-step-item d-flex align-items-start mb-5 position-relative">
                            <!-- Step number circle -->
                            <div class="custom-step-number me-4">{{ $step['number'] }}</div>

                            <!-- Step text -->
                            <div class="custom-step-content">
                                <h3>{{ $step['title'] }}</h2>
                                <p>{{ $step['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
<!-- Right Side: Image -->
<div class="col-lg-6 text-center mt-5 mt-lg-0">
    <img src="assets/images/stepbytep.png"
        alt="Mockup" class="img-fluid custom-stepper-img">
</div>

        </div>
    </div>
</section>
@push('style')
<style>
/* Unique wrapper */
.custom-stepper-section {
    background-color: #fff;
    padding: 50px 0;
}

/* Vertical line for stepper */
.custom-stepper::before {
    content: '';
    position: absolute;
    left: 50px; /* Aligns with circles */
    top: 20px; /* Starts at the first circle's center */
    height: 100%; /* Ensures line doesn't extend beyond last step */
    width: 2px;
    background-color: #f90;
    transform: translateY(0);
}

/* Each step item */
.custom-step-item {
    display: flex;
    align-items: center;
    margin-bottom: 40px; /* Adds spacing */
    position: relative;
}

/* Step number (circle) */
.custom-step-number {
    width: 50px;
    height: 50px;
    min-width: 50px;
    min-height: 50px;
    line-height: 50px;
    text-align: center;
    background-color: #f90;
    color: #fff;
    font-weight: bold;
    font-size: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    padding: 0;
}

/* Step content */
.custom-step-content h3 {
    font-size: 17px;
    color: #333;
    margin-bottom: 5px;
}

.custom-step-content p {
    font-size: 14px;
    color: #666;
    margin-bottom: 0;
}

/* Fix: Remove extra line beyond last step */
.custom-step-item:last-child::after {
    content: none !important;
}

.custom-stepper::before {
    height: calc(100% - 50px); /* Adjust height so the line ends at the last step */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .custom-step-number {
        width: 36px;
        height: 36px;
        font-size: 14px;
    }

    .custom-stepper::before {
        left: 18px;
        top: 18px;
    }

    .custom-step-content h3 {
        font-size: 15px;
    }

    .custom-step-content p {
        font-size: 13px;
    }
}


</style>
@endpush
