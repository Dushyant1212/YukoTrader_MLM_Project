@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
$content = getContent('banner.content', true);
@endphp
<section class="banner-section oh bg_img primary-overlay" data-background="{{ getImage('assets/images/frontend/banner/'. @$content->data_values->background_image, '1200x798')}}">
    <div class="banner-thumb d-none d-lg-block">
        <img src="{{ getImage('assets/images/frontend/banner/'. @$content->data_values->main_image, '705x525')}}" alt="@lang('banner')">
        <div>
            <div class="sub-thumb"><img src="{{ getImage('assets/images/frontend/banner/'. @$content->data_values->image_1, '75x160')}}" alt="@lang('banner')"></div>
            <div class="sub-thumb"><img src="{{ getImage('assets/images/frontend/banner/'. @$content->data_values->image_2, '45x90')}}" alt="@lang('banner')"></div>
            <div class="sub-thumb"><img src="{{ getImage('assets/images/frontend/banner/'. @$content->data_values->image_3, '75x100')}}" alt="@lang('banner')"></div>
            <div class="sub-thumb"><img src="{{ getImage('assets/images/frontend/banner/'. @$content->data_values->image_4, '75x100')}}" alt="@lang('banner')"></div>
            <div class="sub-thumb"><img src="{{ getImage('assets/images/frontend/banner/'. @$content->data_values->image_5, '120x165')}}" alt="@lang('banner')"></div>
        </div>
    </div>

    <div class="container">
        <div class="banner-content">
            <h1 class="title">{{__(@$content->data_values->first_heading)}}<span class="d-block text-theme">{{__(@$content->data_values->second_heading)}}</span></h1>
            <h3 class="subtitle">{{__(@$content->data_values->sub_heading)}}</h3>
            <p>{{__(@$content->data_values->description)}}</p>
            <div class="button-area">
                <a href="{{url(@$content->data_values->first_button_url)}}" class="custom-button cl-light">{{__(@$content->data_values->first_button_text)}}</a>
                <a href="{{url(@$content->data_values->second_button_url)}}" class="custom-button theme hover-cl-light">{{__(@$content->data_values->second_button_text)}}</a>
            </div>
        </div>
    </div>
</section>

@if($sections->secs != null)
    @foreach(json_decode($sections->secs) as $sec)
        @include($activeTemplate.'sections.'.$sec)
    @endforeach
@endif
@endsection
