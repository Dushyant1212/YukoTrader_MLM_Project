@php
    $content = getContent('feature.content', true);
    $elements = getContent('feature.element', false, null, true);
@endphp
<section class="feature-section padding-top padding-bottom primary-overlay bg_img bg_fixed"
         data-background="{{ getImage('assets/images/frontend/feature/'. @$content->data_values->background_image, '1000x667')}}">
    <div class="container">
        <div class="section-header cl-white">
            <h2 class="title">{{__(@$content->data_values->heading)}}</h2>
            <p>{{__(@$content->data_values->sub_heading)}}</p>
        </div>
        <div class="row justify-content-center">
            @foreach($elements as $element)
                <div class="col-sm-10 col-md-6 col-lg-4">
                    <div class="feature-item">
                        <div class="feature-thumb">
                            @php echo $element->data_values->feature_icon @endphp
                        </div>
                        <div class="feature-content">
                            <h5 class="title">{{__($element->data_values->title)}}</h5>
                            <p>{{__($element->data_values->sub_title)}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>