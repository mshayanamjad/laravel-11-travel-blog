@extends('front.layouts.app')
@section('title', 'Delete Account')

@section('content')
<div class="account-main">
    <section class="container py-5 mt-5" style="max-width: 700px !important;">
        <div class="profile-container justify-content-center">
            <div class="section-10 profile-content">
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
                <div class="login-form">    
                    <form action="{{ route('front.processDeleteAcc') }}" method="post" name="changePasswordForm" id="changePasswordForm">
                        @csrf
                        <div class="profile-form-group p-0">
                            <input type="password" class="form-control" placeholder="Enter Your Password" name="given_password" id="given_password">
                        </div>
                        <div class="d-flex align-items-center gap-2">
                        <input type="submit" class="btn btn-dark btn-lg profile-btn col-md-6 col-6" value="Delete Account"> 
                        <a onclick="goBack()" class="back-btn col-md-6 rounded-0 col-6">Back</a>             
                        </div>             
                    </form>			
                </div>
            </div>
        </div>
    </section>
</div>
@endsection