
@php
    $about = getContent('about.content', 'true');
    $aboutElement = getContent('about.element', false);
@endphp
<!-- about section start -->

<section class="pt-120 pb-120 about-section">
    <div class="container">
        <div class="row">
            <!--<div class="col-lg-6">-->
            <!--    <div class="about-thumb pe-lg-2">-->
            <!--        <div class="thumb-one wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">-->
            <!--            <img class="w-100 border--radius"-->
            <!--                src="{{ frontendImage('about', @$about->data_values->image, '600x360') }}"-->
            <!--                alt="@lang('image')">-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

           

<div class="col-lg-12 mt-lg-0 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.7s">
    <div class="section-content ps-lg-4 text-center">
        <h2 class="mb-4">{{ __(@$about->data_values->heading) }}</h2>
        <div class="text-start mb-4">
            <p><?php echo @$about->data_values->description; ?></p>
        </div>
        <div class="btn-group justify-content-center mb-0">
            <a class="cmn-btn mb-0" href="{{ @$about->data_values->button_url }}">
                {{ __(@$about->data_values->button_name) }}
            </a>
        </div>
    </div>
</div>

    </div>
</section>
<!-- about section end -->
