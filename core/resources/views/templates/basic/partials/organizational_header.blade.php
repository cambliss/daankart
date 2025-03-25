<div class="sticky-profile-header">
    <div class="profile-details-tabs">
        <div>
            <a class="{{ menuActive('user.profile.organization') }} tab-menu" href="{{ route('user.profile.organization') }}"> <i class="las la-gopuram"></i>
                @lang('Organization Information')</a>
            <a class="{{ menuActive('user.org.award') }} tab-menu" href="{{ route('user.org.award') }}"> <i class="las la-award"></i> @lang('Award')</a>
            <a class="{{ menuActive('user.org.donor') }} tab-menu" href="{{ route('user.org.donor') }}"><i class="las la-user-tie"></i> @lang('Donor Wall')</a>
            <a class="{{ menuActive('user.org.update') }} tab-menu" href="{{ route('user.org.update') }}"><i class="lab la-ioxhost"></i> @lang('Update')</a>
        </div>
        <div class="organization-wrapper">
            <a href="{{ route('user.profile.setting') }}"><i class="las la-undo"></i>
                @lang('Back')</a>
        </div>
    </div>
</div>
