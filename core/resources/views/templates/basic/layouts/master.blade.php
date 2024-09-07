@extends($activeTemplate . 'layouts.app')
@section('panel')
    @include($activeTemplate . 'partials.user_header')
    @include($activeTemplate . 'partials.breadcrumb')
    @yield('content')
    @include($activeTemplate . 'partials.footer')
@endsection
