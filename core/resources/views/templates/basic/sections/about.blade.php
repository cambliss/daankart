
@php
    $storyContent = getContent('story.content', true);
    $stories = getContent('story.element', null, false, true);
@endphp

@php
    $about = getContent('about.content', 'true');
    $aboutElement = getContent('about.element', false);
@endphp
<!-- about section start -->
<section class="pb-120 about-section">
    <div class="banner-container">
           <img src="{{ asset('assets/images/frontend/about_banner/about_banner.jpg') }}" alt="explore_campaign" class="banner-image">
       </div>
    <div class="container">
        <div class="row about-details">
            <div class="col-lg-6">
                <div class="about-thumb pe-lg-2">
                    <div class="thumb-one wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                        <img class="w-100 border--radius"
                            src="{{ frontendImage('about', @$about->data_values->image, '600x360') }}"
                            alt="@lang('image')">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-lg-0 mt-5 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.7s">
                <div class="section-content ps-lg-4">
                    <h2>{{ __(@$about->data_values->heading) }}</h2>
                    <p><?php echo @$about->data_values->description; ?></p>
                    <div class="btn-group justify-content-start mb-0">
                        <a class="cmn-btn mb-0"
                            href="{{ @$about->data_values->button_url }} ">{{ __(@$about->data_values->button_name) }}</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@push('style')
    <style>
    .banner-container {
        padding-bottom: 120px;
        padding-top: 120px;
        width: 100%; /* Full width */
          height: 380px; /* Adjust height as needed */
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
    }
    
    .about-details{
        padding-top:50px;
    }
    </style>
@endpush    