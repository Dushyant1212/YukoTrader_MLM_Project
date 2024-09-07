
@php
    $content = getContent('deposit_withdraw.content', true);
    $deposits = App\Models\Deposit::where('status', Status::PAYMENT_SUCCESS)->with('user', 'gateway')->orderBy('id', 'DESC')->limit(10)->get();
    $withdrwals = App\Models\Withdrawal::where('status', Status::PAYMENT_SUCCESS)->with('user', 'method')->orderBy('id', 'DESC')->limit(10)->get();
@endphp
<section class="deposit-withdraw padding-bottom padding-top">
    <div class="container">
        <div class="row mb--50">
            <div class="col-lg-6 mb-50">
                <div class="section-header margin-olpo left-style text-center">
                    <h3 class="title">{{__(@$content->data_values->deposit_heading)}}</h3>
                    <p>{{__(@$content->data_values->deposit_sub_heading)}}</p>
                </div>
                <table class="deposit-table">
                    <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Gateway')</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($deposits as $deposit)
                            <tr>
                                <td>{{__(@$deposit->user->fullname)}}</td>
                                <td>{{showAmount($deposit->amount)}} {{ __($general->cur_text) }}</td>
                                <td>{{showdateTime($deposit->created_at, 'd M Y')}}</td>
                                <td>
                                    @if($deposit->method_code != 0)
                                        {{__(@$deposit->gateway->name)}}
                                    @else
                                        @lang('E-pin')
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="col-lg-6 mb-50">
                <div class="section-header margin-olpo left-style text-center">
                    <h3 class="title">{{__(@$content->data_values->withdraw_heading)}}</h3>
                    <p>{{__(@$content->data_values->withdraw_sub_heading)}}</p>
                </div>

                <table class="deposit-table">
                    <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Method')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdrwals as $withdrwal)
                            <tr>
                                <td>{{__($withdrwal->user->fullname)}}</td>
                                <td>{{showAmount($withdrwal->amount)}} {{__($general->cur_text)}}</td>
                                <td>{{showdateTime($withdrwal->created_at, 'd M Y')}}</td>
                                <td>
                                    @if($withdrwal->method_id != 0)
                                        {{__($withdrwal->method->name)}}
                                    @else
                                        @lang('E-pin')
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
