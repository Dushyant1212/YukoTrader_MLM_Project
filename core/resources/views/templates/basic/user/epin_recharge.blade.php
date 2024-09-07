@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="transaction-section padding-top padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="primary-bg item-rounded">
                        <div class="p-3">
                        <div class="support-header d-flex flex-wrap justify-content-between align-items-center">
                            <form action="{{ route('user.erecharge') }}" method="POST" class="support-search w-100">
                                @csrf
                                <div class="input-group contact-from-group">
                                    <input type="text" placeholder="Enter Pin" name="pin" required="">
                                    <button type="submit">@lang('Recharge Now')</button>
                                </div>
                            </form>
                            <button data-bs-toggle="modal" data-bs-target="#generatePin"
                                class="btn btn--base"><i class="fa fa-fw fa-paper-plane"></i> @lang('Create Pin')</button>
                        </div>
                        </div>
                        <table class="deposite-table">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Pin')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Details')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pins as $pin)
                                    <tr>
                                        <td>
                                            @if ($pin->user_id)
                                                <span>{{ __($pin->user->username) }}</span>
                                            @else
                                                <span>@lang('N/A')</span>
                                            @endif
                                        </td>
                                        <td>{{ getAmount($pin->amount) }}
                                            {{ __($general->cur_text) }}</td>
                                        <td>{{ $pin->pin }}</td>
                                        <td>
                                            @if ($pin->status == 1)
                                                <span class="badge badge--success">@lang('Used')</span>
                                                <br>
                                                {{ diffforhumans($pin->updated_at) }}
                                            @elseif($pin->status == 0)
                                                <span class="badge badge--danger">@lang('Unused')</span>
                                            @endif
                                        </td>
                                        <td>{{ __($pin->details) }}</td>
                                        <td>
                                            {{ showDateTime($pin->created_at) }}
                                            <br>
                                            {{ diffforhumans($pin->created_at) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{paginateLinks($pins)}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade custom--modal" id="generatePin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Created Pin')</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('user.pin.generate') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="contact-form-group">
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="amount" placeholder="@lang('Enter Amount')"
                                    value="{{ old('amount') }}" aria-describedby="basic-addon2" step="any" required="">
                                <div class="input-group-text">
                                    {{ __($general->cur_text) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary bg--base">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
