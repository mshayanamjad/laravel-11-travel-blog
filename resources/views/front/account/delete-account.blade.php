@extends('front.layouts.app')
@section('title', 'Delete Account')

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
                <h2>Delete Account</h2>
            </div>
            @if (Session::has('success'))
                <div class="col-md-12 p-0">
                    <div class="alert alert-success alert-dismissible fade show" style="margin: 30px 30px 0" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="col-md-12 p-0">
                    <div class="alert alert-danger alert-dismissible fade show" style="margin: 30px 30px 0" role="alert">
                        {{ Session::get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <div class="form-container">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="alert alert-danger" role="alert">
                            <p style="text-shadow:none;">Please note that deleting your account will remove all your data from our website. This includes your profile information, Favourite posts list, comments, and any other data associated with your account. This action is irreversible, and you will not be able to recover your account or any of the data once it is deleted.</p>
                            {{-- <p style="text-shadow:none;">If you have any questions or concerns, please contact our support team before proceeding with the account deletion.</p> --}}
                            <p style="text-shadow:none;">Are you sure you want to delete your account? This action cannot be undone.</p>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-4 d-flex justify-content-center">
                                <a href="{{ route('front.showDeleteForm') }}" class="btn btn-danger m-1">Delete Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@section('customJs')
@endsection
