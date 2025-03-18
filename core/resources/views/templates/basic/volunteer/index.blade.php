@php
    $content = getContent('cta.content', true);
@endphp
@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <!-- volunteer section start -->
    <section class="pt-90 pb-120">
        <div class="container-fluid custom-container">
            <div class="filter_in_btn d-xl-none mb-4 d-flex justify-content-end">
                <a href="javascript:void(0)"><i class="las la-filter"></i></a>
            </div>
            <div class="row gy-4 ">
                <div class="col-xl-3">
                    <aside class="category-sidebar">
                        <div class="widget d-xl-none filter-top">
                            <div class="d-flex justify-content-between">
                                <h5 class="title border-0 pb-0 mb-0">@lang('Filter')</h5>
                                <div class="close-sidebar"><i class="las la-times"></i></div>
                            </div>
                        </div>
                        <div class="widget p-0">
                            <h5 class="widget-title">@lang('Search By Volunteer Name')</h5>
                            <div class="widget-body">
                                <div class="input-group">
                                    <input class="form-control" id="search" name="search" type="search"
                                        placeholder="@lang('Search by name')">
                                    <button class="input-group-text" id="name-search" type="button">
                                        <i class="la la-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="widget p-0">
                            <h5 class="widget-title">@lang('Filter By Country')</h5>
                            <div class="widget-body">
                                <select class="form-control form--control select2" name="country_code" required>
                                    <option value="">@lang('Select One')</option>
                                    @foreach ($countries as $key => $country)
                                        <option value="{{ $key }}">{{ __($country->country) }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="widget p-0">
                            <div class="widget-body">
                                <a class="cmn-btn w-100 text-center"
                                    href="{{ route('volunteer.form') }}">{{ __(@$content->data_values->button_title) }}</a>
                            </div>
                        </div>
                    </aside>
                </div>

                <div class="col-xl-9">
                    @include($activeTemplate . 'partials.volunteer')
                    @if (@$volunteers->hasPages())
                        <div class="col-lg-12">
                            <div class="py-4">
                                @php echo paginateLinks($volunteers) @endphp
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- volunteer section end -->

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection

@push('style')
    <style>
        .selection {
            width: 100%;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #e5e5e5 !important;
            border-width: 1px !important;
            border-radius: 5px !important;
            padding: .75rem .75rem !important;
            height: 46px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 20px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 10px !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: hsl(var(--base)) !important;
            outline: 0 !important;
        }

        .select2-container--open .select2-selection.select2-selection--single,
        .select2-container--open .select2-selection.select2-selection--multiple {
            border-color: #e5e5e5 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 20px;
        }
    </style>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict'

        $('.select2').select2();

        let data = {};
        data.search = null;
        data.country_code = null;

        //Search by name
        $('#name-search').on('click', function() {
            data.search = $("input[name='search']").val();
            filterVolunteer();
        })

        // Change to 'change' event for select dropdown
        $("select[name='country_code']").on('change', function() {
            data.country_code = $(this).val(); // Simplified way to get the selected value
            filterVolunteer();
        })

        function filterVolunteer() {
            $.ajax({
                url: "{{ route('volunteer.filter') }}",
                method: 'GET',
                data: data,
                success: function(response) {
                    if (response.success) {
                        $('.main-view').html(response.html);
                    }
                },
            });
        }
    </script>
@endpush
