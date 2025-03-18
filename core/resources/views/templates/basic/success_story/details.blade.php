@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <!-- blog-details-section start -->
    <section class="blog-details-section pt-90 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="blog-details-wrapper">
                        <div class="blog-details__thumb">
                            <img src="{{ getImage(getFilePath('success') . '/' . $story->image), getFileSize('success') }}"
                                alt="image">
                            <div class="post__date">
                                <span class="date">{{ showDateTime($story->created_at, 'd') }}</span>
                                <span class="month">{{ showDateTime($story->created_at, 'M') }}</span>
                            </div>
                            <div class="post__date_right">
                                <span class="date">@lang('View')</span>
                                <span class="month">{{ $story->view }}</span>
                            </div>
                        </div><!-- blog-details__thumb end -->
                        <div class="blog-details__content">
                            <h4 class="blog-details__title">{{ __($story->title) }}</h4>
                            <p class="text-justify show-read-more"> @php echo strip_tags($story->description) @endphp</p>
                        </div><!-- blog-details__content end -->
                        <div class="comments-area">
                            <h3 class="title">{{ $comments->count() }} @lang('comments')</h3>
                            <ul class="comments-list">
                                @forelse($comments as $comment)
                                    <li class="single-comment">
                                        <div class="single-comment__thumb">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="single-comment__content">
                                            <h6 class="name">{{ __($comment->reviewer) }}</h6>
                                            <small class="date">{{ diffForHumans($comment->created_at) }}</small>
                                            <p class="text-justify">{{ __($comment->comment) }}</p>
                                        </div>
                                    </li><!-- single-review end -->
                                @empty
                                    @include($activeTemplate . 'partials.empty', [
                                        'message' => 'No comment found!',
                                    ])
                                @endforelse
                            </ul>
                        </div><!-- comments-area end -->
                        <div class="comment-form-area">
                            <h3 class="title">@lang('Leave a Comment')</h3>
                            <form class="comment-form" action="{{ route('success.story.comment', $story->id) }}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <input class="form-control" id="comment-name" name="name" type="text"
                                            value="{{ old('name') }}" placeholder="@lang('Enter Your Name')" required>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <input class="form-control" id="comment-email" name="email" type="email"
                                            value="{{ old('email') }}" placeholder="@lang('Enter Email Address')" required>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <textarea class="form-control" id="message" name="comment" placeholder="@lang('Write Comment Here..')" required> {{ old('comment') }}</textarea>
                                        <code>@lang('Note: Characters remaining') <span id="limit">400</span> </code>
                                    </div>
                                    <div class="col-lg-12">
                                        <button class="cmn-btn w-100" type="submit">@lang('Submit')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="sidebar">
                        @if (!blank($recentStories))
                            <div class="widget p-0">
                                <h5 class="widget-title">@lang('Recent Stories')</h5>
                                <ul class="small-post-list widget-body">
                                    @foreach ($recentStories as $recent)
                                        <li class="small-post">
                                            <div class="small-post__thumb"><img class="border--radius"
                                                    src="{{ getImage(getFilePath('success') . '/' . $recent->image) }}"
                                                    alt="image"></div>
                                            <div class="small-post__content">
                                                <h5 class="post__title">
                                                    <a
                                                        href="{{ route('success.story.details', ['slug' => $recent->slug, 'id' => $recent->id]) }}">{{ strLimit($recent->title, 50) }}</a>
                                                </h5>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="widget p-0">
                            <h5 class="widget-title">@lang('Share The Story')</h5>
                            <div class="widget-body">
                                <div class="form-group copy-link">
                                    <input class="copyURL" class="form-control form--control" id="profile" name="profile"
                                        type="text" value="{{ url()->current() }}" readonly="">
                                    <span class="copy" data-id="profile">
                                        <i class="las la-copy"></i> <strong class="copyText">@lang('Copy')</strong>
                                    </span>
                                </div>
                                <ul class="social-links mt-2 d-flex justify-content-center">
                                    <li class="facebook"><a
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                            target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="twitter"><a
                                            href="https://twitter.com/intent/tweet?text={{ $story->title }} &amp;url={{ urlencode(url()->current()) }}"
                                            target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    <li class="linkedin"><a
                                            href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}"
                                            target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li class="whatsapp"><a href="https://wa.me/?text={{ urlencode(url()->current()) }}"
                                            target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                                    <li class="telegram"><a
                                            href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($story->title) }}"
                                            target="_blank"><i class="fab fa-telegram"></i></a></li>
                                    <li class="pinterest"><a
                                            href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode(getImage(getFilePath('success') . '/' . $story->image, getFileSize('success'))) }}&description={{ urlencode($story->description) }}"
                                            target="_blank"><i class="fab fa-pinterest"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            var maxLength = 400;
            $('#limit').text(maxLength);
            $('#message').keyup(function() {
                var currentLength = $(this).val().length;
                var remainingLength = maxLength - currentLength;
                $('#limit').text(remainingLength);
            });


        })(jQuery);
    </script>
@endpush
