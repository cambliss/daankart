@extends($activeTemplate . 'layouts.app')
@section('panel')
    <div class="profile-section pb-120">
        <div class="container">
            <div class="profile-wrapper">
                <div class="cover-thumb bg_img" @if ($user->enable_org) data-background="{{ cover(@$user->organization->cover ? getFilePath('orgCover') . '/' . @$user->organization->cover : null, true) }}"
                @else data-background="{{ cover(@$user->cover ? getFilePath('userCover') . '/' . @$user->cover : null, false) }}" @endif>
                </div>
                <div class="profile-header-wrapper">
                    <div class="profile-content-wrapper">
                        <div class="profile-img">
                            @if ($user->enable_org)
                                <img src="{{ avatar(@$user->organization->image ? getFilePath('orgProfile') . '/' . @$user->organization->image : null, false) }}" alt="user-avatar">
                            @else
                                <img src="{{ avatar(@$user->image ? getFilePath('userProfile') . '/' . @$user->image : null, false) }}" alt="user-avatar">
                            @endif
                        </div>
                        <div class="profile-info">
                            <h4 class="name"><span class="ico"><i class="las la-user"></i></span>
                                @if ($user->enable_org)
                                    <span>{{ __($user->organization->name) }}</span>
                                @else
                                   <span> {{ __($user->fullname) }}</span>
                                @endif
                            </h4>
                            @if ($user->enable_org)
                                <div class="text"> <span class="ico"><i class="las la-tags"></i></span>
                                    {{ __($user->organization->tagline) }}
                                </div>
                            @else
                                <div class="text"> <span class="icon"><i class="las la-calendar"></i></span>
                                    @lang('Joined at') {{ showDateTime($user->created_at) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    @include($activeTemplate . 'partials.share')
                </div>
                <div class="profile-menu-list">
                    <ul class="nav nav-tabs custom--tab @if(!$user->enable_org ) px-4 justify-content-start @endif " id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ menuActive('profile.info') }}" href="{{ route('profile.info', $user->username) }}"><span class="las la-sitemap d-block text-center mb-1"></span>@lang('Basic')</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ menuActive('profile.index') }}" href="{{ route('profile.index', @$user->username) }}"><span class="lab la-free-code-camp d-block text-center mb-1"></span>@lang('Campaigns')</a>
                        </li>
                        @if ($user->enable_org)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ menuActive('profile.award') }}" href="{{ route('profile.award', $user->username) }}"><span class="las la-gifts d-block text-center mb-1"></span>@lang('Awards')</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ menuActive('profile.donor') }}" href="{{ route('profile.donor', $user->username) }}"><span class="las la-user-secret d-block text-center mb-1"></span>@lang('Donors Wall')</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ menuActive('profile.update') }}"  href="{{ route('profile.update', $user->username) }}"><span class="las la-info-circle d-block text-center mb-1"></span>@lang('Update')</a>
                        </li>
                        @endif
                    </ul>
                </div>

                @yield('content')

            </div>
        </div>
    </div>
@endsection
