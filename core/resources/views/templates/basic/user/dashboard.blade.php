@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="pt-90 pb-120">
        <div class="container">
            <div class="notice"></div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @if (!$user->ts)
                        <div class="alert border border-warning" role="alert">
                            <div class="alert__icon d-flex align-items-center text-warning"><i class="las la-user-lock"></i>
                            </div>
                            <p class="alert__message">
                                <span class="fw-bold">@lang('2FA Authentication')</span><br>
                                <small><i>@lang('To keep safe your account, Please enable') <a class="link-color"
                                            href="{{ route('user.twofactor') }}">@lang('2FA')</a>
                                        @lang('security').</i>
                                    @lang('It will make secure your account and balance.')</small>
                            </p>
                        </div>
                    @endif

                    @php
                        $kyc = getContent('kyc.content', true);
                    @endphp

                    @if ($user->kv == Status::KYC_UNVERIFIED && $user->kyc_rejection_reason)
                        <div class="alert border border-danger" role="alert">
                            <div class="alert__icon d-flex align-items-center text-info"><i class="las la-ban"></i> </div>
                            <p class="alert__message">
                                <span class="fw-bold">@lang('KYC Verification Required')</span><br>
                                <small><i>{{ __(@$kyc->data_values->reject) }} <a class="link-color"
                                            href="{{ route('user.kyc.form') }}">@lang('Click here ')</a>@lang('to Re-submit KYC Documents').</i></small>
                            </p>
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#kycRejectionReason">@lang('Show Reason')</button>
                        </div>
                    @elseif($user->kv == Status::KYC_UNVERIFIED)
                        <div class="alert border border-info" role="alert">
                            <div class="alert__icon d-flex align-items-center text-info"><i
                                    class="las la-file-signature"></i> </div>
                            <p class="alert__message">
                                <span class="fw-bold">@lang('KYC Verification Required')</span><br>
                                <small><i>{{ __(@$kyc->data_values->required) }} <a class="link-color"
                                            href="{{ route('user.kyc.form') }}">@lang('Click here ')</a>@lang('to Submit KYC Documents').</i></small>
                            </p>
                        </div>
                    @elseif($user->kv == Status::KYC_PENDING)
                        <div class="alert border border-warning" role="alert">
                            <div class="alert__icon d-flex align-items-center text-warning"><i
                                    class="las la-user-check"></i></div>
                            <p class="alert__message">
                                <span class="fw-bold">@lang('KYC Verification Pending')</span><br>
                                <small><i>{{ __(@$kyc->data_values->pending) }} <a class="link-color"
                                            href="{{ route('user.kyc.data') }}">@lang('Click here')</a>
                                        @lang('to see your submitted data').</i></small>
                            </p>
                        </div>
                    @endif

                    @if ($campaign['expired'] > 0)
                        <div class="offset-lg-8 col-lg-4 col-md-12">
                            <div class="alert alert-warning alert-dismissible fade show p-3" role="alert">
                                <a class="text-danger" class="text-primary"
                                    href="{{ route('user.campaign.fundrise.expired') }}">
                                    @lang('Expired Campaigns') (<strong>{{ $campaign['expired'] }}</strong>)
                                </a>
                                <button class="btn-close" data-bs-dismiss="alert" type="button"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

            <div class="row gy-4">
                <div class="col-lg-3 col-sm-6">
                    <div class="d-widget bg-one">
                        <div class="d-widget__icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="d-widget__content">
                            <h2 class="d-widget__number text-white">{{ $campaign['total_campaign'] }}</h2>
                            <span class="text-white">@lang('Total Campaigns')</span>
                        </div>
                        <a class="view-btn" href="{{ route('user.campaign.fundrise.all') }}">@lang('View all')</a>

                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="d-widget bg-four">
                        <div class="d-widget__icon">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="d-widget__content">
                            <h2 class="d-widget__number text-white">{{ $campaign['pending'] }}</h2>
                            <span class="text-white">@lang('Pending Campaigns')</span>
                        </div>
                        <a class="view-btn" href="{{ route('user.campaign.fundrise.pending') }}">@lang('View all')</a>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="d-widget bg-five">
                        <div class="d-widget__icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div class="d-widget__content">
                            <h2 class="d-widget__number text-white">{{ $campaign['completed'] }}</h2>
                            <span class="text-white">@lang('Completed Campaigns')</span>
                        </div>
                        <a class="view-btn" href="{{ route('user.campaign.fundrise.complete') }}">@lang('View all')</a>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="d-widget bg-danger">
                        <div class="d-widget__icon">
                            <i class="fa fa-times"></i>
                        </div>
                        <div class="d-widget__content">
                            <h2 class="d-widget__number text-white">{{ $campaign['rejectLog'] }}</h2>
                            <span class="text-white">@lang('Rejected Campaigns')</span>
                        </div>
                        <a class="view-btn" href="{{ route('user.campaign.fundrise.rejected') }}">@lang('View all')</a>
                    </div><!-- d-widget end -->
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="d-widget bg-two">
                        <div class="d-widget__icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="d-widget__content">
                            <h2 class="d-widget__number text-white">
                                {{ showAmount($campaign['received_donation'], $decimal = 0) }}</h2>
                            <span class="text-white">@lang('Total Received Donation')</span>
                        </div>
                        <a class="view-btn" href="{{ route('user.campaign.donation.received') }}">@lang('View all')</a>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="d-widget bg-three">
                        <div class="d-widget__icon">
                            <i class="fas fa-donate"></i>
                        </div>
                        <div class="d-widget__content">
                            <h2 class="d-widget__number text-white">
                                {{ showAmount($campaign['give_donation'], $decimal = 0) }}</h2>
                            <span class="text-white">@lang('Total Given Donation')</span>
                        </div>
                        <a class="view-btn" href="{{ route('user.campaign.donation.given') }}">@lang('View all')</a>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="d-widget bg-seven">
                        <div class="d-widget__icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="d-widget__content">
                            <h2 class="d-widget__number text-white">
                                {{ showAmount($campaign['withdraw'], $decimal = 0) }}</h2>
                            <span class="text-white">@lang('Total Withdraw')</span>
                        </div>
                        <a class="view-btn" href="{{ route('user.withdraw.history') }}">@lang('View all')</a>
                    </div><!-- d-widget end -->
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="d-widget bg-primary">
                        <div class="d-widget__icon">
                            <i class="las la-dollar-sign"></i>
                        </div>
                        <div class="d-widget__content">
                            <h2 class="d-widget__number text-white">
                                {{ showAmount($campaign['current_balance'], $decimal = 0) }}</h2>
                            <span class="text-white">@lang('Current Balance')</span>
                        </div>

                    </div><!-- d-widget end -->
                </div>

                <div class="col-md-6">
                    <div class="card custom--card">
                        <div class="card-body">
                            <h5 class="card-title">@lang('Monthly Donation Raised Report')</h5>
                            <div id="apex-line"> </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card custom--card">
                        <div class="card-body">
                            <h5 class="card-title">@lang('Monthly Withdraw Report')</h5>
                            <div id="apex-line-withdraw"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($user->kv == Status::KYC_UNVERIFIED && $user->kyc_rejection_reason)
            <div class="modal fade" id="kycRejectionReason">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">@lang('KYC Document Rejection Reason')</h5>
                            <button class="btn-close" data-bs-dismiss="modal" type="button"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>{{ $user->kyc_rejection_reason }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </section>
@endsection

@push('style')
    <style>
        .alert-heading {
            color: #6f718f !important;
        }

        .alert {
            display: flex;
            align-items: center;
            padding: 0;
            border: none;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            overflow: hidden;
            align-items: stretch;
        }

        .alert button.close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 12px;
            display: flex;
            align-items: center;
            height: 100%;
            background: transparent;
        }

        .alert__message {
            padding: 12px;
            padding-right: 22px;
        }

        .alert__icon {
            padding: 13px 14px;
            font-size: 20px;
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset($activeTemplateTrue . 'js/apexchart.js') }}" charset="utf-8"></script>
    <script>
        'use strict';

        //apex-line chart:  Donation
        var options = {
            series: [{
                data: @json($donations['perDayAmount'])
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '15%',
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: @json($donations['perDay'])
            }
        };

        //apex-line chart: Withdraw
        var withdraw = {
            series: [{
                data: @json($withdraws['perDayAmount'])
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '10%',
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: @json($withdraws['perDay'])
            }
        };

        var chart = new ApexCharts(document.querySelector("#apex-line"), options);
        var chart2 = new ApexCharts(document.querySelector("#apex-line-withdraw"), withdraw);

        chart.render();
        chart2.render();
    </script>
@endpush
