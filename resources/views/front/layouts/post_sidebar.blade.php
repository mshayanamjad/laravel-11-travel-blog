<div class="sidebar">
    <div class="blog-post-title">
        <h2>Featured</h2>
    </div>
    <div class="sidebar-featured-post">
        @if(!empty(getFeaturdPost()))
            @foreach (getFeaturdPost() as $featuredPost)
                <div class="sidebar-post d-flex align-items-center justify-content-between gap-3">
                    <a href="{{ route('front.singlePost', $featuredPost->slug) }}">
                        <img class="sidebar-post-img" src="{{ asset('uploads/post-images/'.$featuredPost->image) }}" alt="" />
                    </a>
                    <a href="{{ route('front.singlePost', $featuredPost->slug) }}" class="sidebar-post-title">
                            {{ $featuredPost->title }}
                    </a>
                </div>
            @endforeach
        @endif
    </div>
</div>
<div class="sidebar mt-5">
    <div class="social-links">
        <div class="blog-post-title">
            <h2>Social Links</h2>
        </div>
       <div class="social-items d-flex align-items-center justify-content-start flex-wrap">
          <div class="social-item d-flex align-items-center col-6 mb-2">
            <a href="#" target="_blank">
              <span><i class="fa-brands fa-facebook-f"></i></span>
               Facebook
            </a>
          </div>
          <div class="social-item d-flex align-items-center col-6 mb-2">
            <a href="#" target="_blank">
              <span><i class="fa-brands fa-instagram"></i></span>
               Instagram
            </a>
          </div>
          <div class="social-item d-flex align-items-center col-6 mb-2">
            <a href="#" target="_blank">
              <span><i class="fa-brands fa-pinterest"></i></span>
               Pinterest
            </a>
          </div>
          <div class="social-item d-flex align-items-center col-6 mb-2">
            <a href="#" target="_blank">
              <span><i class="fa-brands fa-youtube"></i></span>
               YouTube
            </a>
          </div>
          <div class="social-item d-flex align-items-center col-6 mb-2">
            <a href="mailto:mianshayan201@gmail.com" target="_blank">
              <span><i class="fa-solid fa-envelope"></i></span>
               Email
            </a>
          </div>
        </div>
    </div>
</div>