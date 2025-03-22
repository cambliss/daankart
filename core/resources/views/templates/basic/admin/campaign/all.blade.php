@extends($activeTemplate . 'layouts.master')

@section('content')
    <section class="pt-90 pb-120">
        <div class="container">

            @if (!blank($campaigns))
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
                                            <th>@lang('Goal')</th>
                                            <th>@lang('Raised')</th>
                                            <th>@lang('Deadline')</th>
                                            <th>@lang('Status')</th>
                                            <th class="dp-action">@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($campaigns as $item)
                                            @php
                                                $donation = $item->donations->where('status', Status::DONATION_PAID);
                                                $hasDonations = $donation->count();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div>
                                                        <span class="camp-table-title">
                                                            {{ $item->title }}
                                                        </span>
                                                        <br>
                                                        <small title="@lang('Campaign Category')"><i
                                                                class="las la-chevron-circle-right"></i>
                                                            {{ __($item->category->name) }}</small>
                                                    </div>
                                                </td>
                                                <td>{{ showAmount($item->goal) }} </td>
                                                <td>
                                                    {{ showAmount($donation->sum('donation')) }}
                                                </td>
                                                <td>
                                                    @if ($item->goal_type == Status::GOAL_ACHIEVE)
                                                        <span class="badge badge--primary">@lang('Achieve Goal')</span>
                                                    @elseif($item->goal_type == Status::CONTINUOUS)
                                                        <span class="badge badge--success"> @lang('Continuous')</span>
                                                    @else
                                                        <span class="badge badge--warning">
                                                            {{ showDateTime($item->deadline, 'd-m-Y') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php echo $item->statusBadge; @endphp
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="action-group-link" data-bs-toggle="dropdown"
                                                            href="#">
                                                            <i class="las la-ellipsis-v"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown--menu px-2">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('campaign.details', $item->slug) }}"
                                                                    target="_blank">
                                                                    <i class="las la-desktop"></i> @lang('Explore Campaign')
                                                                </a>
                                                            </li>

                                                            @if ($item->goal_type == Status::AFTER_DEADLINE && $item->deadline < now())
                                                                <li>
                                                                    <button class="dropdown-item extendBtn"
                                                                        data-title="{{ $item->title }}"
                                                                        data-goal="{{ $item->goal }}"
                                                                        data-action="{{ route('user.campaign.fundrise.extended', $item->id) }}">
                                                                        <i class="las la-recycle"></i> @lang('Make Extend')
                                                                    </button>
                                                                </li>
                                                            @endif

                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('user.campaign.donation.report', $item->id) }}">
                                                                    <i class="las la-user"></i> @lang('Donation Report')
                                                                </a>
                                                            </li>
                                                            @if ($item->completed == Status::NO || $item->status != Status::CAMPAIGN_REJECTED)
                                                                <li>
                                                                    <a target="_blank" class="dropdown-item"
                                                                        href="{{ route('user.campaign.fundrise.seo', $item->id) }}">
                                                                        <i class="las la-eye"></i> @lang('SEO Configuration')</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($campaigns->hasPages())
                    @php echo paginateLinks($campaigns) @endphp
                @endif
            @else
                <div class="card custom--card">
                    <div class="card-body">
                        @include($activeTemplate . 'partials.empty', [
                            'message' => ucfirst(strtolower($pageTitle)) . ' not found!',
                        ])
                    </div>
                </div>
            @endif

        </div>
        {{-- //Extend The Expired Campaign modal --}}
        <div class="modal" id="extendedModal" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Are you sure to extend the campaign')?</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <h4 class="campaign-title"></h4>
                            @csrf
                            <div class="form-group">
                                <label>@lang('Extend Deadline')</label>
                                <input class="datepicker-here form-control bg--white" name="deadline" data-language="en"
                                    data-date-format="yyyy-mm-dd" type="text" value="{{ date('Y-m-d') }}"
                                    autocomplete="off" required>
                                <small class="text-muted text--small"> <i class="la la-info-circle"></i>
                                    @lang('Year-Month-Date')</small>
                            </div>

                            <div class="form-group">
                                <label>@lang('Extend Goal') </label>
                                <div class="input-group">
                                    <input class="form-control" name="goal" type="number" value="{{ old('goal') }}"
                                        step="any" required>
                                    <span class="input-group-text">{{ __(gs('cur_text')) }} </span>
                                </div>
                                <code class="was-goal"></code>
                            </div>
                            <div class="form-group">
                                <label>@lang('Final Goal')</label>
                                <div class="input-group">
                                    <input class="form-control" name="final_goal" type="number"
                                        value="{{ old('final_goal') }}" step="any" required readonly>
                                    <span class="input-group-text">{{ __(gs('cur_text')) }} </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="cmn-btn btn-sm" type="submit">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/admin/css/vendor/datepicker.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
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
                let curText = `{{ __(gs('cur_text')) }}`;
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
