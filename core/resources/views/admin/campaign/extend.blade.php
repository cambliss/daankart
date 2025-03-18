@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card ">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Title') | @lang('Category')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Deadline')</th>
                                    <th>@lang('Goal')</th>
                                    <th>@lang('Extend Goal')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($campaigns as $campaign)
                                    <tr>
                                        <td>
                                            <div class="avatar avatar--md">
                                                <img src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}" alt="@lang('Image')">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.fundrise.details', $campaign->id) }}"> {{ strLimit($campaign->title, 25) }} </a>
                                            <br>
                                            <span class="badge badge--danger fw-bold">{{ @$campaign->category->name }}</span>
                                        </td>
                                        <td>
                                            {{ @$campaign->user->fullname }}
                                            <a class="d-block" href="{{ appendQuery('search', @$campaign->user->username) }}"><span>@</span>{{ @$campaign->user->username }}</a>
                                        </td>
                                        <td>
                                            <span class="text--primary d-block"> {{ showDateTime($campaign->deadline) }} </span>
                                            {{ diffForHumans($campaign->deadline) }}
                                        </td>
                                        <td>
                                            @php
                                                $donor = $campaign->donations->where('status', Status::DONATION_PAID);
                                                $donation = $donor->sum('donation');
                                            @endphp

                                            <span class="text--primary"> {{ showAmount($campaign->goal) }}</span>
                                            <br>
                                            @lang('Raised'): <span class="@if ($donation <= $campaign->goal) text--warning @else text--success @endif">{{ showAmount($donation) }}</span>
                                        </td>
                                        <td>
                                            <span
                                                  class="fw-bold text--primary">{{ showAmount($campaign->extend_goal) }}</span>
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary ms-1 mb-2" href="{{ route('admin.fundrise.details', $campaign->id) }}">
                                                    <i class="las la-desktop"></i> @lang('Details')
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>

                @if ($campaigns->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($campaigns) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
@endpush

@push('script')
    <script>
        'use strict';

        $('.deactivateBtn').on('click', function() {
            $('#modalDelete').find('a').attr('href', $(this).data('src'));
            $('#modalDelete').modal('show');
        });

        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable .filt").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    </script>
@endpush
