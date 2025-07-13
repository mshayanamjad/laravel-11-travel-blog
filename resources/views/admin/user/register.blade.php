@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Users</h1>
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
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">	
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                                    <p class="error"></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone">	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-control height_58">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    <p class="error"></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-control height_58">
                                        <option value="admin">Admin</option>
                                        <option value="editor">Editor</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="d-block">Image</label>
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
                                        <button class="browse col-md-2 p-3">Browse</button>
                                    </div>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>							
                </div>
            
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" id="submit" type="submit">Create</button>
                    <a href="{{ route('users.create') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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

        $.ajax({
            url: '{{ route("users.register") }}',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if(response.status == true) {
                    $('.error').removeClass('invalid-feedback').html('');
                    $('input').removeClass('is-invalid');
                    
                    window.location.href="{{ route('users.show') }}";
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