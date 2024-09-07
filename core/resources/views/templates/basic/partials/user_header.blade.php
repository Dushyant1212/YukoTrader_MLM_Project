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
                    <a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                </li>

                <li class="menu-item-has-children">
                    <a href="javascript:void(0)">@lang('Deposit')</a>
                    <ul class="submenu">
                        <li>
                            <a href="{{route('user.deposit.index')}}">@lang('Deposit Money')</a>
                        </li>
                        <li>
                            <a href="{{route('user.deposit.history')}}">@lang('Deposit History')</a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item-has-children">
                    <a href="javascript:void(0)">@lang('Withdraw')</a>
                    <ul class="submenu">
                        <li>
                            <a href="{{route('user.withdraw')}}">@lang('Withdraw Money')</a>
                        </li>
                        <li>
                            <a href="{{route('user.withdraw.history')}}">@lang('Withdraw History')</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('plan') }}">@lang('Plan')</a>
                </li>

                <li>
                    <a href="{{ route('user.transactions') }}">@lang('Transactions')</a>
                </li>

                <li class="menu-item-has-children">
                    <a href="javascript:void(0)">@lang('Referrals')</a>
                    <ul class="submenu">
                        <li>
                            <a href="{{route('user.referral.log')}}">@lang('Referred Users')</a>
                        </li>

                        <li>
                            <a href="{{route('user.referral.commissions')}}">@lang('Referrals Commissions')</a>
                        </li>

                        <li>
                            <a href="{{route('user.level.commissions')}}">@lang('Level Commissions')</a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item-has-children">
                    <a href="javascript:void(0)">Account</a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('user.profile.setting') }}">@lang('Profile Setting')</a>
                        </li>
                        @if ($general->balance_transfer == 1)
                            <li>
                                <a href="{{ route('user.balance.transfer') }}">@lang('Balance Transfer')</a>
                            </li>
                        @endif

                        @if ($general->epin_status == 1)
                            <li>
                                <a href="{{ route('user.epin.recharge') }}">@lang('E-Pin Recharge')</a>
                            </li>
                            <li>
                                <a href="{{ route('user.recharge.log') }}">@lang('Recharge Log')</a>
                            </li>
                        @endif

                        <li>
                            <a href="{{route('user.change.password')}}">@lang('Change Password')</a>
                        </li>

                        <li>
                            <a href="{{route('ticket.index')}}">@lang('Support Ticket')</a>
                        </li>

                        <li>
                            <a href="{{ route('user.twofactor') }}">@lang('2FA Security')</a>
                        </li>

                        <li>
                            <a href="{{ route('user.logout') }}">@lang('Logout')</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="header-bar ml-2 ml-md-4">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>
