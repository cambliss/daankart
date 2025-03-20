@extends($activeTemplate . 'layouts.master')
@section('content')
<style>
    .card {
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .step-indicator {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        position: relative;
    }

    .step {
        width: 40px;
        height: 40px;
        text-align: center;
        background: #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        margin: auto;
    }

    .active-step {
        background: #FF7c1f;
        color: white;
    }

    .completed-step {
        background: #28a745;
        color: white;
    }

    .step-content {
        display: none;
    }

    .step-content.active {
        display: block;
    }

    input, select, textarea {
        margin-bottom: 15px;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .total-price {
        font-size: 18px;
        font-weight: bold;
        color: #ff7c1f;
        margin-top: 10px;
    }

    button.btn.btn-primary.w-100.mt-3 {
        background-color: #ff7c1f !important;
        border-color: #FF7c1f;
    }

    .video-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    iframe {
        width: 100%;
        height: 609px;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }
    .fundraiser-container {
        padding-top: 50px;
    }
</style>

<div class="container p-5">
    @if(!$campaign || $campaign->status != "Completed")
    <div class="row fundraiser-container">
        <!-- Left Half: Form -->
        <div class="col-lg-6">
            <div class="card">
                <div class="step-indicator">
                    <div>
                        <div class="step {{ $step == 1 ? 'active-step' : '' }}" id="step1">1</div>
                        <div>Campaigner</div>
                    </div>
                    <div>
                        <div class="step {{ $step == 2 ? 'active-step' : '' }}" id="step2">2</div>
                        <div>Beneficiary</div>
                    </div>
                    <div>
                        <div class="step {{ $step == 3 ? 'active-step' : '' }}" id="step3">3</div>
                        <div>Campaign</div>
                    </div>
                    <div>
                        <div class="step {{ $step == 4 ? 'active-step' : '' }}" id="step4">4</div>
                        <div>Products</div>
                    </div>
                    <div>
                        <div class="step {{ $step == 5 ? 'active-step' : '' }}" id="step5">5</div>
                        <div>Project</div>
                    </div>
                </div>
                @include('templates.basic.user.campaign.steps.step1')
                @if($campaign)
                    @include('templates.basic.user.campaign.steps.step2')
                    @include('templates.basic.user.campaign.steps.step3')
                    @include('templates.basic.user.campaign.steps.step4')
                    @include('templates.basic.user.campaign.steps.step5')
                @endif
            </div>
        </div>

        <!-- Right Half: Video -->
        <div class="col-lg-6 video-container">
            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Video" allowfullscreen></iframe>
        </div>
    </div>
    @else
        @if($campaign->is_kyc_varified == 0)
            @include('templates.basic.user.campaign.steps.kyc')
        @else
            @include('templates.basic.user.campaign.steps.kyc_completed')
        @endif
    @endif
</div>
<?php

?>
@push('script')
<script>
    @if($campaign)
    let selectedProducts = JSON.parse(`{!! json_encode($campaign->products->map(function($product) {
        return [
            'product_name' => $product->product_name,
            'quantity' => $product->required_quantity,
            'comments' => $product->comments,
            'price' => $product->price_per_unit
        ];
    })) !!}`);
    @else
        let selectedProducts = [];
    @endif
    $(document).ready(function() {
        updateProductList();
    });
    function nextStep(step) {
        document.getElementById(`step${step}`).classList.add('completed-step');
        document.getElementById(`step${step+1}`).classList.add('active-step');
        document.querySelector('.step-content.active').classList.remove('active');
        document.getElementById(`step-content-${step+1}`).classList.add('active');
    }

    function updateCause() {
        var selectedCause = document.getElementById("cause").value;
        document.getElementById("selected-cause").innerText = selectedCause;
    }

    function updatePrice() {
        let productDropdown = document.getElementById("product");
        let quantity = document.getElementById("quantity").value;
        let price = productDropdown.options[productDropdown.selectedIndex].getAttribute("data-price");

        if (quantity && price) {
            document.getElementById("totalPrice").innerText = price * quantity;
        } else {
            document.getElementById("totalPrice").innerText = 0;
        }
    }

    function addProduct() {
        let productDropdown = document.getElementById("product");
        let product_name = productDropdown.options[productDropdown.selectedIndex].text;
        let quantity = document.getElementById("quantity").value;
        let price = productDropdown.options[productDropdown.selectedIndex].getAttribute("data-price");
        let comments = document.getElementById("comments").value;
        if (!product_name || !quantity || quantity <= 0) {
            alert("Please select a product and enter a valid quantity!");
            return;
        }
        selectedProducts.push({ product_name, quantity, comments, price, total: price * quantity });

        updateProductList();
        document.getElementById("product").value = "";
        document.getElementById("quantity").value = "";
        document.getElementById("comments").value = "";
    }

    function updateProductList() {
        let list = document.getElementById("product-list");
        list.innerHTML = "";
        selectedProducts.forEach((item, index) => {
            let listItem = document.createElement("li");
            listItem.innerHTML = `<span>${item.product_name} - ${item.quantity} pcs - ₹${item.total}</span><button style="float: right;" onclick="removeProduct(${index})">❌</button>`;
            list.appendChild(listItem);
        });
        document.getElementById("product_list_hidden").value = JSON.stringify(selectedProducts);
    }

    function removeProduct(index) {
        selectedProducts.splice(index, 1);
        updateProductList();
    }

    function submitForm() {
        if (selectedProducts.length === 0) {
            alert("Please add at least one product before submitting!");
            return;
        }
        document.getElementById("product_list_hidden").value = JSON.stringify(selectedProducts);
        alert("Form submitted successfully with products: " + JSON.stringify(selectedProducts));
    }
</script>
@endpush

@endsection
