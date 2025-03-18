@extends($activeTemplate . 'layouts.app')
@section('panel')
    @if (!request()->routeIs('home'))
        @include($activeTemplate . 'partials.breadcrumb')
    @endif
    <div class="page-wrapper">
        @yield('content')
    </div>
@endsection

