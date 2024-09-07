@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="transaction-section padding-top padding-bottom">
        <div class="container">
            <div class="primary-bg item-rounded">
                <table class="deposite-table">
                    <thead class="custom--table">
                        <tr>
                            <th>@lang('User')</th>
                            <th>@lang('TRX')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Post Balance')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Detail')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commissions as $commission)
                            <tr>
                                <td>{{ $commission->fromUser->username }}</td>
                                <td>{{ $commission->trx }}</td>
                                <td class="budget">
                                    <strong class="text--success">+ {{ getAmount($commission->amount) }}
                                        {{ __($general->cur_text) }}</strong>
                                </td>
                                <td>{{ getAmount($commission->post_balance) }}
                                    {{ __($general->cur_text) }}</td>
                                <td>
                                    {{ showDateTime($commission->created_at) }}
                                    <br>
                                    {{ diffForHumans($commission->created_at) }}
                                </td>
                                <td>{{ __($commission->details) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{paginateLinks($commissions)}}
            </div>
        </div>
    </div>
@endsection
