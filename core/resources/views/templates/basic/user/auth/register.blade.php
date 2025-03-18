@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="login-area pt-90 pb-120">
        @php
            $register = getContent('register.content', true);
        @endphp
        <div class="container">
            <div class="row g-0 justify-content-center">
                <div class="col-md-6 pr-0 pl-0">
                    <div class="content-area bg_img"
                        data-background="{{ frontendImage('register', @$register->data_values->image, '1024x720') }}">
                    </div>
                </div>

                @if (gs('registration'))
                    <div class="col-lg-6 p-sm-0">
                        <div class="p-sm-5 p-3 content-area-right custom--card">
                            <div class="text-center pb-3">
                                <h2 class="title">{{ __(@$register->data_values->heading) }}</h2>
                                <p>{{ __(@$register->data_values->subheading) }}</p>
                            </div>
                            @include($activeTemplate . 'partials.social_login')

                            <form class="verify-gcaptcha disableSubmission action-form"
                                action="{{ route('user.register') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('First Name')</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-text"><i class="las la-user"></i></div>
                                                <input class="form-control" name="firstname" type="text"
                                                    value="{{ old('firstname') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Last Name')</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-text"><i class="las la-user"></i></div>
                                                <input class="form-control form--control" name="lastname" type="text"
                                                    value="{{ old('lastname') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">@lang('E-mail')</label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="las la-envelope"></i></div>
                                                <input class="form-control checkUser" name="email" type="email"
                                                    value="{{ old('email') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group ">
                                        <label class="form-label">@lang('Password')</label>
                                        <div class="input-group overflow-visible">
                                            <span class="input-group-text"><i class="las la-key"></i></span>
                                            <input
                                                class="form-control @if (gs('secure_password')) secure-password @endif"
                                                name="password" type="password" required>
                                            <span class="password-show-hide fas fa-eye-slash toggle-password"
                                                id="your-password"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Confirm Password')</label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="las la-key"></i></div>
                                                <input class="form-control" name="password_confirmation" type="password"
                                                    required>
                                                <span class="password-show-hide fas fa-eye-slash toggle-password"
                                                    id="your-password"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <x-captcha />

                                </div>
                                @if (gs('agree'))
                                    @php
                                        $policyPages = getContent('policy_pages.element', false, orderById: true);
                                    @endphp
                                    <div class="d-flex align-items-center justify-content-start flex-wrap text-start">
                                        <div class="form-group">
                                            <input id="agree" name="agree" type="checkbox"
                                                @checked(old('agree')) required>
                                            <label for="agree">@lang('I agree with')</label> <span>
                                                @foreach ($policyPages as $policy)
                                                    <a class="text--base"
                                                        href="{{ route('policy.pages', $policy->slug) }}">{{ __(@$policy->data_values->title) }}</a>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group text-center">
                                    <button class="btn cmn-btn w-100 shadow-none" type="submit">@lang('Register')</button>
                                </div>
                                <p class="text-center">@lang('Already have an account')?<a class="text--base"
                                        href="{{ route('user.login') }}">&nbsp; @lang('Login')</a> </p>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="col-lg-6 p-sm-0">
                        <div class="p-sm-5 p-3 content-area-right custom--card">
                            @include($activeTemplate . 'partials.registration_disabled')
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="modal fade" id="existModalCenter" role="dialog" aria-labelledby="existModalCenterTitle"
            aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                        <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                            <i class="las la-times"></i>
                        </span>
                    </div>
                    <div class="modal-body">
                        <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-dark btn-sm" data-bs-dismiss="modal"
                            type="button">@lang('Close')</button>
                        <a class="btn cmn-btn btn-sm" href="{{ route('user.login') }}">@lang('Login')</a>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                var data = {
                    email: value,
                    _token: token
                }

                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $('#existModalCenter').modal('show');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
