@php
    $content = getContent('plan.content', true);
    $plans = App\Models\Plan::where('status', Status::ENABLE)
        ->orderBy('id', 'ASC')
        ->limit(3)
        ->get();
@endphp
<section class="plan-section padding-top padding-bottom oh">
    <div class="container">
        <div class="section-header">
            <h2 class="title">{{ __(@$content->data_values->heading) }}</h2>
            <p>{{ __(@$content->data_values->sub_heading) }}</p>
        </div>
        <div class="row justify-content-center">
            @foreach ($plans as $plan)
                <div class="col-md-6 col-lg-4">
                    <div class="plan-item">
                        <div class="plan-header">
                            <span class="plan-badge">
                                {{ __($plan->name) }}
                            </span>
                            <div class="icon">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                            <h3 class="title">{{ __($general->cur_sym) }}{{ getAmount($plan->price) }}</h3>
                        </div>
                        <ul class="plan-info">
                            <li>
                                <h6 class="direct">@lang('Direct Referral Bonus') :
                                    {{ $general->cur_sym }}{{ getAmount($plan->referral_bonus) }}</h6>
                            </li>

                            @php
                                $sumCommission = 0;
                            @endphp

                            @foreach ($plan->totalLevel($plan->id) as $value)
                                @php
                                    $matrixCal = pow($general->matrix_width, $loop->iteration);
                                    $commission = getAmount($value->amount * $matrixCal);
                                    $sumCommission += $commission;
                                @endphp

                                <li>
                                    @lang('L'){{ $loop->iteration }} :
                                    {{ $general->cur_sym }}{{ getAmount($value->amount) }} X {{ $matrixCal }} <i
                                        class="fa fa-users"></i> = <strong
                                        class="profit">{{ __($general->cur_sym) }}{{ $commission }}</strong>
                                </li>
                            @endforeach
                        </ul>
                        <div class="total-return">
                            <h6 class="title">@lang('Total Level Commission') : {{ showAmount($sumCommission) }}
                                {{ __($general->cur_text) }}</h6>
                            <span class="return-remainders">
                                @lang('Returns') <span
                                    class="remainder">{{ getAmount(($sumCommission / $plan->price) * 100) }}%</span>
                                @lang('of Invest')
                            </span>
                        </div>

                        <div class="invest-now py-3">
                            <button type="button" class="btn btn--base btn-lg confirmationBtn"
                                data-question="@lang('Are you sure you want to subscribe this plan')"
                                data-action="{{ route('user.plan.order',$plan->id)}}">@lang('Invest Now')
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <x-confirmation-modal is_custom="yes" />

</section>
