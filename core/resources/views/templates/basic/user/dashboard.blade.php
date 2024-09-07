@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $kycInfo = getContent('kyc_info.content', true);
    @endphp
    <div class="dashboard-section padding-top padding-bottom">
        <div class="container">

            @if (auth()->user()->kv == 0)
                <div class="alert alert-info" role="alert">
                    <h5 class="alert-heading">@lang('KYC Verification required')</h5>
                    <hr>
                    <p class="mb-0">{{ __($kycInfo->data_values->verification_content) }} <a href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a></p>
                </div>
            @elseif(auth()->user()->kv == 2)
                <div class="alert alert-warning" role="alert">
                    <h5 class="alert-heading">@lang('KYC Verification pending')</h5>
                    <hr>
                    <p class="mb-0">{{ __($kycInfo->data_values->pending_content) }} <a href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                </div>
            @endif


            <div class="row justify-content-center mb-30-none">
                <div class="col-md-12">
                    <div class="input-group contact-form-group">
                        <input type="text" name="key" value="{{ route('home') }}?reference={{ $username }}"
                            class="form-control referralURL referral-input" readonly>
                        <button type="button" class="input-group-text copytext bg--base border--base text-white"
                            id="copyBoard"> <i class="fa fa-copy"></i> </button>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Current Balance')</h5>
                            <h4 class="amount">{{ $general->cur_sym }}{{ showAmount($balance) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Deposit')</h5>
                            <h4 class="amount">{{ $general->cur_sym }}{{ showAmount($deposit) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="far fa-credit-card"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Withdraw')</h5>
                            <h4 class="amount">{{ $general->cur_sym }}{{ showAmount($withdraw) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Total Transactions')</h5>
                            <h4 class="amount">{{ $transaction }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Total Commission')</h5>
                            <h4 class="amount">{{ $general->cur_sym }}{{ showAmount($commission) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('My Plan')</h5>
                            <h4 class="amount">{{ __($user->plan->name ?? 'N/A') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-5">
                    <div class="card custom--card primary-bg">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Latest Trasactions')</h5>
                        </div>
                        <div class="card-body p-0">
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
                                            <td class="budget">
                                                <strong
                                                    @if ($trx->trx_type == '+') class="text--success" @else class="text--danger" @endif>
                                                    {{ $trx->trx_type == '+' ? '+' : '-' }} {{ getAmount($trx->amount) }}
                                                    {{ __($general->cur_text) }}
                                                </strong>
                                            </td>
                                            <td class="budget">
                                                {{ __(__($general->cur_sym)) }}
                                                {{ getAmount($trx->charge) }}
                                            </td>
                                            <td>{{ getAmount($trx->post_balance) }}
                                                {{ __($general->cur_text) }}
                                            </td>
                                            <td>{{ __($trx->details) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%">{{ __($emptyMessage) }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#copyBoard').click(function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .copied::after {
            background-color: #{{ $general->base_color }};
        }
    </style>
@endpush
