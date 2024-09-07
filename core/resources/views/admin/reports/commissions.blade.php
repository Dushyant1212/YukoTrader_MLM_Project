@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Trx')</th>
                                    <th>@lang('User By')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Post Balance')</th>
                                    <th>@lang('Detail')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commissions as $commission)
                                    <tr>
                                        <td>
                                            <span>{{ $commission->user->fullname }}</span>
                                            <br>
                                            <span class="small"> <a
                                                    href="{{ route('admin.users.detail', $commission->user_id) }}"><span>@</span>{{ $commission->user->username }}</a>
                                            </span>
                                        </td>

                                        <td>
                                            <strong>{{ $commission->trx }}</strong>
                                        </td>


                                        <td>
                                            <span>{{ $commission->fromUser->fullname }}</span>
                                            <br>
                                            <span class="small"> <a
                                                    href="{{ route('admin.users.detail', $commission->from_user_id) }}"><span>@</span>{{ $commission->fromUser->username }}</a>
                                            </span>
                                        </td>

                                        <td>
                                            {{ showDateTime($commission->created_at) }}<br>{{ diffForHumans($commission->created_at) }}
                                        </td>

                                        <td class="budget">
                                            <span class="text--success">
                                                + {{ showAmount($commission->amount) }} {{ __($general->cur_text) }}
                                            </span>
                                        </td>

                                        <td class="budget">
                                            {{ showAmount($commission->post_balance) }} {{ __($general->cur_text) }}
                                        </td>


                                        <td>{{ __($commission->details) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if($commissions->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($commissions) @endphp
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    @if (request()->routeIs('admin.users.referral.commission') || request()->routeIs('admin.users.level.commission'))
        <form action="" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="@lang('TRX.....')"
                    value="{{ $search ?? '' }}">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    @else
        <form action="{{ route('admin.report.commissions.search') }}" method="GET"
            class="form-inline float-sm-right bg--white b-2 ml-0 ml-xl-2 ml-lg-0">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')"
                    value="{{ $search ?? '' }}">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>

        <form action="{{ route('admin.report.commissions.log') }}" method="GET"
            class="form-inline float-sm-right bg--white">
            <div class="input-group">
                <select class="form-control" name="commissions">
                    @if (@$commi == 1)
                        <option value="2">@lang('Level Commissions')</option>
                        <option value="1" selected="">@lang('Referrals Commissions')</option>
                    @elseif(@$commi == 2)
                        <option value="2" selected>@lang('Level Commissions')</option>
                        <option value="1">@lang('Referrals Commissions')</option>
                    @else
                        <option>@lang('Select One')</option>
                        <option value="2">@lang('Level Commissions')</option>
                        <option value="1">@lang('Referrals Commissions')</option>
                    @endif
                </select>
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    @endif
@endpush
