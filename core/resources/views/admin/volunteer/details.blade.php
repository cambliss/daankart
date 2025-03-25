@extends('admin.layouts.app')
@section('panel')
    <form action="{{ route('admin.volunteer.update', @$volunteer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row gy-4">
            <div class="col-xl-3 col-lg-5 col-md-5 mb-30">
                <div class="card   overflow-hidden box--shadow1">
                    <div class="card-body p-0">
                        <div class="p-3 bg--white">
                            <div class="">
                                <x-image-uploader class="w-100" type="volunteer" image="{{ @$volunteer->image }}"
                                    :required=false />
                            </div>
                            @if (@$volunteer->id)
                                <div class="mt-15">
                                    <h4 class="">{{ @$volunteer->fullname }}</h4>
                                    <span
                                        class="text--small">@lang('Joined At ')<strong>{{ showDateTime(@$volunteer->created_at, 'd M, Y h:i A') }}</strong></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if (@$volunteer->id)
                    <div class="card   overflow-hidden mt-30 box--shadow1">
                        <div class="card-body">
                            <h5 class="mb-20 text-muted">@lang('Notification')</h5>
                            <a class="btn btn--warning btn--shadow w-100 btn-lg"
                                href="{{ route('admin.volunteer.notification.send', @$volunteer->id) }}">
                                <i class="las la-paper-plane"></i> @lang('Send Notification')
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-xl-9 col-lg-7 col-md-7 mb-0">
                <div class="card">
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" name="firstname" type="text"
                                        value="{{ old('firstname', @$volunteer->firstname) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Last Name')</label>
                                    <input class="form-control" name="lastname" type="text"
                                        value="{{ old('lastname', @$volunteer->lastname) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Email')</label>
                                    <input class="form-control" name="email" type="email"
                                        value="{{ old('email', @$volunteer->email) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number')</label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code"></span>
                                        <input class="form-control" id="mobile" name="mobile" type="number"
                                            value="{{ old('mobile', @$volunteer->mobile) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Address') <i class="las la-info-circle"
                                            title=" @lang('House number, street address')"></i></label>
                                    <input class="form-control" name="address" type="text"
                                        value="{{ old('address', @$volunteer->address->address) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Participation Campaign') </label>
                                    <input class="form-control" name="participation" type="number"
                                        value="{{ old('participation', @$volunteer->participated) }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City') </label>
                                    <input class="form-control" name="city" type="text"
                                        value="{{ old('city', @$volunteer->address->city) }}" required>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('State') </label>
                                    <input class="form-control" name="state" type="text"
                                        value="{{ old('state', @$volunteer->address->state) }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Zip/Postal') </label>
                                    <input class="form-control" name="zip" type="text"
                                        value="{{ old('zip', @$volunteer->address->zip) }}" required>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Country') </label>
                                    <select class="form-control" name="country" required>
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $key }}">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.volunteer.index') }}" />
@endpush

@push('script')
    <script>
        'use strict';
        let mobileElement = $('.mobile-code');
        $('select[name=country]').change(function() {
            mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
        });

        $('select[name=country]').val('{{ @$volunteer->country_code }}');
        let dialCode = $('select[name=country] :selected').data('mobile_code');
        if (dialCode) {
            let mobileNumber = `{{ @$volunteer->mobile }}`;
            mobileNumber = mobileNumber.replace(dialCode, '');
            $('input[name=mobile]').val(mobileNumber);
            mobileElement.text(`+${dialCode}`);
        }
    </script>
@endpush
