@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container py-5 section-gap-heading">
        <div class="success-message">
            <div class="success-message-wrapper">
                <div class="modal-body text-center">
                    <div class="modal-body__img">
                        @if ($user->enable_org)
                            <img src="{{ avatar(@$user->organization->image ? getFilePath('orgProfile') . '/' . @$user->organization->image : null, false) }}" alt="user-avatar">
                        @else
                            <img src="{{ avatar(@$user->image ? getFilePath('userProfile') . '/' . @$user->image : null, false) }}" alt="user-avatar">
                        @endif
                    </div>
                    <div class="modal-body__content">
                        <h5 class="modal-body__title">@lang("Thank's for your supporting") @if ($user->enable_org) {{ __($user->organization->name) }} @else {{ __($user->fullname) }} @endif 🎉</h5>
                        <div class="modal-body__share">
                            <p>{{ __(@$campaign->title) }}</p>
                            <div class="modal-body__content share-action">
                                <div class="form-group copy-link">
                                    <input class="copyURL" class="form-control form--control" id="profile" name="profile" type="text" value="{{ route('campaign.details', $campaign->slug) }}" readonly="">
                                    <span class="copy" data-id="profile">
                                        <i class="las la-copy"></i> <strong class="copyText">@lang('Copy')</strong>
                                    </span>
                                </div>
                                <div class="tip-section mt-3 border py-3">
                                    <p><span class="fw-bold">@lang('Tip'): </span> @lang('Add this link to your social bios.')</p>
                                    <ul class="d-flex justify-content-center mt-2">
                                        <li class="youtube me-2"><i class="lab la-youtube"></i></li>
                                        <li class="instagram me-2"><i class="lab la-instagram"></i></li>
                                        <li class="pinterest me-2"><i class="lab la-pinterest-p"></i></li>
                                        <li class="whatsapp me-2"><i class="lab la-whatsapp"></i></li>
                                        <li class="linkedin me-2"><i class="lab la-linkedin-in"></i></li>
                                        <li class="twitter me-2"><i class="lab la-twitter"></i></li>
                                        <li class="facebook me-2"><i class="lab la-facebook"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="success-message-footer">
                <a class="btn btn--sm" href="{{ route('campaign.details', $campaign->slug) }}">@lang('Back To Campaign') <span
                          class="icon"> <i class="las la-arrow-right"></i> </span></a>
                <a class="btn btn--sm" href="{{ route('home') }}">@lang('Back To Home')<span class="icon"><i
                           class="las la-arrow-right"></i></span></a>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .page-share-btn.facebook .icon,
        .tip-section .facebook {
            color: #1877f2;
        }

        .page-share-btn.linkedin .icon,
        .tip-section .linkedin {
            color: #0a66c2;
        }

        .page-share-btn.twitter .icon,
        .tip-section .twitter {
            color: #1d9bf0;
        }

        .page-share-btn.instagram .icon,
        .tip-section .instagram {
            color: #d62976;
        }

        .tip-section .youtube {
            color: #c4302b;
        }

        .tip-section .pinterest {
            color: #E60023;
        }

        .tip-section .whatsapp {
            color: #128c7e;
        }

        .tip-section li i {
            font-size: 25px;
        }

        .tip-section {
            background-color: hsl(var(--base)/.05);
        }

        .modal-body__img {
            height: 160px;
            width: 160px;
            border-radius: 6px;
            overflow: hidden;
            margin: 0 auto 24px;
            padding: 8px;
            border: 3px solid hsl(var(--base));

            @media (max-width: 767px) {
                height: 140px;
                width: 140px;
                margin: 0 auto 16px;
            }

            @media (max-width: 575px) {
                height: 100px;
                width: 100px;
            }

            img {
                height: 100%;
                width: 100%;
                object-fit: cover;
                border-radius: 6px;
            }
        }

        .success-message {
            max-width: 760px;
            width: 100%;
            margin: 0 auto;
        }

        .success-message-wrapper {
            padding: 32px;
            border-radius: 12px;
            background-color: #fff;
            box-shadow: 0 0px 15px 5px rgb(0 0 0 / 10%);

            @media (max-width: 767px) {
                padding: 24px;
            }

            @media (max-width: 575px) {
                padding: 16px;
            }
        }

        .success-message-footer {
            margin-top: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-flow: wrap;
        }

        .success-message-footer .btn:hover {
            text-decoration: underline;
            background-color: transparent;
        }

        @media (max-width: 575px) {
            .success-message-footer .btn {
                font-size: 12px;
            }

            .success-message-footer {
                margin-top: 16px;
            }
        }
    </style>
@endpush
