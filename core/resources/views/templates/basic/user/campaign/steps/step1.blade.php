<!-- Step 1: Campaigner Details -->
<form method="POST" action="{{ route('user.campaign.fundrise.save',['step' => 1]) }}" id="step-content-1" class="step-content {{ $step == 1 ? 'active' : '' }} ">
    <h4 class="text-center">Basic Details</h4>
    <p class="text-center">I am raising funds for a <span id="selected-cause" class="fw-bold">Social</span> cause</p>
    @csrf
    <label>Select Cause</label>
    <select id="cause" class="form-control" name="cause" >
        <option value="Medical">Medical</option>
        <option value="Elderly">Elderly</option>
        <option value="Education">Education</option>
        <option value="Food & Nutrition">Animals</option>
        <option value="Sanitary & Hygiene">Children</option>
        <option value="Transport & Emergency">Faith</option>
        <option value="Home Construction & Shelter">Hunger</option>
        <option value="Home Construction & Shelter">Women</option>
        <option value="Home Construction & Shelter">TransGender</option>
        <option value="Home Construction & Shelter">Specially Abled</option>
        <option value="Home Construction & Shelter">Covid 19</option>
        <option value="Home Construction & Shelter">Others</option>
    </select>

    <label>Name</label>
    <input type="text" class="form-control" placeholder="Enter your name" name="campaigner_name">

    <label>Email</label>
    <input type="email" class="form-control" placeholder="Enter your email" name="email">

    <label>Mobile No</label>
    <input type="number" class="form-control" placeholder="Enter mobile number" name="mobile_number">

    <button type="submit" class="btn btn-primary w-100 mt-3" >Continue</button>
</form>