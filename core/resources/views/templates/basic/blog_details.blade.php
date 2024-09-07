@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="blog-section padding-bottom padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article>
                        <div class="post-item post-classic post-details">
                            <div class="post-thumb c-thumb">
                                <img src="{{ getImage('assets/images/frontend/blog/' . @$blog->data_values->blog_image, '770x570') }}"
                                    alt="@lang('blog')">
                            </div>
                            <div class="post-content">
                                <div class="blog-header">
                                    <h4 class="title">
                                        {{ __(@$blog->data_values->title) }}
                                    </h4>
                                </div>
                                <div class="meta-post">
                                    <div class="date">
                                        <a href="javascript:void(0)">
                                            <i class="flaticon-calendar"></i>
                                            {{ showDateTime($blog->created_at) }}
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    @php echo $blog->data_values->description_nic @endphp
                                    <div class="tag-options">
                                        <div class="share">
                                            <span><i class="fas fa-share-alt"></i></span>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                                target="_blank"><i class="fab fa-facebook-f"></i></a>
                                            <a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{ urlencode(url()->current()) }}"
                                                target="_blank"><i class="fab fa-twitter"></i></a>
                                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}"
                                                target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-comments"
                                    data-href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}"
                                    data-numposts="5"></div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4">
                    <aside class="b-sidebar">

                        <div class="widget widget-post">
                            <h6 class="title">@lang('recent post')</h6>
                            <ul>
                                @foreach ($recentBlogs as $recentBlog)
                                    @if ($recentBlog->id !== $blog->id )
                                        <li>
                                            <div class="c-thumb">
                                                <a
                                                    href="{{ route('blog.details', [$recentBlog->id, slug($recentBlog->data_values->title)]) }}">
                                                    <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$recentBlog->data_values->blog_image, '370x275') }}"
                                                        alt="@lang('blog')">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h6 class="sub-title">
                                                    <a
                                                        href="{{ route('blog.details', [$recentBlog->id, slug($recentBlog->data_values->title)]) }}">
                                                        {{ __(strlimit($recentBlog->data_values->title, 50)) }}</a>
                                                </h6>
                                                <div class="meta">
                                                    @lang('Post by') - @lang('Admin')
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush
