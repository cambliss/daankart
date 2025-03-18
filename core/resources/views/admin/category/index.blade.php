@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Campaigns')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>
                                            <div class="user thumb">
                                                <div class="thumb w-100">
                                                    <img
                                                        src="{{ getImage(getFilePath('category') . '/' . @$category->image, getFileSize('category')) }}">
                                                    <span> {{ $category->name }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span> @lang('Total'): {{ @$category->campaigns_count }}
                                            </span>
                                            <br>
                                            <span class="badge badge--success">@lang('Running')
                                                {{ @$category->active_campaigns_count }}</span>
                                        </td>

                                        <td> @php echo $category->statusBadge @endphp </td>
                                        <td>
                                            <div class="button--group">
                                                @php $category->image_with_path = getImage(getFilePath('category').'/'.$category->image ,getFileSize('category')); @endphp
                                                <button class="btn btn-sm btn-outline--primary editBtn cuModalBtn"
                                                    data-resource="{{ $category }}" data-modal_title="@lang('Edit Category')"
                                                    data-has_status="1" type="button">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </button>
                                                @if ($category->status == Status::DISABLE)
                                                    <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                        data-action="{{ route('admin.category.status', $category->id) }}"
                                                        data-question="@lang('Are you sure to enable this category')?" type="button">
                                                        <i class="la la-eye"></i> @lang('Enabled')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                        data-action="{{ route('admin.category.status', $category->id) }}"
                                                        data-question="@lang('Are you sure to disable this category')?" type="button">
                                                        <i class="la la-eye-slash"></i> @lang('Disabled')
                                                    </button>
                                                @endif
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
                @if ($categories->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($categories) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>

    <!--Cu Modal -->
    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input class="form-control" name="name" type="text" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Image')</label>
                            <x-image-uploader class="w-100" id="uploadLogo" name="image" type="category"
                                :required="false" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
    <button class="btn btn-sm btn-outline--primary cuModalBtn"
        data-image_path="{{ getImage(getFilePath('category'), getFileSize('category')) }}"
        data-modal_title="@lang('Add New Category')" type="button">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush
