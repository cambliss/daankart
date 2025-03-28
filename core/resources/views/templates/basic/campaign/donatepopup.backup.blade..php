@php
    $total_amount = $campaign->products->sum('price_per_unit') * $campaign->products->sum('required_quantity');
    $total_amount = $total_amount>0?$total_amount:1;
    $donation = $total_amount / 2;
    $percent =  round($donation / $total_amount * 100);
@endphp
@push('style')
    <style>
        .show-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        button.close-modal {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .show-modal div.container {
            max-height: 90vh;
            overflow-y: auto;
            margin: auto;
        }

        .donation-widget-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            height: 100vh;
            width: 100vw;
        }

        .show-modal div.container .donation-widget {
            position: relative;
        }
    </style>
@endpush
<div class="col-lg-12 mt-lg-0 mt-5 show-modal" id="donatepopup-modal" style="display: none;">
    <div class="donation-widget-container">
        <div class="container">
            <div class="donation-widget relative">
                <button type="button" class="close-modal" id="close-modal" >×</button>
                @if ($campaign->goal_type == Status::AFTER_DEADLINE)
                    <span class="days-left" data-deadline={{ $campaign->deadline }}>
                        <span class="day"></span>
                        <span class="hour"></span>
                        <span class="minute"></span>
                        <span class="sec"></span>
                    </span>
                @elseif($campaign->goal_type == Status::CONTINUOUS)
                    <span class="cam_deadline"> <i class="las la-spinner"></i> @lang('Continuous')</span>
                @else
                    <span class="cam_deadline"> <i class="las la-trophy"></i> @lang('Achieve Goal ') </span>
                @endif
                <h4 class="title py-3"><i class="las la-thumbtack"></i> {{ __($campaign->title) }}</h4>
                <div class="skill-bar mt-2">
    
                    <div class="progressbar" data-perc="{{ progressPercent($percent > 100 ? '100' : $percent) }}%">
                        <div class="bar"></div>
                        <span
                            class="label">{{ showAmount(progressPercent($percent > 100 ? '100' : $percent), currencyFormat: false) }}%</span>
                    </div>
                </div>
    
                <div class="donation-wrapper">
                    <div class="donation-content">
                        <div>
                            <span class="icon"><i class="lab la-telegram-plane"></i></span>
                            <span class="text">@lang('Goal')</span>
                        </div>
                        <p class="number">{{ showAmount($total_amount) }}</p>
                    </div>
                    <div class="donation-content">
                        <div>
                            <span class="icon"><i class="las la-balance-scale-right"></i></span>
                            <span class="text">@lang('Raised')</span>
                        </div>
                        <p class="number">{{ showAmount($donation) }}</p>
                    </div>
                    <div class="donation-content">
                        <div>
                            <span class="icon"><i class="las la-bullseye"></i></span>
                            <span class="text">@lang('Also To Go')</span>
                        </div>
                        <p class="number">
                            @if ($total_amount > $donation)
                                {{ showAmount($total_amount - $donation) }}
                            @else
                                + {{ showAmount($donation - $total_amount) }}
                            @endif
                        </p>
                    </div>
                    <div class="donation-content">
                        <div>
                            <span class="icon"><i class="las la-clock"></i></span>
                            <span class="text">@lang('Not Yet Completed')</span>
                        </div>
    
                        @php
                            $today = new DateTime();
                            $interval = $today->diff($campaign->created_at);
                        @endphp
                        <p class="number">{{ $interval->days }} @lang('days to go')</p>
                    </div>
                </div>
                <div class="donation-wrapper">
                    <div class="event-cart__top">
                        <p class="mb-0">@lang('Organized By') &#8599;</p>
                        <a class="user-profile" href="{{ route('profile.index', $campaign->user->username) }}">
                            <div class="user-profile__thumb">
                                @if ($campaign->user->enable_org)
                                    <img src="{{ avatar(@$campaign->user->organization->image ? getFilePath('orgProfile') . '/' . @$campaign->user->organization->image : null) }}"
                                        alt="org-cover-avatar">
                                @else
                                    <img src="{{ avatar(@$campaign->user->image ? getFilePath('userProfile') . '/' . @$campaign->user->image : null) }}"
                                        alt="user-avatar">
                                @endif
                            </div>
                            <span class="name">
                                @if ($campaign->user->enable_org)
                                    {{ __($campaign->user->Organization->name) }}
                                @else
                                    {{ __($campaign->user->fullname) }}
                                @endif
                            </span>
                        </a>
                    </div>
                </div><!-- donation-widget end -->
    
                @if (@auth()->user()->id != $campaign->user_id)
                    <div class="donation-widget-2 my-3">
                        <form class="vent-details-form" method="POST"
                            action="{{ route('campaign.donation.daan.process', ['id' => $campaign->id]) }}">
                            @csrf
                            <h3 class="mb-3">@lang('Donation Amount')</h3>
                            <div class="form-row align-items-center">
                                <div class="col-lg-12 form-group donate-amount">
                                    <div class="input-group mr-sm-2">
                                        <div class="input-group-text">{{ gs('cur_sym') }}</div>
                                        <input class="form-control" id="donateAmount" name="amount" type="number"
                                            value="1500" step="any" required>
                                    </div>
                                </div>
                                <div class="col-12 form-group donated-amount">
                                    <div class="form--radio form-check-inline">
                                        <input class="form-check-input donation-radio-check" id="customRadioInline1"
                                            name="customRadioInline1" type="radio" value="1000">
                                        <label class="form-check-label" for="customRadioInline1">
                                            {{ gs('cur_sym') }}@lang('1000')
                                        </label>
                                    </div>
                                    <div class="form--radio form-check-inline">
                                        <input class="form-check-input donation-radio-check" id="customRadioInline2"
                                            name="customRadioInline1" type="radio" value="2000">
                                        <label class="form-check-label" for="customRadioInline2">
                                            {{ gs('cur_sym') }}@lang('1500')
                                        </label>
                                    </div>
                                    <div class="form--radio form-check-inline">
                                        <input class="form-check-input donation-radio-check" id="customRadioInline3"
                                            name="customRadioInline1" type="radio" value="3000">
                                        <label class="form-check-label" for="customRadioInline3">
                                            {{ gs('cur_sym') }}@lang('2000')
                                        </label>
                                    </div>
                                    <div class="form--radio form-check-inline">
                                        <input class="form-check-input donation-radio-check custom-donation"
                                            id="flexRadioDefault4" name="customRadioInline1" type="radio">
                                        <label class="form-check-label" for="flexRadioDefault4">
                                            @lang('Custom')
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <h3 class="mb-4 mt-30">@lang('Personal Information')</h3>
    
                            @if (gs('anonymous_donation'))
                                <div class="form--check mb-4">
                                    <input class="form-check-input" id="checkdon" name="anonymous" type="checkbox"
                                        value="1">
                                    <label class="form-check-label" for="checkdon">@lang('Donate Anonymously')</label>
                                </div>
                            @endif
    
                            @php
                                $user = auth()->user();
                            @endphp
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label>@lang('Full Name')</label>
                                    <input class="form-control checktoggle" name="name" type="text"
                                        value="{{ old('name', @$user->fullname) }}" required>
                                </div>
    
                                <div class="form-group col-lg-12">
                                    <label>@lang('Email')</label>
                                    <input class="form-control checktoggle" name="email" type="text"
                                        value="{{ old('email', @$user->email) }}" required>
                                </div>
    
                                <div class="form-group col-lg-12">
                                    <label>@lang('Mobile'): </label>
                                    <input class="form-control checktoggle" name="mobile" type="number"
                                        value="{{ old('mobile', @$user->mobile) }}" required>
                                </div>
    
                                <div class="form-group col-lg-12">
                                    <label>@lang('Country')</label>
                                    <input class="form-control checktoggle" name="country" type="text"
                                        value="{{ old('country', @$user->country_name) }}" required>
                                </div>
                                <div class="col-lg-12">
                                    <input name="campaign_id" type="hidden" value="{{ $campaign->id }}">
                                    <button class="cmn-btn w-100" type="submit"
                                        @if (@auth()->user()->id == $campaign->user_id) disabled @endif>@lang('MAKE YOUR DONATION')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
                <div class="donation-widget-2 my-3">
                    <h3>@lang('Share Campaign')</h3>
                    <div class="form-group copy-link">
                        {{-- <div class="copy-link input-group">
                                        <input class="form-control form--control copy-input" type="text"
                                            value="{{ url()->current() }}" aria-label="" disabled>
                                        <span class="input-group-text flex-align copy-btn cursor-pointer" id="copyBtn"
                                            data-link="{{ url()->current() }}"><i
                                                class="far fa-copy"></i>&nbsp;@lang('Copy')</span>
                                    </div> --}}
    
                        <input class="copyURL" class="form-control form--control" id="profile" name="profile"
                            type="text" value="{{ url()->current() }}" readonly="">
                        <span class="copy" data-id="profile">
                            <i class="las la-copy"></i> <strong class="copyText">@lang('Copy')</strong>
                        </span>
    
                    </div>
    
                    <div class="form-group">
                        <button class="btn cmn-outline-btn w-100" id="copyButton" data-profile="{{ url()->current() }}"
                            data-url="{{ route('campaign.widget', $campaign->id) }}"
                            type="button">@lang('Copy
                                                                Widget for WebPage')&nbsp;<i class="far fa-copy"></i></span></button>
                    </div>
    
                    <div class="form-group">
                        <textarea class="form-control form--control mt-3 mb-2" id="embedCode" readonly><iframe src="{{ url()->current() }}" width="768" height="415"></iframe></textarea>
                        <button class="btn cmn-outline-btn w-100 copyEmbed" data-embed="">@lang('Copy Embed
                                                            Code')</button>
                    </div>
    
                    <ul class="social-links mt-2 d-flex justify-content-center">
                        <li class="facebook face"><a
                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        <li class="twitter twi"><a
                                href="https://twitter.com/intent/tweet?text={{ __(@$campaign->title) }}&amp;url={{ urlencode(url()->current()) }}"
                                target="_blank"><i class="fab fa-twitter"></i></a></li>
                        <li class="linkedin lin"><a
                                href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}"
                                target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                        <li class="whatsapp what"><a href="https://wa.me/?text={{ urlencode(url()->current()) }}"
                                target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                        <li class="telegram"><a
                                href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($campaign->title) }}"
                                target="_blank"><i class="fab fa-telegram"></i></a></li>
                        <li class="pinterest"><a
                                href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode(getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign'))) }}&description={{ urlencode(strLimit($campaign->description, 40)) }}"
                                target="_blank"><i class="fab fa-pinterest"></i></a></li>
                    </ul>
                </div><!-- donation-widget end -->
                @if ($campaign->donor_visibility)
                    <div class="my-3">
                        <div class="mb-4 d-flex d-inline"><span class="milestone-icon"><i
                                    class="lab la-gratipay"></i></span>
                            <h4>@lang('Donation milestone reached: For successful contributions.')</h4>
                        </div>
                        <ul class="donor-small-list">
                            @php
                                $allDonors = $donor;
                            @endphp
                            @forelse($allDonors->take(4) as $donor)
                                <li class="single">
                                    <div class="thumb feature-card__icon "><i class="fa fa-user"></i></div>
                                    <div class="content">
                                        <h6>{{ $donor->fullname }}</h6>
                                        <p>@lang('Amount') :{{ showAmount($donor->donation) }}</p>
                                    </div>
                                </li>
                            @empty
                                @include($activeTemplate . 'partials.empty', [
                                    'message' => 'No donations raised yet',
                                ])
                            @endforelse
    
                            @if ($allDonors->count() > 4)
                                <li class="single">
                                    <button class="donarModal cmn-btn w-100" type="button">@lang('View All')
                                        &#8594;</button>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif
    
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            $('#close-modal').click(function() {
                $('#donatepopup-modal').css('display', 'none');
            });
        });
    </script>
@endpush
