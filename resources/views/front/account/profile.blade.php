@extends('front.layouts.app')
@section('title', 'MY Account')

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
            <h2>Personal Information</h2>
        </div>
            <div class="form-container">
                <form class="profile-form" action="" method="post" name="userForm" id="userForm" enctype="multipart/form-data">
                    @csrf
                    <div class="profile-form-group">
                        <label for="profile-name">Name</label>
                        <input type="text" id="profile-name" name="name" placeholder="Name" value="{{ $users->name }}">
                        <p class="error"></p>
                    </div>
                    <div class="profile-form-group">
                        <label for="profile-email">Email</label>
                        <input type="email" id="profile-email" name="email" placeholder="Email" value="{{ $users->email }}">
                        <p class="error"></p>
                    </div>
                    <div class="profile-form-group">
                        <label for="profile-phone">Phone</label>
                        <input type="text" id="profile-phone" name="phone" placeholder="Phone" value="{{ $users->phone }}">
                        <p class="error"></p>
                    </div>
                    <div class="profile-form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" class="form-control" id="gender">
                            <option value="" selected disabled>Select Gender</option>
                            <option {{ ($users->gender == 'male') ? 'selected' : '' }} value="male">Male</option>
                            <option {{ ($users->gender == 'female') ? 'selected' : '' }} value="female">Female</option>
                        </select>
                        <p class="error"></p>
                    </div>
                    <div class="profile-form-group">
                        <div class="mb-3">
                            <label for="" class="d-block">Image</label>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="file-btn col-md-9">
                                    <input type="file" name="image" id="image" accept=".jpeg,.png,.jpg,gif">
                                    <div class="file-inner-content d-flex align-items-center col-md-10">
                                        <span class="file-icon"><i class="fa-regular fa-image"></i></span>
                                        <p class="no-file ml-2">Upload a Picture<br>
                                            <span>JPG, JPEG, PNG or WEBP</span>
                                        </p>
                                    </div>
                                </div>
                                <p class="error"></p>
                                
                                <div class="image-container d-flex align-items-center col-md-2 ms-4">
                                    <div class="col-md-12">
                                        <!-- Only one img tag to show either old or new image -->
                                        <img id="category-image-preview" 
                                            src="{{ $users->image ? asset('uploads/profile-pic/' . $users->image) : '' }}" 
                                            alt="{{ $users->name }}" 
                                            style="max-width: 100%; height: 80px; text-align-right; display: {{ $users->image ? 'block' : 'none' }}" />
                                        <p id="no-image-text" style="display: {{ $users->image ? 'none' : 'block' }}">Image Not Uploded Before</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="profile-btn">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@section('customJs')
<script>

    $('#userForm').submit(function (e) {
        let element = $(this);
        e.preventDefault();

        let formData = new FormData(element[0]);
        formData.append('_method', 'PUT');

        $.ajax({
            url: "{{ route('front.updateProfile', $users->id) }}",
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


    const fileUpload = document.getElementById('image');
    const fileNameGetter = document.querySelector('.no-file'); // Single file name display element
    const imagePreview = document.getElementById('category-image-preview');
    const noImageText = document.getElementById('no-image-text');

    fileUpload.addEventListener('change', function() {
        if (fileUpload.files.length > 0) {
            const file = fileUpload.files[0];

            // Update file name display
            fileNameGetter.innerHTML = file.name;

            // Create an image element to preview the uploaded file
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result; // Set the image preview to the new image
                imagePreview.style.display = 'block'; // Show the new image
                noImageText.style.display = 'none';  // Hide the 'No Image Available' text
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        } else {
            // Reset file name and image preview if no file is selected
            fileNameGetter.innerHTML = 'Upload a Picture';
            imagePreview.style.display = 'none'; // Hide the image preview
            noImageText.style.display = 'block'; // Show the 'No Image Available' text
        }
    });



</script>
@endsection
