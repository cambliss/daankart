@extends($activeTemplate . 'layouts.frontend')
@section('content')
<section class="pt-90 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card custom--card mb-4">
                    <div class="card-body">
                        <h3>@lang('Complete Your Profile')</h3>
                        <div class="alert alert-info">
                            @lang("If your intention is for organizational purposes, please navigate to the 'Organizational Operation' section in your profile and complete the organization's profile details.")
                        </div>
                    </div>
                </div>
                <div class="card custom--card">
                    <div class="card-body">
                        <form method="POST" class="disableSubmission" action="{{ route('user.data.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Username')</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-text"><i class="las la-user"></i></div>
                                        <input type="text" class="form-control form--control checkUser" name="username" value="{{ old('username') }}" required>
                                        <small class="text--danger usernameExist"></small>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Country')</label>
                                        <div class="input-group flex-nowrap">
                                            <div class="input-group-text"><i class="las la-globe"></i></div>
                                            <select name="country" class="form-control form--control select2" required>
                                                @foreach ($countries as $key => $country)
                                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Mobile')</label>
                                        <div class="input-group ">
                                            <span class="input-group-text mobile-code">

                                            </span>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                            <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control form--control checkUser"
                                                required>
                                        </div>
                                        <small class="text--danger mobileExist"></small>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('Address')</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="las la-map-marked"></i></div>
                                    <input type="text" class="form-control form--control" name="address" value="{{ old('address') }}">
                                </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('State')</label>
                                    <div class="input-group">
                                        <div class="input-group-text"> <i class="las la-flag"></i></div>
                                    <input type="text" class="form-control form--control" name="state" value="{{ old('state') }}">
                                </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('Zip Code')</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="las la-sort-numeric-up-alt"></i> </div>
                                    <input type="text" class="form-control form--control" name="zip" value="{{ old('zip') }}">
                                </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('City')</label>
                                    <div class="input-group">
                                        <div class="input-group-text"> <i class="las la-city"></i></div>
                                    <input type="text" class="form-control form--control" name="city" value="{{ old('city') }}">
                                </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn cmn-btn w-100">
                                    @lang('Submit')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('style')
    <style>
        .selection {
            width: 100%;
        }
        .select2-container--default .select2-selection--single {
            border-color: #6f6f6 !important;
            border-width: 1px !important;
            border-radius: 5px !important;
            padding: .75rem .75rem !important;
            height: 46px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 20px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 10px !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: hsl(var(--base)) !important;
            outline: 0 !important;
        }
    </style>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush


@push('script')
    <script>
        "use strict";
        (function($) {

            @if($mobileCode)
            $(`option[data-code={{ $mobileCode }}]`).attr('selected','');
            @endif
            $('.select2').select2();

            $('select[name=country]').on('change',function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
                var value = $('[name=mobile]').val();
                var name = 'mobile';
                checkUser(value,name);
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));


            $('.checkUser').on('focusout', function(e) {
                var value = $(this).val();
                var name = $(this).attr('name')
                checkUser(value,name);
            });

            function checkUser(value,name){
                var url = '{{ route('user.checkUser') }}';
                var token = '{{ csrf_token() }}';

                if (name == 'mobile') {
                    var mobile = `${value}`;
                    var data = {
                        mobile: mobile,
                        mobile_code:$('.mobile-code').text().substr(1),
                        _token: token
                    }
                }
                if (name == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                     if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.field} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            }
        })(jQuery);
    </script>
@endpush
