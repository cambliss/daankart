@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="py-5 ">
        <div class="container">
            @if (!blank($transactions))
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="show-filter mb-3 text-end">
                            <button class="btn cmn-btn showFilterBtn btn-sm" type="button"><i class="las la-filter"></i> @lang('Filter')</button>
                        </div>
                        <div class="card responsive-filter-card mb-4">
                            <div class="card-body">
                                <form>
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="flex-grow-1">
                                            <label class="form-label">@lang('Transaction Number')</label>
                                            <input class="form-control" name="search" type="search" value="{{ request()->search }}">
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="form-label d-block">@lang('Type')</label>
                                            <select class="form-select form-control select2" name="trx_type" data-minimum-results-for-search="-1">
                                                <option value="">@lang('All')</option>
                                                <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')</option>
                                                <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')</option>
                                            </select>
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="form-label d-block">@lang('Remark')</label>
                                            <select class="form-select form-control select2" name="remark" data-minimum-results-for-search="-1">
                                                <option value="">@lang('All')</option>
                                                @foreach ($remarks as $remark)
                                                    <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>{{ __(keyToTitle($remark->remark)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex-grow-1 align-self-end">
                                            <button class="btn cmn-btn w-100"><i class="las la-filter"></i> @lang('Filter')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card custom--card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table able--responsive--lg">
                                        <thead>
                                            <tr>
                                                <th>@lang('Trx')</th>
                                                <th>@lang('Transacted')</th>
                                                <th>@lang('Amount')</th>
                                                <th>@lang('Post Balance')</th>
                                                <th>@lang('Detail')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions as $trx)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $trx->trx }}</strong>
                                                    </td>
                                                    <td>
                                                        {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                                                            {{ $trx->trx_type }} {{ showAmount($trx->amount) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ showAmount($trx->post_balance) }}
                                                    </td>
                                                    <td>{{ __($trx->details) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @if ($transactions->hasPages())
                            <div class="pt-3">
                                {{ paginateLinks($transactions) }}
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="card custom--card">
                    <div class="card-body">
                        @include($activeTemplate . 'partials.empty', ['message' => 'Transaction not found!'])
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        $(document).ready(function() {
            $.each($('.select2'), function() {
                $(this)
                    .wrap(`<div class="position-relative"></div>`)
                    .select2({
                        dropdownParent: $(this).parent()
                    });
            });
        });
    </script>
@endpush

