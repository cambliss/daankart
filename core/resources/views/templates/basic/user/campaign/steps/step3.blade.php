<!-- Step 3: Campaign Details -->
<form 
    method="POST" 
    action="{{ route('user.campaign.fundrise.save',['step' => 3 ,'id' => ($id??0) ]) }}" 
    id="step-content-3" 
    class="step-content {{ $step == 3 ? 'active' : '' }}" 
    enctype="multipart/form-data"
>
    @csrf
    <h4>Campaign Details</h4>
    <label>Upload Image</label>
    <input type="file" class="form-control" name="campaign_image">

    <label>Title</label>
    <input 
        type="text" 
        class="form-control" 
        placeholder="Enter title" 
        name="campaign_title" 
        value="Support {{ $campaign->campaigner_name }} To Empower Underprivileged People In India">

    <label>Description</label>
    <textarea class="form-control" rows="10" placeholder="Enter campaign description" name="campaign_description">
    Hello everyone,
    {{ $campaign->campaigner_name }} is dedicated to making a positive impact in the lives of the elderly. We believe that every senior deserves access to care, companionship, and respect, and we’re tirelessly striving to provide them with the love and support they need for their well-being.
        So many of them lack the basic resources they need to lead a dignified life. Despite doing our best, we’re struggling to continue looking after the elderly and need your help to make a difference.
        With your support, we can give these seniors the respect they deserve, enabling them to live their lives free from the burdens of neglect and isolation.
        I kindly urge you to consider joining us on this mission. Together, we can create a world where every elderly person experiences care, companionship, and respect.

    Thank you.
    Warm regards,
    {{ $campaign->campaigner_name }}
    </textarea>
    <button class="btn btn-primary w-100 mt-3" onclick="nextStep(3)">Continue</button>
</form> 