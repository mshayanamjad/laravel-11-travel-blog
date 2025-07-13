@extends('editor.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Post</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('editor-posts.index')}}" class="btn btn-primary">Back</a>
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
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ $post->title }}">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $post->slug }}">
                                        <p class="error"></p>	
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description">{{ $post->description }}</textarea>
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
                                    <br>Drop files here or click to upload.<br><br>                                            
                                </div>
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="col-md-8 pb-5 pt-3 d-flex d-md-none">
                        <button class="btn btn-primary">Update</button>
                        <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Post status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($post->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                    <option {{ ($post->status == 0) ? 'selected' : '' }} value="0">Block</option>
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="pt-5 d-none d-md-flex">
                                <button class="btn btn-primary">Update</button>
                                <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Featured Post</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option {{ ($post->is_featured == 'No') ? 'selected' : '' }} value="No">No</option>
                                    <option {{ ($post->is_featured == 'Yes') ? 'selected' : '' }} value="Yes">Yes</option>                                                
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div> 
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Featured Image</h2>
                            <div class="mb-0 position-relative">
                                <div id="image-preview" class="mt-3"></div>
                                @if(!empty($post->image))
                                <div class="post-image">
                                    <img src="{{ asset('uploads/post-images/'.$post->image) }}" alt="" style="width: 100%; object-fit: contain;" height="250">
                                </div>
                                @endif
                                <div class="hidden-file">
                                    <input type="file" name="image" id="post_image">
                                </div>
                                <div class="file-container mt-2">
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
                                @if ($availableCategories)
                                    @foreach ($availableCategories as $category)
                                        <div>
                                            <input @if(in_array($category->id, $selectedCategories)) checked @endif type="checkbox" name="category[]" id="{{ $category->id }}" value="{{ $category->id }}">
                                            
                                            <label for="{{ $category->id }}">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                                <p class="error"></p>
                            </div>
                            <a href="{{ route('ed-categories.create') }}">Add Category</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Sub Category</h2>                        
                            <div class="mb-3 sub-category-container">
                                @if ($availableSubCategories)
                                    @foreach ($availableSubCategories as $sub_category)
                                        <div>
                                            <input @if(in_array($sub_category->id, $selectedSubCategories)) checked @endif type="checkbox" name="sub_category[]" id="{{ $sub_category->id }}" value="{{ $sub_category->id }}">
                                            
                                            <label for="{{ $sub_category->id }}">{{ $sub_category->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                                <p class="error"></p>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Tag</h2>
                            <div class="mb-3 tags-container">
                                @if ($availableTags)
                                    @foreach ($availableTags as $tag)
                                        <div>
                                            <input @if(in_array($tag->id, $selectedTags)) checked @endif type="checkbox" name="tags[]" id="{{ $tag->id }}" value="{{ $tag->id }}">
                                            
                                            <label for="{{ $tag->id }}">{{ $tag->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                                <p class="error"></p>
                            </div>
                        </div>
                    </div> 
                    <div class="card">
                        <div class="card-body">	
                            <label for="short_description">Short Description</label>
                            <textarea name="short_description" id="short_description" class="form-control" rows="5" placeholder="Short Description">{{ $post->short_description }}</textarea>
                            <p class="error"></p>
                            </div>
                        </div>
                    </div>                                
                </div>
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
    let formData = new FormData(this);
    
    formData.append('_method', 'PUT');

    $.ajax({
        url: '{{ route("editor-posts.update", $post->id) }}',
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
                window.location.href = "{{ route('editor-posts.index') }}";
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
const postImages = document.querySelectorAll('.post-image'); // Select all elements with the class .post-image

fileUploads.forEach(function(fileUpload, index) {
    fileUpload.addEventListener('change', function() {
        if (fileUpload.files.length > 0) {
            const file = fileUpload.files[0];
            // Create an image element to preview the uploaded file
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreviews[index].innerHTML = `<img src="${e.target.result}" alt="Image Preview" style="width: 100%;">`;
            };
            reader.readAsDataURL(file); // Read the file as a data URL

            // Hide the .post-image element when an image is added
            postImages[index].style.display = 'none';
        } else {
            imagePreviews[index].innerHTML = ''; // Clear the preview if no file is selected

            // Show the .post-image element again if no image is added
            postImages[index].style.display = '';
        }
    });
});




</script>
@endsection