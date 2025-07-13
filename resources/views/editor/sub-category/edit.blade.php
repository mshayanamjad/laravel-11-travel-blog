@extends('editor.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('editor-sub-categories.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" id="subCategoryForm" name="subCategoryForm">
            @csrf
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $subCategory->name }}">
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $subCategory->slug }}">	
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option disabled selected>Select Category</option>

                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option {{ ($subCategory->category_id == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($subCategory->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                    <option {{ ($subCategory->status == 0) ? 'selected' : '' }} value="0">Block</option>
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>																	
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('editor-sub-categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJS')
<script>


$('#subCategoryForm').submit(function (e) {
    e.preventDefault();
    $('#submit').prop('disabled', true);
    let element = $(this);

    $.ajax({
        url: '{{ route("editor-sub-categories.update", $subCategory->id) }}',
        type: 'put',
        data: element.serializeArray(),
        dataType: 'json',
        success: function (response) {

            if (response.status == true) {

                $('.error').removeClass('invalid-feedback').html('');
                $('input, select').removeClass('is-invalid');

                window.location.href="{{ route('editor-sub-categories.create') }}";

            } else {
                
                let errors = response['errors'];
                $('.error').removeClass('invalid-feedback').html('');
                $('input, select').removeClass('is-invalid');

                $.each(errors, function(key, value) {
                    $(`#${key}`).addClass('is-invalid').siblings('.error').addClass('invalid-feedback').html(value);
                });
            }
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