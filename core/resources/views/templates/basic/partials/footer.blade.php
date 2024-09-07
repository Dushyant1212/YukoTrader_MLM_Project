@php
    $content = getContent('footer.content', true);
    $footerMenu = getContent('policy_pages.element', false);
    $socialIcons = getContent('social_icon.element', false, false, true);
@endphp

<footer class="padding-top primary-overlay bg_img"
    data-background="{{ getImage('assets/images/frontend/footer/' . @$content->data_values->background_image, '1000x421') }}">
    <div class="footer-top padding-bottom">
        <div class="container">
            <div class="footer-wrapper cl-white">
                <div class="footer-logo">
                    <a href="">
                        <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="images">
                    </a>
                </div>
                <p>{{ __(@$content->data_values->heading) }}</p>
                <ul class="social__icons">
                    @foreach ($socialIcons as $element)
                        <li>
                            <a href="{{ @$element->data_values->url }}" target="_blank"
                                class="facebook">@php echo $element->data_values->icon @endphp</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <ul class="footer-menu">
                @foreach($footerMenu as $policy)
                    <li>
                        <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">{{__($policy->data_values->title)}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; @lang('All Right Reserved By') <a href="{{route('home')}}">{{__($general->site_name)}}</a></p>
        </div>
    </div>
</footer>
