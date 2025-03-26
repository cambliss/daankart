@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Campaign')</th>
                                    <th>@lang('Category') | @lang('Deadline') </th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Goal')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($campaigns as $campaign)
                                    <tr>
                                        <td>
                                            <div class="campaign user thumb">
                                                <div class="thumb">
                                                    <img
                                                        src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}">
                                                </div>
                                                <div>
                                                    <p>
                                                        {{ strLimit($campaign->title, 25) }}
                                                    </p>
                                                    <small>@lang("Total Donors : ({$campaign->donations_count})")</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ @$campaign->category->name }}
                                            <br>
                                            @if ($campaign->goal_type == Status::GOAL_ACHIEVE)
                                                <span class="badge badge--success">@lang('Achieve Goal')</span>
                                            @elseif($campaign->goal_type == Status::CONTINUOUS)
                                                <span class="badge badge--primary"> @lang('Continuous')</span>
                                            @else
                                                <small
                                                    class="badge badge--warning">{{ diffForHumans($campaign->deadline, 'd-m-Y') }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if (@$campaign->user)
                                                <a class="d-block text--primary"
                                                    href="{{ appendQuery('search', @$campaign->user->username) }}">
                                                    {{ @$campaign->user->fullname }}</a>
                                                <a class="text--small"
                                                    href="{{ route('admin.users.detail', ['id' => $campaign->user->id]) }}">
                                                    <span>@</span>{{ @$campaign->user->username }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $donor = $campaign->donations->where('status', Status::DONATION_PAID);
                                                $donation = $donor->sum('donation');
                                            @endphp
                                            <span class="text--primary"> {{ showAmount($campaign->goal) }}</span>
                                            <br>
                                            @lang('Raised'): <span
                                                class="@if ($donation <= $campaign->goal) text--warning @else text--success @endif">{{ showAmount($donation) }}</span>
                                        </td>

                                        <td> @php echo $campaign->statusBadge;@endphp </td>
                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary ms-1 mb-2"
                                                    href="{{ route('admin.fundrise.details', $campaign->id) }}">
                                                    <i class="las la-desktop"></i>@lang('Details')
                                                </a>
                                                @if (request()->routeIs('admin.fundrise.rejected'))
                                                    <button class="btn btn-sm btn-outline--danger ms-1 mb-2 confirmationBtn"
                                                        data-action="{{ route('admin.fundrise.delete', $campaign->id) }}"
                                                        data-question="@lang('Are you sure to delete this campaign?')" type="button">
                                                        <i class="la la-trash"></i>@lang('Delete')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($campaigns->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($campaigns) @endphp
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card my-3">
                        <div class="card-body">
                            <h2>Daan Campaigns</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Campaign')</th>
                                    <th>@lang('Category') | @lang('Deadline') </th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Goal')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($daanCampaigns as $campaign)
                                    <tr>
                                        <td>
                                            <div class="campaign user thumb">
                                                <div class="thumb">
                                                    <img
                                                        src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}">
                                                </div>
                                                <div>
                                                    <p>
                                                        {{ strLimit($campaign->campaign_title, 25) }}
                                                    </p>
                                                    <small>@lang('Total Donors : (' . $campaign->donations_count . ')')</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ @$campaign->category->name }}
                                            <br>
                                            @if ($campaign->goal_type == Status::GOAL_ACHIEVE)
                                                <span class="badge badge--success">@lang('Achieve Goal')</span>
                                            @elseif($campaign->goal_type == Status::CONTINUOUS)
                                                <span class="badge badge--primary"> @lang('Continuous')</span>
                                            @else
                                                <small
                                                    class="badge badge--warning">{{ diffForHumans($campaign->deadline, 'd-m-Y') }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if (@$campaign->user)
                                                <a class="d-block text--primary"
                                                    href="{{ appendQuery('search', @$campaign->user->username) }}">
                                                    {{ @$campaign->user->fullname }}
                                                </a>
                                                <a class="text--small"
                                                    href="{{ route('admin.users.detail', @$campaign->user->id) }}">
                                                    <span>@</span>{{ @$campaign->user->username }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $donor = $campaign->donations->where('status', Status::DONATION_PAID);
                                                $donation = $donor->sum('donation');
                                            @endphp
                                            <span class="text--primary"> {{ showAmount($campaign->goal) }}</span>
                                            <br>
                                            @lang('Raised'): <span
                                                class="@if ($donation <= $campaign->goal) text--warning @else text--success @endif">{{ showAmount($donation) }}</span>
                                        </td>

                                        <td> @php echo $campaign->statusBadge;@endphp </td>
                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary ms-1 mb-2"
                                                    href="{{ route('admin.fundrise.details', $campaign->id) . '?tab=daan' }}">
                                                    <i class="las la-desktop"></i>@lang('Details')
                                                </a>
                                                <button class="btn btn-sm btn-outline--success ms-1 mb-2 confirmationBtn"
                                                    data-action="{{ route('admin.daan.campaign.update', ['id' => $campaign->id, 'status' => 'Approved']) }}"
                                                    data-question="Are you sure to approve this campaign?" type="button">
                                                    Approve
                                                </button>
                                                @if (request()->routeIs('admin.fundrise.rejected'))
                                                    <button class="btn btn-sm btn-outline--danger ms-1 mb-2 confirmationBtn"
                                                        data-action="{{ route('admin.fundrise.delete', $campaign->id) }}"
                                                        data-question="@lang('Are you sure to delete this campaign?')" type="button">
                                                        <i class="la la-trash"></i>@lang('Delete')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
@endpush
@push('style')
    <style>
        .campaign.user {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
    </style>
@endpush
