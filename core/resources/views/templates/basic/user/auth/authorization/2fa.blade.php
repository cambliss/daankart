@extends($activeTemplate .'layouts.frontend')
@section('content')
<div class="login-area pt-90 pb-120">
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="verification-code-wrapper">
            <div class="verification-area">
                <form action="{{route('user.2fa.verify')}}" method="POST" class="submit-form">
                    @csrf

                    @include($activeTemplate.'partials.verification_code')

                    <div class="form--group">
                        <button type="submit" class="btn cmn-btn shadow-none w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
