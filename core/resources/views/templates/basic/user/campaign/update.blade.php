@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="pt-90 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 p-lg-5 p-md-4 p-3 card custom--card">
                    <form class="action-form" action="{{ route('user.campaign.fundrise.update.store', $campaign->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">@lang('Updation')</label>
                            <textarea class="form-control nicEdit" name="updation" rows="10">{{ old('updation', @$campaign->campaignUpdate->updation) }}</textarea>
                            <small>@lang('It can be a detailed text describing why the campaign is running and how the donations will work').</small>
                        </div>
                        <button class="btn cmn-btn w-100" type="submit" type="submit">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

