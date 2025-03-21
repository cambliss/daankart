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
                                    <th>@lang('Campaign | Trx')</th>
                                    <th>@lang('Donor') | @lang('Country')</th>
                                    <th>@lang('Email') | @lang('Mobile')</th>
                                    <th>@lang('Donation')</th>
                                    <th>@lang('Payment Method')</th>
                                    <th>@lang('Donation Date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($donations as $donation)
                                    <tr>
                                        <td>
                                            <a class="d-block" href="{{ route('admin.fundrise.details', $donation->campaign_id) }}">
                                                {{ strLimit(@$donation->campaign->title, 25) }}
                                            </a>
                                            {{ @$donation->deposit->trx }}
                                        </td>
                                        <td><span class="d-block fw-bold">{{ __($donation->fullname) }}</span>
                                            {{ $donation->country }}</td>
                                        <td>{{ $donation->email }} <br /> {{ $donation->mobile }}</td>
                                        <td><span class="fw-bold">{{ showAmount($donation->donation) }}</span></td>
                                        <td>{{ @$donation->deposit->gateway->alias }}</td>
                                        <td><span class="d-block">{{ showDateTime($donation->created_at) }}</span>
                                            {{ diffForHumans($donation->created_at) }}</td>
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
                @if ($donations->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($donations) @endphp
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <x-search-form dateSearch='yes' />
    <form class="filter">
        <div class="input-group w-auto flex-fill">
            <select class="form-control" id="anonymous-select" name="anonymous">
                <option value="">@lang('All Donation')</option>
                <option value="1" @selected(request()->anonymous == 1)>@lang('Anonymous Donation')</option>
                <option value="0" @selected(request()->anonymous == '0')>@lang('Specified Donation')</option>
            </select>
            <button class="btn btn--primary" type="submit"><i class="la la-search"></i></button>
        </div>
    </form>
@endpush

@push('script')
    <script>
        'use strict';
        $(document).ready(function() {
            $('#anonymous-select').on('change', function() {
                $(this).closest('form').submit(); 
            });
        });
    </script>
@endpush
