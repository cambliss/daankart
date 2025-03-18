@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    @include($activeTemplate . 'partials.organizational_header')

                    <div class="d-flex justify-content-between align-content-center p-4">
                        <h5>
                            @lang('Organization'):
                            @if ($org)
                                {{ __($org->name) }}
                            @endif
                        </h5>
                        <button class="btn btn-sm cmn-btn updateModalBtn" data-modal_title="@lang('New Update')">
                            <i class="las la-plus"></i>@lang('New Update')
                        </button>
                    </div>

                    <div class="card custom--card">
                        <div class="card-body">
                            @if (!blank($updates))
                                <div class="table-responsive--md table-responsive">
                                    <table class="table table--responsive--md">
                                        <thead>
                                            <tr>
                                                <th>@lang('S.N.')</th>
                                                <th>@lang('Updated at')</th>
                                                <th>@lang('Details')</th>
                                                <th class="dp-action">@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($updates as $update)
                                                <tr>

                                                    <td>
                                                        {{ $updates->firstItem() + $loop->index }}
                                                    </td>
                                                    <td>
                                                        {{ showDateTime($update->date, 'Y,F d') }}
                                                    </td>
                                                    <td>
                                                        {{ strLimit(__($update->updation), 50) }}
                                                    </td>

                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="action-group-link" data-bs-toggle="dropdown"
                                                                href="#">
                                                                <i class="las la-ellipsis-v"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown--menu px-2">
                                                                <li>
                                                                    <button class="dropdown-item updateModalBtn"
                                                                        data-modal_title="@lang('Edit Updation')"
                                                                        data-resource="{{ $update }}">
                                                                        <i class="las la-pen"></i> @lang('Edit')
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item deleteBtn"
                                                                        data-action="{{ route('user.org.update.delete', $update->id) }}">
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
                                @if ($updates->hasPages())
                                    <div class="pt-3">
                                        {{ paginateLinks($updates) }}
                                    </div>
                                @endif
                            @else
                                @include($activeTemplate . 'partials.empty', [
                                    'message' => 'updation not found!',
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="updateModal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="{{ route('user.org.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 modal-title"></h5>
                                <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Update at')</label>
                                <input class="datepicker-here form-control" name="date" data-range="true"
                                    data-language="en" data-position='bottom left' type="text"
                                    value="{{ old('date') }}" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Updation')</label>
                                <textarea class="form-control form--control" name="updation" required></textarea>
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
                            <p class="py-2"><small>@lang('Are you certain about deleting this updation? Once confirmed, this action can\'t be undone!')</small></p>
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

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/datepicker.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/datepicker.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/datepicker.en.js') }}"></script>
@endpush

@push('style')
    <style>
        .datepicker {
            z-index: 9999
        }

        .table-responsive {
            min-height: 250px;
            background: transparent
        }

        .custom--card .card-body {
            padding: .5rem;
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

            $('.datepicker-here').on('keyup keypress keydown input', function() {
                return false;
            });
            $('.datepicker-here').datepicker({
                minDate: new Date()
            })


            //delete-modal
            $(document).on('click', '.deleteBtn', function() {
                let action = $(this).data('action');
                var modal = $("#confirmDeleteModal");
                let form = modal.find("form");
                form.attr('action', action);
                modal.modal('show');
            });

            //update
            let updateModal = $("#updateModal");
            let form = updateModal.find("form");
            const action = form[0] ? form[0].action : null;
            $(document).on("click", ".updateModalBtn", function() {
                let data = $(this).data();
                let resource = data.resource ?? null;
                updateModal.find(".modal-title").text(`${data.modal_title}`);

                if (!resource) {
                    form[0].reset();
                    form[0].action = `${action}`;
                }
                if (resource) {
                    form[0].action = `${action}/${resource.id}`;
                    updateModal.find("[name='date']").val(resource.date);
                    updateModal.find("[name='updation']").val(resource.updation);
                }
                updateModal.modal("show");
            });

        })(jQuery);
    </script>
@endpush
