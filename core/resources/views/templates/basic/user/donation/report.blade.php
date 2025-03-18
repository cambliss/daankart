@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="pt-90 pb-120">
        <div class="container">
            <div class="row">
                <div class="card custom--card">
                    <div class="card-header">
                        <div class="row g-2 align-items-center">
                            <div class="col-sm-6">
                                <h5 class="card-title mb-0 mr-3">@lang('Total Donation')</h5>
                                <span class="ml-5 text--base totalAmount"> </span>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <div class="d-flex justify-content-sm-end g-2">
                                    <select class="widget_select form-control form-select" name="donation_time">
                                        <option value="week">@lang('Current Week')</option>
                                        <option value="month" selected>@lang('Current Month')</option>
                                        <option value="year">@lang('Current Year')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center pb-0 px-0">
                        <div id="chart-area"></div>
                    </div>
                </div>
            </div>

            @if (!blank($donations))
                <div class="row justify-content-center mt-5">
                    <div class="col-12">
                        <div class="card custom--card">
                            <div class="card-body p-0">
                                <table class="table table--responsive--lg">
                                    <thead>
                                        <tr>
                                            <th>@lang('S.N.')</th>
                                            <th>@lang('Trx')</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Email')</th>
                                            <th>@lang('Mobile')</th>
                                            <th>@lang('Country')</th>
                                            <th>@lang('Amount')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($donations as $item)
                                            <tr>
                                                <td>{{ $donations->firstItem() + $loop->index }}</td>
                                                <td>{{ @$item->deposit->trx ?? '---' }}</td>
                                                <td>{{ __($item->fullname) }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->mobile }}</td>
                                                <td>{{ $item->country }}</td>
                                                <td>{{ showAmount($item->donation) }} </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($donations->hasPages())
                    @php echo paginateLinks($donations) @endphp
                @endif
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'This campaign has no donation!'])
            @endif
        </div>
    </div>
@endsection

@push('style')
    <style>
        .widget_select {
            padding: 3px 3px;
            font-size: 13px;
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script>
        'use strict';
        (function($) {

            var chart;

            $('[name=donation_time]').on('change', function() {
                let time = $(this).val();
                let campaign = `{{ @$campaignId }}`;
                let url = "{{ route('user.campaign.donation.donor.report') }}";

                $.get(url, {
                    time: time,
                    campaign_id: campaign
                }, function(response) {
                    if (!response.chart_data) {
                        console.error('No chart data available');
                        return;
                    }

                    let paidData = [];
                    let labels = [];


                    $.each(response.chart_data, function(label, value) {
                        labels.push(label);
                        paidData.push(value.paid);
                    });

                    $('.totalAmount').text(`{{ gs('cur_sym') }}` + response.total_amount);

                    var options = {
                        series: [{
                            name: "Donation",
                            data: paidData
                        }],
                        chart: {
                            type: 'area',
                            height: 350,
                            zoom: {
                                enabled: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'straight'
                        },
                        labels: labels,
                        yaxis: {
                            opposite: true
                        },
                        xaxis: {
                            categories: labels,
                        },
                        legend: {
                            horizontalAlign: 'left'
                        }
                    };

                    if (chart) {
                        chart.destroy();
                    }

                    chart = new ApexCharts(document.querySelector("#chart-area"), options); // Reuse the `chart` variable without re-declaring it
                    chart.render();

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Failed to fetch data:', textStatus, errorThrown);
                });
            }).change();

        })(jQuery);
    </script>
@endpush
