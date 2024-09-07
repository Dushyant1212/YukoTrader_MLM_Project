@php
    $content = getContent('testimonial.content', true);
    $elements = getContent('testimonial.element');
@endphp
<section class="client-section primary-overlay bg_img bg_fixed padding-bottom padding-top"
    data-background="{{ getImage('assets/images/frontend/testimonial/' . @$content->data_values->background_image, '1000x667') }}">
    <div class="container">
        <div class="section-header cl-white">
            <h2 class="title">{{ __(@$content->data_values->heading) }}</h2>
            <p>{{ __(@$content->data_values->sub_heading) }}</p>
        </div>
        <div class="client-slider owl-theme owl-carousel">
            @foreach ($elements as $element)
                <div class="client-item mt-55">
                    <div class="client-thumb">
                        <img src="{{ getImage('assets/images/frontend/testimonial/' . $element->data_values->image, '200x200') }}"
                            alt="client">
                    </div>
                    <div class="client-content">
                        <div class="header">
                            <h5 class="title">{{ __($element->data_values->name) }}</h5>
                            <span class="info">{{ __($element->data_values->designation) }}</span>
                        </div>
                        <p>{{ __($element->data_values->description) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
