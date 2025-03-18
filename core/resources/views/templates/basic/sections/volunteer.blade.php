@php
    $volunteer = getContent('volunteer.content', true);
    $volunteers = App\Models\Volunteer::active()->orderBy('participated')->limit(4)->get();
@endphp

<section class="pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __(@$volunteer->data_values->heading) }}</h2>
                    <p>{{ __(@$volunteer->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        @include($activeTemplate . 'partials.volunteer')
    </div>
</section>
