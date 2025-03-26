<li><a class="{{ menuActive('about') }}" href="{{ url('/about') }}">@lang('ABOUT US')</a></li>
<li>
    <a 
        href="{{ url('/donate-monthly') }}" 
        class="menu-item btn p-3 mt-1 text-white" 
        style="margin-left: -20px; background: linear-gradient(90deg, orange, red);">
        DONATE MONTHLY
    </a>
</li>

<li>
    <a class="{{ menuActive('campaign.*') }}" 
       href="{{ auth()->check() ? route('campaign.index') : route('user.login') }}">
       @lang('START A CAMPAIGN')
    </a>
</li>


