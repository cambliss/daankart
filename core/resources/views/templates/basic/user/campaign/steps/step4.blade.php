<!-- Step 4: Product Selection -->
<style>
    .product-list {
        list-style-type: none;
        padding: 0;
    }
    .product-list li {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
        display: flex;
    }
    .product-list li button {
        margin-left: auto;
    }
    
</style>
<form method="POST" action="{{ route('user.campaign.fundrise.save',['step' => 4 ,'id' => ($id??0)]) }}" id="step-content-4" class="step-content {{ $step == 4 ? 'active' : '' }}">
    @csrf
    <h4>Select Products for Donation</h4>
    <label>Choose Product</label>
    <select class="form-control" id="product" onchange="updatePrice()" name="product">
        <option value="">Select Product</option>
        
        <optgroup label="🍼 Baby Care Products">
            <option data-price="300">Baby Diapers (Pack of 20) – ₹300</option>
            <option data-price="150">Baby Wipes (Pack of 80 wipes) – ₹150</option>
            <option data-price="600">Infant Formula (500g Tin) – ₹600</option>
            <option data-price="350">Cereal Food (Cerlac, Nestum - 300g) – ₹350</option>
            <option data-price="250">Baby Soap & Shampoo Combo – ₹250</option>
            <option data-price="280">Baby Lotion & Powder Combo – ₹280</option>
            <option data-price="600">Baby Clothes Set (3 Pairs) – ₹600</option>
            <option data-price="400">Soft Baby Blanket – ₹400</option>
            <option data-price="350">Baby Feeding Bottles (Pack of 2) – ₹350</option>
        </optgroup>

        <optgroup label="🍲 Food & Nutrition">
            <option data-price="500">Rice (10kg Bag) – ₹500</option>
            <option data-price="300">Flour (Atta/Maida - 5kg) – ₹300</option>
            <option data-price="250">Lentils (Dal - 2kg) – ₹250</option>
            <option data-price="800">Cooking Oil (5L Can) – ₹800</option>
            <option data-price="700">Milk Powder (1kg) – ₹700</option>
            <option data-price="350">Sugar (5kg) – ₹350</option>
            <option data-price="400">Salt & Spices Kit – ₹400</option>
            <option data-price="500">Biscuits & Nutrition Bars (10 Packs) – ₹500</option>
            <option data-price="250">Packaged Drinking Water (12 Bottles) – ₹250</option>
        </optgroup>

        <optgroup label="🚻 Sanitary & Hygiene">
            <option data-price="250">Sanitary Pads (Pack of 20) – ₹250</option>
            <option data-price="100">Toothbrush & Toothpaste Kit – ₹100</option>
            <option data-price="200">Soap & Handwash Combo – ₹200</option>
            <option data-price="350">Shampoo & Conditioner (500ml each) – ₹350</option>
            <option data-price="500">Detergent Powder (5kg) – ₹500</option>
            <option data-price="180">Sanitary Napkin Disposal Bags (Pack of 30) – ₹180</option>
            <option data-price="400">Toilet Cleaning Kit (Brush, Cleaner, Gloves) – ₹400</option>
            <option data-price="300">Cotton Towels (Pack of 2) – ₹300</option>
        </optgroup>

        <optgroup label="🚑 Medical & First Aid">
            <option data-price="500">First Aid Kit (Basic) – ₹500</option>
            <option data-price="200">Paracetamol, Pain Relievers (Pack of 10 Strips) – ₹200</option>
            <option data-price="150">ORS Sachets (Pack of 10) – ₹150</option>
            <option data-price="300">Sanitizer Bottles (500ml - 2 Pack) – ₹300</option>
            <option data-price="700">Gloves & Masks (50 Pairs) – ₹700</option>
            <option data-price="400">Thermometer (Digital) – ₹400</option>
            <option data-price="1200">Basic BP Monitor – ₹1200</option>
            <option data-price="7500">Wheelchair (Standard) – ₹7500</option>
            <option data-price="2000">Crutches (Adjustable Pair) – ₹2000</option>
        </optgroup>

        <optgroup label="📚 Education & School Supplies">
            <option data-price="600">School Bags (High Quality) – ₹600</option>
            <option data-price="350">Notebooks (10-Pack) – ₹350</option>
            <option data-price="250">Pens & Pencils Set (50 Pieces) – ₹250</option>
            <option data-price="300">Crayons & Colors Set – ₹300</option>
            <option data-price="1200">School Uniform (Shirt, Pant/Skirt, Shoes, Socks) – ₹1200</option>
            <option data-price="400">Lunch Box & Water Bottle – ₹400</option>
            <option data-price="200">Basic Stationery Kit (Erasers, Sharpeners, Scale) – ₹200</option>
            <option data-price="500">Story Books (Children's Collection - 5 Books) – ₹500</option>
        </optgroup>

        <optgroup label="👕👟 Clothing & Footwear">
            <option data-price="1000">Winter Blanket (Heavy Woolen) – ₹1000</option>
            <option data-price="1200">Sweater & Jacket (Men/Women) – ₹1200</option>
            <option data-price="800">Saree/Dhoti Set (Traditional Wear) – ₹800</option>
            <option data-price="1500">Daily Wear Clothes (T-Shirts, Pants, Kurtis - 3 Sets) – ₹1500</option>
            <option data-price="600">Undergarments (Pack of 5) – ₹600</option>
            <option data-price="400">Chappals (Men/Women) – ₹400</option>
            <option data-price="1200">Shoes (Running Shoes) – ₹1200</option>
        </optgroup>

        <optgroup label="🚗 Transport & Emergency Support">
            <option data-price="5000">Bicycle for Daily Use – ₹5000</option>
            <option data-price="8000">Rickshaw (Hand-Pulled) – ₹8000</option>
            <option data-price="150000">Auto-Rickshaw for Transportation – ₹1,50,000</option>
            <option data-price="1000">Fuel Coupons (₹1000 Worth) – ₹1000</option>
            <option data-price="2000">Public Transport Monthly Pass – ₹2000</option>
        </optgroup>

        <optgroup label="🏡 Home Construction & Shelter">
            <option data-price="5000">Brick Set (500 Bricks) – ₹5000</option>
            <option data-price="2500">Cement Bags (50kg - 5 Bags) – ₹2500</option>
            <option data-price="4000">Roof Sheets (Metal - 3 Pieces) – ₹4000</option>
            <option data-price="10000">Doors & Windows (Basic Wooden Set) – ₹10,000</option>
            <option data-price="6000">Floor Tiles (30 Pieces) – ₹6000</option>
            <option data-price="2000">Paint & Brushes Kit – ₹2000</option>
        </optgroup>
    </select>

    <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity" oninput="updatePrice()" name="quantity">
    <textarea class="form-control" id="comments" placeholder="Enter Comments" name="comments"></textarea>
    <p class="total-price">Total Price: ₹<span id="totalPrice">0</span></p>

    <button type="button" class="btn btn-primary mt-3" onclick="addProduct()">Add Product</button>
    
    <h5 class="mt-3">Selected Products:</h5>
    <ul id="product-list" class="product-list"></ul>

    <input type="hidden" name="product_list" id="product_list_hidden" value="" />
    <!-- Handel error -->
    @error('product_list')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <button type="submit" class="btn btn-success w-100 mt-3">Submit</button>
</form> 