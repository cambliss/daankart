@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h5 class="card-title">@lang('Donation Amount')</h5>
                        <div class="border p-1 cursor-pointer rounded" id="donationDatePicker">
                            <i class="la la-calendar"></i>&nbsp;
                            <span></span> <i class="la la-caret-down"></i>
                        </div>
                    </div>

                    <div id="donationChartArea"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts.js') }}"></script>
@endpush



@push('script')
    <script>
        'use strict';
        (function($) {

            const start = moment().subtract(14, 'days');
            const end = moment();

            const dateRangeOptions = {
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                        .endOf('month')
                    ],
                    'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                },
                maxDate: moment()
            }

            const changeDatePickerText = (element, startDate, endDate) => {
                $(element).html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
            }


            let donChart = lineChart(
                document.querySelector("#donationChartArea"),
                [{
                    name: "Successful Doantion",
                    data: []
                }],
                []
            );



            const donationChart = (startDate, endDate) => {

                const data = {
                    start_date: startDate.format('YYYY-MM-DD'),
                    end_date: endDate.format('YYYY-MM-DD')
                }

                const url = @json(route('admin.donation.statistics.chart'));
                const baseCurrency = `{{ gs('cur_text') }}`;


                $.get(url, data,
                    function(data, status) {
                        if (status == 'success') {

                            donChart.updateSeries(data.data);
                            donChart.updateOptions({
                                xaxis: {
                                    categories: data.created_on,
                                }
                            });
                        }
                    }
                );
            }


            $('#donationDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText(
                '#donationDatePicker span', start, end));
            changeDatePickerText('#donationDatePicker span', start, end);
            donationChart(start, end);

            $('#donationDatePicker').on('apply.daterangepicker', (event, picker) => donationChart(picker.startDate,
                picker.endDate));


        })(jQuery);
    </script>
@endpush
