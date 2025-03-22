@php
    $contact = getContent('contact_us.content', true);
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();
@endphp

<header class="header__bottom @if (request()->routeIs('profile.*')) header-for-profile @endif">
    <div class="container">
        <nav class="navbar navbar-expand-xl p-0 align-items-center">
            <a class="site-logo site-title" href="{{ url('/') }}">
                <img src="{{ siteLogo() }}" alt="site-logo">
                <span class="logo-icon"><i class="flaticon-fire"></i></span>
            </a>
            <button class="navbar-toggler ml-auto" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="las la-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @php
                    $routeName = Route::currentRouteName();
                    $routePrefix = explode('.', $routeName)[0];
                @endphp

                @auth
                    @php
    $contact = getContent('contact_us.content', true);
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();
@endphp

<header class="header__bottom @if (request()->routeIs('profile.*')) header-for-profile @endif">
    <div class="container">
        <nav class="navbar navbar-expand-xl p-0 align-items-center">
            <a class="site-logo site-title" href="{{ url('/') }}">
                <img src="{{ siteLogo() }}" alt="site-logo">
                <span class="logo-icon"><i class="flaticon-fire"></i></span>
            </a>
            <button class="navbar-toggler ml-auto" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="las la-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @php
                    $routeName = Route::currentRouteName();
                    $routePrefix = explode('.', $routeName)[0];
                @endphp

                @auth
                    @if ($routePrefix != 'user' && !request()->routeIs('ticket.index'))
                        <ul class="navbar-nav main-menu ms-auto">
                            <li><a href="/campaign/index" class="menu-item">EXPLORE CAMPAIGNS</a></li>
                            @include($activeTemplate . 'partials.common_menus')
                        </ul>
                    @else
                        <ul class="navbar-nav main-menu ms-2 me-auto">
                            <li><a href="/campaign/index" class="menu-item">EXPLORE CAMPAIGNS</a></li>
                            <li class="menu_has_children">
                                <a class="{{ menuActive('user.campaign.fundrise.*') }}" href="javascript:void(0)">@lang('MY CAMPAIGNS')</a>
                                <ul class="sub-menu">
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.fundrise.approved') }}" href="{{ route('user.campaign.fundrise.approved') }}">@lang('APPROVED CAMPAIGNS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.fundrise.pending') }}" href="{{ route('user.campaign.fundrise.pending') }}">@lang('PENDING CAMPAIGNS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.fundrise.complete') }}" href="{{ route('user.campaign.fundrise.complete') }}">@lang('SUCCESSFUL CAMPAIGNS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.fundrise.rejected') }}" href="{{ route('user.campaign.fundrise.rejected') }}">@lang('REJECTED CAMPAIGNS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.fundrise.all') }}" href="{{ route('user.campaign.fundrise.all') }}">@lang('ALL CAMPAIGNS')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children">
                                <a class="{{ menuActive(['user.withdraw', 'user.withdraw.history']) }}" href="#0">@lang('WITHDRAW MONEY')</a>
                                <ul class="sub-menu">
                                    <li><a class="dropdown-item {{ menuActive('user.withdraw') }}" href="{{ route('user.withdraw') }}">@lang('WITHDRAW MONEY')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.withdraw.history') }}" href="{{ route('user.withdraw.history') }}">@lang('WITHDRAW LOG')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children">
                                <a class="{{ menuActive(['ticket.open', 'ticket.index', 'ticket.view']) }}" href="#0">@lang('SUPPORT TICKET')</a>
                                <ul class="sub-menu">
                                    <li><a class="dropdown-item {{ menuActive('ticket.open') }}" href="{{ route('ticket.open') }}">@lang('CREATE NEW')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('ticket.index') }}" href="{{ route('ticket.index') }}">@lang('MY TICKETS')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children">
                                <a class="{{ menuActive(['user.favorite.index', 'user.change.password', 'user.twofactor', 'user.profile.setting', 'user.transactions', 'user.campaign.donation.received', 'user.campaign.donation.give']) }}" href="#0">
                                    <i class="las la-user me-1"></i>
                                    @if (auth()->user()->profile_complete)
                                        {{ strtoupper(auth()->user()->username) }}
                                    @else
                                        @lang('ACCOUNT')
                                    @endif
                                </a>
                                <ul class="sub-menu">
                                    <li><a class="dropdown-item {{ menuActive('user.profile.setting') }}" href="{{ route('user.profile.setting') }}">@lang('PROFILE SETTING')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.favorite.index') }}" href="{{ route('user.favorite.index') }}">@lang('FAVORITE CAMPAIGNS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.transactions') }}" href="{{ route('user.transactions') }}">@lang('TRANSACTION LOG')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.donation.received') }}" href="{{ route('user.campaign.donation.received') }}">@lang('RECEIVED DONATIONS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.donation.given') }}" href="{{ route('user.campaign.donation.given') }}">@lang('GIVEN DONATIONS')</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.logout') }}">@lang('LOGOUT')</a></li>
                                </ul>
                            </li>
                        </ul>
                    @endif
                    <div class="nav-right">
                        <a class="btn cmn-btn" href="{{ route('user.campaign.fundrise.create') }}">@lang('START A CAMPAIGN')</a>
                    </div>
                @else
                    <!-- Custom menu items for the homepage -->
                    @if(request()->is('/'))
                        <ul class="navbar-nav main-menu ms-2 me-auto">
                            <!--<li><a href="/" class="menu-item">HOME</a></li>-->
                            <li><a href="/about" class="menu-item">ABOUT</a></li>
                            <!--<li><a href="/donate" class="menu-item">DONATE</a></li>-->
                            <li><a href="/campaign/index" class="menu-item">EXPLORE CAMPAIGNS</a></li>
                            <li><a href="/donate-monthly" class="menu-item">DONATE MONTHLY</a></li>
                            <li><a href="https://daankart.com/user/login" class="menu-item">START A CAMPAIGN</a></li>
                            <!--<li><a href="/volunteer" class="menu-item">VOLUNTEER</a></li>-->
                            <!--<li><a href="/blogs" class="menu-item">BLOGS</a></li>-->
                        </ul>
                    @else
                        <!-- Dynamic menu for other pages -->
                        <li><a href="/campaign/index" class="menu-item">EXPLORE CAMPAIGNS</a></li>
                        <ul class="navbar-nav main-menu ms-2 me-auto">
                            @include($activeTemplate . 'partials.common_menus')
                        </ul>
                    @endif
                    <div class="header-top__right text-center">
                        <a href="{{ route('user.login') }}" class="header-top__link">
                            <i class="las la-sign-in-alt"></i> @lang('LOGIN')
                        </a>
                        <a href="{{ route('user.register') }}" class="header-top__link">
                            <i class="las la-user-plus"></i> @lang('REGISTER')
                        </a>
                    </div>
                @endauth
            </div>
        </nav>
    </div>
</header>

                    @if ($routePrefix != 'user' && !request()->routeIs('ticket.index'))
                        <ul class="navbar-nav main-menu ms-auto">
                            @include($activeTemplate . 'partials.common_menus')
                        </ul>
                    @else
                        <ul class="navbar-nav main-menu ms-2 me-auto">
                            <li class="menu_has_children">
                                <a class="{{ menuActive('user.campaign.fundrise.*') }}" href="javascript:void(0)">@lang('MY CAMPAIGNS')</a>
                                <ul class="sub-menu">
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.fundrise.approved') }}" href="{{ route('user.campaign.fundrise.approved') }}">@lang('APPROVED CAMPAIGNS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.fundrise.pending') }}" href="{{ route('user.campaign.fundrise.pending') }}">@lang('PENDING CAMPAIGNS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.fundrise.complete') }}" href="{{ route('user.campaign.fundrise.complete') }}">@lang('SUCCESSFUL CAMPAIGNS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.fundrise.rejected') }}" href="{{ route('user.campaign.fundrise.rejected') }}">@lang('REJECTED CAMPAIGNS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.fundrise.all') }}" href="{{ route('user.campaign.fundrise.all') }}">@lang('ALL CAMPAIGNS')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children">
                                <a class="{{ menuActive(['user.withdraw', 'user.withdraw.history']) }}" href="#0">@lang('WITHDRAW MONEY')</a>
                                <ul class="sub-menu">
                                    <li><a class="dropdown-item {{ menuActive('user.withdraw') }}" href="{{ route('user.withdraw') }}">@lang('WITHDRAW MONEY')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.withdraw.history') }}" href="{{ route('user.withdraw.history') }}">@lang('WITHDRAW LOG')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children">
                                <a class="{{ menuActive(['ticket.open', 'ticket.index', 'ticket.view']) }}" href="#0">@lang('SUPPORT TICKET')</a>
                                <ul class="sub-menu">
                                    <li><a class="dropdown-item {{ menuActive('ticket.open') }}" href="{{ route('ticket.open') }}">@lang('CREATE NEW')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('ticket.index') }}" href="{{ route('ticket.index') }}">@lang('MY TICKETS')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children">
                                <a class="{{ menuActive(['user.favorite.index', 'user.change.password', 'user.twofactor', 'user.profile.setting', 'user.transactions', 'user.campaign.donation.received', 'user.campaign.donation.give']) }}" href="#0">
                                    <i class="las la-user me-1"></i>
                                    @if (auth()->user()->profile_complete)
                                        {{ strtoupper(auth()->user()->username) }}
                                    @else
                                        @lang('ACCOUNT')
                                    @endif
                                </a>
                                <ul class="sub-menu">
                                    <li><a class="dropdown-item {{ menuActive('user.profile.setting') }}" href="{{ route('user.profile.setting') }}">@lang('PROFILE SETTING')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.favorite.index') }}" href="{{ route('user.favorite.index') }}">@lang('FAVORITE CAMPAIGNS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.transactions') }}" href="{{ route('user.transactions') }}">@lang('TRANSACTION LOG')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.donation.received') }}" href="{{ route('user.campaign.donation.received') }}">@lang('RECEIVED DONATIONS')</a></li>
                                    <li><a class="dropdown-item {{ menuActive('user.campaign.donation.given') }}" href="{{ route('user.campaign.donation.given') }}">@lang('GIVEN DONATIONS')</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.logout') }}">@lang('LOGOUT')</a></li>
                                </ul>
                            </li>
                        </ul>
                    @endif
                    <div class="nav-right">
                        <a class="btn cmn-btn" href="{{ route('user.campaign.fundrise.create') }}">@lang('START A CAMPAIGN')</a>
                    </div>
                @else
                    <!-- Custom menu items for the homepage -->
                    @if(request()->is('/'))
                        <ul class="navbar-nav main-menu ms-2 me-auto">
                            <!--<li><a href="/" class="menu-item">HOME</a></li>-->
                            <li><a href="/about" class="menu-item">ABOUT</a></li>
                            <!--<li><a href="/donate" class="menu-item">DONATE</a></li>-->
                            <li><a href="/campaign/index" class="menu-item">EXPLORE CAMPAIGNS</a></li>
                            <li><a href="/donate-monthly" class="menu-item">DONATE MONTHLY</a></li>
                            <li><a href="https://daankart.com/user/login" class="menu-item">START A CAMPAIGN</a></li>
                            <!--<li><a href="/volunteer" class="menu-item">VOLUNTEER</a></li>-->
                            <!--<li><a href="/blogs" class="menu-item">BLOGS</a></li>-->
                        </ul>
                    @else
                        <!-- Dynamic menu for other pages -->
                        <li><a href="/campaign/index" class="menu-item">EXPLORE CAMPAIGNS</a></li>
                        <ul class="navbar-nav main-menu ms-2 me-auto">
                            @include($activeTemplate . 'partials.common_menus')
                        </ul>
                    @endif
                    <div class="header-top__right text-center">
                        <a href="{{ route('user.login') }}" class="header-top__link">
                            <i class="las la-sign-in-alt"></i> @lang('LOGIN')
                        </a>
                        <a href="{{ route('user.register') }}" class="header-top__link">
                            <i class="las la-user-plus"></i> @lang('REGISTER')
                        </a>
                    </div>
                @endauth
            </div>
        </nav>
    </div>
</header>
