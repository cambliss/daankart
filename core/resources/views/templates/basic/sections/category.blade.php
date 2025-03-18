@php
    $content = getContent('category.content', true);
    $categories = App\Models\Category::active()
        ->orderByDesc('id')
        ->withCount([
            'campaigns' => function ($query) {
                $query->active()->running()->boundary();
            },
        ])
        ->get();
@endphp
<section>
    <div class="banner-slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section-header mb-2">
                        <h2 class="section-title">{{ __(@$content->data_values->heading) }}</h2>
                    </div>
                </div>
            </div>
            <div class="justify-content-center">
                <div class="responsive">
                    @foreach ($categories as $category)
                        <div class="category-card has-link hover--effect-1 js-tilt {{ $loop->iteration % 3 == 0 ? 'overlay--three' : ($loop->odd ? 'overlay--one' : 'overlay--two') }}"
                            data-tilt-perspective="300" data-tilt-speed="400" data-tilt-max="25">
                            <a class="item-link" href="{{ route('campaign.index', ['slug' => $category->slug]) }}"></a>
                            <div class="category-card__thumb">
                                <img class="w-100 __abc"
                                    src="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}"
                                    alt="{{ __($category->name) }}">
                            </div>
                            <div class="category-card__content">
                                <h4 class="title text-white">{{ __($category->name) }}@if ($category->campaigns_count)
                                        ({{ $category->campaigns_count }})
                                    @endif
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
