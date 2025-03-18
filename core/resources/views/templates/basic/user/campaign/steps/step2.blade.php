<!-- Step 2: Beneficiary Details -->
<form method="POST" action="{{ route('user.campaign.fundrise.save',['step' => 2, 'id' => ($id??0) ]) }}" id="step-content-2" class="step-content {{ $step == 2 ? 'active' : '' }}">
    @csrf    
    <h4>Beneficiary Details</h4>
    <label>Beneficiary Type</label>
    <select class="form-control" name="beneficiary_type">
        <option>Individual Other than Self</option>
        <option>Myself</option>
        <option>NGO</option>
    </select>

    <label>Beneficiary Name</label>
    <input type="text" class="form-control" placeholder="Enter name" name="beneficiary_name">

    <label>Location</label>
    <input type="text" class="form-control" placeholder="Enter location" name="beneficiary_location">

    <label>Mobile No</label>
    <input type="number" class="form-control" placeholder="Enter mobile number" name="beneficiary_mobile">

    <button class="btn btn-primary w-100 mt-3" onclick="nextStep(2)">Continue</button>
</form> 