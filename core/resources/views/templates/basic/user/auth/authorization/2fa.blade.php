@extends($activeTemplate .'layouts.frontend')
@section('content')
<div class="container padding-top padding-bottom">
    <div class="d-flex justify-content-center">
        <div class="verification-code-wrapper primary-bg">
            <div class="verification-area">
                <h5 class="pb-3 text-center border-bottom base--color mb-3">@lang('2FA Verification')</h5>
                <form action="{{route('user.go2fa.verify')}}" method="POST" class="submit-form">
                    @csrf
                    @include($activeTemplate.'partials.verification_code')

                    <div class="contact-form-group">
                        <button type="submit" class="w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
    <style>
        .submit-form .mb-3 label {
        color: #ffffff;
        margin-bottom: 13px;
}
    </style>
@endpush
