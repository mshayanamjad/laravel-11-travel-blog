@extends('editor.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit User</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a onclick="goBack()" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" name="userForm" id="userForm" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">								
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $user->name }}">	
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" disabled value="{{ $user->email }}">
                                    <p class="error"></p>	
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone"  value="{{ $user->phone }}">	
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-control height_58">
                                        <option {{ ($user->gender == 'male') ? 'selected' : '' }} value="male">Male</option>
                                        <option {{ ($user->gender == 'female') ? 'selected' : '' }} value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="role">Role</label>
                                        <input type="text" id="role" class="form-control" placeholder="Role"  value="{{ $user->role }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="d-block">Image</label>
                                    <div class="d-flex align-items-center">
                                        <div class="file-btn col-md-10">
                                            <input type="file" name="image" id="image" accept=".jpeg,.png,.jpg,gif">
                                            <div class="file-inner-content d-flex align-items-center col-md-10">
                                                <span class="file-icon"><i class="fa-regular fa-image"></i></span>
                                                <p class="no-file ml-2">Upload a Picture<br>
                                                    <span>JPG, JPEG, PNG or WEBP</span>
                                                </p>
                                            </div>
                                            <button class="browse col-md-2 p-3">Browse</button>
                                        </div>
                                        <p class="error"></p>
                                        
                                        <div class="image-container d-flex align-items-center col-md-2">
                                            <div class="col-md-12">
                                                <!-- Only one img tag to show either old or new image -->
                                                <img id="category-image-preview" 
                                                    src="{{ $user->image ? asset('uploads/profile-pic/' . $user->image) : '' }}" 
                                                    alt="{{ $user->name }}" 
                                                    style="max-width: 100%; height: 140px; display: {{ $user->image ? 'block' : 'none' }}" />
                                                <p id="no-image-text" style="display: {{ $user->image ? 'none' : 'block' }}">Image Not Uploded Before</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>							
                </div>
            
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" id="submit" type="submit">Update</button>
                    <a href="{{ route('editor.edit', $user->id) }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

</section>

@endsection
@section('customJS')
<script>

    $('#userForm').submit(function (e) {
        let element = $(this);
        e.preventDefault();

        let formData = new FormData(element[0]);
        formData.append('_method', 'PUT');

        $.ajax({
            url: '{{ route("editor.update", $user->id) }}',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if(response.status == true) {
                    $('.error').removeClass('invalid-feedback').html('');
                    $('input').removeClass('is-invalid');
                    
                    window.location.href="{{ route('editor.edit', $user->id) }}";
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