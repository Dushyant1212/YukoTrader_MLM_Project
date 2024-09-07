@php
    $content = getContent('blog.content', true);
    $elements = getContent('blog.element', false, 3);
@endphp
<section class="blog-section padding-top padding-bottom">
    <div class="container">
        <div class="section-header">
            <h3 class="title">{{ __(@$content->data_values->heading) }}</h3>
            <p>{{ __(@$content->data_values->sub_heading) }}</p>
        </div>
        <div class="row justify-content-center mb-30-none">
            @foreach ($elements as $element)
                <div class="col-md-6 col-xl-4 col-sm-10">
                    <div class="post-item"> 
                        <div class="post-thumb c-thumb">
                            <a href="{{ route('blog.details', [$element->id, slug($element->data_values->title)]) }}">
                                <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$element->data_values->blog_image, '370x275') }}"
                                    alt="blog">
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="blog-header">
                                <h6 class="title">
                                    <a
                                        href="{{ route('blog.details', [$element->id, slug($element->data_values->title)]) }}">{{ __(@$element->data_values->title) }}</a>
                                </h6>
                            </div>
                            <div class="meta-post">
                                <div class="date">
                                    <div>
                                        <i class="flaticon-calendar"></i>
                                        {{ showDateTime($element->created_at, 'd M Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="entry-content">
                                <p>{{ strlimit(strip_tags(@$element->data_values->description_nic), 100) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
