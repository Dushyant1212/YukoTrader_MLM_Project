@extends($activeTemplate . 'layouts.app')
@section('panel')
    @php
        $policys = getContent('policy_pages.element', false, null, true);
    @endphp

    <section class="account-section style--two">
        <div class="left"
            style="background-image: url('{{ getImage('assets/images/frontend/auth/' . @getContent('auth.content', true)->data_values->image) }}');">
            <div class="left-inner text-center">
                <h6 class="text--base">@lang('Welcome back')</h6>
                <h3 class="title text-white mt-2">@lang('Sign Up to your account')</h3>
            </div>
        </div>

        <div class="right">
            <div class="top w-100 text-center">
                <a href="{{ route('home') }}" class="account-logo"><img
                        src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('logo')"></a>
            </div>
            <div class="middle w-100">
                <form action="{{ route('user.register') }}" method="POST"
                    class="contact-form row mb--25 align-items-center verify-gcaptcha">
                    @csrf
                    @if (session()->get('reference') != null)
                        <div class="col-md-12">
                            <div class="contact-form-group">
                                <label>@lang('Reference By')</label>
                                <input type="text" name="referBy" id="referenceBy"
                                    value="{{ session()->get('reference') }}" readonly>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label>@lang('Username')</label>
                            <input type="text" placeholder="@lang('Username')" id="username" class="checkUser"
                                value="{{ old('username') }}" required name="username">
                                <small class="text--danger usernameExist"></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label>@lang('Email Address')</label>
                            <input type="email" placeholder="@lang('Email Address')" id="email" class="checkUser"
                                value="{{ old('email') }}" required name="email">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label>{{ __('Country') }}</label>
                            <div class="select-item">
                                <select name="country" id="country" class="select-bar">
                                    @foreach ($countries as $key => $country)
                                        <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}"
                                            data-code="{{ $key }}">
                                            {{ __($country->country) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label>@lang('Mobile')</label>
                            <div class="input-group ">

                                <span class="input-group-text mobile-code">

                                </span>
                                <input type="hidden" name="mobile_code">
                                <input type="hidden" name="country_code">

                                <input type="number" name="mobile" id="mobile" value="{{ old('mobile') }}"
                                    class="form-control checkUser" placeholder="@lang('Your Phone Number')">
                            </div>
                            <small class="text--danger mobileExist"></small>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label>@lang('Password')</label>
                            <div class="form-group">
                                <input type="password" placeholder="@lang('Enter Password')" id="password" required
                                    name="password">
                                @if ($general->secure_password)
                                    <div class="input-popup">
                                        <p class="error lower">@lang('1 small letter minimum')</p>
                                        <p class="error capital">@lang('1 capital letter minimum')</p>
                                        <p class="error number">@lang('1 number minimum')</p>
                                        <p class="error special">@lang('1 special character minimum')</p>
                                        <p class="error minimum">@lang('6 character password')</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label>@lang('Confirm Password')</label>
                            <input type="password" placeholder="@lang('Confirm Password')" id="password" required
                                name="password_confirmation">
                        </div>
                    </div>

                    <div class="col-md-12 captcha">
                        <x-captcha />
                    </div>

                    @if ($general->agree)
                        <div class="col-md-12">
                            <div class="contact-form-group checkgroup">
                                <input type="checkbox" id="check" name="agree" required>
                                <label for="check">@lang('I agree with')
                                    @foreach ($policys as $policy)
                                        <a class="text-theme"
                                            href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">{{ __($policy->data_values->title) }}</a>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </label>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <button type="submit" class="mt-3">@lang('Create Account')</button>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <div class="contact-form-group">
                            <p class="text-white m-0">@lang('Already have an account?') <a href="{{ route('user.login') }}"
                                    class="text-theme">@lang('Sign In')</a></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bottom w-100 text-center">
                <p class="text-white">&copy; @lang('All Right Reserved By') <a href="{{ route('home') }}"
                        class="text-theme">{{ __($general->site_name) }}</a>
                 </p>
            </div>
        </div>
    </section>

    <div class="modal fade custom--modal" id="existModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('You are with us')</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-white">@lang('You already have an account please Sign in ')</p>
                </div>
                <div class="modal-footer">
                    <button href="javascript:void(0)" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="custom-button theme btn-sm text-white">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .country-code .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }
    </style>
@endpush

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif
            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
