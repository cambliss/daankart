@php
    $content = getContent('cta.content', true);
@endphp
{{-- <section class="pt-120 pb-120 position-relative bg_img overlay-one"
    data-background="{{ frontendImage('cta', @$content->data_values->image, '730x465') }}">
    <!--<div class="bottom-shape"><img src="{{ asset($activeTemplateTrue . 'images/top-shape.png') }}" alt="@lang('image')">-->
    <!--</div>-->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center pb-90">
                <h2 class="text-white">{{ __(@$content->data_values->heading) }}</h2>
                <p class="text-white">{{ __(@$content->data_values->subheading) }}</p>
                <a class="cmn-btn my-5"
                    href="{{ @$content->data_values->button_url }}">{{ __(@$content->data_values->button_title) }}</a>
            </div>
        </div>
    </div>
</section> --}}

<section class="pt-120 pb-120 container volunter-video">
    <div class="text-center d-flex justify-content-center align-items-center m-3 position-relative">
        <video width="100%" height="100%" muted autoplay playsinline class="rounded" loop >
            <source src="/assets/videos/volunteer_bannar_for_daankart.mp4"  type="video/mp4">
        </video>
        <a class="position-absolute top-0 bottom-0 start-0 end-0" href="/volunteer/join-as/volunteer " ></a>
    </div>
</section>


@push('style')
    <style>
        @media(max-width:420px){
        .volunter-video {
            padding-top: 10px;
            padding-bottom: 25px;
            }
        }
    </style>
@endpush  