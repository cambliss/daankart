<!-- Step 3: Campaign Details -->
<form method="POST" action="{{ route('user.campaign.fundrise.save', ['step' => 3, 'id' => $id ?? 0]) }}"
    id="step-content-3" class="step-content {{ $step == 3 ? 'active' : '' }}" enctype="multipart/form-data">
    @csrf
    <h4>Campaign Details</h4>
    <label>Upload Image</label>
    <input type="file" class="form-control" name="campaign_image">

    <label>Title</label>
    <input type="text" class="form-control" placeholder="Enter title" name="campaign_title"
        value="Support {{ $campaign->campaigner_name }} To Empower Underprivileged People In India">

    <label>Description</label>
    <textarea class="form-control" rows="10" placeholder="Enter campaign description" name="campaign_description" id="campaign_description">
    Hello everyone,
    {{ $campaign->campaigner_name }}  is dedicated to supporting the elderly with care, companionship & respect. We strive to ensure their well-being with love & support. Thank you! Warm regards,
    {{ $campaign->campaigner_name }}
    </textarea>
    <span id="charCount">0/200</span>
    <button class="btn btn-primary w-100 mt-3" onclick="nextStep(3)">Continue</button>
</form>
<script type="text/javascript" >
    const charCountDisplay = document.querySelector('span#charCount');
    const campaignDescription = document.getElementById('campaign_description');
    campaignDescription.addEventListener('input', function() {
        const currentLength = this.value.length;
        charCountDisplay.textContent = currentLength + '/200';
        if (currentLength > 200) {
            this.value = this.value.substring(0, 200);
            charCountDisplay.textContent = '200/200';
        }
    });
    charCountDisplay.textContent = `${campaignDescription.value.length}/200`;
</script>