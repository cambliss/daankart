<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ gs()->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/lightcase.css') }}" rel="stylesheet">


    <link href="{{ asset($activeTemplateTrue . 'css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/slick.css') }}" rel="stylesheet">

    <link href="{{ asset($activeTemplateTrue . 'css/main.css') }}" rel="stylesheet">

    @stack('style-lib')

    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet">

    @stack('style')

    <link href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs('base_color') }}" rel="stylesheet">
</head>
@php echo loadExtension('google-analytics') @endphp

<body>

    @stack('fbComment')

    <div class="preloader">
        <div class="dl">
            <div class="dl__container">
                <div class="dl__corner--top"></div>
                <div class="dl__corner--bottom"></div>
            </div>
            <div class="dl__square"></div>
        </div>
    </div>

    <!-- Overlay Start -->
    <div class="body-overlay"></div>
    <!-- Overlay End -->

    <!-- Scroll To Top -->
    <a class="scroll-top show"><i class="fas fa-angle-double-up"></i></a>
@include('templates.basic.partials.header')

    @yield('panel')

    @include($activeTemplate . 'partials.footer')

    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp
    @if (@$cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
        <!-- cookies dark version start -->
        <div class="cookies-card text-center hide">
            <div class="cookies-card__icon bg--base">
                <i class="las la-cookie-bite"></i>
            </div>
            <p class="mt-2 cookies-card__content">{{ @$cookie->data_values->short_desc }}
            <div class="cookies-card__btn flex-align justify-content-between mt-3 gap-4">
                <a class="btn cmn-outline-btn flex-1" href="{{ route('cookie.policy') }}"
                    target="_blank">@lang('Learn More')</a>
                <a class="btn cmn-outline-btn policy flex-1" href="javascript:void(0)">@lang('Accept All')</a>
            </div>
        </div>
        <!-- cookies dark version end -->
    @endif

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/lightcase.js') }}"></script>

    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/contact.js') }}"></script>

    @stack('script-lib')

    <script src="{{ asset($activeTemplateTrue . 'js/app.js') }}"></script>

    @php echo loadExtension('tawk-chat') @endphp

    @include('partials.notify')

    @if (gs('pn'))
        @include('partials.push_script')
    @endif
    @stack('script')

    <script>
        (function($) {
            "use strict";

            $(".langSel").on("click", function() {
                var value = $(this).data('value');
                window.location.href = "{{ route('home') }}/change/" + value;
            });

            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input:not([type=checkbox]):not([type=hidden]), select, textarea'), function(i, element) {
                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }
            });

            let disableSubmission = false;
            $('.disableSubmission').on('submit', function(e) {
                if (disableSubmission) {
                    e.preventDefault()
                } else {
                    disableSubmission = true;
                }
            });

        })(jQuery);
    </script>

</body>

</html>
