@extends($activeTemplate.'layouts.master')
@section('content')
<div class="transaction-section padding-top padding-bottom">
    <div class="container">
        <div class="primary-bg item-rounded">
            <div class="text-end p-3">
                <a href="{{route('ticket.open') }}" class="custom-button theme btn-sm text-white"><i class="fas fa-plus"></i> @lang('New Ticket')</a>
            </div>
            <table class="deposite-table">
                <thead class="custom--table">
                    <tr>
                        <th>@lang('Subject')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Priority')</th>
                        <th>@lang('Last Reply')</th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($supports as $key => $support)
                        <tr>
                            <td> <a href="{{ route('ticket.view', $support->ticket) }}" class="text-white"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                            <td>
                                @if($support->status == 0)
                                    <span class="badge badge--success py-2 px-3">@lang('Open')</span>
                                @elseif($support->status == 1)
                                    <span class="badge badge--primary py-2 px-3">@lang('Answered')</span>
                                @elseif($support->status == 2)
                                    <span class="badge badge--warning py-2 px-3">@lang('Customer Reply')</span>
                                @elseif($support->status == 3)
                                    <span class="badge badge--dark py-2 px-3">@lang('Closed')</span>
                                @endif
                            </td>
                            <td>
                                @if($support->priority == 1)
                                    <span class="badge badge--dark py-2 px-3">@lang('Low')</span>
                                @elseif($support->priority == 2)
                                    <span class="badge badge--success py-2 px-3">@lang('Medium')</span>
                                @elseif($support->priority == 3)
                                    <span class="badge badge--primary py-2 px-3">@lang('High')</span>
                                @else
                                     <span class="badge badge--info py-2 px-3">@lang('N/A')</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>
                            <td>
                                <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn--primary btn-sm">
                                    <i class="fa fa-desktop"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">{{__($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{paginateLinks($supports)}}
            </div>
        </div>
    </div>
@endsection
