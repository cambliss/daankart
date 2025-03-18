@extends($activeTemplate . 'layouts.profile')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="donar-slider">
                @if (!blank($user->organization->donors))
                    @foreach ($user->organization->donors as $donor)
                        <div class="donar-item">
                            <div class="donar-item__thumb">
                                <img src="{{ avatar(@$donor->image ? getFilePath('orgDonor') . '/' . @$donor->image : null) }}" alt="">
                            </div>
                            <div class="donar-item__info">
                                <h6 class="name">{{ __($donor->name) }}</h6>
                                <p class="donar-item__details">{{ __($donor->details) }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    @include($activeTemplate . 'partials.empty', ['message' => 'No donation raised yet!'])
                @endif
            </div>
        </div>
    </div>
@endsection
