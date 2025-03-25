@php
    $content = getContent('faq.content', true);
    $faqElements = getContent('faq.element', false, null, true);
@endphp
<section class="pt-90 pb-120" data-background="{{ getImage($activeTemplateTrue . 'images/faq.jpg') }}">
    <div class="container">
        <div class="row gy-sm-5 gy-4">
            <div class="section-header">
                <h5 class="section-title">{{ __(@$content->data_values->title) }}</h5>
            </div>
            @foreach ($faqElements as $item)
                <div class="col-md-12 {{ $loop->iteration % 2 == 0 ? 'even-class' : 'odd-class' }}">
                    <div class="faq-item">
                        <div class="faq-item__icon"><i class="fas fa-question"></i></div>
                        <div class="faq-item__content">
                            <h5 class="faq-item__title">{{ __(@$item->data_values->question) }}</h5>
                            <p class="faq-item__desc">{{ __(@$item->data_values->answer) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
