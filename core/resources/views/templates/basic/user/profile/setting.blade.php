@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="pt-90 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 ">
                    @include($activeTemplate . 'partials.profile_header')
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="col-md-12 mb-4">
                                <div>
                                    <h4 class="mb-1">@lang('Share Profile & Earn Donation')</h4>
                                    <div class="form-group">
                                        <div class="copy-link">
                                            <input class="copyURL" class="form-control form--control" id="profile" name="profile" type="text" value="{{ route('profile.index', auth()->user()->username) }}" readonly="">
                                            <span class="copy" data-id="profile">
                                                <i class="las la-copy"></i> <strong class="copyText">@lang('Copy')</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form class="register" action="{{ route('user.profile.setting') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label">@lang('Profile')</label>
                                        <div class="profile-thumb-wrapper">
                                            <div class="profile-thumb justify-content-center">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview" style="background-image: url('{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}');">
                                                    </div>
                                                    <div class="avatar-edit">
                                                        <input class="profilePicUpload" id="profilePicUpload1" name="image" type='file' accept=".png, .jpg, .jpeg" />
                                                        <label class="btn btn--upload mb-0" for="profilePicUpload1"><i class="la la-camera"></i></label>
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
                                                    <div class="profilePicPreview" style="background-image: url('{{ getImage(getFilePath('userCover') . '/' . $user->cover, getFileSize('userCover')) }}');">
                                                    </div>
                                                    <div class="avatar-edit">
                                                        <input class="profilePicUpload" id="profilePicUpload2" name="cover" type='file' accept=".png, .jpg, .jpeg" />
                                                        <label class="btn btn--upload mb-0" for="profilePicUpload2"><i class="la la-camera"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('First Name')</label>
                                            <input class="form-control form--control" name="firstname" type="text" value="{{ $user->firstname }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Last Name')</label>
                                            <input class="form-control form--control" name="lastname" type="text" value="{{ $user->lastname }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('E-mail Address')</label>
                                            <input class="form-control form--control" value="{{ $user->email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Mobile Number')</label>
                                            <input class="form-control form--control" value="{{ $user->mobile }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label class="form-label">@lang('Address')</label>
                                            <input class="form-control form--control" name="address" type="text" value="{{ @$user->address }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('State')</label>
                                            <input class="form-control form--control" name="state" type="text" value="{{ @$user->state }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Zip Code')</label>
                                            <input class="form-control form--control" name="zip" type="text" value="{{ @$user->zip }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">@lang('City')</label>
                                            <input class="form-control form--control" name="city" type="text" value="{{ @$user->city }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Country')</label>
                                            <input class="form-control form--control" value="{{ @$user->country_name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">@lang('Description')</label>
                                        <textarea class="form-control form--control nicEdit" name="description">{{ old('description', @$user->description) }}</textarea>
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

@push('style')
    <style>
        .form-control:focus {
            box-shadow: none !important;
        }
        .form-check-input:focus {
            box-shadow: none;
        }
    </style>
@endpush

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
