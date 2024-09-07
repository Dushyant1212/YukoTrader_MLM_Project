@extends($activeTemplate .'layouts.frontend')
@section('content')
<div class="container padding-bottom padding-top">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card custom--card primary-bg">
                <div class="card-body">
                    <h3 class="text-center text--danger mb-3">@lang('You are banned')</h3>
                    <p class="fw-bold mb-1">@lang('Reason'):</p>
                    <p>{{ $user->ban_reason }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
