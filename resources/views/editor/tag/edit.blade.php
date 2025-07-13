@extends('editor.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Tags</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('editor-tags.create') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        @include('admin.admin-authentication.message')
        <form action="" method="post" name="tagForm" id="tagForm">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">								
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $tag->name }}">
                                    <p class="error"></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $tag->slug }}">
                                    <p class="error"></p>	
                                </div>
                            </div>	
                        </div>								
                    </div>
                </div>	
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">status</h2>
                            <div class="mb-0">
                                <select name="status" id="status" class="form-control">
                                    <option {{  ($tag->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                    <option {{  ($tag->status == 0) ? 'selected' : '' }} value="0">Block</option>
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="pt-2 d-flex">
                                <button class="btn btn-primary">Update</button>
                                <a href="{{ route('editor-tags.create') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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

$('#tagForm').submit(function (e) {
    e.preventDefault();
    let element = $(this);
    
    // Create a FormData object
    let formData = new FormData(this);
    formData.append('_method', 'PUT');

    $.ajax ({
        url: '{{ route("editor-tags.update", $tag->id) }}',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            if(response.status == true) {
                $('.error').removeClass('invalid-feedback').html('');
                $('input, select').removeClass('is-invalid');
                
                window.location.href="{{ route('tags.create') }}";
            } else {
                let errors = response['errors'];
                $('.error').removeClass('invalid-feedback').html('');
                $('input, select').removeClass('is-invalid');

                $.each(errors, function(key, value) {
                    $(`#${key}`).addClass('is-invalid').siblings('.error').addClass('invalid-feedback').html(value);
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

</script>
@endsection