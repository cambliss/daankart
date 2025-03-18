@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card   ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Profile')</th>
                                    <th>@lang('Email-Mobile')</th>
                                    <th>@lang('Country')</th>
                                    <th>@lang('Joined At')</th>
                                    <th>@lang('Balance')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="small">
                                                @if (@$user->username)
                                                    <a href="{{ route('profile.index', $user->username) }}" target="__blank">
                                                        @if ($user->enable_org == Status::ENABLE)
                                                            <span class="text--primary"> @lang('Organization')</span>
                                                        @else
                                                            <span class="text--info"> @lang('Personal')</span>
                                                        @endif <i class="las la-external-link-alt"></i>
                                                    </a>
                                                @else
                                                    @
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            {{ $user->email }}<br>{{ $user->mobileNumber }}
                                        </td>
                                        <td>
                                            <span class="fw-bold" title="{{ @$user->country_name }}">{{ $user->country_code }}</span>
                                        </td>
                                        <td>
                                            {{ showDateTime($user->created_at) }} <br> {{ diffForHumans($user->created_at) }}
                                        </td>
                                        <td>
                                            <span class="fw-bold">

                                                {{ showAmount($user->balance) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.users.detail', $user->id) }}">
                                                    <i class="las la-desktop"></i> @lang('Details')
                                                </a>
                                                @if (request()->routeIs('admin.users.kyc.pending'))
                                                    <a class="btn btn-sm btn-outline--dark" href="{{ route('admin.users.kyc.details', $user->id) }}" target="_blank">
                                                        <i class="las la-user-check"></i>@lang('KYC Data')
                                                    </a>
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
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($users->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($users) }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username / Email" />
@endpush
