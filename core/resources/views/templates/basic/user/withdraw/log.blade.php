@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="transaction-section padding-top padding-bottom">
        <div class="container">
            <div class="primary-bg item-rounded">
                <form action="">
                    <div class="d-flex justify-content-end pt-3 mx-3">
                        <div class="input-group contact-form-group w-50">
                            <input type="text" name="search" class="form-control" value="{{ request()->search }}" placeholder="@lang('Search by transactions')">
                            <button class="input-group-text bg--base text-white">
                                <i class="las la-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="deposite-table">
                        <thead class="custom--table">
                            <tr>
                                <th>@lang('Gateway | Transaction')</th>
                                <th class="text-center">@lang('Initiated')</th>
                                <th class="text-center">@lang('Amount')</th>
                                <th class="text-center">@lang('Conversion')</th>
                                <th class="text-center">@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($withdraws as $withdraw)
                                <tr>
                                    <td>
                                        <span class="fw-bold"><span class="text-primary">
                                                @if (@$withdraw->method->name)
                                                {{ __(@$withdraw->method->name) }}
                                            @else
                                                @lang('E-pin')
                                            @endif

                                            </span></span>
                                        <br>
                                        <small>{{ $withdraw->trx }}</small>
                                    </td>
                                    <td class="text-center">
                                        {{ showDateTime($withdraw->created_at) }} <br>
                                        {{ diffForHumans($withdraw->created_at) }}
                                    </td>
                                    <td class="text-center">
                                        {{ __($general->cur_sym) }}{{ showAmount($withdraw->amount) }} - <span
                                            class="text--danger"
                                            title="@lang('charge')">{{ showAmount($withdraw->charge) }} </span>
                                        <br>
                                        <strong title="@lang('Amount after charge')">
                                            {{ showAmount($withdraw->amount - $withdraw->charge) }}
                                            {{ __($general->cur_text) }}
                                        </strong>

                                    </td>
                                    <td class="text-center">
                                        1 {{ __($general->cur_text) }} = {{ showAmount($withdraw->rate) }}
                                        {{ __($withdraw->currency) }}
                                        <br>
                                        <strong>{{ showAmount($withdraw->final_amount) }}
                                            {{ __($withdraw->currency) }}
                                        </strong>
                                    </td>
                                    <td class="text-center">
                                        @php echo $withdraw->statusBadge @endphp
                                    </td>
                                    <td>
                                        <button class="btn btn-sm h-auto btn--primary @if($withdraw->withdraw_information) detailBtn @else disabled @endif"
                                            data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                            @if ($withdraw->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $withdraw->admin_feedback }}" @endif>
                                            <i class="fa fa-desktop"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($withdraws->hasPages())
                    {{paginateLinks($withdraws)}}
                @endif
            </div>
        </div>
    </div>



    {{-- APPROVE MODAL --}}
    <div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData">

                    </ul>
                    <div class="feedback"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var userData = $(this).data('user_data');
                var html = ``;
                userData.forEach(element => {
                    if (element.type != 'file') {
                        html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center primary-bg text-white">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                    }
                });
                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);

                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
