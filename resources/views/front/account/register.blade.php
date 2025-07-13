@extends('front.layouts.app')
@section('title', 'Travel Blog')

 @section('content')
    <div class="account-main">
        <section class="section-10 py-5 mt-5">
            <div class="container">
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
                <div class="login-form p-0">    
                    <form action="" method="post" name="userForm" id="userForm" enctype="multipart/form-data">
                        @csrf
                        <h4 class="modal-title">Register Now</h4>
                        <div class="profile-form-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name">
                            @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="profile-form-group">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="profile-form-group">
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" name="phone">
                            @error('phone')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="profile-form-group">
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" id="gender">
                                <option value="" selected disabled>Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('phone')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="profile-form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
                            @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 profile-form-group">
                            <div class="mb-3">
                                <div class="file-btn">
                                    <input type="file" name="image" id="image" accept=".jpeg,.png,.jpg,gif">
                                    <div class="file-inner-content d-flex align-items-center col-md-10">
                                        <span class="file-icon">
                                            <div id="image-preview"></div>
                                        </span>
                                        <p class="no-file ml-2">Upload a Picture<br>
                                            <span>JPG, JPEG, PNG or WEBP</span>
                                        </p>
                                    </div>
                                </div>
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="profile-form-group small">
                            <a href="{{ route('account.forgotPassword') }}" class="forgot-link">Forgot Password?</a>
                        </div> 
                        <input type="submit" class="btn btn-dark btn-block btn-lg profile-btn" value="Register">              
                    </form>			
                    <div class="signup-link text-center small mt-3">Already have an account? <a href="{{ route('front.login') }}">Login Now</a></div>
                </div>
            </div>
        </section>
    </div>
 @endsection
 @section('customJs')
 <script>

    $('#userForm').submit(function (e) {
        let element = $(this);
        e.preventDefault();

        let formData = new FormData(element[0]);

        $.ajax({
            url: '{{ route("front.userRegisteration") }}',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if(response.status == true) {
                    $('.error').removeClass('invalid-feedback').html('');
                    $('input').removeClass('is-invalid');
                    
                    window.location.href="{{ route('front.profile') }}";
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


    const fileUploads = document.querySelectorAll('input[type="file"]');
    const fileNameGetters = document.querySelectorAll('.no-file');
    const imagePreviews = document.querySelectorAll('#image-preview');

    // Default icon to show when no file is uploaded
    const defaultIcon = '<i class="fa-regular fa-image"></i>';

    fileUploads.forEach(function(fileUpload, index) {
        fileUpload.addEventListener('change', function() {
            if (fileUpload.files.length > 0) {
                const file = fileUpload.files[0];
                fileNameGetters[index].innerHTML = file.name;

                // Create an image element to preview the uploaded file
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreviews[index].innerHTML = `<img src="${e.target.result}" alt="Image Preview" style="max-width: 100%; height: 40px; object-fit: cover;">`;
                };
                reader.readAsDataURL(file); // Read the file as a data URL
            } else {
                fileNameGetters[index].innerHTML = 'Upload a Picture';

                // Display the default icon if no file is selected
                imagePreviews[index].innerHTML = defaultIcon;
            }
        });

        // Initialize with the default icon if no file is selected
        if (fileUpload.files.length === 0) {
            imagePreviews[index].innerHTML = defaultIcon;
        }
    });
    </script>
 @endsection