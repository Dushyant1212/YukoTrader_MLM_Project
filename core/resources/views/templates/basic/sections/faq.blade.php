@php
    $content = getContent('faq.content', true);
    $elements = getContent('faq.element', false);
@endphp
<section class="faq-section padding-bottom padding-top-half">
    <div class="container">
        <div class="section-header">
            <h2 class="title">{{__(@$content->data_values->heading)}}</h2>
            <p>{{__(@$content->data_values->sub_heading)}}</p>
        </div>
        <div class="row flex-wrap-reverse justify-content-center mb--50">
            @foreach($elements->chunk(3) as $elements)
                <div class="col-lg-6">
                @foreach($elements as $element)
                    <div class="faq-wrapper mb-20">
                        <div class="faq-item">
                            <div class="faq-title">
                                <h6 class="title">{{__($element->data_values->question)}}</h6>
                                <span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>
                                    {{__($element->data_values->answers)}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            @endforeach
        </div>
    </div>
</section>