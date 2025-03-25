@extends($activeTemplate . 'layouts.profile')
@section('content')
    <div class="org-update card custom--card">
        @if (!blank($user->organization->orgUpdates))
            @foreach ($user->organization->orgUpdates as $update)
                <div class=" @if (!$loop->first) border-top pt-3 @endif">
                    <p class="date"><span class="icon"><i class="las la-calendar"></i></span>{{ showDateTime(@$update->date, 'd F, Y') }} ({{ diffForHumans(@$update->date) }})</p>
                    <div class="org-update__content">
                        <p class="text"> <span class="icon"><i class="lab la-slack-hash"></i></span> {{ __(@$update->updation) }}</p>
                    </div>
                </div>
            @endforeach
        @else
            @include($activeTemplate . 'partials.empty', ['message' => 'Not any updation yet!'])
        @endif
    </div>
@endsection
