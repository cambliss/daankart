@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="login-area pt-90 pb-120">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-5">
            <div class="card custom--card">
                <div class="card-body">
                    <div class="mb-4">
                        <p>@lang('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.')</p>
                    </div>
                    <form method="POST" action="{{ route('user.password.update') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label class="form-label">@lang('Password')</label>
                            <div class="input-group overflow-visible">
                                <span class="input-group-text"><i class="las la-key"></i></span>
                                <input class="form-control @if (gs('secure_password')) secure-password @endif" name="password" type="password" required>
                                <span class="password-show-hide fas fa-eye-slash toggle-password" id="your-password"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Confirm Password')</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="las la-key"></i></div>
                                <input class="form-control" name="password_confirmation" type="password" required>
                                <span class="password-show-hide fas fa-eye-slash toggle-password" id="your-password"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn cmn-btn shadow-none w-100" id="recaptcha"> @lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@if(gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
