@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="transaction-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">

                @if (!request()->routeIs('user.recharge.log'))
                    <div class="col-md-12">
                        <div class="show-filter mb-3 text-end">
                            <button type="button" class="btn btn--base showFilterBtn btn-sm"><i class="las la-filter"></i>
                                @lang('Filter')</button>
                        </div>
                        <div class="card responsive-filter-card mb-4 primary-bg">
                            <div class="card-body">
                                <form action="">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="flex-grow-1 contact-form-group">
                                            <label>@lang('Transaction Number')</label>
                                            <input type="text" name="search" value="{{ request()->search }}"
                                                class="form-control form--control">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="contact-form-group">
                                                <label>@lang('Type')</label>
                                                <div class="select-item">
                                                    <select name="trx_type" class="select-bar">
                                                        <option value="">@lang('All')</option>
                                                        <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')
                                                        </option>
                                                        <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="contact-form-group">
                                                <label>@lang('Remark')</label>
                                                <select class="select-bar" name="remark">
                                                    <option value="">@lang('Any')</option>
                                                    @foreach ($remarks as $remark)
                                                        <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                                            {{ __(keyToTitle($remark->remark)) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 align-self-end">
                                            <div class="contact-form-group">
                                                <button class="btn btn--base w-100"><i class="las la-filter"></i>
                                                    @lang('Filter')</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="primary-bg item-rounded">
                <table class="deposite-table">
                    <thead class="custom--table">
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('TRX')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Charge')</th>
                            <th>@lang('Post Balance')</th>
                            <th>@lang('Detail')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                            <tr>
                                <td>
                                    {{ showDateTime($trx->created_at) }}
                                    <br>
                                    {{ diffforhumans($trx->created_at) }}
                                </td>

                                <td>
                                    {{ $trx->trx }}
                                </td>

                                <td>
                                    <strong
                                        @if ($trx->trx_type == '+') class="text--success" @else class="text--danger" @endif>
                                        {{ $trx->trx_type == '+' ? '+' : '-' }} {{ getAmount($trx->amount) }}
                                        {{ __($general->cur_text) }}</strong>
                                </td>

                                <td>
                                    {{ getAmount($trx->charge) }} {{ __($general->cur_text) }}
                                </td>
                                <td>
                                    {{ getAmount($trx->post_balance) }} {{ __($general->cur_text) }}</td>
                                <td class="text-end">
                                    {{ __($trx->details) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($transactions->hasPages() )
                    <div class="py-3">
                        {{paginateLinks($transactions) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
