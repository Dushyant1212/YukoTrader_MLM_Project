@php
    $content = getContent('subscribe.content', true);
@endphp
<section class="newsletter-section padding-top padding-bottom bg_img bg_fixed primary-overlay"
    data-background="{{ getImage('assets/images/frontend/subscribe/' . @$content->data_values->background_image, '1000x667') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9 col-xl-8">
                <div class="section-header margin-olpo cl-white">
                    <h3 class="title">{{ __(@$content->data_values->heading) }}</h3>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <form class="subscribe-form" method="POST">
                            <div class="subscribe-group">
                                <input type="email"  required id="emailSub" placeholder="@lang('Your Email Address')">
                                <button type="submit" class="subscribe-btn"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('script')
    <script>
        'use strict';
        $(document).on('submit', '.subscribe-form', function(e) {
            e.preventDefault();
            var email = $("#emailSub").val();
            if (email) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('subscribe') }}",
                    method: "POST",
                    data: {
                        email: email
                    },
                    success: function(response) {
                        if (response.success) {
                            notify('success', response.success);
                            $("#emailSub").val('');
                        } else {
                            $.each(response, function(i, val) {
                                notify('error', val);
                            });
                        }
                    }
                });
            } else {
                notify('error', "Please Input Your Email");
            }
        });
    </script>
@endpush
