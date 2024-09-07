@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="card custom--card primary-bg p-3">
                        <div class="card-body">
                            <div class="mb-4">
                                <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                            </div>
                            <form method="POST" action="{{ route('user.password.email') }}">
                                @csrf
                                <div class="contact-form-group">
                                    <label class="form-label">@lang('Email or Username')</label>
                                    <input type="text" class="form-control form--control" autofocus name="value"
                                        value="{{ old('value') }}" required autofocus="off">
                                </div>
                                <div class="contact-form-group">
                                    <button type="submit" class="w-100 btn--base">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
