@extends($activeTemplate . 'layouts.master')
@section('content')
<section class="pt-90 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 p-lg-5 p-md-4">
                <div class="card custom--card">
                    <div class="card-body">
                        <form class="action-form disableSubmission" action="{{ route('user.campaign.fundrise.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="form-label">@lang('Upload Video')</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-video"></i></span>
                                <input class="form-control" type="file" name="video" accept="video/mp4">
                            </div>
                            <small class="text-muted">Supported format: MP4 (Max: 100MB)</small>
                            <button type="submit" class="btn btn-primary mt-2">Upload</button>


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Category')</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text"><i class="las la-layer-group"></i></span>
                                            <select class="form-control form-select select2" name="category_id"
                                                required>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @selected(old('category_id')==$category->id)>
                                                    {{ __($category->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Goal Amount')
                                            <span data-bs-toggle="tooltip" data-bs-placement="top" type="button"
                                                title="{{ __('You will get :percentage of total raised', ['percentage' => 100 - @gs('raised_charge') . '%']) }}">
                                                <i class="las la-info-circle"></i>
                                            </span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                            <input class="form-control" name="goal" type="number"
                                                value="{{ old('goal') }}" step="any" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Title')</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="las la-heading"></i></span>
                                    <input class="form-control" name="title" type="text" value="{{ old('title') }}"
                                        required>
                                </div>
                            </div>

                            <div class="form-group decide-deadline">
                                <label class="form-label">@lang('Decide how you want to complete your
                                    campaign?')</label>
                                <div class="form-check">
                                    <input class="form-check-input" id="after_goal" name="goal_type" type="radio"
                                        value="1">
                                    <label class="form-check-label" for="after_goal">
                                        @lang('After Goal Achieve')
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="after_deadline" name="goal_type" type="radio"
                                        value="2" checked>
                                    <label class="form-check-label" for="after_deadline">
                                        @lang('After Deadline')
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="continuous" name="goal_type" type="radio"
                                        value="3">
                                    <label class="form-check-label" for="continuous">
                                        @lang('Continuous')
                                    </label>
                                </div>
                            </div>

                            <div class="form-group deadline-wrapper">
                                <label class="form-label">@lang('Deadline')</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    <input class="datepicker-here form-control" name="deadline" data-language="en"
                                        data-position='bottom left' type="text" value="{{ old('deadline') }}"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Description')<span class="text-danger">*</span></label>
                                <textarea class="form-control nicEdit" name="description"
                                    rows="8">{{ old('description') }}</textarea>
                                <small>@lang('It can be long text and describe why the campaign was created').</small>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Poster Image')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-images"></i></span>
                                            <input class="form-control" id="inputAttachments" name="image" type="file"
                                                accept="image/*" required />
                                        </div>
                                        <small class="text-muted"> @lang('Supported Files:')
                                            <b>@lang('.png'), @lang('.jpg'), @lang('.jpeg')</b>
                                            @lang('Image will be resized into') <b>{{ getFileSize('campaign') }}</b>
                                            @lang('px')</b>
                                        </small>
                                    </div><!-- form-group end -->
                                </div>

                                <div class="document-file">
                                    <div class="document-file__input">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Images and Documents(.pdf)')</label>
                                            <input class="form-control mb-2" id="inputAttachments" name="attachments[]"
                                                type="file" accept=".jpg, .jpeg, .png, .pdf" required />
                                        </div><!-- form-group end -->
                                    </div>
                                    <button class="btn cmn-btn add-new" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <div id="fileUploadsContainer"></div>
                                    <small class="text-muted"> @lang('Supported Files:')
                                        <b>@lang('.png'), @lang('.jpg'), @lang('.pdf')</b>
                                        @lang('Image will be resized into') <b>{{ getFileSize('proof') }}</b>
                                        @lang('px')</b>
                                    </small>
                                </div>

                                <div class="form-group">
                                    <div class="faq-wrapper">
                                        <h6 class="text-underline">@lang('Campaign FAQs'):</h6>
                                        <div class="row gx-5 gy-4">
                                            <div class="col-lg-4 col-md-6 mb-3 ">
                                                <div class="form-group">
                                                    <label class="form-label">@lang('Question')</label>
                                                    <input class="form-control" name="question[]" type="text" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">@lang('Answer')</label>
                                                    <textarea class="form-control" name="answer[]" required></textarea>
                                                </div>
                                                <button class="btn btn--danger remove-btn w-100" type="button"
                                                    disabled><i class="las la-trash"></i> @lang('Remove')</button>
                                            </div>

                                            <div class="col-lg-4 col-md-6 addFaqArea">
                                                <div class="add-new-faq addNewFAQ mt-3">
                                                    <div class="add-new-faq-box">
                                                        <i class="las la-plus-circle"></i>
                                                        <p>@lang('Add New')</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label class="form-label">@lang('Text on Video')</label>
                            <input class="form-control" type="text" name="textonvideo">

                            <label class="form-label">@lang('Title 2')</label>
                            <input class="form-control" type="text" name="title2" required>

                            <label class="form-label">@lang('Upload Images')</label>
                            <input class="form-control" type="file" name="image1" accept="image/*" required>
                            <input class="form-control" type="file" name="image2" accept="image/*" required>
                            <input class="form-control" type="file" name="image3" accept="image/*" required>
                            <input class="form-control" type="file" name="image4" accept="image/*" required>
                            <input class="form-control" type="file" name="image5" accept="image/*" required>
                            <input class="form-control" type="file" name="image6" accept="image/*" required>

                            <label class="form-label">@lang('Text 1')</label>
                            <textarea class="form-control" name="text1" required></textarea>

                            <label class="form-label">@lang('Text 2')</label>
                            <textarea class="form-control" name="text2" required></textarea>

                            <label class="form-label">@lang('Text 3')</label>
                            <textarea class="form-control" name="text3" required></textarea>

                            <div class="container mt-5">
                                <h5 class="mb-3">Add Products</h5>
                                <div id="productFormContainer">
                                    <div class="product-form-row mb-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="productName" class="form-label">Product Name</label>
                                                <select class="form-select productName" name="product_name[]">
                                                    <option value="" disabled selected>Select a product</option>
                                                    <!-- Food & Groceries -->
                                                    <optgroup label="Food & Groceries 🍚🥦">
                                                        <option value="Atta" data-price="50">Atta (Wheat Flour) - ₹50/kg</option>
                                                        <option value="Rice" data-price="60">Rice (Basmati) - ₹60/kg</option>
                                                        <option value="Dal" data-price="70">Dal (Toor Dal) - ₹70/kg</option>
                                                        <option value="Sugar" data-price="40">Sugar - ₹40/kg</option>
                                                        <option value="Salt" data-price="20">Salt - ₹20/kg</option>
                                                        <option value="Spices" data-price="100">Spices - ₹100/pack</option>
                                                        <option value="Cooking Oil" data-price="150">Cooking Oil - ₹150/litre</option>
                                                        <option value="Tea & Coffee" data-price="200">Tea & Coffee - ₹200/pack</option>
                                                        <option value="Dry Fruits" data-price="500">Dry Fruits - ₹500/kg</option>
                                                        <option value="Biscuits & Snacks" data-price="50">Biscuits & Snacks - ₹50/pack</option>
                                                        <option value="Dairy Products" data-price="80">Dairy Products - ₹80/unit</option>
                                                        <option value="Bakery Items" data-price="120">Bakery Items - ₹120/unit</option>
                                                        <option value="Frozen Food" data-price="250">Frozen & Ready-to-Eat - ₹250/pack</option>
                                                    </optgroup>
                                                    <!-- Construction & Building Materials -->
                                                    <optgroup label="Construction & Building Materials 🏗️🧱">
                                                        <option value="Cement" data-price="400">Cement - ₹400/bag</option>
                                                        <option value="Bricks" data-price="10">Bricks - ₹10/piece</option>
                                                        <option value="Sand" data-price="500">Sand - ₹500/cubic ft</option>
                                                        <option value="Steel Rods" data-price="1000">Steel Rods - ₹1000/unit</option>
                                                        <option value="Concrete Blocks" data-price="50">Concrete Blocks - ₹50/piece</option>
                                                        <option value="Paints & Primers" data-price="800">Paints & Primers - ₹800/bucket</option>
                                                        <option value="Plywood & Timber" data-price="1500">Plywood & Timber - ₹1500/sheet</option>
                                                        <option value="Tiles & Marble" data-price="2000">Tiles & Marble - ₹2000/sqft</option>
                                                        <option value="Roofing Sheets" data-price="1200">Roofing Sheets - ₹1200/sheet</option>
                                                        <option value="Pipes" data-price="300">PVC & CPVC Pipes - ₹300/unit</option>
                                                        <option value="Electrical Fittings" data-price="500">Electrical Wiring & Fittings - ₹500/set</option>
                                                    </optgroup>
                                                    <!-- Vehicles & Automotive -->
                                                    <optgroup label="Vehicles & Automotive 🚗🚜">
                                                        <option value="Cars & Bikes" data-price="500000">Cars & Bikes - ₹5,00,000+</option>
                                                        <option value="Tractors" data-price="800000">Tractors - ₹8,00,000+</option>
                                                        <option value="Trucks & Heavy Vehicles" data-price="1500000">Trucks - ₹15,00,000+</option>
                                                        <option value="Auto Parts" data-price="500">Auto Parts - ₹500/unit</option>
                                                        <option value="Batteries" data-price="2500">Batteries & Lubricants - ₹2500/unit</option>
                                                        <option value="Helmets" data-price="1500">Helmets & Safety Gear - ₹1500/unit</option>
                                                    </optgroup>
                                                    <!-- Sanitary & Hygiene Products -->
                                                    <optgroup label="Sanitary & Hygiene Products 🚿🧴">
                                                        <option value="Handwash" data-price="100">Handwash & Sanitizers - ₹100/bottle</option>
                                                        <option value="Toilet Cleaners" data-price="80">Toilet Cleaners - ₹80/bottle</option>
                                                        <option value="Floor Cleaners" data-price="150">Floor Cleaners - ₹150/bottle</option>
                                                        <option value="Soap" data-price="40">Soap & Shampoo - ₹40/unit</option>
                                                        <option value="Toothpaste" data-price="60">Toothpaste & Toothbrush - ₹60/unit</option>
                                                        <option value="Shaving Cream" data-price="120">Shaving Cream & Razors - ₹120/unit</option>
                                                        <option value="Diapers" data-price="500">Baby Diapers & Wipes - ₹500/pack</option>
                                                        <option value="Sanitary Pads" data-price="150">Sanitary Pads & Tampons - ₹150/pack</option>
                                                        <option value="Tissues" data-price="50">Tissue Paper & Napkins - ₹50/pack</option>
                                                        <option value="Air Fresheners" data-price="200">Air Fresheners - ₹200/unit</option>
                                                    </optgroup>
                                                    <!-- Household Essentials -->
                                                    <optgroup label="Household Essentials 🏡🛏️">
                                                        <option value="Detergents" data-price="120">Detergents & Washing Powder - ₹120/kg</option>
                                                        <option value="Dishwashing Liquid" data-price="80">Dishwashing Liquid - ₹80/bottle</option>
                                                        <option value="Mosquito Repellents" data-price="200">Mosquito Repellents - ₹200/unit</option>
                                                        <option value="Utensils" data-price="500">Utensils & Kitchenware - ₹500/set</option>
                                                        <option value="Home Decor" data-price="1000">Home Décor - ₹1000/unit</option>
                                                        <option value="Furniture" data-price="5000">Furniture - ₹5000/piece</option>
                                                        <option value="Electronic Appliances" data-price="10000">Electronic Appliances - ₹10,000+</option>
                                                    </optgroup>
                                                    <!-- Electrical & Electronics -->
                                                    <optgroup label="Electrical & Electronics 🔌📱">
                                                        <option value="LED Bulbs" data-price="200">LED Bulbs & Tubelights - ₹200/unit</option>
                                                        <option value="Switches" data-price="500">Switches & Sockets - ₹500/set</option>
                                                        <option value="Wires" data-price="1500">Wires & Cables - ₹1500/bundle</option>
                                                        <option value="Power Banks" data-price="3000">Power Banks & Chargers - ₹3000/unit</option>
                                                        <option value="Mobile Phones" data-price="15000">Mobile Phones - ₹15,000+</option>
                                                        <option value="Laptops" data-price="50000">Laptops & Computers - ₹50,000+</option>
                                                        <option value="Smart Devices" data-price="5000">Smart Home Devices - ₹5000/unit</option>
                                                    </optgroup>
                                                    <!-- Industrial & Manufacturing -->
                                                    <optgroup label="Industrial & Manufacturing ⚙️🏭">
                                                        <option value="Machinery" data-price="100000">Machinery & Tools - ₹1,00,000+</option>
                                                        <option value="Bearings" data-price="3000">Bearings & Gears - ₹3000/unit</option>
                                                        <option value="Packaging" data-price="200">Packaging Materials - ₹200/set</option>
                                                        <option value="Safety Equipment" data-price="1500">Safety Equipment - ₹1500/set</option>
                                                        <option value="Generators" data-price="50000">Generators & Transformers - ₹50,000+</option>
                                                    </optgroup>
                                                    <!-- Healthcare & Medical -->
                                                    <optgroup label="Healthcare & Medical 🏥💊">
                                                        <option value="Medicines" data-price="500">Medicines & Syrups - ₹500/pack</option>
                                                        <option value="First Aid Kit" data-price="800">First Aid Kit - ₹800/unit</option>
                                                        <option value="Thermometers" data-price="400">Thermometers & BP Monitors - ₹400/unit</option>
                                                        <option value="Bandages" data-price="100">Bandages & Antiseptics - ₹100/pack</option>
                                                        <option value="Protein Supplements" data-price="2000">Protein Supplements - ₹2000/unit</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="price"class="form-label">Price (per kg)</label>
                                                <input type="text" name="price[]" class="form-control price" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="quantity"  class="form-label">Quantity</label>
                                                <input type="number" name="quantity[]" class="form-control quantity" min="1">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="totalCost" class="form-label">Total Cost</label>
                                                <input type="text" name="total_cost[]" class="form-control totalCost" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="comments" class="form-label">Comments</label>
                                                <input class="form-control comments" name="comments[]"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary add-product" type="button">Add Product</button>
                            </div>

                            <button class="btn cmn-btn w-100" type="submit" type="submit">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('style-lib')
<link href="{{ asset($activeTemplateTrue . 'css/datepicker.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush
@push('script-lib')
<script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/datepicker.min.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/datepicker.en.js') }}"></script>
<script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('style')
<style>
    .decide-deadline {
        margin: 0;
    }

    .select2-container--default .select2-selection--single {
        border: 0 !important;
    }
</style>
@endpush

@push('script')
<script>
    'use strict';

        $('.select2').select2();


        $(".add-new").on('click', function() {
            $("#fileUploadsContainer").append(` <div class="input-group mb-2">
                <input type="file" name="attachments[]" id="inputAttachments" class="form-control" accept=".jpg, .jpeg, .png, .pdf" required/>
                        <button type="button" class="input-group-text remove-btn"><i class="las la-times"></i></button>
                    </div>
                `);
        })

        $(document).on('click', '.remove-btn', function() {
            $(this).closest('.input-group').remove();
        });


        //nicEdit
        $(".nicEdit").each(function(index) {
            $(this).attr("id", "nicEditor" + index);
            new nicEditor({
                fullPanel: true
            }).panelInstance('nicEditor' + index, {
                hasPanel: true
            });
        });

        (function($) {
            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });
        })(jQuery);

        //date-validation

        $('.datepicker-here').on('keyup keypress keydown input', function() {
            return false;
        });
        $('.datepicker-here').datepicker({
            minDate: new Date()
        })

        //Faq-added//
        $('.addNewFAQ').on('click', function() {
            $(".addFaqArea").before(`
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('Question')</label>
                        <input type="text" name="question[]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Answer')</label>
                        <textarea name="answer[]" class="form-control"></textarea>
                    </div>
                    <button type="button" class="btn btn--danger remove-btn w-100"><i class="las la-trash"></i> @lang('Remove')</button>
            </div>
                `)
            disableRemoveFaq()
        });
        $(document).on('click', '.remove-btn', function() {
            $(this).closest('div').remove();
            disableRemoveFaq()
        });

        function disableRemoveFaq() {
            if ($(document).find('.remove-btn').length == 1) {
                $(document).find('.remove-btn').attr('disabled', true);
            } else {
                $(document).find('.remove-btn').removeAttr('disabled');
            }
        }

        // deadline-wrapper
        $("[name='goal_type']").on('click', function() {
            if ($(this).val() == 2) {
                $('.deadline-wrapper').removeClass('d-none');
            } else {
                $('.deadline-wrapper').addClass('d-none');
            }
        })
        // deadline-wrapper End


        //Start tooltip//
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
            //end tooltip//
        });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateTotalCost(row) {
            let price = parseFloat(row.querySelector('.price').value) || 0;
            let quantity = parseInt(row.querySelector('.quantity').value) || 0;
            row.querySelector('.totalCost').value = price * quantity;
        }

        document.getElementById('productFormContainer').addEventListener('change', function (event) {
            if (event.target.classList.contains('productName')) {
                let selectedOption = event.target.options[event.target.selectedIndex];
                let price = selectedOption.getAttribute('data-price');
                let row = event.target.closest('.product-form-row');
                row.querySelector('.price').value = price;
                
                updateTotalCost(row);
            }
        });

        document.getElementById('productFormContainer').addEventListener('input', function (event) {
            if (event.target.classList.contains('quantity')) {
                let row = event.target.closest('.product-form-row');
                updateTotalCost(row);
            }
        });

        document.querySelector('.add-product').addEventListener('click', function () {
            let newRow = document.querySelector('.product-form-row').cloneNode(true);
            newRow.querySelectorAll('input, select, textarea').forEach(input => input.value = '');
            document.getElementById('productFormContainer').appendChild(newRow);
        });
    });
</script>



@endpush