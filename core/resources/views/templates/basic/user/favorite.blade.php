@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="pt-90 pb-120">
        <div class="container">
            @if (!blank($favorites))
                <div class="row justify-content-end gy-4">
                    <div class="col-lg-4 col-sm-12">
                        <form>
                            <div class="input-group">
                                <input class="form-control" name="search" type="search" value="{{ request()->search }}"
                                    placeholder="@lang('Search by title')">
                                <button class="input-group-text bg-cmn text-white border-0">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-12">
                        <div class="card custom--card">
                            <div class="card-body p-0">
                                <table class="table table--responsive--lg">
                                    <thead>
                                        <tr>
                                            <th>@lang('Title')</th>
                                            <th>@lang('Owner')</th>
                                            <th>@lang('Goal')</th>
                                            <th>@lang('Fund Raised')</th>
                                            <th>@lang('Deadline')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($favorites as $item)
                                            @php
                                                $donation = $item->campaign->donations->where(
                                                    'status',
                                                    Status::DONATION_PAID,
                                                );
                                                $hasDonations = $donation->count();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div>
                                                        <span class="camp-table-title">

                                                            {{ $item->campaign->title }}
                                                        </span>
                                                        <br>
                                                        <small title="@lang('Campaign Category')"><i
                                                                class="las la-chevron-circle-right"></i>
                                                            {{ __($item->campaign->category->name) }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-start">
                                                        @if ($item->campaign->user->enable_org)
                                                            <img class="avatar avatar--xs"
                                                                src="{{ avatar(@$item->campaign->user->organization->image ? getFilePath('orgProfile') . '/' . @$item->campaign->user->organization->image : null) }}"
                                                                alt="org-cover-avatar">
                                                            <a
                                                                href="{{ route('profile.index', $item->campaign->user->username) }}">
                                                                <span
                                                                    class="text--base px-3">{{ __($item->campaign->user->organization->name) }}
                                                                </span></a>
                                                        @else
                                                            <img class="avatar avatar--xs"
                                                                src="{{ avatar(@$item->campaign->user->image ? getFilePath('userProfile') . '/' . @$item->campaign->user->image : null) }}">
                                                            <a
                                                                href="{{ route('profile.index', $item->campaign->user->username) }}">
                                                                <span
                                                                    class="text--base px-3">{{ __($item->campaign->user->fullname) }}
                                                                </span></a>
                                                        @endif

                                                    </div>
                                                </td>
                                                <td>{{ showAmount($item->campaign->goal) }} </td>
                                                <td>
                                                    {{ showAmount($donation->sum('donation')) }}
                                                </td>
                                                <td>
                                                    @if ($item->campaign->goal_type == Status::GOAL_ACHIEVE)
                                                        <span class="badge badge--primary">@lang('Achieve Goal')</span>
                                                    @elseif($item->campaign->goal_type == Status::CONTINUOUS)
                                                        <span class="badge badge--success"> @lang('Continuous')</span>
                                                    @else
                                                        <span class="badge badge--warning">
                                                            {{ showDateTime($item->campaign->deadline, 'd-m-Y') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="{{ route('campaign.details', $item->campaign->slug) }}"
                                                            title="@lang('View Details')"><i
                                                                class="bg-cmn text-white p-2 rounded la la-desktop"></i></a>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if ($favorites->hasPages())
                        <div class="pt-3">
                            {{ paginateLinks($favorites) }}
                        </div>
                    @endif
                </div>
            @else
                <div class="card custom--card">
                    <div class="card-body">
                        @include($activeTemplate . 'partials.empty', [
                            'message' => 'Favorite campaigns not found!',
                        ])
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/datepicker.min.css') }}" rel="stylesheet">
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/datepicker.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/datepicker.en.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';

        $(function() {
            $('.extendBtn').on('click', function(e) {
                e.preventDefault();
                let route = $(this).data('action');
                let title = $(this).data('title');
                let goal = parseFloat($(this).data('goal'));
                let curText = `{{ gs('cur_text') }}`;
                var modal = $('#extendedModal');
                modal.find('.modal-body .campaign-title').text(`${title}`);
                modal.find('.modal-body .was-goal').text(`@lang('Previous Goal'):` + `${goal}` + ' ' +
                    `${curText}`);
                modal.find('form').attr('action', route);

                $(document).on('input', '[name=goal]', function() {
                    const currentGoal = parseFloat($(this).val());
                    var finalGoal = goal + currentGoal;
                    $('[name=final_goal]').val(finalGoal);
                })

                modal.modal('show');
            });

            //date-validation
            $(document).on('click', 'form button[type=submit]', function(e) {
                if (new Date($('.datepicker-here').val()) == "Invalid Date") {
                    notify('error', 'Invalid extend deadline');
                    return false;
                }
            });
        })
    </script>
@endpush

@push('style')
    <style>
        .datepickers-container {
            z-index: 9999999999;
        }
    </style>
@endpush
