@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <!-- login section start -->
    <section class="pt-90 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card custom--card p-3">
                        <div class="card-body">
                            <form class="action-form" action="{{ route('volunteer.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-md-12 text-center ">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Upload Your Image') </label>
                                            <div class="profile-thumb justify-content-center">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview" style="background-image: url('{{ getImage('', getFileSize('volunteer')) }}');">
                                                    </div>

                                                    <div class="avatar-edit">
                                                        <input class="profilePicUpload" id="profilePicUpload1" name="image" type='file' accept=".png, .jpg, .jpeg" required />
                                                        <label class="btn btn--upload mb-0" for="profilePicUpload1">
                                                            <i class="la la-camera"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('First Name')</label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="las la-user"></i></div>
                                                <input class="form-control" name="firstname" type="text" value="{{ old('firstname') }}" required />
                                            </div>
                                        </div>
                                    </div><!-- form-group end -->
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label class="form-label">@lang('Last Name')</label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="las la-user"></i></div>
                                                <input class="form-control" name="lastname" type="text" value="{{ old('lastname') }}" required>
                                            </div>
                                        </div>
                                    </div><!-- form-group end -->
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label class="form-label">@lang('Email')</label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="las la-envelope"></i></div>
                                                <input class="form-control" name="email" type="text" value="{{ old('email') }}" required>
                                            </div>
                                        </div>
                                    </div><!-- form-group end -->
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label class="form-label">@lang('Country')</label>
                                            <div class="input-group flex-nowrap">
                                                <div class="input-group-text"><i class="las la-globe"></i></div>
                                                <select class="form-control form-select select2" name="country" required>
                                                    @foreach ($countries as $key => $country)
                                                        <option data-mobile_code="{{ $country->dial_code }}" data-code="{{ $key }}" value="{{ $country->country }}">
                                                            {{ __($country->country) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Mobile')</label>
                                            <div class="input-group ">
                                                <span class="input-group-text mobile-code"></span>
                                                <input name="mobile_code" type="hidden">
                                                <input name="country_code" type="hidden">
                                                <input class="form-control" id="mobile" name="mobile" type="number" value="{{ old('mobile') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('State')</label>
                                            <div class="input-group">
                                                <div class="input-group-text"> <i class="las la-flag"></i></div>
                                                <input class="form-control" name="state" type="text" required>
                                            </div>
                                        </div>
                                    </div><!-- form-group end -->
                                    <div class="form-group col-md-6">
                                        <label class="form-label">@lang('Zip')</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="las la-sort-numeric-up-alt"></i> </div>
                                            <input class="form-control" name="zip" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">@lang('City')</label>
                                        <div class="input-group">
                                            <div class="input-group-text"> <i class="las la-city"></i></div>
                                            <input class="form-control" name="city" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="form-label">@lang('Address')</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="las la-map-marked"></i></div>
                                            <input class="form-control" name="address" type="text" required>
                                        </div>
                                    </div><!-- form-group end -->
                                </div>
                                <input class="btn cmn-btn w-100" type="submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login section end -->
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush


@push('style')
    <style>
        .btn--upload:after{
            display: none;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 20px;
        }
        
    </style>
@endpush

@push('script')
    <script>
        $(function() {
            "use strict";
            $('.select2').select2();

            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif
            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            }).change();

            function companyProfilePhoto(input) {
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
                companyProfilePhoto(this);
            });

            const requiredClass = document.querySelector('.btn--base');
            requiredClass.classList.remove("required");

        })
    </script>
@endpush
