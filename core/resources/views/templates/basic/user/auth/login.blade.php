@extends($activeTemplate . 'layouts.app')
@section('panel')
    <section class="account-section">
        <div class="left"
            style="background-image: url('{{ getImage('assets/images/frontend/auth/' . @getContent('auth.content', true)->data_values->image) }}');">
            <div class="left-inner text-center">
                <h6 class="text--base">@lang('Welcome back')</h6>
                <h3 class="title text-white mt-2">@lang('Sign In to your account')</h3>
            </div>
        </div>

        <div class="right">
            <div class="top w-100 text-center">
                <a href="{{ route('home') }}" class="account-logo"><img
                        src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('logo')"></a>
            </div>
            <div class="middle w-100">
                <form method="POST" action="{{ route('user.login') }}"
                    class="contact-form row mb--25 align-items-center verify-gcaptcha">
                    @csrf
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label>@lang('Username or Email')</label>
                            <input type="text" value="{{ old('username') }}"
                                id="username" name="username" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label>@lang('Your Password')</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <x-captcha />
                    </div>

                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <button type="submit" class="w-100">@lang('Sign In')</button>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="contact-form-group">
                            <p class="text-white m-0">@lang("Don'\t have an account?") <a href="{{ route('user.register') }}"
                                    class="text-theme">@lang('Sign Up')</a></p>
                        </div>
                    </div>

                    <div class="col-xl-4 text-xl-end">
                        <div class="contact-form-group">
                            <a href="{{ route('user.password.request') }}" class="text-theme">@lang('Forgot Password')</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bottom w-100 text-center">
                <p class="text-white">&copy; @lang('All Right Reserved By') <a href="{{ route('home') }}"
                        class="text-theme">{{ __($general->site_name) }}</a></p>
            </div>
        </div>
    </section>
@endsection
