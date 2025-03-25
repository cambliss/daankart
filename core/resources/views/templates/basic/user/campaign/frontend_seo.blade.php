@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="pt-80 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 p-lg-5 p-md-4">
                    <div class="card custom--card">
                        <div class="card-body">
                            <form class="disableSubmission" method="POST" action="{{ route('user.campaign.fundrise.update.seo', $data->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <label>@lang('SEO Image')</label>
                                            <div class="profile-thumb-wrapper">
                                                <div class="profile-thumb justify-content-center">
                                                    <div class="avatar-preview">
                                                        <div class="profilePicPreview" style="background-image: url('{{ frontendImage('campaign', @$data->seo_content->image, getFileSize('seo'), true) }}');">
                                                        </div>
                                                        <div class="avatar-edit">
                                                            <input class="profilePicUpload" id="profilePicUpload1" name="image" type='file' accept=".png, .jpg, .jpeg" />
                                                            <label class="btn btn--upload mb-0" for="profilePicUpload1"><i class="la la-camera"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-8 mt-xl-0 mt-4">
                                        <div class="form-group select2-parent position-relative">
                                            <label>@lang('Meta Keywords')</label>
                                            <small class="ms-2 mt-2  ">@lang('Separate multiple keywords by') <code>,</code>(@lang('comma')) @lang('or') <code>@lang('enter')</code> @lang('key')</small>
                                            <select class="form-control select2-auto-tokenize" name="keywords[]" multiple="multiple">
                                                @if (@$data->seo_content->keywords)
                                                    @foreach (@$data->seo_content->keywords as $option)
                                                        <option value="{{ $option }}" selected>{{ __($option) }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('Meta Description')</label>
                                            <textarea class="form-control" name="description" rows="3">{{ @$data->seo_content->description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('Social Title')</label>
                                            <input class="form-control" name="social_title" type="text" value="{{ @$data->seo_content->social_title }}" />
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('Social Description')</label>
                                            <textarea class="form-control" name="social_description" rows="3">{{ @$data->seo_content->social_description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn cmn-btn w-100" type="submit">@lang('Submit')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            $('.select2-auto-tokenize').select2({
                dropdownParent: $('.select2-parent'),
                tags: true,
                tokenSeparators: [',']
            });

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

            $(".remove-image").on('click', function() {
                $(".profilePicPreview").css('background-image', 'none');
                $(".profilePicPreview").removeClass('has-image');
            })
        })(jQuery);
    </script>
@endpush
