<div class="row main-view justify-content-center">
    @forelse ($volunteers as $item)
        <div class="col-xxl-3 col-xl-4 col-md-4 col-sm-6 mb-30 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
            <div class="volunteer-card h-100">
                <div class="volunteer-card__thumb">
                    <img class="w-100" src="{{ getImage(getFilePath('volunteer') . '/' . $item->image, getFileSize('volunteer')) }}" alt="image">
                    <div class="volunteer-shape">
                        <img src="{{ asset($activeTemplateTrue . 'images/top-shape.png') }}" alt="image">
                    </div>
                </div>
                <div class="volunteer-card__content">
                    <h4 class="name">{{ __($item->fullname) }}</h4>
                    <span class="designation">@lang("Participate {$item->participated} Campaigns")</span>
                    <div class="designation"><i class="las la-globe"></i><small> @lang('From') : {{ __(@$item->country) }}</small></div>
                </div>
            </div><!-- volunteer-card end -->
        </div>
    @empty
        <div class="text-center py-3">
            @include($activeTemplate . 'partials.empty', ['message' => ucfirst(strtolower($pageTitle)) . ' not found!'])
        </div>
    @endforelse
</div>

@push('style')
    <style>
        .empty-slip-message img {
            width: 75px !important;
            margin-bottom: 0.875rem;
        }
    </style>
@endpush
