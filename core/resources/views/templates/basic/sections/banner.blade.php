@php
    $content = getContent('banner.content', true);
    $banners = getContent('banner.element', null, false, true);
    $campaigns = App\Models\Campaign::running()
        ->boundary()
        ->with([
            'donations' => function ($query) {
                $query->where('status', Status::DONATION_PAID);
            },
        ])
        ->withSum(
            [
                'donations' => function ($query) {
                    $query->where('status', Status::DONATION_PAID);
                },
            ],
            'donation',
        )
        ->orderBy('id', 'DESC')
        ->get();
@endphp
<section class="hero">
    <div class="hero__slider">
        @foreach ($banners as $item)
            @php
                // Assign campaign URLs based on the banner index
                $campaignUrls = [
                    'https://daankart.com/campaign/explore/one-rupee-meal-initiative-help-us-serve-dignity-with-every-meal-by-good-samaritan',
                    'https://daankart.com/campaign/explore/elders-initiative-empowering-supporting-and-celebrating-our-seniors',
                    'https://daankart.com/campaign/explore/a-future-of-love-support-and-care-no-child-orphaned'
                ];
                $redirectUrl = $campaignUrls[$loop->index] ?? '#'; // Default to '#' if index not found
            @endphp

            <div class="single__slide bg_img"
                data-background="{{ frontendImage('banner', @$item->data_values->image, '1980x1280') }}">
                <a href="{{ $redirectUrl }}" class="d-block w-100 h-100" style="position: absolute; top: 0; left: 0; z-index: 2;"></a> <!-- Full slide clickable -->
                <div class="container">
                    <div class="row justify-content-left">
                        <div class="col-lg-8">
                            <div class="hero__content" style="position: relative; z-index: 3;"> <!-- Ensure content stays clickable -->
                                <h2 class="hero__title" data-animation="fadeInUp" data-delay=".3s">
                                    {{ __(@$item->data_values->heading) }}
                                </h2>
                                <p data-animation="fadeInUp" data-delay=".5s">
                                    {{ __(@$item->data_values->subheading) }}
                                </p>
                                <!-- Uncomment below if you want buttons instead of full slide link -->
                                <!-- <div class="btn-group mt-40" data-animation="fadeInUp" data-delay=".7s">
                                    <a class="cmn-btn" href="{{ $redirectUrl }}">Donate Now</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@include($activeTemplate . 'partials.carousel')
<!--<section class="rise-area">-->
<!--    <div class="container">-->
<!--        <form id="rise-form" method="POST" class="disableSubmission">-->
<!--            @csrf-->
<!--            <input name="anonymous" type="hidden" value="1" checked>-->
<!--            <div class="rise-contents">-->
<!--                <h2 class="title mb-0">{{ __(@$content->data_values->title) }}</h2>-->
<!--                <div class="form-group">-->
<!--                    <select class="gateway-select-box d-none" name="campaign_id" required>-->
<!--                        <option data-title="@lang('Select Campaign')" data-goal="@lang('N/A')"-->
<!--                            data-raised="@lang('N/A')" value="">-->
<!--                            @lang('Select One')</option>-->
<!--                        @foreach ($campaigns as $data)-->
<!--                            <option data-title="{{ strLimit(__($data->title), 45) }}"-->
<!--                                data-goal="{{ showAmount($data->goal) }}"-->
<!--                                data-raised="{{ showAmount($data->donations_sum_donation) }}"-->
<!--                                data-slug="{{ $data->slug }}" data-id="{{ $data->id }}"-->
<!--                                value="{{ $data->id }}" @selected(old('campaign_id') == $data->id)>-->
<!--                                {{ __($data->name) }}-->
<!--                            </option>-->
<!--                        @endforeach-->
<!--                    </select>-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <div class="input-group">-->
<!--                        <input class="form-control" name="amount" type="number" value="{{ old('amount') }}"-->
<!--                            step="any" required>-->
<!--                        <span class="input-group-text">{{ __(@gs('cur_text')) }}</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="form-group w-100">-->
<!--                    <button class="btn cmn-donate-btn w-100" type="submit"> <span class="icon"><i-->
<!--                                class="las la-heart"></i></span> @lang('Donate Now')</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </form>-->
<!--    </div>-->
<!--</section>-->

@push('style')
    <style>
        .gateway-select {
            background-color: #fff;
            border-radius: 5px;
        }

        .single-gateway .gateway-raised {
            font-size: 12px;
            margin-bottom: 0;
        }
    </style>
@endpush

@push('script')
    <script>
        var gatewayOptions = $('.gateway-select-box').find('option');
        var gatewayHtml = `
            <div class="gateway-select">
                <div class="selected-gateway d-flex justify-content-between align-items-center">
                    <p class="gateway-title">Example Campaign Donation</p>
                    <div class="icon-area">
                        <i class="las la-angle-down"></i>
                    </div>
                </div>
                <div class="gateway-list d-none">
        `;
        $.each(gatewayOptions, function(key, option) {
            option = $(option);
            if (option.data('title') && option.data('goal') != 'N/A') {
                gatewayHtml += `<div class="single-gateway" data-value="${option.val()}" data-slug="${option.data('slug')}" data-id="${option.data('id')}">
                            <p class="gateway-title">${option.data('title')}</p>
                            <p class="gateway-charge">Goal: ${option.data('goal')}</p>
                            <p class="gateway-raised">Raised: ${option.data('raised')}</p>
                        </div>`;
            } else {
                gatewayHtml += `<div class="single-gateway" data-value="${option.val()}" data-slug="${option.data('slug')}" data-id="${option.data('id')}">
                            <p class="gateway-title">${option.data('title')}</p>
                            </div>`;
            }
        });
        gatewayHtml += `</div></div>`;
        $('.gateway-select-box').after(gatewayHtml);
        var selectedGateway = $('.gateway-select-box :selected');
        $(document).find('.selected-gateway .gateway-title').text(selectedGateway.data('title'))

        $('.selected-gateway').click(function() {
            $('.gateway-list').toggleClass('d-none');
            $(this).find('.icon-area').find('i').toggleClass('la-angle-up');
            $(this).find('.icon-area').find('i').toggleClass('la-angle-down');
        });

        $(document).on('click', '.single-gateway', function() {
            $('.selected-gateway').find('.gateway-title').text($(this).find('.gateway-title').text());
            $('.gateway-list').addClass('d-none');
            $('.selected-gateway').find('.icon-area').find('i').toggleClass('la-angle-up');
            $('.selected-gateway').find('.icon-area').find('i').toggleClass('la-angle-down');
            $('.gateway-select-box').val($(this).data('value'));
            $('.gateway-select-box').trigger('change');

            //dynamic-action
            var slug = $(this).data('slug');
            var id = $(this).data('id');
            var $form = $('#rise-form');
            let actionUrlTemplate = `{{ route('campaign.donation.process', ['campSlug', 'campId']) }}`;
            var actionUrl = actionUrlTemplate.replace('campSlug', slug).replace('campId', id);
            $form.attr('action', actionUrl);

        });

        function selectPostType(whereClick, whichHide) {
            if (!whichHide) return;
            $(document).on("click", function(event) {
                var target = $(event.target);
                if (!target.closest(whereClick).length) {
                    $(document).find('.icon-area i').addClass("la-angle-down");
                    whichHide.addClass("d-none");
                }
            });
        }
        selectPostType(
            $('.selected-gateway'),
            $(".gateway-list")
        );
    </script>
@endpush
