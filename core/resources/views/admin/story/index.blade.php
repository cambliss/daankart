@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card   ">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Story')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('created At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse(@$successStories as $story)
                                    <tr>
                                        <td>
                                            <div class="user thumb">
                                                <div class="thumb w-100">
                                                    <img src="{{ getImage(getFilePath('success') . '/' . $story->image, getFileSize('success')) }}" alt="@lang('Image')">
                                                    <span> {{ strLimit($story->title, 35) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ __(@$story->category->name) }}</td>
                                        <td>
                                            {{ showDateTime($story->created_at) }}
                                            <span class="d-block">{{ diffForHumans($story->created_at) }}</span>
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.success.story.seo', $story->id) }}" class="btn btn-sm btn-outline--info"><i class="la la-cog"></i> @lang('SEO Setting')</a>
                                        
                                                <a class="btn btn-sm btn-outline--info ms-1" href="{{ route('admin.success.story.detail', $story->id) }}">
                                                    <i class="la la-desktop"></i>@lang('Details')
                                                </a>
                                                <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.success.story.edit', $story->id) }}">
                                                    <i class="la la-pen"></i>@lang('Edit')
                                                </a>
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.success.story.delete', $story->id) }}" data-question="@lang('Are you sure to delete this success story?')" type="button">
                                                    <i class="la la-trash"></i>@lang('Delete')
                                                </button>

                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
                @if ($successStories->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($successStories) @endphp
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
    <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.success.story.create') }}"> <i
           class="las la-plus"></i>@lang('Add New')</a>
@endpush
