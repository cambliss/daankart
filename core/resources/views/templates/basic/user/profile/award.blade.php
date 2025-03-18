@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    @include($activeTemplate . 'partials.organizational_header')
                    <div class="d-flex justify-content-between align-items-center  p-4">
                        <h5>
                            @lang('Organization'):
                            @if ($org)
                                {{ __(@$org->name) }}
                            @else
                                @lang('Organization')
                            @endif
                        </h5>
                        <button class="btn btn-sm cmn-btn awardModalBtn" data-modal_title="@lang('Add New Award')">
                            <i class="las la-plus"></i>@lang('New')
                        </button>
                    </div>
                    <div class="card custom--card">
                        <div class="card-body">
                            @if (!blank($awards))
                                <div class="table-responsive--md table-responsive">
                                    <table class="table table--responsive--md">
                                        <thead>
                                            <tr>
                                                <th>@lang('Image')</th>
                                                <th>@lang('Title')</th>
                                                <th>@lang('Contribution')</th>
                                                <th>@lang('Institute')</th>
                                                <th class="dp-action">@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($awards as $award)
                                                <tr>
                                                    <td>
                                                        <div class="avatar">
                                                            <img class="avatar__img"
                                                                src="{{ getImage(getFilePath('orgAward') . '/' . @$award->image, getFileSize('orgAward')) }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ strLimit(__($award->title), 50) }}
                                                    </td>
                                                    <td>
                                                        {{ strLimit(__($award->contribution), 60) }}
                                                    </td>
                                                    <td>
                                                        {{ __($award->institute) }}
                                                    </td>
                                                    @php
                                                        $award->image_with_path = getImage(
                                                            getFilePath('orgAward') . '/' . $award->image,
                                                            getFileSize('orgAward'),
                                                        );
                                                    @endphp
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="action-group-link" data-bs-toggle="dropdown"
                                                                href="#">
                                                                <i class="las la-ellipsis-v"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown--menu px-2">
                                                                <li>
                                                                    <button class="dropdown-item awardModalBtn"
                                                                        data-modal_title="@lang('Update Award')"
                                                                        data-resource="{{ $award }}">
                                                                        <i class="las la-pen"></i> @lang('Edit')
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item deleteBtn"
                                                                        data-action="{{ route('user.org.award.delete', $award->id) }}">
                                                                        <i class="las la-trash"></i> @lang('Delete')
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if ($awards->hasPages())
                                    <div class="pt-3">
                                        {{ paginateLinks($awards) }}
                                    </div>
                                @endif
                            @else
                                @include($activeTemplate . 'partials.empty', [
                                    'message' => 'No rewarded Yet!',
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $awardImage = getImage(getFilePath('orgAward'), getFileSize('orgAward'));
        @endphp

        <div class="modal" id="awardModal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="{{ route('user.org.award') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 modal-title"></h5>
                                <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                            </div>

                            <div class="form-group mt-4">
                                <label class="form-label">@lang('Award Photo')</label>
                                <div class="profile-thumb-wrapper">
                                    <div class="profile-thumb justify-content-center">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview"
                                                style="background-image: url({{ $awardImage }});">
                                            </div>
                                            <div class="avatar-edit">
                                                <input class="profilePicUpload" id="profilePicUpload1" name="image"
                                                    type='file' accept=".png, .jpg, .jpeg" />
                                                <label class="btn btn--upload mb-0" for="profilePicUpload1"><i
                                                        class="la la-camera"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('Title')</label>
                                <input class="form-control form--control" name="title" type="text" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Contribution')</label>
                                <textarea class="form-control form--control" name="contribution" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Awarded By')</label>
                                <input class="form-control form--control" name="institute" type="text" required>
                            </div>
                            <div class="text-end">
                                <button class="btn cmn-btn" type="submit">@lang('Submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="confirmDeleteModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0"> <i class="las la-trash text--danger"></i> @lang('Confirmation Alert!')</h5>
                                <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                            </div>
                            <p class="py-2"><small>@lang('Are you certain about deleting this award? Once confirmed, this action can\'t be undone!')</small></p>
                            <div class="text-end">
                                <button class="btn btn-sm btn--dark" data-bs-dismiss="modal"
                                    type="button">@lang('No')</button>
                                <button class="btn btn-sm cmn-btn deleteBtn" type="submit">@lang('Yes')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .table-responsive {
            min-height: 250px;
            background: transparent
        }

        .custom--card .card-body {
            padding: .5rem;
        }

        .avatar {
            width: 35px;
            height: 35px;
        }

        .avatar-preview .profilePicPreview {
            border-radius: 5px !important;
        }

        .custom--card .card-header {
            border-bottom: transparent;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            //delete-modal
            $(document).on('click', '.deleteBtn', function() {
                let action = $(this).data('action');
                var modal = $("#confirmDeleteModal");
                let form = modal.find("form");
                form.attr('action', action);
                modal.modal('show');
            });

            //update
            let awardModal = $("#awardModal");
            let form = awardModal.find("form");
            const action = form[0] ? form[0].action : null;
            $(document).on("click", ".awardModalBtn", function() {
                let data = $(this).data();
                let resource = data.resource ?? null;
                awardModal.find(".modal-title").text(`${data.modal_title}`);

                if (!resource) {
                    form[0].reset();
                    form[0].action = `${action}`;
                }
                if (resource) {
                    form[0].action = `${action}/${resource.id}`;
                    // If form has image
                    if (resource.image_with_path) {
                        awardModal
                            .find(".profilePicPreview")
                            .css("background-image", `url(${resource.image_with_path})`);
                    }
                    awardModal.find("[name='title']").val(resource.title);
                    awardModal.find("[name='institute']").val(resource.institute);
                    awardModal.find("[name='contribution']").val(resource.contribution);
                }
                awardModal.modal("show");
            });


            //image preview
            function proPicURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var preview = $(input).parents('.profile-thumb').find('.profilePicPreview');
                        $(preview).css('background-image', 'url(' + e.target.result + ')');
                        $(preview).addClass('has-image');
                        $(preview).hide();
                        $(preview).fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(".profilePicUpload").on('change', function() {
                proPicURL(this);
            });

            $('#awardModal').on('hidden.bs.modal', function() {
                $(this).find('.profilePicPreview').css('background-image', `url('{{ $awardImage }}')`)
            })


        })(jQuery);
    </script>
@endpush
