<div class="sticky-profile-header">
    <div class="profile-details-tabs">
        <div>
            <a class="{{ menuActive('user.profile.setting') }} tab-menu" href="{{ route('user.profile.setting') }}"> <i class="las la-user-circle"></i>
                @lang('Basic Information')</a>
            <a class="{{ menuActive('user.change.password') }} tab-menu" href="{{ route('user.change.password') }}"> <i class="la la-lock"></i> @lang('Change Password')</a>
            <a class="{{ menuActive('user.twofactor') }} tab-menu" href="{{ route('user.twofactor') }}"> <i class="la la-key"></i> @lang('2FA Security')</a>
        </div>
        <div class="organization-wrapper">
            <a href="{{ route('user.profile.organization') }}"><i class="las la-ribbon"></i>
                @lang('Organizational Operation?')</a>
        </div>
    </div>
</div>
