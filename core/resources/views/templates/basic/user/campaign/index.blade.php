@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="pt-90 pb-120">
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
                                <table class="table table--responsive--md">
                                    <thead>
                                        <tr>
                                            <th>@lang('S.N.')</th>
                                            <th>@lang('Title')</th>
                                            <th>@lang('Goal') | @lang('Raised')</th>
                                            <th>@lang('Deadline') | @lang('Created at')</th>
                                            <th class="dp-action">@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($campaigns as $item)
                                            <tr>
                                                <td>{{ $loop->index + $campaigns->firstItem() }}</td>
                                                <td>
                                                    <div>
                                                        <span class="camp-table-title">
                                                            @if ($item->featured)
                                                                <i class="las la-star text-warning"
                                                                    title="@lang('Campaign Featured')"></i>
                                                            @endif
                                                            {{ $item->title }}
                                                        </span>
                                                        <br>
                                                        <small title="@lang('Campaign Category')"><i
                                                                class="las la-chevron-circle-right"></i>
                                                            {{ __($item->category->name) }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ showAmount($item->goal) }} <br>
                                                    <small>
                                                        {{ showAmount($item->donations->where('status', Status::DONATION_PAID)->sum('donation')) }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <div>
                                                        @if ($item->goal_type == Status::GOAL_ACHIEVE)
                                                            <span class="badge badge--primary">@lang('Achieve Goal')</span>
                                                        @elseif($item->goal_type == Status::CONTINUOUS)
                                                            <span class="badge badge--success"> @lang('Continuous')</span>
                                                        @else
                                                            <span class="badge badge--warning">
                                                                {{ showDateTime($item->deadline, 'd-m-Y') }}</span>
                                                        @endif
                                                        <span class="d-block">{{ diffForHumans($item->created_at) }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="action-group-link" data-bs-toggle="dropdown"
                                                            href="#">
                                                            <i class="las la-ellipsis-v"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown--menu px-2">
                                                            @if (request()->routeIs('user.campaign.fundrise.pending'))
                                                                @if ($item->expired())
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('user.campaign.fundrise.edit', $item->id) }}">
                                                                            <i class="las la-edit"></i> @lang('Edit')
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endif

                                                            @if (request()->routeIs('user.campaign.fundrise.rejected'))
                                                                <li>
                                                                    <button class="dropdown-item confirmationBtn"
                                                                        data-question="@lang('Are you sure to delete the expired campaign?')"
                                                                        data-action="{{ route('user.campaign.fundrise.delete', $item->id) }}">
                                                                        <i class="las la-trash"></i> @lang('Delete')
                                                                    </button>
                                                                </li>
                                                            @endif

                                                            @if (request()->routeIs('user.campaign.fundrise.pending') ||
                                                                    request()->routeIs('user.campaign.fundrise.rejected') ||
                                                                    request()->routeIs('user.campaign.fundrise.complete'))
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('campaign.details', $item->slug) }}"
                                                                        target="__blank">
                                                                        <i class="las la-desktop"></i> @lang('Explore Campaign')
                                                                    </a>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('campaign.details', $item->slug) }}"
                                                                        target="__blank">
                                                                        <i class="las la-desktop"></i> @lang('Explore Campaign')
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item "
                                                                        href="{{ route('user.campaign.donation.report', $item->id) }}">
                                                                        <i class="las la-user"></i>@lang('Donation Report')
                                                                    </a>
                                                                </li>

                                                                @if ($item->completed == Status::NO)
                                                                    <li>
                                                                        <button class="dropdown-item confirmationBtn"
                                                                            data-question="@lang('Are you sure to mark as complete? Because this action can\'t back again! And can\'t relaunch again')"
                                                                            data-action="{{ route('user.campaign.fundrise.make.complete', $item->id) }}">
                                                                            <i class="las la-check"></i> @lang('Mark as Complete')
                                                                        </button>
                                                                    </li>
                                                                @endif

                                                                @if (!request()->routeIs('user.campaign.fundrise.expired'))
                                                                    @if ($item->stop)
                                                                        <li>
                                                                            <button class="dropdown-item confirmationBtn"
                                                                                data-question="@lang('Are you sure to start this campaign?')"
                                                                                data-action="{{ route('user.campaign.fundrise.stop', $item->id) }}">
                                                                                <i class="las la-pause-circle"></i>
                                                                                @lang('Resume Campaign')
                                                                            </button>
                                                                        @else
                                                                            <button class="dropdown-item confirmationBtn"
                                                                                data-question="@lang('Are you sure to pause/stop this campaign?')"
                                                                                data-action="{{ route('user.campaign.fundrise.stop', $item->id) }}">
                                                                                <i class="las la-pause-circle"></i>
                                                                                @lang('Pause Campaign')
                                                                            </button>
                                                                        </li>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                            @if ($item->completed == Status::NO || $item->status != Status::CAMPAIGN_REJECTED)
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('user.campaign.fundrise.seo', $item->id) }}"
                                                                        target="_blank"> <i class="las la-eye"></i>
                                                                        @lang('SEO Configuration')</a>
                                                                </li>
                                                            @endif
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('user.campaign.fundrise.update', $item->id) }}">
                                                                    <i class="las la-sync"></i> @lang('Update Log')
                                                                </a>
                                                            </li>

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
    </div>
    <x-confirmation-modal />
@endsection
