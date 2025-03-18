@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="container my-5">
        <ul class="list-group">
            <li class="list-group-item bg--base text-white">
                <i class="fa fa-list font-style"></i>
                @if ($given)
                    @lang('Details of My Given Donation')
                @else
                    @lang('Details of Donor'): {{ $donor->fullname }}
                @endif
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="lab la-sith fs-25"></i>
                        </div>
                        <div>
                            <div class="fw-bold">
                               @lang('Campaign')
                                @if ($given)
                                <small class="fw-lighten">(@lang('Which was i donated.'))</small>
                                @endif
                            </div>
                            <span>
                                <a target="_blank" href="{{ route('campaign.details',  $donor->campaign->slug) }}" title="@lang('View Details')">{{ __($donor->campaign->title) }}</a>
                            </span>
                        </div>
                    </div>
                </div>
            </li>
            @if (!$given)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="las la-user fs-25"></i>
                        </div>
                        <div>
                            <div class="fw-bold">@lang('Given By')</div>
                            <span>{{ __($donor->fullname) }}</span>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="las la-envelope-open-text fs-25"></i>
                        </div>
                        <div>
                            <div class="fw-bold">@lang('E-mail')</div>
                            <span>{{ $donor->email }}</span>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="las la-globe fs-25"></i>
                        </div>
                        <div>
                            <div class="fw-bold">@lang('Country')</div>
                            <span>{{ $donor->country }}</span>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="las la-phone-alt fs-25"></i>
                        </div>
                        <div>
                            <div class="fw-bold">@lang('Mobile')</div>
                            <span class="category-detail">+{{ $donor->mobile }}</span>
                        </div>
                    </div>
                </div>
            </li>
            @endif

            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="las la-hand-holding-usd fs-25"></i>
                        </div>
                        <div>
                            <div class="fw-bold">@lang('Amount')</div>
                            <span class="start-counter-detail">{{ showAmount($donor->donation, 2) }}</span>
                        </div>
                    </div>
                </div>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="las la-money-check fs-25"></i>
                        </div>
                        <div>
                            <div class="fw-bold">@lang('Payment Method')</div>
                            <span class="remains-detail">{{ @$donor->deposit->gateway->alias }}</span>
                        </div>
                    </div>
                </div>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="las la-calendar-day fs-25"></i>
                        </div>
                        <div>
                            <div class="fw-bold">@lang('Payment At')</div>
                            <span class="runs-detail">{{ showDateTime(@$donor->deposit->created_at) }} ( {{ diffForHumans(@$donor->deposit->created_at) }})</span>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

    </div>
@endsection


