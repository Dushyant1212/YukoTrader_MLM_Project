@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = getContent('contact_us.content', true);
    @endphp
    <div class="contact-section padding-top padding-bottom">
        <div class="container">
            <div class="row g-4 justify-content-center mb-5">
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item">
                        <div class="contact__icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact__body">
                            <h5 class="contact__title">@lang('Phone')</h5>
                            <ul class="contact__info">
                                <li>
                                    <a
                                        href="Tel:{{ @$content->data_values->contact_number }}">{{ __(@$content->data_values->contact_number) }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item">
                        <div class="contact__icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact__body">
                            <h5 class="contact__title">@lang('Email')</h5>
                            <ul class="contact__info">
                                <li>
                                    <a
                                        href="mailto:{{ __(@$content->data_values->email_address) }}">{{ __(@$content->data_values->email_address) }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item">
                        <div class="contact__icon">
                            <i class="fas fa-map-marker"></i>
                        </div>
                        <div class="contact__body">
                            <h5 class="contact__title">@lang('Address')</h5>
                            <ul class="contact__info">
                                <li>
                                    <a href="javascript:void(0)">{{ __(@$content->data_values->contact_address) }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-wrapper">
                <h3 class="title text-center cl-white mb-20 mb-lg-4">{{ __(@$content->data_values->title) }}</h3>
                <form class="contact-form row mb--25 verify-gcaptcha" action="" method="POST">
                    @csrf
                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label>@lang('Name')</label>
                            <input type="text" placeholder="@lang('Enter Name')" id="name"
                                value="@if (auth()->user()){{ auth()->user()->fullname }}@else{{ old('name') }}@endif"
                                @if (auth()->user()) readonly @endif required name="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label>@lang('Email')</label>
                            <input type="email" placeholder="@lang('Enter Email')" id="email"
                                value="@if (auth()->user()) {{ auth()->user()->email }} @else {{ old('email') }} @endif"
                                @if (auth()->user()) readonly @endif required name="email">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label>@lang('Subject')</label>
                            <input type="text" placeholder="@lang('Enter Subject')" id="subject"
                                value="{{ old('subject') }}" required name="subject">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label>@lang('Message')</label>
                            <textarea name="message" id="message" placeholder="@lang('Enter Message')" required="">{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <x-captcha />
                    </div>

                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <button type="submit" class="w-100">@lang('Send Message')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
