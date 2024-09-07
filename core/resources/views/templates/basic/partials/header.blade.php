<header class="header-section">
    <div class="container">
        <div class="header-wrapper">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="logo">
                </a>
            </div>
            <ul class="menu">
                <li>
                    <a href="{{ route('home') }}">@lang('Home')</a>
                </li>

                @foreach ($pages as $k => $data)
                    <li><a href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a></li>
                @endforeach

                <li>
                    <a href="{{ route('plan') }}">@lang('Plan')</a>
                </li>

                <li>
                    <a href="{{ route('blog') }}">@lang('Blog')</a>
                </li>

                <li>
                    <a href="{{ route('contact') }}">@lang('Contact')</a>
                </li>
                @guest
                    <li class="d-md-none">
                        <a href="{{ route('user.login') }}" class="custom-button theme py-0 m-1">@lang('Sign In')</a>
                    </li>
                @endguest

                @auth
                    <li class="d-md-none">
                        <a href="{{ route('user.home') }}" class="custom-button theme py-0 m-1">@lang('Dashboard')</a>
                    </li>
                @endauth

            </ul>
            <div class="right-area ms-lg-0 ms-auto">
                
                @if ($general->language == 1)
                    <select name="language" class="select-bar langSel">
                        @foreach ($language as $item)
                            <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>
                                {{ __($item->name) }}</option>
                        @endforeach
                    </select>
                @endif

                @guest
                    <a href="{{ route('user.login') }}" class="custom-button theme hover-cl-light d-none d-md-flex">
                        @lang('Sign In')
                    </a>
                @endguest

                @auth
                    <a href="{{ route('user.home') }}"
                        class="custom-button theme hover-cl-light d-none d-md-flex">@lang('Dashboard')</a>
                @endauth

            </div>
            <div class="header-bar ms-2 ms-md-4">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>
