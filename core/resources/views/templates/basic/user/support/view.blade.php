@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
    <section class="pt-90 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card custom--card">
                        <div class="card-header card-header-bg d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="card-title ticket-title mt-1">
                                @php echo $myTicket->statusBadge; @endphp
                                [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                            </h5>
                            @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                                <button class="btn btn--danger close-button btn-sm confirmationBtn" data-question="@lang('Are you sure to close this ticket?')" data-action="{{ route('ticket.close', $myTicket->id) }}" type="button"><i class="fas fa-lg fa-times-circle"></i>
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <form class="disableSubmission" method="post" action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-between">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control form--control" name="message" rows="4" required>{{ old('message') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <button class="btn btn-dark btn-sm addAttachment my-2" type="button"> <i class="fas fa-plus"></i> @lang('Add Attachment') </button>
                                        <p class="mb-2"><span class="text--info">@lang('Max 5 files can be uploaded | Maximum upload size is ' . convertToReadableSize(ini_get('upload_max_filesize')) . ' | Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</span></p>
                                        <div class="row fileUploadsContainer">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn cmn-btn w-100 my-2" type="submit"><i class="la la-fw la-lg la-reply"></i> @lang('Reply')
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mt-4">
                        @foreach (@$messages as $message)
                            @if (@$message->admin_id == 0)
                                <div class="support-list">
                                    <div class="support-card">
                                        <div class="support-card__head">
                                            <h6 class="support-card__title">
                                                {{ $message->ticket->name }}
                                            </h6>
                                            <span class="support-card__date">
                                                <code class="text-muted">
                                                    <i class="far fa-clock"></i>
                                                    {{ showDateTime($message->created_at,'l, dS F Y @ h:i a') }}
                                                </code>
                                            </span>
                                        </div>
                                        <div class="support-card__body">
                                            <p class="support-card__body-text">
                                                {{ @$message->message }}
                                            </p>
                                            @if (@$message->attachments->count() > 0)
                                                <ul class="list list--row support-card__list">
                                                    @foreach (@$message->attachments as $k => $image)
                                                        <li>
                                                            <a class="support-card__file" href="{{ route('ticket.download', encrypt(@$image->id)) }}">
                                                                <span class="support-card__file-icon">
                                                                    <i class="fas fa-file-download"></i>
                                                                </span>
                                                                <span class="support-card__file-text">
                                                                    @lang('Attachment') {{ ++$k }}
                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="support-list">
                                    <div class="support-card support-card__admin">
                                        <div class="support-card__head support-card__head__admin">
                                            <h6 class="support-card__title">
                                                {{ @$message->admin->name }}
                                            </h6>
                                            <span class="support-card__date">
                                                <code class="text-muted">
                                                    <i class="far fa-clock"></i>
                                                    {{ showDateTime($message->created_at,'l, dS F Y @ h:i a') }}
                                                </code>
                                            </span>
                                        </div>
                                        <div class="support-card__body">
                                            <p class="support-card__body-text">
                                                {{ @$message->message }}
                                            </p>
                                            @if (@$message->attachments->count() > 0)
                                                <ul class="list list--row support-card__list">
                                                    @foreach (@$message->attachments as $k => $image)
                                                        <li>
                                                            <a class="support-card__file" href="{{ route('ticket.download', encrypt(@$image->id)) }}">
                                                                <span class="support-card__file-icon">
                                                                    <i class="fas fa-file-download"></i>
                                                                </span>
                                                                <span class="support-card__file-text">
                                                                    @lang('Attachment') {{ ++$k }}
                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <x-confirmation-modal />
    </section>
@endsection
@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }

        .reply-bg {
            background-color: #ffd96729
        }

        .empty-message img {
            width: 120px;
            margin-bottom: 15px;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addAttachment').on('click', function() {
                fileAdded++;
                if (fileAdded == 5) {
                    $(this).attr('disabled', true)
                }
                $(".fileUploadsContainer").append(`
                    <div class="col-lg-4 col-md-12 removeFileInput">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="file" name="attachments[]" class="form-control" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx" required>
                                <button type="button" class="input-group-text removeFile bg--danger border--danger"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                `)
            });
            $(document).on('click', '.removeFile', function() {
                $('.addAttachment').removeAttr('disabled', true)
                fileAdded--;
                $(this).closest('.removeFileInput').remove();
            });
        })(jQuery);
    </script>
@endpush
