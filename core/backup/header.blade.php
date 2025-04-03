@php
    $contact = getContent('contact_us.content', true);
    $pages = App\Models\Page::where('tempname', $activeTemplate)->where('is_default', Status::NO)->get();
    $routeName = Route::currentRouteName();
    $routePrefix = explode('.', $routeName)[0] ?? '';
    $isHomepage = request()->is('/');
@endphp
<style>
    .navbar-nav.main-menu>li:first-child>a {
        padding-left: 0px !important;
    }
</style>
<header class="header__bottom @if (request()->routeIs('profile.*')) header-for-profile @endif">
    <div class="container">
        <nav class="navbar navbar-expand-xl p-0 align-items-center">
            <a class="site-logo site-title" href="{{ url('/') }}">
                <img src="{{ siteLogo() }}" alt="site-logo">
                <span class="logo-icon"><i class="flaticon-fire"></i></span>
            </a>
            
            <button class="navbar-toggler ml-auto" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="las la-bars" style="color: #292f19;"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @auth
                    @if ($routePrefix != 'user' && !request()->routeIs('ticket.index'))
                        <ul class="navbar-nav main-menu ms-auto">
                            <li><a href="/campaign/all" class="menu-item px-2">DISCOVER CAMPAIGNS</a></li>
                            @include($activeTemplate . 'partials.common_menus')
                        </ul>
                    @else
                        {{-- Authenticated user menu --}}
                        @include($activeTemplate . 'partials.authenticated_menu')
                    @endif
                    
                    <div class="nav-right">
                        <a class="btn cmn-btn" href="{{ route('user.campaign.fundrise.create') }}">
                            @lang('START A CAMPAIGN')
                        </a>
                    </div>
                @else
                    {{-- Guest user menu --}}
                    @if ($isHomepage)
                        <ul class="navbar-nav main-menu ms-2 me-auto">
                            <li><a href="/about" class="menu-item">ABOUT</a></li>
                            <li><a href="/campaign/all" class="menu-item">DISCOVER CAMPAIGNS</a></li>
                            <li>
                                <a href="/donate-monthly" class="menu-item btn p-3 mt-1 text-white" 
                                   style="margin-left: -20px; background: linear-gradient(90deg, orange, red);color: white !important;">
                                    DONATE MONTHLY
                                </a>
                            </li>
                            <li><a href="https://daankart.com/user/login" class="menu-item">START A CAMPAIGN</a></li>
                        </ul>
                    @else
                        <ul class="navbar-nav main-menu ms-2 me-auto">
                            <li><a href="/campaign/all" class="menu-item px-2">DISCOVER CAMPAIGNS</a></li>
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
