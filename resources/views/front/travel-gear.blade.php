@extends('front.layouts.app')
@section('title', 'My Camera Gear')

@section('content')

<!--  Section 1 End Here -->
<section class="travel-gear py-5 mt-5">
    <div class="container mt-1 mt-md-5">
        <div class="d-flex align-items-start">
            <div class="w-100 w-md-70 ps-0">
                <div class="travel-gear-inner pe-0 pe-md-5">
                    <div class="travel-gear-title mb-2 mb-md-4 text-center">
                        <h1 class="title">My Travel Gear</h1>
                    </div>
                    <div class="gear-hero-img mb-3">
                        <img src="{{ asset('front-assets/images/gear-1.webp') }}">
                    </div>
                    <div class="about-text">
                        <p>
                            Sometimes I get questions from people asking what type of camera, drone, or other gear I use, so I’ve put together this list of my travel essentials to help you get started.
                        </p>
                        <p>
                            These aren’t all of the items I use while traveling, but they’re some of my must haves. I’m a big fan of all of these items, and I’ve had lots of experience with them over the years, but if I upgrade to something new then I’ll try to update the list as well.
                        </p>
                        <p>
                            This is almost everything you need to travel the world and take lots of photos and videos while doing it! If you have any questions about any of this gear, feel free to ask me!
                        </p>
                    </div>
                    <div class="tools-containes">
                        <div class="tool-info-box mb-5">
                            <div class="travel-gear-title mb-2 mb-md-2">
                                <h3 class="title">My Travel Camera</h3>
                            </div>
                            <div class="about-text">
                                <ul>
                                    <li>
                                        <a href="https://amzn.to/3M0x2yI" class="fw-bold">Fujifilm X-T5 Mirrorless Digital Camera
                                        </a>
                                    </li>
                                </ul>
                                <p>
                                    This is my current go-to camera for most of the photography I do in my travels. You can see some photo samples in my <a href="{{ route('front.gallery') }}">Gallery</a> or <a href="{{ route('front.gallery') }}">Photo Essays</a>, although most of the pictures on my site were taken with the older X-T2 model.
                                </p>
                                <p>
                                    I’m now using the newer and better X-T5 version, but I still have a lot to learn before I master this thing. I love to take pictures with the Fuji X-series cameras and the prices are quite a bit lower than what you’d normally pay for a kitted out DLSR.
                                </p>
                            </div>
                            <div class="product-image">
                                <a href="https://amzn.to/3M0x2yI">
                                    <img src="{{ asset('front-assets/images/camera.png') }}">
                                </a>
                            </div>
                        </div>

                        <div class="tool-info-box mb-5">
                            <div class="travel-gear-title mb-2 mb-md-2">
                                <h3 class="title">My Drone</h3>
                            </div>
                            <div class="about-text">
                                <ul>
                                    <li>
                                        <a href="https://amzn.to/3KkGk7h" class="fw-bold">DJI Mavic 2 Pro Drone Quadcopter
                                        </a>
                                    </li>
                                </ul>
                                <p>
                                    The DJI Mavic 2 Pro is great for the price range. It shoots high definition 4K videos and 20MP photos, and it’s surprisingly small and easy to fly.
                                </p>
                                <p>
                                    I’m in the process of upgrading to a DJI Air 3S or Mavic 3 Pro now.
                                </p>
                            </div>
                            <div class="product-image">
                                <a href="https://amzn.to/3KkGk7h">
                                    <img src="{{ asset('front-assets/images/drone.png') }}">
                                </a>
                            </div>
                        </div>

                        <div class="tool-info-box mb-5">
                            <div class="travel-gear-title mb-2 mb-md-2">
                                <h3 class="title">UnderWater Camera</h3>
                            </div>
                            <div class="about-text">
                                <ul>
                                    <li>
                                        <a href="https://amzn.to/3M5KaCO" class="fw-bold">GoPro HERO7 Black — Waterproof Digital Action Camera
                                        </a>
                                    </li>
                                </ul>
                                <p>
                                    GoPro is nice for underwater filming and such. I’m not a big fan of GoPro for other situations, but they are good for easy underwater photography, and prices are coming down lately.
                                </p>
                                <p>
                                    I’m in the process of upgrading to an <a href="https://amzn.to/3KATHzF">Insta360 Ace Pro</a> for underwater work since those seem to do better.
                                </p>
                            </div>
                            <div class="product-image">
                                <a href="https://amzn.to/3M5KaCO">
                                    <img src="{{ asset('front-assets/images/underwater-cam.png') }}">
                                </a>
                            </div>
                        </div>

                        <div class="tool-info-box mb-5">
                            <div class="travel-gear-title mb-2 mb-md-2">
                                <h3 class="title">Hammock</h3>
                            </div>
                            <div class="about-text">
                                <ul>
                                    <li>
                                        <a href="https://www.amazon.com/gp/product/B01N8TGK70/ref=as_li_tl?ie=UTF8&tag=theworldtr062-20&camp=1789&creative=9325&linkCode=as2&creativeASIN=B01N8TGK70&linkId=6d0fe4729e3da46ff164289a696132ee" class="fw-bold">Winner Outfitters Portable Double Camping Hammock
                                        </a>
                                    </li>
                                </ul>
                                <p>
                                   This hammock folds down into a small package, making it super portable for hiking. I’ve used it with great success on some epic backpacking trips like the Kalalau Trail in Hawaii.
                                </p>
                            </div>
                            <div class="product-image">
                                <a href="https://www.amazon.com/gp/product/B01N8TGK70/ref=as_li_tl?ie=UTF8&tag=theworldtr062-20&camp=1789&creative=9325&linkCode=as2&creativeASIN=B01N8TGK70&linkId=6d0fe4729e3da46ff164289a696132ee">
                                    <img src="{{ asset('front-assets/images/hammock.png') }}">
                                </a>
                            </div>
                        </div>

                        <div class="tool-info-box mb-5">
                            <div class="travel-gear-title mb-2 mb-md-2">
                                <h3 class="title">Truck Tent</h3>
                            </div>
                            <div class="about-text">
                                <ul>
                                    <li>
                                        <a href="https://www.amazon.com/gp/product/B00ASYOTZA/ref=as_li_tl?ie=UTF8&tag=theworldtr062-20&camp=1789&creative=9325&linkCode=as2&creativeASIN=B00ASYOTZA&linkId=4c3e12b97363aa8b48a71fc4cf49aff7" class="fw-bold">Napier Backroadz Truck Camping Tent
                                        </a>
                                    </li>
                                </ul>
                                <p>
                                   I love this tent and it’s the perfect way to travel the United States on a budget. One time I slept in my Napier truck tent for 6 months and drove 20,000 miles in 8 states, hiking and filming scenic places all over the US. This tent kept me safe and dry through lots of bad storms and temperatures as low as 20 °F (-6 °C) in the mountains. Plus it just looks awesome!
                                </p>
                            </div>
                            <div class="product-image">
                                <a href="https://www.amazon.com/gp/product/B00ASYOTZA/ref=as_li_tl?ie=UTF8&tag=theworldtr062-20&camp=1789&creative=9325&linkCode=as2&creativeASIN=B00ASYOTZA&linkId=4c3e12b97363aa8b48a71fc4cf49aff7">
                                    <img src="{{ asset('front-assets/images/tent.png') }}">
                                </a>
                            </div>
                        </div>

                        <div class="tool-info-box mb-5">
                            <div class="travel-gear-title mb-2 mb-md-2">
                                <h3 class="title">Travel Adapter</h3>
                            </div>
                            <div class="about-text">
                                <ul>
                                    <li>
                                        <a href="https://amzn.to/45gcNEF" class="fw-bold">Worldwide All In One Universal Travel Adapter / Wall Charger
                                        </a>
                                    </li>
                                </ul>
                                <p>
                                   This travel adapter works in 180+ countries. So far, I haven’t found a destination where it doesn’t work! It has 4 USB ports and it’s 120W, so it has enough power to charge laptops through USB-C. If you’re looking for a cheaper adapter that’s also good, <a href="https://amzn.to/3xkgGff">here</a> is what my wife uses.
                                </p>
                            </div>
                            <div class="product-image">
                                <a href="https://amzn.to/45gcNEF">
                                    <img src="{{ asset('front-assets/images/adapter.png') }}">
                                </a>
                            </div>
                        </div>
                    </div>
                     <div class="travel-gear-title mb-1 mb-md-2 pt-3">
                        <h2 class="title">See Also</h2>
                    </div>
                    <div class="about-text">
                        <ul>
                            <li><a href="{{ route('front.about') }}" class="fw-bold">About</a></li>
                            <li><a href="{{ route('front.contact') }}" class="fw-bold">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <di class="w-md-30 sidebar-widget">
                @include('front.layouts.post_sidebar')
            </div>
        </div>
    </div>
</section>

@endsection