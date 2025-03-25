<li><a class="{{ menuActive('about') }}" href="{{ url('/about') }}">@lang('ABOUT US')</a></li>
<li>
    <a href="{{ url('/donate-monthly') }}">
        @lang('DONATE MONTHLY')
    </a>
</li>

<li>
    <a class="{{ menuActive('campaign.*') }}" 
       href="{{ auth()->check() ? route('campaign.index') : route('user.login') }}">
       @lang('START A CAMPAIGN')
    </a>
</li>


