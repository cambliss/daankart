@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview"
                                type="button">@lang('Campaign Overview')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#donation"
                                type="button">@lang('Donation Config')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#gallery"
                                type="button">@lang('Gallery')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#document"
                                type="button">@lang('Documents')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#faq"
                                type="button">@lang('FAQs')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews"
                                type="button">@lang('Reviews')</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="overview">
                            <div class="mt-4">
                                <div class="campaing-img">
                                    <img
                                        src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}">
                                </div>

                                <div class="my-4">
                                    <ul class="list-group list-group-flush">

                                        <li class="list-group-item">
                                            <span class="fw-bold">@lang('Donation Reason')</span>
                                            <h6 class="text--primary">
                                                <a href="{{ route('profile.index', $campaign->user->username) }}"
                                                    target="__blank">
                                                    @if ($campaign->user->enable_org == Status::ENABLE)
                                                        <span class="text--primary"> @lang('Organization')</span>
                                                    @else
                                                        <span class="text--info"> @lang('Personal')</span>
                                                    @endif <i class="las la-external-link-alt"></i>
                                                </a>
                                            </h6>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold">@lang('Campaign Owner')</span>
                                            <h6 class="text--primary">
                                                <a href="{{ route('admin.users.detail', $campaign->user_id) }}">{{ __(@$campaign->user?->fullname) }}
                                                    ({{ $campaign->user->username }})</a>
                                            </h6>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold">@lang('Title')</span>
                                            <h6>
                                                <a href="{{ route('campaign.details', ['slug' => $campaign->slug, 'id' => $campaign->id]) }}"
                                                    target="__blank">
                                                    {{ __($campaign->title) }}
                                                </a>
                                            </h6>
                                        </li>

                                        <li class="list-group-item">
                                            <span class="fw-bold">@lang('Category')</span>
                                            <h6>{{ __($campaign->category->name) }}</h6>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold">@lang('Deadline')</span>
                                            <h6>
                                                @if ($campaign->goal_type == Status::GOAL_ACHIEVE)
                                                    <span class="badge badge--success">@lang('Achieve Goal')</span>
                                                @elseif($campaign->goal_type == Status::CONTINUOUS)
                                                    <span class="badge badge--primary"> @lang('Continuous')</span>
                                                @else
                                                    <small
                                                        class="badge badge--warning">{{ diffForHumans($campaign->deadline, 'd-m-Y') }}</small>
                                                    <small
                                                        class=" d-block text-center">{{ showDateTime($campaign->deadline, 'd-m-Y') }}</small>
                                                @endif
                                            </h6>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold">@lang('Status')</span>
                                            @php echo $campaign->statusBadge; @endphp
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold">@lang('Is Featured')</span>
                                            <div>
                                                @if ($campaign->featured)
                                                    <span class="badge badge--successs">@lang('Yes')</span>
                                                @else
                                                    <span class="badge badge--danger">@lang('No')</span>
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <h5>@lang('Description')</h5>
                                <hr>
                                <div class="mb-4">
                                    @php  echo $campaign->description; @endphp
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="donation">
                            <div class="mt-4">
                                <div class="mb-4">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <span class="fw-bold">@lang('Goal Amount')</span>
                                            <h6>{{ showAmount($campaign->goal) }}</h6>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold ">@lang('Raised Amount')</span>
                                            <h6>{{ showAmount($donate) }}</h6>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold ">@lang('Total Donors')</span>
                                            <h6>{{ $campaign->donations_count }}</h6>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold ">@lang('Donation Completed Stage')</span>
                                            <h6>{{ getAmount($percent) }}%</h6>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold ">@lang('Donation Progress')</span>
                                            <div class="w-50">
                                                <div class="progress" role="progressbar" aria-label="Example with label"
                                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: {{ getAmount($percent) }}%">
                                                        {{ getAmount($percent) }}%</div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <ul class="list-group my-5">
                                        <h6 class="my-3">@lang('Latest Donars')</h6>
                                        <div class="table-responsive--md table-responsive">
                                            <table class=" table align-items-center table--light">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('Name')</th>
                                                        <th>@lang('Amount')</th>
                                                        <th>@lang('Donate at')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($campaign->donations->take(10) as $value)
                                                        <tr>
                                                            <td>{{ $value->fullname }}</td>
                                                            <td>{{ getAmount($value->donation) }} {{ __(gs('cur_text')) }}
                                                            </td>
                                                            <td>{{ showDateTime($value->created_at) }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td class="text-muted text-center" colspan="100%">
                                                                {{ __($emptyMessage) }}</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        @if (!blank($campaign->donations))
                                            <div class="d-flex justify-content-end align-items-end">
                                                <a class="btn btn-outline--primary text--primary mt-3"
                                                    href="{{ route('admin.donation.campaign.wise', $campaign->id) }}">@lang('View all')&#8594;</a>
                                            </div>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @php
                            $foundImg = false;
                            $foundPdf = false;
                        @endphp

                        <div class="tab-pane fade" id="gallery">
                            <div class="mt-4">
                                <div class="row gy-4 ">
                                    @foreach (@$campaign->proof_images as $images)
                                        @if (explode('.', $images)[1] != 'pdf')
                                            @php
                                                $foundImg = true;
                                            @endphp
                                            <div class="col-md-4 d-flex justify-content-around ">
                                                <div class="gallery-card">
                                                    <a class="view-btn" data-rel="lightcase:myCollection"
                                                        href="{{ asset(getFilePath('proof') . '/' . $images) }}"><i
                                                            class="las la-plus"></i></a>
                                                    <div class="gallery-card__thumb">
                                                        <img class="w-100 h-100"
                                                            src="{{ asset(getFilePath('proof') . '/' . $images) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if (!$foundImg)
                                        <p class="text-center">@lang('Gallery photo not found!')</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="document">
                            <div class="mt-4">
                                <div class="row h-100">
                                    @foreach ($campaign->proof_images as $pdfFiles)
                                        @if (explode('.', $pdfFiles)[1] == 'pdf')
                                            @php
                                                $foundPdf = true;
                                            @endphp
                                            <iframe class="iframe"
                                                src="{{ asset(getFilePath('proof') . '/' . @$pdfFiles) }}"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope picture-in-picture"
                                                allowfullscreen></iframe>
                                        @endif
                                    @endforeach
                                    @if (!$foundPdf)
                                        <p class="text-center">@lang('Documents not found!')</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="faq">
                            <div class="mt-4">
                                @if ($campaign->faqs)
                                    <div class="accordion" id="faq">
                                        @foreach ($campaign->faqs->question as $key => $faq)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button
                                                        class="accordion-button {{ !$loop->first ? 'collapsed' : null }}"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse-{{ $key + 1 }}" type="button"
                                                        aria-expanded="{{ !$loop->first ? 'false' : 'true' }}">
                                                        {{ $campaign->faqs->question[$key] }}
                                                    </button>
                                                </h2>
                                                <div class="accordion-collapse collapse {{ $loop->first ? 'show' : null }}"
                                                    id="collapse-{{ $key + 1 }}" data-bs-parent="#faq">
                                                    <div class="accordion-body">
                                                        {{ $campaign->faqs->answer[$key] }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="reviews">
                            <div class="mt-4">
                                @if ($campaign->comments->count())
                                    <div class="table-responsive--md table-responsive">
                                        <table class=" table align-items-center table--light">
                                            <thead>
                                                <tr>
                                                    <th>@lang('Fullname') | @lang('Email')</th>
                                                    <th>@lang('Review')</th>
                                                    <th>@lang('Created At')</th>
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (@$campaign->comments as $comment)
                                                    <tr>
                                                        <td>
                                                            <span
                                                                class="fw-bold">{{ __(@$comment->user?->fullname) }}</span>
                                                            <span class="d-block">{{ @$comment->user?->email }}</span>
                                                        </td>
                                                        <td>{{ strLimit($comment->review, 30) }}</td>
                                                        <td>
                                                            {{ showDateTime($comment->created_at) }}
                                                            <span
                                                                class="d-block">{{ diffForHumans($comment->created_at) }}</span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline--primary showReviewModal"
                                                                data-review="{{ $comment->review }}">
                                                                <i class="las la-desktop"></i> @lang('View')
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-center"> @lang('Review not found!')</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="reviewModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Review')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="review"></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center">
        @if ($campaign->status == Status::PENDING)
            <button class="btn btn--success  confirmationBtn"
                data-action="{{ route('admin.fundrise.approve.reject', ['status' => Status::CAMPAIGN_APPROVED, 'id' => $campaign->id]) }}"
                data-question="@lang('Are you sure to approve this campaign')?" type="button">
                <i class="la la-check"></i>@lang('Approve')
            </button>
            <button class="btn btn--danger confirmationBtn"
                data-action="{{ route('admin.fundrise.approve.reject', ['status' => Status::REJECTED, 'id' => $campaign->id]) }}"
                data-question="@lang('Are you sure to reject this campaign')?" type="button">
                <i class="la la-times"></i>@lang('Reject')
            </button>
        @endif

        @if ($campaign->status == Status::CAMPAIGN_APPROVED)
            @if (!$campaign->featured)
                <button class="btn btn-outline--primary confirmationBtn"
                    data-action="{{ route('admin.fundrise.make.featured', $campaign->id) }}"
                    data-question="@lang('Are you sure to fetured this campaign')?" type="button">
                    <i class="las la-arrow-alt-circle-right"></i>@lang('Feature It')
                </button>
            @else
                <button class="btn btn-outline--dark confirmationBtn"
                    data-action="{{ route('admin.fundrise.make.featured', $campaign->id) }}"
                    data-question="@lang('Are you sure to remove fetured this campaign')?" type="button">
                    <i class="las la-arrow-alt-circle-left"></i>@lang('Remove Featured')
                </button>
            @endif
        @endif

    </div>

@endpush

@push('style-lib')
    <link href="{{ asset('assets/global/css/lightcase.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/lightcase.js') }}"></script>
@endpush

@push('style')
    <style>
        .campaing-img {
            text-align: center;
        }

        .campaing-img img {
            width: 400px;
            height: 300px;
            border-radius: 10%;
            object-fit: cover;
        }

        .iframe {
            width: 100%;
            height: 580px;
        }

        @media(max-width: 991px) {
            .iframe {
                width: 100%;
                height: inherit;
            }
        }

        .list-group-item {
            border: 0;
        }

        .border-b {
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .gallery-card {
            max-width: 450px;
            margin-bottom: 10px;
            border: 3px solid #ddd;
            border-radius: 5px;
        }

        .gallery-card__thumb img {
            object-fit: cover;
            object-position: center;
        }

        iframe.iframe {
            min-height: 300px;
        }

        .list-group-item {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            padding: .8rem 0;
            border: 1px solid #f1f1f1;
        }

        .accordion-button:not(.collapsed) {
            box-shadow: none !important;
        }

        .gallery-card {
            position: relative;
        }

        .gallery-card:hover .view-btn {
            opacity: 1;
            visibility: visible;
        }

        .gallery-card .view-btn {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.364);
            color: #f0e9e9;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            font-size: 42px;
            opacity: 0;
            visibility: none;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .thumb i {
            font-size: 22px;
        }

        .lightcase-icon-prev:before {
            content: '\f104' !important;
            font-family: 'Line Awesome Free' !important;
            font-weight: 900 !important;
        }

        .lightcase-icon-next:before {
            content: '\f105' !important;
            font-family: 'Line Awesome Free' !important;
            font-weight: 900 !important;
        }

        .lightcase-icon-close:before {
            content: '\f00d' !important;
            font-family: 'Line Awesome Free' !important;
            font-weight: 900 !important;
        }

        .lightcase-icon-prev,
        .lightcase-icon-next,
        .lightcase-icon-close {
            border: 1px solid #ddd;
            font-size: 22px !important;
            width: 50px !important;
            height: 50px !important;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background-color: #ffffff0f;
        }

        .nav-link {
            color: #868e96;
        }

        .nav-tabs .nav-link.active {
            color: #4634ff;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('a[data-rel^=lightcase]').lightcase();

            $(document).on('click', '.showReviewModal', function() {
                var modal = $('#reviewModal');
                let data = $(this).data();
                modal.find('.review').text(`${data.review}`);
                modal.modal('show');
            });


        })(jQuery);
    </script>
@endpush
