@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card custom--card primary-bg profile-wrapper">
                        <div class="card-body">
                            <form class="register" action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="contact-form-group col-sm-6 contact-form-group">
                                        <label class="form-label">@lang('First Name')</label>
                                        <input type="text"  name="firstname"
                                            value="{{ $user->firstname }}" required>
                                    </div>
                                    <div class="contact-form-group contact-form-group col-sm-6">
                                        <label class="form-label">@lang('Last Name')</label>
                                        <input type="text"  name="lastname"
                                            value="{{ $user->lastname }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="contact-form-group contact-form-group col-sm-6">
                                        <label class="form-label">@lang('E-mail Address')</label>
                                        <input  value="{{ $user->email }}" readonly>
                                    </div>
                                    <div class="contact-form-group contact-form-group col-sm-6">
                                        <label class="form-label">@lang('Mobile Number')</label>
                                        <input  value="{{ $user->mobile }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="contact-form-group contact-form-group col-sm-6">
                                        <label class="form-label">@lang('Address')</label>
                                        <input type="text"  name="address"
                                            value="{{ @$user->address->address }}">
                                    </div>
                                    <div class="contact-form-group contact-form-group col-sm-6">
                                        <label class="form-label">@lang('State')</label>
                                        <input type="text"  name="state"
                                            value="{{ @$user->address->state }}">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="contact-form-group col-sm-4 contact-form-group">
                                        <label class="form-label">@lang('Zip Code')</label>
                                        <input type="text"  name="zip"
                                            value="{{ @$user->address->zip }}">
                                    </div>

                                    <div class="contact-form-group contact-form-group col-sm-4">
                                        <label class="form-label">@lang('City')</label>
                                        <input type="text"  name="city"
                                            value="{{ @$user->address->city }}">
                                    </div>

                                    <div class="contact-form-group contact-form-group col-sm-4">
                                        <label class="form-label">@lang('Country')</label>
                                        <input  value="{{ @$user->address->country }}"
                                            disabled>
                                    </div>

                                </div>

                                <div class="contact-form-group contact-form-group">
                                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
