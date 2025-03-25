<div class="blog-post has-link h-100">
    <a class="item-link" href="{{ route('success.story.details', ['slug' => $story->slug, 'id' => $story->id]) }}"></a>
    <div class="blog-post__thumb">
        <img class="w-100" src="{{ getImage(getFilePath('success') . '/' . $story->image) }}" alt="@lang('image')">
    </div>
    <div class="blog-post__content">
        <ul class="blog-post__meta mb-3">
            <li>
                <i class="las la-calendar-day"></i>
                <small>{{ showDateTime($story->created_at, 'Y-m-d') }}</small>
            </li>
        </ul>
        <h4 class="blog-post__title fw-bold">@php echo __(strLimit($story->title,30)) @endphp</h4>
        @php echo strLimit(@$story->description, 80) @endphp
        <span class="blog_link d-block mt-2">@lang('See More') <i class="las la-arrow-right"></i></span>
    </div>
</div>
