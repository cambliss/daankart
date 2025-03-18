@php
    $storyContent = getContent('story.content', true);
    $stories = getContent('story.element', null, false, true);
@endphp
<!-- story section start -->
<section class="pt-120 pb-120">
    <div class="container insfirational-story">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __(@$storyContent->data_values->heading) }}</h2>
                    <p>{{ __(@$storyContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div><!-- row end -->

        <div class="row g-0 ">
            <div class="col-lg-6">
                <div class="story-thumb">
                    <div class="story-thumb-slider">
                        @foreach ($stories as $story)
                            <div class="single-slide">
                                <img src="{{ frontendImage('story', @$story->data_values->image, '730x465') }}"
                                    alt="@lang('image')">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-6 right position-relative bg--base text-center">
                <div class="section-img"><img src="{{ getImage($activeTemplateTrue . 'images/texture-3.jpg') }}"
                        alt="@lang('image')">
                </div>
                <div class="story-content">
                    <div class="story-slider">
                        @foreach ($stories as $story)
                            <div class="single-slide">
                                <h3 class="text-white mb-3">{{ __(@$story->data_values->title) }}</h3>
                                <p class="text-white"> @php echo strLimit(@$story->description, 80) @endphp</p>
                            </div>
                        @endforeach
                    </div><!-- story-slider end -->
                </div>
            </div>
        </div><!-- row end -->
    </div>
</section>
<!-- story section end -->
