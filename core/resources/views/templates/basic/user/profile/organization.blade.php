@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="pt-90 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    @include($activeTemplate . 'partials.organizational_header')

                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <p>@lang("Attention: Please submit your organization or NGO details if you're aiding the underprivileged or require crowdfunding support. This step is crucial for facilitating assistance. Thank you for your cooperation.")</p>
                            </div>
                            <form class="register" action="{{ route('user.profile.organization') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group border p-3">
                                    <div class="form-check">
                                        <input class="form-check-input" id="enableOrg" name="enable_org" type="checkbox"
                                            @if (@$org->user->enable_org) checked @endif>
                                        <label class="form-check-label text-warning" for="enableOrg">
                                            @lang("Please confirm if you are collecting donations on behalf of an organization. If 'Yes', tick the box. If 'No', and you are collecting donations for personal reasons, leave the box unticked.")
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label">@lang('Profile')</label>
                                        <div class="profile-thumb-wrapper">
                                            <div class="profile-thumb justify-content-center">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                        style="background-image: url('{{ getImage(getFilePath('orgProfile') . '/' . @$org->image, getFileSize('orgProfile')) }}');">
                                                    </div>
                                                    <div class="avatar-edit">
                                                        <input class="profilePicUpload" id="profilePicUpload1"
                                                            name="image" type='file' accept=".png, .jpg, .jpeg" />
                                                        <label class="btn btn--upload mb-0" for="profilePicUpload1"><i
                                                                class="la la-camera"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">@lang('Cover')</label>
                                        <div class="profile-thumb-wrapper">
                                            <div class="profile-thumb justify-content-center">
                                                <div class="avatar-preview cover">
                                                    <div class="profilePicPreview"
                                                        style="background-image: url('{{ getImage(getFilePath('orgCover') . '/' . @$org->cover, getFileSize('orgCover')) }}');">
                                                    </div>
                                                    <div class="avatar-edit">
                                                        <input class="profilePicUpload" id="profilePicUpload2"
                                                            name="cover" type='file' accept=".png, .jpg, .jpeg" />
                                                        <label class="btn btn--upload mb-0" for="profilePicUpload2"><i
                                                                class="la la-camera"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Organization Name')</label>
                                            <input class="form-control form--control" name="name" type="text"
                                                value="{{ old('name', @$org->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('E-mail')</label>
                                            <input class="form-control form--control" name="email"
                                                value="{{ old('email', @$org->address->email) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Mobile')</label>
                                            <input class="form-control form--control" name="mobile" type="number"
                                                value="{{ old('mobile', @$org->address->mobile) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label class="form-label">@lang('Address')</label>
                                            <input class="form-control form--control" name="address" type="text"
                                                value="{{ old('address', @$org->address->address) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Tagline')</label>
                                            <input class="form-control form--control" name="tagline" type="text"
                                                value="{{ old('tagline', @$org->tagline) }}" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">@lang('Description')</label>
                                        <textarea class="form-control form--control nicEdit" name="description">{{ old('description', @$org->description) }}</textarea>
                                    </div>

                                </div>

                                <div class="form-group text-end">
                                    <button class="btn cmn-btn w-100" type="submit">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

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
    </script>
@endpush
