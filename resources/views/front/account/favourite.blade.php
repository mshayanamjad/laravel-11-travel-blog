@extends('front.layouts.app')
@section('title', 'Favourite Posts')

@section('content')
<div class="account-main">
    <section id="breadcrumb-container" class="section-5 py-4 bg-light">
        <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
            <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.profile') }}">My Account</a></li>
            <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
        </div>
    </section>
    <section class="container">
    <div class="profile-container">
        <div class="profile-sidebar">
            @include('front.account.common.sidebar')
        </div>
        <div class="profile-content">
            <div class="profile-heading d-flex align-items-center justify-content-between">
                <h2>Favourite Posts</h2>
                <p class="m-0" style="text-shadow: none;">Favourites: {{ $favPostCount }}</p>
            </div>
            <div class="form-container">
                <div class="row">
                    @foreach($favPosts as $favPost)
                        <div class="col-md-4 mb-2 favpost-container">
                            <div class="card">
                                <img src="{{ asset('uploads/post-images/'. $favPost->post->image) }}" class="card-img-top" alt="{{ $favPost->post->title }}">
                                <div class="card-body">
                                    <a class="card-title" href="{{ route('front.singlePost', $favPost->post->slug) }}">
                                    <h5>{{ $favPost->post->title }}</h5>
                                    </a>
                                    <p class="card-text"></p>
                                    <button onclick="removePost({{ $favPost->post->id }});" class="btn btn-danger w-100">Remove</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@section('customJs')
<script>
function removePost(id) {
        $.ajax({
          url: "{{ route('front.removeFavPosts') }}",
          type: "post",
          data: {id:id},
          dataType: "json",
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            if (response.status == true) {
                window.location.href = "{{ route('front.favPost') }}";
            }
          },
        });
      }
</script>
@endsection
