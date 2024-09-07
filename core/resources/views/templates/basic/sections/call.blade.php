@php
    $content = getContent('call.content', true);
@endphp
<section class="call-section padding-top padding-bottom bg_img bg_fixed primary-overlay"
         data-background="{{ getImage('assets/images/frontend/call/'. @$content->data_values->background_image, '1000x667')}}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 xol-xl-8">
                <div class="section-header cl-white">
                    <h3 class="title">{{__(@$content->data_values->heading)}}</h3>
                    <p>{{__(@$content->data_values->sub_heading)}}</p>
                </div>
                <div class="text-center">
                    <a href="{{url(@$content->data_values->button_url)}}" class="custom-button theme hover-cl-light">{{__(@$content->data_values->button_name)}}</a>
                </div>
            </div>
        </div>
    </div>
</section>
