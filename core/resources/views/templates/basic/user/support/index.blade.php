@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="pt-90 pb-120">
        <div class="container">
            @if (!blank($supports))
                <div class="row justify-content-center mt-4">
                    <div class="col-md-12">
                        <div class="text-end">
                            <a class="btn cmn-btn btn-sm mb-2" href="{{ route('ticket.open') }}"> <i class="fas fa-plus"></i> @lang('New Ticket')</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table able--responsive--lg">
                                <thead>
                                    <tr>
                                        <th>@lang('Subject')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Priority')</th>
                                        <th>@lang('Last Reply')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supports as $support)
                                        <tr>
                                            <td> <a class="fw-bold" href="{{ route('ticket.view', $support->ticket) }}"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                            <td>
                                                @php echo $support->statusBadge; @endphp
                                            </td>
                                            <td>
                                                @if ($support->priority == Status::PRIORITY_LOW)
                                                    <span class="badge badge--dark">@lang('Low')</span>
                                                @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                                    <span class="badge  badge--warning">@lang('Medium')</span>
                                                @elseif($support->priority == Status::PRIORITY_HIGH)
                                                    <span class="badge badge--danger">@lang('High')</span>
                                                @endif
                                            </td>
                                            <td>{{ diffForHumans($support->last_reply) }} </td>

                                            <td>
                                                <a class="btn cmn-btn btn-sm" href="{{ route('ticket.view', $support->ticket) }}">
                                                    <i class="fas fa-desktop"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($supports->hasPages())
                            <div class="pt-3">
                                {{ paginateLinks($supports) }}
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="card custom--card">
                    <div class="card-body">
                        @include($activeTemplate . 'partials.empty', ['message' => 'Support ticket not created yet!'])
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
