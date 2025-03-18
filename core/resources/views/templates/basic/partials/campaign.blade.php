@forelse ($campaigns as $campaign)
    <div class="col-lg-4 col-sm-6">
        <div class="event-card has-link">
            <span class="feature">
                @if (isset($type))
                    {{ __($type) }}
                @else
                    {{ $campaign->category->name }}
                @endif
            </span>
            <a class="item-link" href="{{ route('campaign.details', $campaign->slug) }}"></a>
<div class="event-card__thumb">
    <span class="camp_deadline"> 
        <i class="las la-certificate"></i> @lang('Tax Verified') 
    </span>

    <img class="w-100" src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}" alt="image">
</div>

            <div class="event-card__content">
                <div class="event-cart__top">
                    <a class="user-profile " href="{{ route('profile.index', $campaign->user->username) }}">
                        <div class="user-profile__thumb">
                            @if ($campaign->user->enable_org)
                                <img src="{{ avatar(@$campaign->user->organization->image ? getFilePath('orgProfile') . '/' . @$campaign->user->organization->image : null) }}" alt="org-cover-avatar">
                            @else
                                <img src="{{ avatar(@$campaign->user->image ? getFilePath('userProfile') . '/' . @$campaign->user->image : null) }}" alt="user-avatar">
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
                    <p class="date">
                        <i class="las la-calendar"></i>
                        {{ showDateTime($campaign->created_at, 'd-m-Y') }}
                    </p>
                </div>

                <h4 class="title pt-2">{{ __($campaign->title) }}</h4>

                <div class="event-bar-item">
                    <div class="skill-bar">
                        @php
                            $campDonation = $campaign->donations->where('status', Status::DONATION_PAID)->sum('donation');
                            $percent = percent($campDonation, $campaign);
                        @endphp
                        <div class="progressbar" data-perc="{{ progressPercent($percent > 100 ? '100' : $percent) }}%">
                            <div class="bar"></div>
                            <span class="label">{{ showAmount(progressPercent($percent > 100 ? '100' : $percent),currencyFormat:false) }}%</span>
                        </div>
                    </div>
                </div><!-- event-bar-item end -->

                <div class="amount-status">
                    <div class="left">
                        <b>{{ showAmount($campDonation,$decimal = 0) }}</b>
                        @lang('Raised')
                    </div>
                    <div class="right">
                        @lang('Goal')
                        <b>{{ showAmount($campaign->goal, $decimal = 0) }}</b>
                    </div>
                </div>
            </div>
        </div><!-- event-card end -->
    </div>
@empty
    <div class="mx-auto d-flex justify-content-center @if (request()->routeIs('home')) change-color @endif">
        @include($activeTemplate . 'partials.empty', ['message' => 'Campaigns not found!'])
    </div>
@endforelse

@push('style')
    <style>
        .empty-slip-message img {
            width: 75px !important;
            margin-bottom: 0.875rem;
        }

        .spinner-border {
            width: 14px;
            height: 14px;
            animation: .95s linear infinite spinner-border;
        }

        .amount-status .left,
        .right {
            font-size: 15px;
        }
    </style>
@endpush
