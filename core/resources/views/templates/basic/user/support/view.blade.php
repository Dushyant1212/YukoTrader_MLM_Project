@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
    <div class="message__chatbox-section padding-top-half padding-bottom">
        <div class="container">
            <div class="message__chatbox ">
                <div class="message__chatbox__header">
                    <h5 class="title text-white">
                        @if ($myTicket->status == 0)
                            <span class="badge badge--success">@lang('Open')</span>
                        @elseif($myTicket->status == 1)
                            <span class="badge badge--primary">@lang('Answered')</span>
                        @elseif($myTicket->status == 2)
                            <span class="badge badge--warning">@lang('Replied')</span>
                        @elseif($myTicket->status == 3)
                            <span class="badge badge--dark">@lang('Closed')</span>
                        @endif
                        @lang('Ticket ID'):<span class="cl-theme">[#{{ $myTicket->ticket }}] {{ $myTicket->subject }}</span>
                    </h5>
                    @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                        <a href="javascript:void(0)" class="btn btn--sm d-block btn--danger text-center confirmationBtn" data-action="{{ route('ticket.close', $myTicket->id) }}" data-question="@lang('Are you sure you want to close this support ticket?')">@lang('Close Ticket')</a>
                    @endif
                </div>
                <div class="message__chatbox__body">
                    @if ($myTicket->status != 4)
                        <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}"
                            class="message__chatbox__form row" enctype="multipart/form-data">
                            @csrf
                            <div class="contact-form-group col-sm-12">
                                <label>@lang('Your Message')</label>
                                <textarea id="message" name="message" placeholder="@lang('Enter Message')" required=""></textarea>
                            </div>

                            <div class="contact-form-group col-sm-12">
                                <div class="d-block">
                                    <label>@lang('Attachments')</label>
                                    <small class="text--danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is')
                                        {{ ini_get('upload_max_filesize') }}</small>
                                    <div class="input-group w-100">
                                        <input type="file" class="form-control form--control" name="attachments[]"
                                            id="file2">
                                        <button class="btn--base btn--sm bg--primary cmn--form--control addFile"
                                            type="button"><i class="fas fa-plus"></i></button>
                                    </div>

                                </div>
                                <div id="fileUploadsContainer"></div>
                                <span class="info text-white fs--14">@lang('Allowed File Extensions'): .@lang('jpg'),
                                    .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'),
                                    .@lang('docx')</span>
                            </div>
                            <div class="contact-form-group col-sm-12">
                                <button type="submit" name="replayTicket" value="1">@lang('Send Message')</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- <Message> Section -->
    <div class="message__chatbox-section padding-bottom">
        <div class="container">
            <div class="message__chatbox">
                <div class="message__chatbox__body">
                    <ul class="reply-message-area">
                        @foreach ($messages as $message)
                            <li>
                                @if ($message->admin_id == 0)
                                    <div class="reply-item">
                                        <div class="name-area">
                                            <h6 class="title">{{ __($message->ticket->name) }}</h6>
                                        </div>
                                        <div class="content-area">
                                            <span class="meta-date">
                                                @lang('Posted on') <span
                                                    class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                            </span>
                                            <p>
                                                {{ __($message->message) }}
                                            </p>
                                            @if ($message->attachments->count() > 0)
                                                <div class="mt-2">
                                                    @foreach ($message->attachments as $k => $image)
                                                        <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                            class="mr-3"><i class="fa fa-file"></i> @lang('Attachment')
                                                            {{ ++$k }} </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <ul>
                                        <li>
                                            <div class="reply-item">
                                                <div class="name-area">
                                                    <div class="reply-thumb">
                                                        <img src="{{ getImage('assets/admin/images/profile/' . $message->admin->image, '400x400') }}"
                                                            alt="@lang('Admin Image')">
                                                    </div>
                                                    <h6 class="title">{{ __($message->admin->name) }}</h6>
                                                </div>
                                                <div class="content-area">
                                                    <span class="meta-date">
                                                        @lang('Posted on'), <span
                                                            class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                                    </span>
                                                    <p>
                                                        {{ __($message->message) }}
                                                    </p>
                                                    @if ($message->attachments->count() > 0)
                                                        <div class="mt-2">
                                                            @foreach ($message->attachments as $k => $image)
                                                                <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                                    class="mr-3"><i class="fa fa-file"></i>
                                                                    @lang('Attachment') {{ ++$k }} </a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                            </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="modal fade custom--modal" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('ticket.close', $myTicket->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Confirmation')!</h5>
                        <button type="button" class="close text-white" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <strong class="text-white">@lang('Are you sure you want to close this support ticket')?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger btn--sm" data-bs-dismiss="modal">
                            @lang('Close')
                        </button>
                        <button type="submit" class="btn btn--success btn--sm" name="replayTicket"
                            value="2">@lang('Confirm')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <x-confirmation-modal is_custom="yes" />
@endsection

@push('script')
<script>
    (function($) {
        "use strict";
        var fileAdded = 0;
        $('.addFile').on('click', function() {
            if (fileAdded >= 4) {
                notify('error', 'You\'ve added maximum number of file');
                return false;
            }
            fileAdded++;
            $("#fileUploadsContainer").append(
                `<div class="removeFile mt-3">
                        <div class="input-group col p-0">
                            <input type="file" class="form-control form--control" name="attachments[]" id="file2" required>
                            <button class="btn--sm bg--danger ml-md-4 cmn--form--control remove-btn" type="button"><i class="fas fa-times-circle"></i></button>
                        </div>

                    </div>`
            )
        });
        $(document).on('click', '.remove-btn', function() {
            fileAdded--;
            $(this).closest('.input-group').remove();
        });
    })(jQuery);
</script>
@endpush
