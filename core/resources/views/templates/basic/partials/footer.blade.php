@php
    $footer = getContent('footer.content', true);
    $socialIcons = getContent('social_icon.element', false, null, true);
    $policyPages = getContent('policy_pages.element');
    $subscribe = getContent('subscribe.content', true);
    $contact = getContent('contact_us.content', true);
    $donation = App\Models\Donation::paid()->get();
    $donationCount = $donation->count();
    $donationSum = $donation->sum('donation');
    $countCampaign = App\Models\Campaign::running()->boundary()->count();
    $query = App\Models\Category::active()->hasCampaigns()->orderBy('id', 'DESC');
    $totalCategories = $query->count();
    $categories = $query->take(4)->get();
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();
@endphp

<!-- footer section start -->
<footer class="footer-section base--bg position-relative bg_img"
    data-background="{{ frontendImage('footer', @$footer->data_values->image, '730x465') }}">
    <!--<div class="top-shape"><img src="{{ getImage($activeTemplateTrue . 'images/top_texture.png') }}" alt="footer-image">-->
    <!--</div>-->
    <div class="footer-top">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-2 mb-lg-0 mb-5 text-lg-left text-center">
                    <a class="footer-logo" href="{{ route('home') }}">
                        <img src="{{ siteLogo() }}" alt="@lang('footer-logo')">
                    </a>
                </div>
                <div class="col-lg-7 col-md-12 mb-4">
                    <div class="row justify-content-center gy-4 align-items-center">
                        <div class="col-lg-4 col-4 footer-overview-item text-md-left text-center">
                            <h3 class="text-white amount-number text-center">{{ $donationCount }}</h3>
                            <p class="text-white text-center">@lang('Total Donate Members')</p>
                        </div>
                        <div class="col-lg-4 col-4 footer-overview-item text-md-left text-center">
                            <h3 class="text-white amount-number text-center">{{ $countCampaign }}</h3>
                            <p class="text-white text-center">@lang('Total Campaigns')</p>
                        </div>

                        <div class="col-lg-4 col-4 footer-overview-item text-md-left text-center">
                            <h3 class="text-white amount-number text-center">
                                {{ showAmount($donationSum) }}</h3>
                            <p class="text-white text-center">@lang('Donation Raised')</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                    <div class="text-md-right text-center mb-lg-0 mb-4">
                        <a class="btn cmn-btn"
                            href="{{ url(@$footer->data_values->button_url) }}">{{ __(@$footer->data_values->button_name) }}</a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row gy-4">
                <div class="col-lg-3 col-md-6 col-sm-8 ">
                    <div class="footer-widget">
                        <h3 class="footer-widget__title">{{ __(@$footer->data_values->heading) }}</h3>
                        <p>{{ __(@$footer->data_values->subheading) }}</p>
                        <ul class="social-links mt-4">
                            @foreach ($socialIcons as $icon)
                                <li class="bg-transparent">
                                    <a href="{{ @$icon->data_values->url }}" target="_blank">
                                        @php echo @$icon->data_values->social_icon; @endphp
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div><!-- footer-widget end -->
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="footer-widget">
                        <h3 class="footer-widget__title">@lang('Contact Information')</h3>
                          <ul class="short-link-list">
            <li>
                <i class="las la-envelope"></i>
                <span>Hyderabad</span>
            </li>
            <li>
                <i class="las la-phone"></i>
                <span>9090990900</span>
            </li>
            <li>
                <i class="las la-map-marker-alt"></i>
                <span>contact@daankart.com</span>
            </li>
        </ul>
                        <!--<ul class="short-link-list">-->
                        <!--    @foreach ($categories as $category)-->
                        <!--        <li><a-->
                        <!--                href="{{ route('campaign.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>-->
                        <!--        </li>-->
                        <!--    @endforeach-->
                        <!--    @if ($totalCategories > 4)-->
                        <!--        <li><a href="{{ route('campaign.index') }}">@lang('View All') &#8594;</a></li>-->
                        <!--    @endif-->
                        <!--</ul>-->
                    </div><!-- footer-widget end -->
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="footer-widget">
                        <h3 class="footer-widget__title">@lang('Quick links')</h3>
                        <ul class="short-link-list">
                            @auth
                                @if (request()->routeIs('home'))
                                    <li><a href="{{ route('contact') }}">@lang('Contact Us')</a></li>
                                @else
                                    <li><a href="{{ route('ticket.open') }}">@lang('Support Ticket')</a></li>
                                @endif
                            @else
                                <li><a href="{{ route('user.register') }}">@lang('Join With') {{ gs('site_name') }}</a>
                                </li>
                            @endauth
                            <li><a href="{{ route('success.story.archive') }}">@lang('Our Success Stories')</a></li>
                            <li><a href="{{ route('campaign.index') }}">@lang('Make Donation')</a></li>
                            @foreach ($pages as $data)
                                <li><a href="{{ route('pages', [$data->slug]) }}">{{ Str::title($data->name) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div><!-- footer-widget end -->
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h3 class="footer-widget__title">{{ __(@$subscribe->data_values->heading) }}</h3>
                        <p>{{ __(@$subscribe->data_values->subheading) }}</p>
                        <form class="subscribe-form mt-3">
                            <div class="input-group">
                                <input class="form-control" name="email" type="email"
                                    placeholder="@lang('Email address')" autocomplete="off">
                                <button class="input-group-text"><i class="lab la-telegram"></i></button>
                            </div>
                        </form>
                    </div><!-- footer-widget end -->
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-lg-8 col-md-6 text-md-start text-center">
                    @lang('Copyright') &copy; {{ date('Y') }}. @lang('All Rights Reserved By') <a class="text--base"
                        href="{{ route('home') }}">{{ __(@gs('site_name')) }}</a>
                </div>
                <div class="col-lg-4 col-md-6 mt-md-0">
                    <ul class="link-list justify-content-md-end justify-content-center">
                        @foreach ($policyPages as $policy)
                            <li><a
                                    href="{{ route('policy.pages', $policy->slug) }}">{{ __(@$policy->data_values->title) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer section end -->

@push('script')
    <script>
        'use strict';

        $(function() {
            $('.subscribe-form').on('submit', function(event) {
                event.preventDefault();
                var email = $('.subscribe-form').find('[name="email"]').val();
                if (!email) {
                    notify('error', 'Email field is required');
                } else {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        url: "{{ route('subscribe') }}",
                        method: "POST",
                        data: {
                            email: email
                        },
                        success: function(response) {
                            if (response.success) {
                                notify('success', response.message);
                            } else {
                                notify('error', response.error);
                            }
                            $('.subscribe-form').find('[name="email"]').val('');
                        }
                    });
                }
            });

        })
    </script>