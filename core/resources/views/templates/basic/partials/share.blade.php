@php
    $route = route('profile.index', $user->username);
@endphp
<div class="share flex-align gap-2 ms-auto order-sm-2">
    <div class="dropdown">
        <span class="icon" data-bs-toggle="dropdown" data-bs-toggle="tooltip" data-bs-placement="right" title="@lang('Share')" role="button" aria-expanded="false">
            <i class="fas fa-share-alt"></i>
        </span>
        <div class="dropdown-menu share-action dropdown-menu-end">
            <div class="form-group">
                <div class="copy-link">
                    <input class="copyURL" class="form-control form--control" id="profile" name="profile" type="text" value="{{ $route }}" readonly="">
                    <span class="copy" data-id="profile">
                        <i class="las la-copy"></i> <strong class="copyText">@lang('Copy')</strong>
                    </span>
                </div>
            </div>

            <div class="social-list flex-align">
                <a class="social-btn facebook flex-align" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($route) }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i>&nbsp; @lang('Facebook')</a>
                <a class="social-btn linkedin flex-align" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode($route) }}&amp;title={{ $user->username }}&amp;{{ $user->fullname }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i>&nbsp; @lang('Linkedin')</a>
                <a class="social-btn twitter flex-align" href="https://twitter.com/intent/tweet?text={{ $user->username }}&amp;url={{ urlencode($route) }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i>&nbsp; @lang('Twitter')</a>
                <a class="social-btn instagram flex-align" href="https://www.instagram.com/share?u={{ urlencode($route) }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i>&nbsp; @lang('Instagram')</a>
            </div>
        </div>
    </div>
</div>

@push('style')
    <style>
        .share .icon {
            font-size: 15px;
        }

        .share:hover {
            color: hsl(var(--base));
        }

        .share-action .social-list .social-btn {
            padding: 3px 5px;
        }

        .share-action .social-list .facebook {
            background-color: #1877f2;
            color: #fff
        }

        .share-action .social-list .linkedin {
            background-color: #0a66c2;
            color: #fff
        }

        .share-action .social-list .twitter {
            background-color: #1d9bf0;
            color: #fff
        }

        .share-action .social-list .instagram {
            background-color: #d62976;
            color: #fff
        }

        .share-action .copy-link .input-group-text::after {
            display: none;
        }

        .share-action .copy-link .form--control:disabled {
            background-color: transparent !important;
            border: 0;
            color: #2d2d2d00;
        }

        @media screen and (max-width:425px) {
            .dropdown-menu.share-action {
                width: 300px;
                padding: 5px;
            }

            .share-action .social-list .social-btn {
                padding: 5px 8px;
            }
        }

        .header-share .close-preview {
            position: absolute;
            width: 20px;
            height: 20px;
            display: grid;
            place-items: center;
        }

        .header-share .share-card__share .page-share-btn {
            flex: 1;
            border: 1px solid #929090 !important;
            border-radius: 10px;
        }

        /* new  */
        .dropdown-menu.share-action {
            width: 417px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 2px 4px 4px #99999942;
        }

        @media (max-width:575px) {
            .dropdown-menu.share-action {
                width: 300px;
            }
        }

        .share-action .copy-link {
            border: 1px solid #c5c1c142;
            margin-bottom: 15px;
        }

        .share-action .copy-link .form--control:disabled {
            background-color: transparent !important;
            border: 0;
            color: #000;
        }

        .share-action .copy-link .copy-input {
            padding: 5px 2px 5px 0;
            font-size: 14px;
        }

        .share-action .copy-link .copy-btn {
            background-color: #fff;
            border: 0;
            border-left: 1px solid #c5c1c142;
            cursor: pointer;
            gap: 5px;
        }

        .flex-align {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .share-action .social-list {
            gap: 6px;
            margin-top: 10px;
            justify-content: space-evenly;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            $('.copy').on('click', function(e) {
                e.preventDefault(); 
            });
        });
    </script>
@endpush
