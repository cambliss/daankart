@extends($activeTemplate . 'layouts.profile')
@section('content')
    <div class="row gy-4 justify-content-center">
        @if (!blank($user->organization->awards))
            @foreach ($user->organization->awards as $award)
                <div class="col-lg-4 col-md-6">
                    <div class="card custom--card">
                        <div class="award-item">
                            <div class="award-item__thumb">
                                <img src="{{ getImage(getFilePath('orgAward') . '/' . $award->image, getFileSize('orgAward')) }}" alt="award">
                            </div>
                            <div class="award-item__content">
                                <h5 class="award-item__title"><span class="icon"><i class="las la-check-square"></i></span> {{ __($award->title) }}</h5>
                                <small class="award-item__institute"> <span class="icon"><i class="las la-graduation-cap"></i></span> {{ __($award->institute) }}</small>
                                <p class="award-item__text"> <span class="user-info__title">@lang('Contribution'):</span> <br> {{ __($award->contribution) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            @include($activeTemplate . 'partials.empty', ['message' => 'Not awarded yet!'])
        @endif
    </div>
@endsection

@push('style')
    <style>
        .user-info__title {
            margin-bottom: 3px;
        }
    </style>
@endpush
