@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $data = getContent('campaign.content', true);
        session()->forget('DONATION');
    @endphp
    <!-- Urgent Fundrised -->
    <br/><br/>
    <section class="pt-120 pb-120">
        <div class="container-fluid custom-container">
            <div class="row m-0">
                <div class="col-xl-3 ">
                    <aside class="category-sidebar">
                        <div class="widget d-xl-none filter-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="title border-0 pb-0 mb-0">@lang('Filter')</h5>
                                <div class="close-sidebar"><i class="las la-times"></i></div>
                            </div>
                        </div>
                        <!--Name Filter-->
                        <div class="widget p-0">
                            <h5 class="widget-title">@lang('Filter By Campaign Title')</h5>
                            <div class="widget-body">
                                <div class="input-group">
                                    <input class="form-control" name="search" type="search"
                                        placeholder="@lang('Enter Title..')">
                                    <button class="input-group-text" id="title-search" type="button"> <i
                                            class="la la-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <!--Campaign RadioBox Filter-->
                        <div class="widget p-0">
                            <h5 class="widget-title">@lang('Filter By Criteria')</h5>
                            <div class="widget-body">
                                <div class="widget-input-group">
                                    <input class="check_size_xs" id="check_size_xs" name="check_size_xs" type="radio"
                                        value="">
                                    <label class="form-check-label" for="check_size_xs">@lang('All')</label>
                                </div>
                                <div class="widget-input-group">
                                    <input class="check_size_xs" id="check_size_xs_1" type="radio" value="urgent">
                                    <label class="form-check-label" for="check_size_xs_1">@lang('Urgent Campaigns')</label>
                                </div>

                                <div class="widget-input-group">
                                    <input class="check_size_xs" id="check_size_xs_2" type="radio" value="feature">
                                    <label class="form-check-label" for="check_size_xs_2">@lang('Featured Campaigns')</label>
                                </div>

                                <div class="widget-input-group">
                                    <input class="check_size_xs" id="check_size_xs_3" type="radio" value="top">
                                    <label class="form-check-label" for="check_size_xs_3">@lang('Top Campaigns')</label>
                                </div>
                            </div>

                        </div>
                        <!--Category Filter-->
                        <div class="widget p-0">
                            <h5 class="widget-title">@lang('Filter By Category')</h5>
                            <div class="widget-body">
                                <ul class="filter-category">
                                    <li class="mb-2">
                                        <a class="categoryId" data-url="{{ route('campaign.filter', 0) }}"
                                            href="javascript:void(0)"><i class="las la-angle-double-right"></i>
                                            @lang('All')</a>
                                    </li>
                                    <li>
                                        @foreach ($categories as $category)
                                            <a class="categoryId" data-id="{{ $category->id }}"
                                                data-url="{{ route('campaign.filter', $category->id) }}"
                                                href="javascript:void(0)">
                                                <i class="las la-angle-right"></i>
                                                {{ __($category->name) }}
                                            </a>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--Date Filter-->
                        <div class="widget p-0">
                            <h5 class="widget-title">@lang('Filter By Date')</h5>
                            <div class="widget-body">
                                <input class="datepicker-here form-control bg--white datepicker-filter" id="datepicker"
                                    data-language="en" data-date-format="yyyy-mm-dd" type="text" value=""
                                    autocomplete="off" placeholder="@lang('From Created Date..')">
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-xl-9">
                    <div class="filter_in_btn d-xl-none mb-3 d-flex justify-content-end">
                        <a href="javascript:void(0)"><i class="las la-filter"></i></a>
                    </div>

                    <div class="row filter_tab_menu_wrapper main-view gy-4">
                        @include($activeTemplate . 'partials.campaign')
                    </div>
                    @if ($campaigns->hasPages())
                        @php echo paginateLinks($campaigns) @endphp
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--section end -->

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/datepicker.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/datepicker.en.js') }}"></script>
@endpush

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/datepicker.min.css') }}" rel="stylesheet">
@endpush

@push('script')
    <script>
        'use strict';

        let data = {};
        data.category_d = 0;
        data.checkbox = null;
        data.search = null;
        data.date = '';
        var arrayFilter = [];

        $(function() {
            //Date-Filter and Dateficker-initialize!
            $("#datepicker").datepicker({
                dateFormat: 'yyyy-mm-dd',
                onSelect: function(picker) {
                    data.date = picker;
                    filterCompaigns();
                }
            });

            //Search by name
            $('#title-search').on('click', function() {
                data.search = $("input[name='search']").val();
                filterCompaigns();
            })

            //category
            $('.categoryId').each(function(index) {
                $(this).on('click', function() {
                    data.category_id = $(this).data('id');
                    filterCompaigns();
                    $('.categoryId').not(this).removeClass('active');
                    $(this).addClass('active');
                });
            });



            //radio-checkboix
            $(".check_size_xs").on('change', function() {
                data.checkbox = $(this).val();
                data.checkbox = $(this).val();
                $('.check_size_xs').prop('checked', false);
                $(this).prop('checked', true);
                if ($(this).prop('checked')) {
                    filterCompaigns();
                }
            })

            function filterCompaigns() {
                $.ajax({
                    url: "{{ route('campaign.filter') }}",
                    method: 'GET',
                    data: data,
                    success: function(response) {
                        $('.main-view').html(response)
                    },
                });
            }
        });
    </script>
@endpush
