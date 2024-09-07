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

                <table class="deposite-table">
                    <thead class="custom--table">
                        <tr>
                            <th>@lang('Gateway | Transaction')</th>
                            <th class="text-center">@lang('Initiated')</th>
                            <th class="text-center">@lang('Amount')</th>
                            <th class="text-center">@lang('Conversion')</th>
                            <th class="text-center">@lang('Status')</th>
                            <th>@lang('Details')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deposits as $deposit)
                            <tr>
                                <td>
                                    <span class="fw-bold"> <span class="text-primary">
                                            @if ($deposit->method_code != 0)
                                                {{ __(@$deposit->gateway->name) }}
                                            @else
                                                @lang('E-pin')
                                            @endif
                                        </span> </span>
                                    <br>
                                    <small> {{ $deposit->trx }} </small>
                                </td>

                                <td class="text-center">
                                    {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                </td>
                                <td class="text-center">
                                    {{ __($general->cur_sym) }}{{ showAmount($deposit->amount) }} + <span
                                        class="text--danger" title="@lang('charge')">{{ showAmount($deposit->charge) }}
                                    </span>
                                    <br>
                                    <strong title="@lang('Amount with charge')">
                                        {{ showAmount($deposit->amount + $deposit->charge) }} {{ __($general->cur_text) }}
                                    </strong>
                                </td>
                                <td class="text-center">
                                    1 {{ __($general->cur_text) }} = {{ showAmount($deposit->rate) }}
                                    {{ __($deposit->method_currency) }}
                                    <br>
                                    <strong>{{ showAmount($deposit->final_amo) }}
                                        {{ __($deposit->method_currency) }}</strong>
                                </td>
                                <td class="text-center">
                                    @php echo $deposit->statusBadge @endphp
                                </td>
                                @php
                                    $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                                @endphp

                                <td>
                                    <button
                                        class="btn btn--primary h-auto btn-sm @if ($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                        @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif
                                        @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                        <i class="fa fa-desktop"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($deposits->hasPages())
                    {{paginateLinks($deposits)}}
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
                    <ul class="list-group userData mb-2">
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
                var modal    = $('#detailModal');
                var userData = $(this).data('info');
                var html     = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center primary-bg text-white">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }

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
