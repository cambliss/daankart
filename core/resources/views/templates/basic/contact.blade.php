@php
    $contact = getContent('contact_us.content', true);
    $contactElements = getContent('contact_us.element', false, 3);
    $socialIcons = getContent('social_icon.element', false, null, true);
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="pt-90 pb-120">
        <div class="container">
            <div class="card custom--card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            <h2 class="mb-1">{{ __($contact->data_values->heading) }}</h2>
                            <form class="verify-gcaptcha action-form" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="name" type="text"
                                            value="{{ old('name', @$user->fullname) }}" placeholder="@lang('Enter Name')"
                                            @if ($user && $user->profile_complete) readonly @endif required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="email" type="email"
                                            value="{{ old('email', @$user->email) }}" placeholder="@lang('Enter E-mail')"
                                            {{ $user ? 'readonly' : '' }} required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="subject" type="text"
                                            value="{{ old('subject') }}" placeholder="@lang('Enter Subject')" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="message" wrap="off" placeholder="@lang('Enter Message')" required>{{ old('message') }}</textarea>
                                </div>

                                <x-captcha isCustom="true" />

                                <button class="btn cmn-btn w-100 shadow-none" type="submit">@lang('Send Message')</button>
                            </form>
                        </div>
                        <div class="col-md-5 ps-lg-4 ps-xl-5">
                            <div class="contacts-info">
                                <img class="contact-img my-4"
                                    src="{{ asset('assets/images/frontend/contact_us/' . $contact->data_values->image) }}"
                                    alt="image">
                                <div class="address row gy-3">
                                    @foreach (@$contactElements as $contact)
                                        <div class="col-12">
                                            <div class="contact-card d-flex"
                                                title="{{ __(@$contact->data_values->title) }}">
                                                <span class="icon me-2">@php echo @$contact->data_values->icon @endphp</span>
                                                @if (in_array(@$contact->data_values->contact_type, ['mailto', 'tel']))
                                                    <a
                                                        href="{{ @$contact->data_values->contact_type }}:{{ @$contact->data_values->content }}">
                                                        {{ @$contact->data_values->content }} </a>
                                                @else
                                                    <span class="desc">{{ __(@$contact->data_values->content) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <ul class="social-links mt-4">
                                    @foreach ($socialIcons as $icon)
                                        <li>
                                            <a href="{{ @$icon->data_values->url }}" target="_blank"> @php echo @$icon->data_values->social_icon; @endphp</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .contact-card a {
            color: unset !important;
        }
    </style>
@endpush
