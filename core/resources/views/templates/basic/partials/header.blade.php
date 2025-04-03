@php
    $contact = getContent('contact_us.content', true);
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();
    $routeName = Route::currentRouteName();
    $routePrefix = explode('.', $routeName)[0] ?? '';
    $isHomepage = request()->is('/');
    $isProfileRoute = request()->routeIs('profile.*');
    $isTicketIndex = request()->routeIs('ticket.index');
@endphp
<style>
    .navbar-nav.main-menu>li:first-child>a {
        padding-left: 0px !important;
    }
</style>

<header class="header__bottom @if($isProfileRoute) header-for-profile @endif">
    <div class="container">
        <nav class="navbar navbar-expand-xl p-0 align-items-center">
            <a class="site-logo site-title" href="{{ url('/') }}">
                <img src="{{ siteLogo() }}" alt="site-logo">
                <span class="logo-icon"><i class="flaticon-fire"></i></span>
            </a>
            
            <button class="navbar-toggler ml-auto" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" type="button" 
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="las la-bars" style="color: #292f19;" ></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @auth
                    {{-- Authenticated User Menu --}}
                    <ul class="navbar-nav main-menu @if($routePrefix != 'user' && !$isTicketIndex) ms-auto @else ms-2 me-auto @endif">
                        <li><a href="/campaign/all" class="menu-item px-4">DISCOVER CAMPAIGNS</a></li>
                        
                        @if($routePrefix == 'user' || $isTicketIndex)
                            {{-- User Dashboard Menu --}}
                            <li class="menu_has_children">
                                <a class="{{ menuActive('user.campaign.fundrise.*') }}" href="javascript:void(0)">
                                    @lang('MY CAMPAIGNS')
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a class="dropdown-item {{ menuActive('user.campaign.fundrise.approved') }}" 
                                           href="{{ route('user.campaign.fundrise.approved') }}">
                                            @lang('APPROVED CAMPAIGNS')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ menuActive('user.campaign.fundrise.pending') }}" 
                                           href="{{ route('user.campaign.fundrise.pending') }}">
                                            @lang('PENDING CAMPAIGNS')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ menuActive('user.campaign.fundrise.complete') }}" 
                                           href="{{ route('user.campaign.fundrise.complete') }}">
                                            @lang('SUCCESSFUL CAMPAIGNS')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ menuActive('user.campaign.fundrise.rejected') }}" 
                                           href="{{ route('user.campaign.fundrise.rejected') }}">
                                            @lang('REJECTED CAMPAIGNS')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ menuActive('user.campaign.fundrise.all') }}" 
                                           href="{{ route('user.campaign.fundrise.all') }}">
                                            @lang('ALL CAMPAIGNS')
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="menu_has_children">
                                <a class="{{ menuActive(['ticket.open', 'ticket.index', 'ticket.view']) }}" href="#0">
                                    @lang('SUPPORT TICKET')
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a class="dropdown-item {{ menuActive('ticket.open') }}" 
                                           href="{{ route('ticket.open') }}">
                                            @lang('CREATE NEW')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ menuActive('ticket.index') }}" 
                                           href="{{ route('ticket.index') }}">
                                            @lang('MY TICKETS')
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="menu_has_children">
                                <a class="{{ menuActive([
                                    'user.favorite.index', 
                                    'user.change.password', 
                                    'user.twofactor', 
                                    'user.profile.setting', 
                                    'user.transactions', 
                                    'user.campaign.donation.received', 
                                    'user.campaign.donation.give'
                                ]) }}" href="#0">
                                    <i class="las la-user me-1"></i>
                                    @if(auth()->user()->profile_complete)
                                        {{ strtoupper(auth()->user()->username) }}
                                    @else
                                        @lang('ACCOUNT')
                                    @endif
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a class="dropdown-item {{ menuActive('user.profile.setting') }}" 
                                           href="{{ route('user.profile.setting') }}">
                                            @lang('PROFILE SETTING')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ menuActive('user.favorite.index') }}" 
                                           href="{{ route('user.favorite.index') }}">
                                            @lang('FAVORITE CAMPAIGNS')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ menuActive('user.transactions') }}" 
                                           href="{{ route('user.transactions') }}">
                                            @lang('TRANSACTION LOG')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ menuActive('user.campaign.donation.received') }}" 
                                           href="{{ route('user.campaign.donation.received') }}">
                                            @lang('RECEIVED DONATIONS')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ menuActive('user.campaign.donation.given') }}" 
                                           href="{{ route('user.campaign.donation.given') }}">
                                            @lang('GIVEN DONATIONS')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.logout') }}">
                                            @lang('LOGOUT')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            {{-- Common Menu Items for Authenticated Users --}}
                            @foreach($pages as $page)
                                <li>
                                    <a 
                                        href="{{ route('pages', [$page->slug]) }}" 
                                        class="menu-item {{ $page->slug == 'donate-monthly' ? 'btn donate-monthly' : '' }}"
                                        >
                                        {{ __($page->name) }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    <div class="nav-right">
                        <a class="btn cmn-btn" href="{{ route('user.campaign.fundrise.create') }}">
                            @lang('START A CAMPAIGN')
                        </a>
                    </div>
                @else
                    {{-- Guest User Menu --}}
                    <ul class="navbar-nav main-menu ms-2 me-auto">
                        <li><a href="/campaign/all" class="menu-item px-4">DISCOVER CAMPAIGNS</a></li>
                        
                        @if($isHomepage)
                            {{-- Homepage Specific Menu --}}
                            <li><a href="/about" class="menu-item">ABOUT US</a></li>
                            <li>
                                <a href="/donate-monthly" class="menu-item btn donate-monthly" >
                                    DONATE MONTHLY
                                </a>
                            </li>
                            <li><a href="/user/login" class="menu-item">START A CAMPAIGN</a></li>
                        @else
                            {{-- Common Menu Items for Guests --}}
                            @foreach($pages as $page)
                                <li>
                                    <a 
                                        href="{{ route('pages', [$page->slug]) }}" 
                                        class="menu-item {{ $page->slug == 'donate-monthly' ? 'btn donate-monthly' : '' }}">
                                        {{ __($page->name) }}
                                    </a>
                                </li>
                            @endforeach
                            <li><a href="/user/login" class="menu-item">START A CAMPAIGN</a></li>
                        @endif
                    </ul>

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