@extends($activeTemplate . 'layouts.profile')
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="user-info">
                @php
                    $description = $user->enable_org ? @$user->organization->description : @$user->description;
                    $cleanDescription = trim(strip_tags($description));
                @endphp

                @if (!empty($cleanDescription))
                    <p class="user-info__desc">{{ $cleanDescription }}</p>
                @else
                    @include($activeTemplate . 'partials.empty', ['message' => 'Basic information not provided yet!'])
                @endif

            </div>
        </div>
        <div class="col-lg-4">
            <div class="contact-item card custom--card p-3">
                <h6 class="contact-item__title">@lang('Contact')</h6>
                <p class="contact-item__info"><span class="icon"><i class="las la-envelope"></i></span> @lang('Email'):
                    @if ($user->enable_org)
                        {{ $user->organization->address->email }}
                    @else
                        {{ $user->email }}
                    @endif
                </p>
                <p class="contact-item__info"><span class="icon"><i class="las la-phone"></i></span> @lang('Phone'):
                    @if ($user->enable_org)
                        {{ $user->organization->address->mobile }}
                    @else
                        {{ $user->mobile }}
                    @endif
                </p>
                <p class="contact-item__info"><span class="icon"><i class="las la-map-marker"></i></span> @lang('Location'):
                    @if ($user->enable_org)
                        {{ $user->organization->address->address }}
                    @else
                        {{ $user->address . ',' . $user->state . ',' . $user->city . ',' . $user->country_name . ' -' . $user->zip }}
                    @endif
                </p>
            </div>
        </div>
    </div>
@endsection
