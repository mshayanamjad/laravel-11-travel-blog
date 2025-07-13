@extends('editor.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Tags</h1>
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
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    <p class="error"></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
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
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="pt-2 d-flex">
                                <button class="btn btn-primary">Create</button>
                                <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </form>	
        
        {{------------------------------------- Tags View -----------------------------------------}}
        <div class="card mt-5">
            <form action="" method="get">
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" class="btn btn-secondary btn-md" onclick="window.location.href='{{ route('editor-tags.create') }}'">Reset</button>
                    </div>
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body table-responsive p-0">								
                <table class="categoriesTable table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60">Sr.</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tags as $tag)
                            <tr>
                                <td>{{ $tag->id }}</td>
                                <td>{{ $tag->name }}</td>
                                <td>{{ $tag->slug }}</td>
                                <td>
                                    @if($tag->status == 1)
                                        <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('editor-tags.edit', $tag->id) }}">
                                            <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('editor-tags.delete', $tag->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger w-4 h-4 mr-1 border-0 outline-o bg-transparent">
                                                <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Records Not Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>										
            </div>
            <div class="card-footer clearfix">
                {{ $tags->links() }}
            </div>
        </div>
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
    let formData = new FormData(element[0]);

    $.ajax ({
        url: '{{ route("editor-tags.store") }}',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            if(response.status == true) {
                $('.error').removeClass('invalid-feedback').html('');
                $('input, select').removeClass('is-invalid');
                
                window.location.href="{{ route('editor-tags.create') }}";
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