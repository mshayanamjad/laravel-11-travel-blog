@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="row">
            <!-- Box for Users -->
            <div class="col-lg-4 col-6">
                <div class="small-box card shadow-lg" id="users-box">
                    <div class="inner">
                        <h3 class="font-weight-bold">{{ $total_users }}</h3>
                        <p class="text-uppercase">Users</p>
                    </div>
                    <div class="icon">
                       <ion-icon name="person-add-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- Box for Subscribers -->
            <div class="col-lg-4 col-6">
                <div class="small-box card shadow-lg" id="subscribers-box">
                    <div class="inner">
                        <h3 class="font-weight-bold">{{ $total_subscribers }}</h3>
                        <p class="text-uppercase">Subscribers</p>
                    </div>
                    <div class="icon">
                       <ion-icon name="notifications-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- Box for Posts -->
            <div class="col-lg-4 col-6">
                <div class="small-box card shadow-lg" id="posts-box">
                    <div class="inner">
                        <h3 class="font-weight-bold">{{ $total_posts }}</h3>
                        <p class="text-uppercase">Total Posts</p>
                    </div>
                    <div class="icon">
                        <ion-icon name="document-text-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- Box for Categories -->
            <div class="col-lg-4 col-6">
                <div class="small-box card shadow-lg" id="categories-box">
                    <div class="inner">
                        <h3 class="font-weight-bold">{{ $total_categories }}</h3>
                        <p class="text-uppercase">Total Categories</p>
                    </div>
                    <div class="icon">
                        <ion-icon name="cube-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- Box for Comments -->
            <div class="col-lg-4 col-6">
                <div class="small-box card shadow-lg" id="comments-box">
                    <div class="inner">
                        <h3 class="font-weight-bold">{{ $total_comments }}</h3>
                        <p class="text-uppercase">Total Comments</p>
                    </div>
                    <div class="icon">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- Box for Views -->
            <div class="col-lg-4 col-6">
                <div class="small-box card shadow-lg" id="views-box">
                    <div class="inner">
                        <h3 class="font-weight-bold">{{ $total_views }}</h3>
                        <p class="text-uppercase">Total Views</p>
                    </div>
                    <div class="icon">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
