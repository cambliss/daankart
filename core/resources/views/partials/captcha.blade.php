@php
    $customCaptcha = loadCustomCaptcha();
    $googleCaptcha = loadReCaptcha();
@endphp
@if ($googleCaptcha)
    <div class="mb-3">
        @php echo $googleCaptcha @endphp
    </div>
@endif
@if ($customCaptcha)
    @props(['radius' => 'custom-radius'])
    @props(['isCustom' => ''])
    <div class="form-group">
        <div class="mb-3 {{ @$radius }}">
            @php echo $customCaptcha @endphp
        </div>
        @if ($isCustom)
            <input class="form-control form--control" name="captcha" type="text" placeholder="Capcha" required>
        @else
            <label class="form-label">@lang('Captcha')</label>
            <input class="form-control form--control" name="captcha" type="text" required>
        @endif
    </div>
@endif
@if ($googleCaptcha)
    @push('script')
        <script>
            (function($) {
                "use strict"
                $('.verify-gcaptcha').on('submit', function() {
                    var response = grecaptcha.getResponse();
                    if (response.length == 0) {
                        document.getElementById('g-recaptcha-error').innerHTML = '<span class="text--danger">@lang('Captcha field is required.')</span>';
                        return false;
                    }
                    return true;
                });

                window.verifyCaptcha = () => {
                    document.getElementById('g-recaptcha-error').innerHTML = '';
                }
            })(jQuery);
        </script>
    @endpush
@endif
