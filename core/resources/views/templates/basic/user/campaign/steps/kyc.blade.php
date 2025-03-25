<style>
    .card {
        padding: 20px;
        border-radius: 10px;
    }

    .upload-box {
        border: 2px dashed #ccc;
        height: 250px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #888;
        cursor: pointer;
    }

    .submit-btn {
        background: linear-gradient(to right, #ff5722, #ff9800);
        color: white;
        border: none;
        padding: 10px;
        font-size: 18px;
        border-radius: 5px;
        width: 100%;
    }
</style>
<div class="container mt-4" id="kyc-lander">
    <h4 class="text-warning">My FundRaisers</h4>
    <div class="card p-3 shadow-sm">
        <p class="fw-bold">Join Hands With {{ $campaign->campaigner_name }} To Bring Hope And Aid To Se...</p>
        <div class="alert alert-warning text-center" role="alert">
            <h5 class="fw-bold">Welcome {{ $campaign->campaigner_name }},</h5>
            <p class="mb-1 fw-bold">Your fundraiser is Pre-approved!</p>
            <p>Currently it is only visible via the <a href="#" class="fw-bold">Campaign Link</a> and can accept
                only INR donations for 7 days.</p>
            <div class="bg-light p-3 rounded">
                <p>Submit your KYC documents to get your fundraiser approved and continue fundraising and withdraw
                    money.</p>
                <button class="btn btn-danger" onclick="handleKYC()">Complete KYC</button>
                <button class="btn btn-outline-warning">Campaign Link</button>
            </div>
        </div>
    </div>
    <h4 class="text-warning mt-4">Total Impact</h4>
    <div class="row text-center">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <p class="fs-2">💜</p>
                <p class="fs-4">₹0</p>
                <p class="fw-bold">Total Donations</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <p class="fs-2">🤍</p>
                <p class="fs-4">0</p>
                <p class="fw-bold">Total Donors</p>
            </div>
        </div>
    </div>
</div>
<div id="kyc-container" style="display: none;">
    <form action="{{ route('user.campaign.fundrise.save', ['action' => 'upload-kyc', 'id' => $id ?? 0]) }}"
        method="post" class="card" enctype="multipart/form-data" >
        @csrf
        <h4>Provide Documents for KYC of {{ $campaign->campaigner_name }}</h4>
        <p class="text-muted">Note: Fields with '*' symbol are required</p>
        <label class="mt-3">Select Document Type</label>
        <select class="form-control" name="document_type">
            <option value="pan" selected>PAN</option>
            <option value="aadhar">Aadhar</option>
            <option value="passport">Passport</option>
        </select>
        <label class="mt-3">Upload PAN of {{ $campaign->campaigner_name }} (Image Only) *</label>
        <div class="upload-box mt-2" onclick="handleUpload('kyc-document')" role="button">
            <div id="kyc-document-preview-container" >
                <div class="mx-auto mb-3 position-relative" style="width: 250px; height: 160px;"  >
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-light border rounded shadow-sm" style="opacity: 0.9;">
                        <i class="bi bi-file-earmark-text fs-1 text-secondary mb-2"></i>
                        <p class="text-secondary small text-center mb-0">ID Card / Passport / Driver's License</p>
                    </div>
                </div>
                <p class="text-muted small">Supported formats: <b>JPG, PNG, PDF</b> (max 5MB)</p>
            </div>
        
        
            <input type="file" id="kyc-document" name="kyc_document" class="d-none" onchange="previewFile('kyc-document')">
        
            <img alt="Upload PAN" 
                 id="kyc-document-preview"
                 class="img-fluid border rounded"
                 style="width: 100%; height: 100%; object-fit: contain; display: none;" />
        </div>
        <p class="text-muted mt-2">Note: For PAN/Aadhar, Please avoid uploading online generated document image (e.g.
            Digi locker).</p>
        <button type="submit" class="submit-btn mt-3">Submit</button>
    </form>
</div>
@push('script')
    <script>
        function handleKYC() {
            document.getElementById('kyc-lander').style.display = 'none';
            document.getElementById('kyc-container').style.display = 'block';
        }

        function handleUpload(id) {
            document.getElementById(id).click();
            document.getElementById(id).onchange = function() {
                document.getElementById('kyc-document-preview-container').style.display = 'none';
                document.getElementById('kyc-document-preview').src = URL.createObjectURL(this.files[0]);
                document.getElementById('kyc-document-preview').style.display = 'block';
            }
        }
    </script>
@endpush
