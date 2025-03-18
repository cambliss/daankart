@php
    $login = getContent('login.content', true);
@endphp
@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <section class="login-area pt-90 pb-120">
        <div class="container">
            <div class="row g-0 justify-content-center">
                <div class="col-md-6 pr-0 pl-0">
                    <div class="content-area bg_img" data-background="{{ frontendImage('login', @$login->data_values->image, '1025x720') }}"></div>
                </div>
                <div class="col-lg-6 p-sm-0">
                    <div class="p-sm-5 p-3 content-area-right custom--card">
                        <div class="text-center">
                            <h2 class="title">{{ __(@$login->data_values->heading) }}</h2>
                            <p>{{ __(@$login->data_values->subheading) }}</p>
                        </div>

                        @include($activeTemplate . 'partials.social_login')

                        <form class="verify-gcaptcha action-form disableSubmission" action="{{ route('user.login') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label class="form-label">@lang('Username')</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="las la-user"></i></span>
                                    <input class="form-control" name="username" type="text" value="{{ old('username') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                    <label class="form-label mb-0" for="password">@lang('Password')</label>
                                    <a class="forgot-pass text--base" href="{{ route('user.password.request') }}">
                                        @lang('Forgot your password?')
                                    </a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="las la-key"></i></span>
                                    <input class="form-control" name="password" type="password" required>
                                    <span class="password-show-hide fas fa-eye-slash toggle-password" id="your-password"></span>
                                </div>
                            </div>

                            <x-captcha />

                            <div class="form-group form-check">
                                <input class="form-check-input" id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    @lang('Remember Me')
                                </label>
                            </div>

                            <div class="form-group">
                                <button class="btn cmn-btn  shadow-none w-100" id="recaptcha" type="submit">@lang('Login')</button>
                            </div>
                        </form>

                        <p class="text-center">
                            @lang("Haven't an account")? <a class="text--base" href="{{ route('user.register') }}">@lang('Register')</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


