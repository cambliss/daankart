@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="pt-90 pb-120">
        <div class="container">
            @if (!blank($donations))
                <div class="row justify-content-center my-5">
                    <div class="col-12">
                        <div class="card custom--card">
                            <div class="card-body p-0">
                                <table class="table table--responsive--lg">
                                    <thead>
                                        <tr>
                                            <th>@lang('S.N.')</th>
                                            <th>@lang('Trx')</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Email')</th>
                                            <th>@lang('Mobile')</th>
                                            <th>@lang('Country')</th>
                                            <th>@lang('Amount')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($donations as $item)
                                            <tr>
                                                <td>{{ $donations->firstItem() + $loop->index }}</td>
                                                <td>{{ @$item->deposit->trx }}</td>
                                                <td>{{ __($item->fullname) }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->mobile }}</td>
                                                <td>{{ $item->country }}</td>
                                                <td>{{ showAmount($item->donation) }} </td>
                                                <td>
                                                    <a href="{{ route('user.campaign.donation.details', [$item->id, 'slug' => $given]) }}"><i class="la la-desktop bg-cmn text-white p-2 rounded" title="Show Details"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($donations->hasPages())
                    @php echo paginateLinks($donations) @endphp
                @endif
            @else
                <div class="card custom--card">
                    <div class="card-body">
                        @include($activeTemplate . 'partials.empty', ['message' => ucfirst(strtolower($pageTitle)) . ' not found!'])
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('style')
    <style>
        .widget_select {
            padding: 3px 3px;
            font-size: 13px;
        }
    </style>
@endpush
