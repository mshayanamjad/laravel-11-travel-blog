@extends('front.layouts.app')
@section('title', 'Change Password')

@section('content')
<div class="account-main">
    <section class="container py-5 mt-5">
        <div class="profile-container">
            <div class="profile-sidebar">
                @include('front.account.common.sidebar')
            </div>
            <div class="section-10 profile-content">
                <div class="profile-heading">
                    <h2>Change Password</h2>
                </div>
                @if (Session::has('success'))
                    <div class="col-md-12 p-0">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="col-md-12 p-0">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ Session::get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                <div class="login-form">    
                    <form action="" method="post" name="changePasswordForm" id="changePasswordForm">
                        @csrf
                        <div class="profile-form-group">
                            <input type="password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Old Password" name="old_password">
                            @error('old_password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="profile-form-group">
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" placeholder="New Password" name="new_password">
                            @error('new_password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="profile-form-group">
                            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Confirm Password" name="confirm_password">
                            @error('confirm_password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="submit" class="btn btn-dark btn-block btn-lg profile-btn col-12 col-md-12" value="Change Password">              
                    </form>			
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('customJs')
<script>

    $('#changePasswordForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('front.changePassword') }}",
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (response) {
                if(response.status == true) {
                    $('.error').removeClass('invalid-feedback').html('');
                    $('input').removeClass('is-invalid');
                    
                    window.location.href="{{ route('front.logout') }}";
                } else {
                    let errors = response['errors'];
                    $('.error').removeClass('invalid-feedback').html('');
                    $('input').removeClass('is-invalid');

                    $.each(errors, function(key, value) {
                        $(`#${key}`).addClass('is-invalid').siblings('.error').addClass('invalid-feedback').html(value);
                    });
                }
            }
        });
    });

</script>
@endsection