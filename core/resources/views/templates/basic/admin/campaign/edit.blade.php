@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="pt-90 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 p-md-4">
                    <div class="card custom--card">
                        <div class="card-body">

                            <form class="action-form" action="{{ route('user.campaign.fundrise.store', $campaign->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Category')</label>
                                            <div class="input-group flex-nowrap">
                                                <span class="input-group-text"><i class="las la-layer-group"></i></span>
                                                <select class="form-control form--control select2" name="category_id" required>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" @selected($campaign->category_id == $category->id)>
                                                            {{ __($category->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">@lang('Title')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                                <input class="form-control" name="title" type="text" value="{{ old('title', $campaign->title) }}" required>
                                            </div>
                                        </div><!-- form-group end -->

                                        <div class="form-group">
                                            <div class="alert alert-primary d-flex align-items-center mt-1" role="alert">
                                                <i class="las la-info-circle"></i> {{ __('You will get :percentage of total raised', ['percentage' => 100 - @gs('raised_charge') . '%']) }}
                                            </div>
                                            <labe class="form-label"l>@lang('Goal Amount')</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                                    <input class="form-control" name="goal" type="number" value="{{ $campaign->goal }}" step="any" required placeholder="@lang('Your goal')">
                                                </div>
                                        </div>

                                        <div class="form-group decide-deadline">
                                            <label class="form-label">@lang('Decide how you want to complete your campaign?')</label>
                                            <div class="form-check">
                                                <input class="form-check-input" id="after_goal" name="goal_type" type="radio" value="1" @if ($campaign->goal_type == Status::GOAL_ACHIEVE) checked @endif>
                                                <label class="form-check-label" for="after_goal">
                                                    @lang('After Goal Achieve')
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="after_deadline" name="goal_type" type="radio" value="2" @if ($campaign->goal_type == Status::AFTER_DEADLINE) checked @endif>
                                                <label class="form-check-label" for="after_deadline">
                                                    @lang('After Deadline')
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="continuous" name="goal_type" type="radio" value="3" @if ($campaign->goal_type == Status::CONTINUOUS) checked @endif>
                                                <label class="form-check-label" for="continuous">
                                                    @lang('Continuous')
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group deadline-wrapper @if ($campaign->goal_type != Status::AFTER_DEADLINE) d-none @endif">
                                            <label class="form-label">@lang('Deadline')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                <input class="datepicker-here form-control" name="deadline" data-language="en" data-position='bottom left' type="text" value="{{ old('deadline', $campaign->goal_type == Status::AFTER_DEADLINE ? showDateTime($campaign->deadline, 'Y/m/d') : '') }}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">@lang('Description')<span class="text-danger">*</span></label>
                                            <textarea class="form-control  nicEdit" name="description" rows="8">{{ old('description', $campaign->description) }}</textarea>
                                            <small>@lang('It can be long text and describe why the campaign was created').</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-warning" role="alert">
                                            <i class="las la-exclamation-circle"></i> @lang('Here you can change/replace campaign poster image and documents'). &#8595;
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Poster Image')</label>
                                            <div class="input-group mb-2">
                                                <span class="input-group-text"><i class="fas fa-images"></i></span>
                                                <input class="form-control" id="inputAttachments" name="image" type="file" accept="image/*" />
                                            </div>
                                            <small class="text-muted"> @lang('Supported Files:')
                                                <b>@lang('.png'), @lang('.jpg'), @lang('.jpeg')</b>
                                                @lang('Image will be resized into') <b>{{ getFileSize('campaign') }}</b> @lang('px')</b>
                                            </small>
                                        </div><!-- form-group end -->
                                    </div>

                                    <div class="document-file">
                                        <div class="document-file__input">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Relevant Images and Documents(.pdf)')</label>
                                                <input class="form-control mb-2" id="inputAttachments" name="attachments[]" type="file" accept=".jpg, .jpeg, .png, .pdf" />
                                            </div><!-- form-group end -->
                                        </div>
                                        <button class="btn cmn-btn add-new" type="button">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <div id="fileUploadsContainer"></div>
                                        <small class="text-muted"> @lang('Supported Files:')
                                            <b>@lang('.png'), @lang('.jpg'), @lang('.pdf')</b>
                                            @lang('Image will be resized into') <b>{{ getFileSize('proof') }}</b> @lang('px')</b>
                                        </small>
                                    </div>

                                    <div class="form-group">
                                        <div class="faq-wrapper">
                                            <h6 class="text-underline">@lang('Campaign FAQs'):</h6>
                                            <div class="row gx-5 gy-4">
                                                @foreach ($campaign->faqs->question ?? [] as $key => $faq)
                                                    <div class="col-lg-6 mb-3 ">
                                                        <div class="form-group">
                                                            <label class="form-label">@lang('Question')</label>
                                                            <input class="form-control" name="question[]" type="text" value="{{ $campaign->faqs->question[$key] }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">@lang('Answer')</label>
                                                            <textarea class="form-control" name="answer[]" required>{{ $campaign->faqs->answer[$key] }}</textarea>
                                                        </div>
                                                        <button class="btn btn--danger remove-btn w-100" type="button" disabled><i class="las la-trash"></i> @lang('Remove')</button>
                                                    </div>
                                                @endforeach
                                                <div class="col-lg-6 addFaqArea">
                                                    <div class="add-new-faq addNewFAQ my-3">
                                                        <div class="add-new-faq-box">
                                                            <i class="las la-plus-circle"></i>
                                                            <p>@lang('Add New')</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="privet-message form--check" for="donor_visibility">
                                            <span class="custom--check">
                                                <input class="form-check-input" id="donor_visibility" name="donor_visibility" type="checkbox" @if ($campaign->donor_visibility == Status::YES) checked @endif>
                                            </span>
                                            <p class="form-check-label"><i class="las la-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('By default donor list showed on campaign explore page.')"></i> <small>@lang(' If You prefer to hide your donor list publicly, Please uncheck this box.')</small></p>
                                        </label>
                                    </div>
                                </div>
                                <button class="btn cmn-btn w-100" type="submit" type="submit">@lang('Update')</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 pl-md-5">
                    <div class="card custom--card">
                        <div class="card-body">
                            <h3>@lang('Current Poster Image')</h3>

                            <img src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}">

                            <h3 class="mt-4"> @lang('Current Attachements') </h3>
                            <ul class="nav nav-tabs nav-tabs--style" id="myTab" role="tablist">
                                <li class="nav-item " role="presentation">
                                    <a class="nav-link active" id="gallery-tab" data-bs-toggle="tab" href="#gallery" role="tab" aria-controls="gallery" aria-selected="false">@lang('Proof Images')</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="video-tab" data-bs-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">@lang('Proof Document')</a>
                                </li>
                            </ul>

                            @php
                                $foundImg = false;
                                $foundPdf = false;
                            @endphp
                            <div class="tab-content mt-4" id="myTabContent">
                                <div class="tab-pane fade show active" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                                    <div class="row gy-4">
                                        @foreach ($campaign->proof_images as $image)
                                            @if (explode('.', $image)[1] != 'pdf')
                                                @php
                                                    $foundImg = true;
                                                @endphp
                                                <div class="col-lg-4 col-sm-6 mb-30">
                                                    <div class="gallery-card">
                                                        <a class="view-btn" data-rel="lightcase:myCollection:slideshow" href="{{ getImage(getFilePath('proof') . '/' . $image) }}"><i
                                                               class="las la-plus"></i></a>
                                                        <div class="gallery-card__thumb">
                                                            <img src="{{ getImage(getFilePath('proof') . '/' . $image) }}" alt="image">
                                                        </div>
                                                    </div><!-- gallery-card end -->
                                                </div>
                                            @endif
                                        @endforeach

                                        @if (!$foundImg)
                                            @include($activeTemplate . 'partials.empty', ['message' => 'Gallery image not found!'])
                                        @endif
                                    </div>
                                </div><!-- tab-pane end -->
                                <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab">
                                    @foreach ($campaign->proof_images as $proof)
                                        @if (explode('.', $proof)[1] == 'pdf')
                                            @php
                                                $foundPdf = true;
                                            @endphp
                                            <iframe class="iframe" src="{{ getImage(getFilePath('proof') . '/' . $proof) }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture, pdf" allowfullscreen></iframe>
                                        @endif
                                    @endforeach
                                    @if (!$foundPdf)
                                        @include($activeTemplate . 'partials.empty', ['message' => 'Document not found!'])
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush
@push('script-lib')
<script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/datepicker.min.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/datepicker.en.js') }}"></script>
<script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush


@push('style')
    <style>
        .decide-deadline {
            margin: 0;
        }

        .select2-container--default .select2-selection--single {
            border: 0 !important;
        }

    </style>
@endpush

@push('script')
    <script>
        'use strict';

        $(".add-new").on('click', function() {
            $("#fileUploadsContainer").append(` <div class="input-group mb-2">
                <input type="file" name="attachments[]" id="inputAttachments" class="form-control" accept=".jpg, .jpeg, .png, .pdf" required/>
                        <button type="button" class="input-group-text btn--danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `);
        })

        $(document).on('click', '.remove-btn', function() {
            $(this).closest('.input-group').remove();
        });

        //nicEdit
        $(".nicEdit").each(function(index) {
            $(this).attr("id", "nicEditor" + index);
            new nicEditor({
                fullPanel: true
            }).panelInstance('nicEditor' + index, {
                hasPanel: true
            });
        });

        (function($) {
            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });
        })(jQuery);

        //date-validation

        if (`{{ @$campaign->goal_type == 2 }}`) {
            $(document).on('click', 'form button[type=submit]', function(e) {
                if (new Date($('.datepicker-here').val()) == "Invalid Date") {
                    notify('error', 'Invalid deadline');
                    return false;
                }
            });
        }

        //Faq-added//
        disableRemoveFaq();

        $('.addNewFAQ').on('click', function() {
            $(".addFaqArea").before(`
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label">@lang('Question')</label>
                        <input type="text" name="question[]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Answer')</label>
                        <textarea name="answer[]" class="form-control"></textarea>
                    </div>
                    <button type="button" class="btn btn--danger remove-btn w-100"><i class="las la-trash"></i> @lang('Remove')</button>
            </div>
                `)
            disableRemoveFaq()
        });
        $(document).on('click', '.remove-btn', function() {
            $(this).closest('div').remove();
            disableRemoveFaq()
        });


        function disableRemoveFaq() {
            if ($(document).find('.remove-btn').length == 1) {
                $(document).find('.remove-btn').attr('disabled', true);
            } else {
                $(document).find('.remove-btn').removeAttr('disabled');
            }
        }

        // deadline-wrapper
        $("[name='goal_type']").on('click', function() {
            if ($(this).val() == 2) {
                $('.deadline-wrapper').removeClass('d-none');
            } else {
                $('.deadline-wrapper').addClass('d-none');
            }
        })
        // deadline-wrapper End

        //Start tooltip//
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
            //end tooltip//
        });

        
    </script>
@endpush

@push('style')
    <style>
        .iframe {
            width: 100%;
            height: 500px;
        }

        .add-new {
            margin-top: 31px !important;
        }
    </style>
@endpush
