@extends($activeTemplate . 'layouts.master')

@section('content')
    <section class="pt-90 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @include($activeTemplate . 'partials.profile_header')
                    <div class="card custom--card">
                        <div class="card-body">
                            <form method="post">
                                @csrf

                                <div class="form-group">
                                    <label class="form-label">@lang('Current Password')</label>
                                    <div class="input-group overflow-visible">
                                        <span class="input-group-text"><i class="las la-key"></i></span>
                                        <input class="form-control " name="current_password" type="password" required
                                            autocomplete="current-password">
                                        <span class="password-show-hide fas fa-eye-slash toggle-password"
                                            id="your-password"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">@lang('Password')</label>
                                    <div class="input-group overflow-visible">
                                        <span class="input-group-text"><i class="las la-key"></i></span>
                                        <input class="form-control @if (gs('secure_password')) secure-password @endif"
                                            name="password" type="password" required autocomplete="current-password">
                                        <span class="password-show-hide fas fa-eye-slash toggle-password"
                                            id="your-password"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">@lang('Confirm Password')</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="las la-key"></i></div>
                                        <input class="form-control" name="password_confirmation" type="password" required
                                            autocomplete="current-password">
                                        <span class="password-show-hide fas fa-eye-slash toggle-password"
                                            id="your-password"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn cmn-btn w-100" type="submit">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
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
