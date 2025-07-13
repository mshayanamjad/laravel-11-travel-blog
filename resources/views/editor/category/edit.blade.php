@extends('editor.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('ed-categories.create') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" id="categoryForm" name="categoryForm">
            @csrf
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Category Name" autocomplete="given-name" value="{{ $category->name }}">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $category->slug }}">	
                                    <p></p>
                                </div>
                            </div>											
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ ($category->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ ($category->status == 0) ? 'selected' : '' }} value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="d-block">Image</label>
                                <div class="file-btn">
                                    <input type="file" name="image" id="image" accept=".jpeg,.png,.jpg,gif">
                                    <div class="file-inner-content d-flex align-items-center col-md-10">
                                        <span class="file-icon"><i class="fa-regular fa-image"></i></span>
                                        <p class="no-file ml-2">Upload a Picture<br>
                                            <span>JPG, JPEG, PNG or WEBP</span>
                                        </p>
                                    </div>
                                    <button class="browse col-md-2">Browse</button>
                                </div>
                                <p class="error"></p>
                                
                                <div class="image-container d-flex align-items-center">
                                    <div class="col-md-12">
                                        <!-- Only one img tag to show either old or new image -->
                                        <img id="category-image-preview" 
                                             src="{{ $category->image ? asset('admin-assets/uploads/category-images/' . $category->image) : '' }}" 
                                             alt="{{ $category->name }}" 
                                             style="max-width: 100%; height: 140px; display: {{ $category->image ? 'block' : 'none' }}" />
                                        <p id="no-image-text" style="display: {{ $category->image ? 'none' : 'block' }}">Image Not Uploded Before</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" id="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('ed-categories.create') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJS')
<script>

$('#categoryForm').submit(function (e) {
    e.preventDefault();
    
    let element = $(this);
    let formData = new FormData(this); // Use FormData to handle file uploads
    
    // Add the _method field to spoof PUT request
    formData.append('_method', 'PUT');

    $.ajax({
        url: '{{ route("ed-categories.update", $category->id) }}',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,  // Required for file upload
        processData: false,  // Prevent jQuery from processing the data
        success: function (response) {
            if (response.status == true) {
                $('.error').removeClass('invalid-feedback').html('');
                $('input, select').removeClass('is-invalid');

                // Redirect after success
                window.location.href = "{{ route('ed-categories.create') }}";
            } else {
                // Handle validation errors
                let errors = response.errors;

                $('.error').removeClass('invalid-feedback').html('');
                $('input, select').removeClass('is-invalid');

                $.each(errors, function(key, value) {
                    $(`#${key}`).addClass('is-invalid').siblings('P').addClass('invalid-feedback').html(value);
                });
            }
        },
        error: function (jqXHR, exception) {
            console.log('Something Went Wrong');
        }
    });
});




$('#name').change(function () {
    $('#submit').prop('disabled', true);
    element = $(this);
    $.ajax({
        url: '{{ route("getSlug") }}',
        type: 'get',
        data: {title: element.val()},
        dataType: 'json',
        success: function (response) {
            $('#submit').prop('disabled', false);
            if (response['status'] == true) {
                $('#slug').val(response['slug']);
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