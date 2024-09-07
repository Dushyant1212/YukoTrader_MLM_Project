@php
    $content = getContent('counter.content', true);
    $elements = getContent('counter.element', false, null, true);
@endphp
<section class="counter-section padding-bottom padding-top primary-overlay bg_fixed bg_img"
         data-background="{{ getImage('assets/images/frontend/counter/'. @$content->data_values->background_image, '1000x667')}}">
    <div class="container">
        <div class="section-header cl-white">
            <h2 class="title">{{__(@$content->data_values->heading)}}</h2>
            <p>{{__(@$content->data_values->sub_heading)}}</p>
        </div>
        <div class="row justify-content-center mb-40-none">

        @foreach($elements as $element)
            <div class="col-xl-3 col-sm-6">
                <div class="counter-item">
                    <div class="counter-thumb">
                        @php echo $element->data_values->counter_icon @endphp
                    </div>
                    <div class="counter-content">
                        <h5 class="title">{{__($element->data_values->title)}}</h5>
                        <div class="counter-header">
                            <h5 class="subtitle">{{__($element->data_values->counter_digit)}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</section>

