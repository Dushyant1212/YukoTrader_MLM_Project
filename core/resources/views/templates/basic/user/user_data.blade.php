@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <div class="padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-7">
                    <div class="card custom--card primary-bg">
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.data.submit') }}">
                                @csrf
                                <div class="row">
                                    <div class="contact-form-group col-sm-6 contact-form-group">
                                        <label class="form-label">@lang('First Name')</label>
                                        <input type="text" class="form-control form--control" name="firstname"
                                            value="{{ old('firstname') }}" required>
                                    </div>

                                    <div class="contact-form-group col-sm-6 contact-form-group">
                                        <label class="form-label">@lang('Last Name')</label>
                                        <input type="text" class="form-control form--control" name="lastname"
                                            value="{{ old('lastname') }}" required>
                                    </div>
                                    <div class="contact-form-group col-sm-6 contact-form-group">
                                        <label class="form-label">@lang('Address')</label>
                                        <input type="text" class="form-control form--control" name="address"
                                            value="{{ old('address') }}">
                                    </div>
                                    <div class="contact-form-group col-sm-6 contact-form-group">
                                        <label class="form-label">@lang('State')</label>
                                        <input type="text" class="form-control form--control" name="state"
                                            value="{{ old('state') }}">
                                    </div>
                                    <div class="contact-form-group col-sm-6 contact-form-group">
                                        <label class="form-label">@lang('Zip Code')</label>
                                        <input type="text" class="form-control form--control" name="zip"
                                            value="{{ old('zip') }}">
                                    </div>

                                    <div class="contact-form-group col-sm-6 contact-form-group">
                                        <label class="form-label">@lang('City')</label>
                                        <input type="text" class="form-control form--control" name="city"
                                            value="{{ old('city') }}">
                                    </div>
                                </div>
                                <div class="contact-form-group contact-form-group">
                                    <button type="submit" class="btn btn--base w-100">
                                        @lang('Submit')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
