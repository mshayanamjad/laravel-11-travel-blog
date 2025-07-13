@extends('front.layouts.app')
@section('title', 'Comments')

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
        <div class="profile-heading">
            <h2>Comment History</h2>
        </div>
            <div class="form-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered comment-list-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Comment</th>
                                        <th width="100">Published</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($comments as $comment)
                                        <tr>
                                            <td><a href="{{ route('front.singlePost', $comment->post->slug) }}">{{ $comment->post->title }}</a></td>
                                            <td>{{ $comment->comment }}</td>
                                            <td>{{ $comment->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No comments found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
