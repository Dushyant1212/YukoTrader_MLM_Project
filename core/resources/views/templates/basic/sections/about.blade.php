@php
    $content = getContent('about.content', true);
@endphp
<section class="about-section padding-top padding-bottom">
    <div class="container">
        <div class="row mb--50">
            <div class="col-lg-6 mb-50">
                <div class="about-content">
                    <div class="section-header margin-olpo left-style">
                        <h2 class="title">{{ __(@$content->data_values->heading) }}</h2>
                        <p>{{ __(@$content->data_values->sub_heading) }}</p>
                    </div>
                    <p>{{ __(@$content->data_values->description) }}</p>
                    <a href="{{ @$content->data_values->button_url }}"
                        class="theme-button mt-20">{{ __(@$content->data_values->button_text) }}</a>
                </div>
            </div>
            <div class="col-lg-6 mb-50">
                <div class="video-wrapper w-100 h-100 padding-bottom padding-top bg_img"
                    data-background="{{ getImage('assets/images/frontend/about/' . @$content->data_values->video_background_image, '594x400') }}">
                    <a href="{{ @$content->data_values->video_link }}" class="video-button popup"><i
                            class="fas fa-play"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
