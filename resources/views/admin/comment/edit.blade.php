@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Post</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="products.html" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{ route('comment.updateComment', $comment->id) }}" method="post" id="commentForm">
            @csrf
            <div class="row">
                <div class="col-md-12" style="height: fit-content">
                    <div class="card mb-3">
                        <div class="card-body">								
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="user_id">User</label>
                                        <input type="text" name="user_id" id="user_id" class="form-control" placeholder="User" value="{{ $comment->user->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="post">Post Title</label>
                                        <input type="text" name="post" id="post" class="form-control" placeholder="Post Title" value="{{ $comment->post->title }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="comment">Comment</label>
                                        <textarea name="comment" class="form-control" id="comment" rows="7" placeholder="Comment">{{ $comment->comment }}</textarea>
                                    </div>
                                </div>                                                                                        
                            </div>
                        </div>	                                    
                    </div>
                    <div class="col-md-12 pb-5 pt-3">
                        <button class="btn btn-primary">Update</button>
                        <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
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

</script>
@endsection