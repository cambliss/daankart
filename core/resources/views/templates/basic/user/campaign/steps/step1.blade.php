<!-- Step 1: Campaigner Details -->
<form method="POST" action="{{ route('user.campaign.fundrise.save',['step' => 1]) }}" id="step-content-1" class="step-content {{ $step == 1 ? 'active' : '' }} ">
    <h4 class="text-center">Basic Details</h4>
    <p class="text-center">I am raising funds for a <span id="selected-cause" class="fw-bold">Social</span> cause</p>
    @csrf

    <label>Select Cause</label>
    <select id="cause" class="form-control" name="category_id" required>
        <option value="">-- Select a Cause --</option> <!-- Default option -->
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <label>Name</label>
    <input type="text" class="form-control" placeholder="Enter your name" name="campaigner_name" value="{{ auth()->user()->username ?? '' }}">

    <label>Email</label> 
    <input type="email" class="form-control" placeholder="Enter your email" name="email" value="{{ auth()->user()->email ?? '' }}">

    <label>Mobile No</label>
    <input type="number" class="form-control" placeholder="Enter mobile number" name="mobile_number" value="{{ auth()->user()->mobile ?? '' }}">

    <button type="submit" class="btn btn-primary w-100 mt-3">Continue</button>
</form>
