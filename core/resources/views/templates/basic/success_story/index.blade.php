@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pt-90 pb-120">
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="filter_in_btn d-xl-none mb-4 d-flex justify-content-end">
                        <a href="javascript:void(0)"><i class="las la-filter"></i></a>
                    </div>
                    <div class="row gy-4">
                        <div class="col-xl-3">
                            <aside class="category-sidebar">
                                <div class="widget d-xl-none filter-top">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="title border-0 pb-0 mb-0">@lang('Filter')</h5>
                                        <div class="close-sidebar"><i class="las la-times"></i></div>
                                    </div>
                                </div>
                                <div class="widget p-0">
                                    <div class="widget-body">
                                        <form class="search-form" method="GET"
                                            action="{{ route('success.story.archive') }}">
                                            <div class="input-group">
                                                <input class="form-control" name="search" type="text"
                                                    value="{{ request()->search }}" placeholder="@lang('Search by Title')...">
                                                <button class="input-group-text " type="submit"><i
                                                        class="las la-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="widget p-0">
                                    <h5 class="widget-title">@lang('Categories')</h5>
                                    <div class="widget-body">
                                        <ul class="categories__list mt-2">
                                            <li class="categories__item">
                                                <a href="{{ route('success.story.archive') }}">@lang('All')</a>
                                            </li>
                                            @foreach (@$categories as $category)
                                                <li
                                                    class="categories__item @if ($category->name == request()->category_id) active @endif">
                                                    <a href="{{ route('success.story.archive', ['slug' => $category->slug]) }}"
                                                        @if ($category->slug == request()->slug) class="active" @endif>{{ __($category->name) }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @if (!blank($archives))
                                    <div class="widget">
                                        <h5 class="widget-title">@lang('Archive')</h5>
                                        <div class="widget-body">
                                            <ul class="archive__list mt-2">
                                                @foreach ($archives as $archive)
                                                    <li class="archive__item"><a
                                                            class="@if ($archive->month == request()->month && $archive->year == request()->year) active @endif"
                                                            href="{{ route('success.story.archive', ['month' => $archive->month, 'year' => $archive->year]) }}">
                                                            {{ __($archive->month) }} {{ __($archive->year) }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div><!-- widget end -->
                                @endif
                            </aside>

                        </div>
                        <div class="col-xl-9">
                            <div class="row gy-4 justify-content-center">
                                @forelse($stories as $story)
                                    <div class="col-xxl-4 col-sm-6">
                                        @include($activeTemplate . 'partials.story')
                                    </div>
                                @empty
                                    <div class="col-md-12 mb-30">
                                        <div class="empty-story">
                                            @include($activeTemplate . 'partials.empty', [
                                                'message' => ucfirst(strtolower($pageTitle)) . ' not found!',
                                            ])
                                        </div>
                                    </div>
                                @endforelse
                            </div><!-- row end -->

                            @if ($stories->hasPages())
                                @php echo paginateLinks($stories) @endphp
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

@push('style')
    <style>
        .empty-story {
            width: 80%;
            margin: auto;
            text-align: center;
        }

        .empty-story h1 {
            font-size: 36px;
            color: #333;
        }

        .empty-story p {
            font-size: 24px;
            color: #666;
            margin-top: 20px;
        }

        .sidebar .widget+.widget {
            margin-top: unset !important;
        }
    </style>
@endpush
