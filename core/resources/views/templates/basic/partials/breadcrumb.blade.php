@php
    $content = getContent('breadcrumb.content', true);
@endphp
<section class="hero-section primary-overlay oh bg_img"
    data-background="{{ getImage('assets/images/frontend/breadcrumb/' . @$content->data_values->background_image, '1000x667') }}">
    <div class="container">
        <div class="hero-content">
            <h1 class="title">{{ $pageTitle }}</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">@lang('Home')</a>
                </li>
                <li>
                    {{ $pageTitle }}
                </li>
            </ul>
        </div>
    </div>
</section>
