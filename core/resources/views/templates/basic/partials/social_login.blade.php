@php
    $text = request()->route()->getName() == 'user.login' ? 'Login' : 'Register';
    $credentials = @gs('socialite_credentials');
@endphp
@if ($credentials->google->status == Status::ENABLE || $credentials->facebook->status == Status::ENABLE || $credentials->linkedin->status == Status::ENABLE)
    <div class="d-flex flex-wrap gap-3">
        @if ($credentials->facebook->status == Status::ENABLE)
            <a class="btn-outline-facebook social-login-btn btn-sm flex-grow-1" href="{{ route('user.social.login', 'facebook') }}">
                <span class="social-login-icon"><i class="fab fa-facebook-f"></i></span> <span class="text-center flex-fill"> @lang('FACEBOOK')</span>
            </a>
        @endif
        @if ($credentials->google->status == Status::ENABLE)
            <a class="btn-outline-google social-login-btn btn-sm flex-grow-1" href="{{ route('user.social.login', 'google') }}">
                <span class="social-login-icon"><i class="lab la-google"></i></span> <span class="text-center flex-fill"> @lang('GOOGLE')</span>
            </a>
        @endif
        @if ($credentials->linkedin->status == Status::ENABLE)
            <a class="btn-outline-linkedin social-login-btn btn-sm flex-grow-1" href="{{ route('user.social.login', 'linkedin') }}">
                <span class="social-login-icon"><i class="lab la-linkedin-in"></i></span> <span class="text-center flex-fill">@lang('LINKEDIN')</span>
            </a>
        @endif
    </div>

    <div class="registration-socails__content text-center mt-3">
        <p class="registration-socails__desc">
            @lang('Or') {{ __($text) }} @lang('With')
        </p>
    </div>
@endif

@push('style')
    <style>
        .social-login-icon {
            height: 28px;
            width: 28px;
            background-color: #fff;
            display: grid;
            place-content: center;
            font-size: 18px;
            border-radius: inherit;
        }

        .social-login-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 3px !important;
            padding-right: 20px !important;
            border-radius: 4px;
        }

        .btn-outline-linkedin {
            background-color: #0077B5;
            color: #fff;
        }

        .btn-outline-linkedin i {
            color: #0077B5;
        }

        .btn-outline-linkedin:hover {
            color: #fff !important;
            background-color: #058fda;
        }

        .btn-outline-facebook {
            background-color: #395498;
            color: #fff;
        }

        .btn-outline-facebook i {
            color: #395498;
        }

        .btn-outline-facebook:hover {
            color: #fff !important;
            background-color: #456ac8;
        }

        .btn-outline-google {
            background-color: #D64937;
            color: #fff;
        }

        .btn-outline-google i {
            color: #D64937;
        }

        .btn-outline-google:hover {
            color: #fff !important;
            background-color: #f55843;
        }
    </style>
@endpush
