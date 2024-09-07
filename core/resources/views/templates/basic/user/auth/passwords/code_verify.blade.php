@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="d-flex justify-content-center">
                        <div class="verification-code-wrapper primary-bg">
                            <div class="verification-area">
                                <h5 class="pb-3 mb-3 text-center border-bottom base--color">@lang('Verify Email Address')</h5>
                                <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form">
                                    @csrf
                                    <p class="verification-text text-white">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
                                    <input type="hidden" name="email" value="{{ $email }}">

                                    @include($activeTemplate . 'partials.verification_code')

                                    <div class="form-group">
                                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                    </div>

                                    <div class="form-group text-white">
                                        @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                        <a href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                                    </div>

                                </form>
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
        .submit-form .mb-3 label {
        color: #ffffff;
        margin-bottom: 13px;
}
    </style>
@endpush
