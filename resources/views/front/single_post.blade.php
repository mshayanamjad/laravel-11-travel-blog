@extends('front.layouts.app')
@section('title', $postsData->title)

@section('content')

<section class="single-post-thumbnail py-5 mt-5">
    <div class="container mt-1 mt-md-3">
        <div class="post-header position-relative p-0">
            <div class="post-thumbnail">
            <img src="{{ asset('uploads/post-images/'.$postsData->image) }}" />
            </div>
            <div class="single-post-meta text-center">
                <ul class="post-meta-data">
                    @if(!empty($postsData->categories))
                        @foreach($postsData->categories as $category)
                            <li>
                                <a href="#">
                                    {{ $category }}
                                    @if(!empty($postsData->sub_categories))
                                        @foreach($postsData->sub_categories as $sub_category)
                                            <div class="ms-1">
                                                <a href="#">
                                                    | {{ $sub_category }}
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <h1 class="single-post-title">
                    {{ $postsData->title }}
                </h1>
                <div class="post-info d-flex justify-content-center align-items-center pt-3">
                    <div class="autor-name">By {{ $postsData->user->name }}</div>
                    <div class="publish-date">{{ $postsData->created_at->format('F d, Y') }}</div>
                </div>

            </div>
        </div>
    </div>
</section>

<!--  Section 1 End Here -->
<section class="single-post-content-wrapper py-0 pb-md-0">
    <div class="container">
        <div class="d-flex align-items-start">
            <div class="w-100 w-md-70 ps-0 pe-5">
                <div class="single-post-content pe-0 pe-md-5">
                    {!! $postsData->description !!}
                </div>
            </div>
            <di class="w-md-30 sidebar-widget">
                @include('front.layouts.post_sidebar')
            </div>
        </div>
    </div>
</section>
<section class="comment-section">
    @include('front.layouts.comments')
    
</section>

@endsection