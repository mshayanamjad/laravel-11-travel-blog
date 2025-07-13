@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Post</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a onclick="goBack()" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" name="postForm" id="postForm" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8" style="height: fit-content">
                    <div class="card mb-3">
                        <div class="card-body">								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                        <p class="error"></p>	
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                        <p class="error"></p>
                                    </div>
                                </div>                                                                                                                    
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Post Gallery</h2>	
                            						
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <div id="gallery-image-preview"></div>  
                                    <p class="drop-file">Drop files here or click to upload.<p>                                            
                                </div>
                            </div>
                        </div>	                                                                      
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Post status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="pt-5 d-none d-md-flex">
                                <button class="btn btn-primary">Create</button>
                                <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Featured Post</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>                                                
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div> 
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Featured Image</h2>
                            <div class="mb-0">
                                <div id="image-preview" class="mt-3"></div>
                                <div class="file-container">
                                    <input type="file" name="image" id="post_image">
                                    +Add Post Thumbnail
                                    <img class="trash-icon" src="{{ asset('admin-assets/img/trash.svg') }}">
                                </div>
                                <p class="error m-0"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Category</h2>
                            <div class="mb-2 category-container">
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                        <div>
                                            <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}">
                                            <label for="{{ $category->name }}">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                                <p class="error"></p>
                            </div>
                            <a href="{{ route('categories.create') }}">+Add Category</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Sub Category</h2>                        
                            <div class="mb-2 sub-category-container">
                                @if ($sub_categories->isNotEmpty())
                                    @foreach ($sub_categories as $sub_category)
                                        <div>
                                            <input type="checkbox" name="sub_category[]" id="{{ $sub_category->name }}" value="{{ $sub_category->id }}">
                                            <label for="{{ $sub_category->name }}">{{ $sub_category->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                                <p class="error"></p>
                            </div>
                            <a href="{{ route('sub-categories.create') }}">+Add Sub Category</a>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Tag</h2>
                            <div class="mb-2 tags-container">
                                @if ($tags->isNotEmpty())
                                    @foreach ($tags as $tag)
                                        <div>
                                            <input type="checkbox" name="tags[]" id="{{ $tag->name }}" value="{{ $tag->id }}">
                                            <label for="{{ $tag->name }}">{{ $tag->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                                <p class="error"></p>
                            </div>
                            <a href="{{ route('tags.create') }}">+Add Tag</a>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">
                            <label for="short_description">Short Description</label>
                            <textarea name="short_description" id="short_description" rows="5" class="w-100 p-2" placeholder="Short Description"></textarea>
                            <p class="error mb-0"></p>
                        </div>
                    </div>                                
                </div>
            </div>
            <div class="col-md-8 pb-5 pt-3 d-flex d-md-none">
                <button class="btn btn-primary">Create</button>
                <a href="{{ route('posts.create') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->

@endsection

@section('customJS')
<script>

$('#postForm').submit(function (e) {
    e.preventDefault();
    let element = $(this);
    let formData = new FormData(element[0]);

    // // Log form data to check if category data is being passed correctly
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    $.ajax({
        url: '{{ route("posts.store") }}',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token
        },
        success: function (response) {
            if (response.status == true) {
                $('.error').removeClass('invalid-feedback').html('');
                $('input, select').removeClass('is-invalid');
                window.location.href = "{{ route('posts.index') }}";
            } else {
                let errors = response['errors'];
                $('.error').removeClass('invalid-feedback').html('');
                $('input, select').removeClass('is-invalid');

                $.each(errors, function (key, value) {
                    $(`#${key}`).addClass('is-invalid').siblings('.error').addClass('invalid-feedback').html(value);
                });
            }
        }
    });
});



$('#title').change(function () {
    $('#submit').prop('disabled', true);
    let element = $(this);
    
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



const fileUploads = document.querySelectorAll('input[type="file"]');
const imagePreviews = document.querySelectorAll('#image-preview');

fileUploads.forEach(function(fileUpload, index) {
    fileUpload.addEventListener('change', function() {
        if (fileUpload.files.length > 0) {
            const file = fileUpload.files[0];
            // Create an image element to preview the uploaded file
            const reader = new FileReader();
            reader.onload = function(e) {
                // Only update the correct preview based on the file input (post_gallery or featured image)
                if (fileUpload.name === 'image') {
                    // For the featured image, update a single preview
                    imagePreviews[0].innerHTML = `<img src="${e.target.result}" alt="Featured Image Preview" style="width: 100%;">`;
                }
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        } else {
            if (fileUpload.name === 'image') {
                imagePreviews[0].innerHTML = ''; // Clear the featured image preview
            }
        }
    });
});



$(function () {
    // Summernote
    $('.summernote').summernote({
        height: '300px'
    });

});


</script>
@endsection