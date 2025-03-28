<?php
    $donarName = auth()->user()->fullname ?? '';
    $donarEmail = auth()->user()->email ?? '';
    $donarMobile = auth()->user()->mobile ?? '';
?>
<div class="py-2" id="donatepopup-modal" style="display: none;">
    <div class="donation-popup-container card p-3 relative" >
        <button type="button" class="close-modal" id="close-modal" >×</button>
        <!-- Donation type toggle buttons -->
        <div class="donation-toggle-container">
            <button class="donation-toggle-btn active" id="one-time-btn">Donate Once</button>
            <button class="donation-toggle-btn" id="monthly-btn">Donate Monthly</button>
        </div>
        @if(isset($campaign))
        <!-- White container with forms -->
        <div class="donation-popup">
            <!-- One-time donation form -->
            <form class="donation-form active" id="one-time-form" action="{{ route('campaign.donation.daan.process', ['id' => $campaign->id]) }}" method="POST" >
                @csrf
                <input type="hidden" name="campaign_id" value="{{ $campaign->id }}" />
                <input type="hidden" name="amount" value="" />
                <p class="support-text">By supporting Daankart, you are helping us reach out to more campaigns like this and scale our impact. <a href="#">Learn More</a>.</p>

                <div class="campaign-title">{{ $campaign->category->name }} - {{ $campaign->campaign_title }}</div>
                <div class="campaign-description">
                    {{-- trim the description to 100 characters --}}
                    {!! substr($campaign->campaign_description, 0, 100) !!}
                </div>
                <div class="donation-amounts" id="donation-amounts">
                    <div class="donation-option">₹ 300</div>
                    <div class="donation-option">₹ 600</div>
                    <div class="donation-option">₹ 1000</div>
                </div>

                <div class="mb-3">
                    <input type="hidden" name="donateAmount" id="donateAmount" class="form-control" placeholder="Enter Amount" />
                </div>

                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $donarName }}" />
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email ID" value="{{ $donarEmail }}" />
                </div>

                <div class="mb-3">
                    <input type="tel" name="mobile" class="form-control" placeholder="Mobile Number (10 digit)" value="{{ $donarMobile }}" />
                </div>

                <div class="form-check">
                    <input class="form-check-input" name="country" type="radio" id="indianNational" value="indian" checked>
                    <label class="form-check-label" for="indianNational">I'm An Indian National</label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" name="country" type="radio" id="notIndianNational" value="non-indian">
                    <label class="form-check-label" for="notIndianNational">I'm Not An Indian National</label>
                </div>

                {{-- <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="anonymous" id="anonymousDonation">
                    <label class="form-check-label" for="anonymousDonation">Make my donation anonymous</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="whatsapp_updates" id="whatsappUpdates">
                    <label class="form-check-label" for="whatsappUpdates">I want to receive transaction and donation updates on WhatsApp</label>
                </div> --}}

                <p class="small text-muted mb-3">By continuing, you are agreeing to <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a></p>

                <button class="btn btn-continue" id="one-time-btn" >
                    INR <span id="donateAmountValue">00</span> - Continue To Pay
                </button>
            </form>

            <!-- Monthly donation form -->
            <form class="donation-form" id="monthly-form" action="{{ route('campaign.donation.daan.process', ['id' => $campaign->id]) }}" method="POST" >
                @csrf
                <p class="support-text">Your first donation will support this campaigner. The following payments will support other similar causes who need immediate help.</p>
                <input type="hidden" name="campaign_id" value="{{ $campaign->id }}" />
                <input type="hidden" name="amount" value="" />
                <div class="mb-3">
                    <label class="form-label">For a Cause:</label>
                    <select class="form-select" name="campaign_id" disabled>
                        <option value="{{ $campaign->id }}" selected>{{ $campaign->campaign_title }}</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Monthly Donation:</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" name="monthlyAmount" class="form-control mb-0" placeholder="Amount" value="00">
                        <span class="input-group-text">/ month</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Preferred Date</label>
                    <select class="form-select">
                        <option>1st of each month</option>
                        <option>15th of each month</option>
                        <option>Last day of month</option>
                    </select>
                </div>

                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $donarName }}" />
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email ID" value="{{ $donarEmail }}" />
                </div>

                <div class="mb-3">
                    <input type="tel" name="mobile" class="form-control" placeholder="Mobile Number (10 digit)" value="{{ $donarMobile }}" />
                </div>

                <div class="form-check">
                    <input class="form-check-input" name="country" type="radio" id="indianNational" value="indian" checked>
                    <label class="form-check-label" for="indianNational">I'm An Indian National</label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" name="country" type="radio" id="notIndianNational" value="non-indian">
                    <label class="form-check-label" for="notIndianNational">I'm Not An Indian National</label>
                </div>

                {{-- <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="monthlyWhatsappUpdates" checked>
                    <label class="form-check-label" for="monthlyWhatsappUpdates">I want to receive transaction and donation updates on WhatsApp</label>
                </div> --}}

                <p class="small text-muted mb-3">By continuing, you are agreeing to <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a></p>

                <button class="btn btn-continue">Continue</button>
            </form>
        </div>
        @else
        <div class="donation-popup">
            <p>
                Please select a campaign to donate. <a href="{{ route('campaign.index') }}">Click here to view all campaigns</a>
            </p>
        </div>
        @endif
    </div>
</div>

<style>
    /* Include your styles here or in your main stylesheet */
    #donatepopup-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1001;
        max-height: 100%;
        overflow: auto;
    }
    .donation-popup-container { max-width: 500px; margin: 0 auto; position: relative; }
    .donation-toggle-container { display: inline-flex; border: 2px solid #FF6B35; border-radius: 8px; overflow: hidden; margin: 0 auto 25px; }
    .donation-toggle-btn { padding: 12px 30px; border: none; background: transparent; color: #FF6B35; font-weight: 600; cursor: pointer; transition: all 0.3s ease; outline: none; font-size: 16px; margin: -1px; }
    .donation-toggle-btn.active { background-color: #FF6B35; color: white; }
    .donation-toggle-btn:first-child { border-right: 1px solid rgba(255, 107, 53, 0.5); }
    .donation-popup { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .donation-amounts { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
    .donation-option { border: 1px solid #ddd; border-radius: 6px; padding: 8px 15px; cursor: pointer; transition: all 0.3s; }
    .donation-option:hover, .donation-option.active { border-color: #FF6B35; background-color: #FFF5F2; }
    .form-control { margin-bottom: 15px; }
    .btn-continue { background-color: #FF6B35; color: white; width: 100%; padding: 10px; font-weight: 500; border-radius: 6px; border: none; }
    .btn-continue:hover { background-color: #E05B2B; color: white; }
    .form-check { margin-bottom: 15px; }
    .donation-form { display: none; }
    .donation-form.active { display: block; }
    .campaign-title { font-size: 1.1rem; font-weight: 600; margin-bottom: 10px; }
    .campaign-description, .support-text { color: #666; margin-bottom: 15px; }
    a { color: #FF6B35; }
    .close-modal { 
        position: absolute; 
        top: 10px; 
        right: 10px; 
        background: none; 
        border: none; 
        font-size: 24px; 
        cursor: pointer; 
    }
</style>

<script>
    // Toggle between donation types
    // $(document).ready(function() {
        document.getElementById('one-time-btn').addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('monthly-btn').classList.remove('active');
            document.getElementById('one-time-form').classList.add('active');
            document.getElementById('monthly-form').classList.remove('active');
        });

        document.getElementById('monthly-btn').addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('one-time-btn').classList.remove('active');
            document.getElementById('monthly-form').classList.add('active');
            document.getElementById('one-time-form').classList.remove('active');
        });

        // Add active class to clicked donation amount
        document.querySelectorAll('.donation-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.donation-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                let amount = this.textContent.replace('₹', '').trim();
                document.querySelector('#one-time-form #donateAmount').value = amount;
                document.querySelector('#one-time-form #donateAmount').dispatchEvent(new Event('change'));

                // let indianRupee = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' });
                // document.querySelector('#one-time-form #donateAmountValue').textContent = indianRupee.format(amount);
            });
        });

        document.querySelector("#one-time-form #donateAmount").addEventListener('change', function() {
            let amount = this.value;
            let indianRupee = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' });
            document.querySelector('#one-time-form #donateAmountValue').textContent = indianRupee.format(amount);
            // update the amount in the monthly form
            document.querySelector('#monthly-form #monthlyAmount').value = amount;
            document.querySelector('#monthly-form #monthlyAmount').dispatchEvent(new Event('change'));

            document.querySelector('#one-time-form [name="amount"]').value = amount;
            document.querySelector('#monthly-form [name="amount"]').value = amount;

        });

        document.querySelector('#close-modal').addEventListener('click', function() {
            $("#donatepopup-modal").hide();
        });
    // });
</script>
