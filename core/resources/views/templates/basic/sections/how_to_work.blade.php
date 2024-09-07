@php
    $content = getContent('how_to_work.content', true);
    $elements = getContent('how_to_work.element');
@endphp
<section class="how-section padding-top padding-bottom oh">
    <div class="container">
        <div class="section-header">
            <h2 class="title">{{__(@$content->data_values->heading)}}</h2>
            <p>{{__(@$content->data_values->sub_heading)}}</p>
        </div>
        <div class="how-wrapper">
            @foreach($elements as $element)
                <div class="how-item">
                    <div class="how-thumb">
                        @php echo $element->data_values->work_icon @endphp
                    </div>
                    <div class="how-content">
                        <h5 class="title">{{__($element->data_values->title)}}</h5>
                        <p>{{__($element->data_values->sub_title)}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>