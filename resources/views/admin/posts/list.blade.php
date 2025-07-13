@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Post</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('posts.create') }}" class="btn btn-primary">New Post</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('admin.admin-authentication.message')
            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="card-title">
                            <button type="button" class="btn btn-secondary btn-md" onclick="window.location.href='{{ route('posts.index') }}'">Reset</button>
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
                    </form>
                <div class="card-body table-responsive p-0">								
                    <table class="table table-hover text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Categories</th>
                                <th width="100">Status</th>
                                <th width="100">Views</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($posts))
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $post->id}}</td>
                                        <td><a href="{{ route('front.singlePost', $post->slug) }}" target="_blank">{{ $post->title }}</a></td>
                                        <td>{{ $post->user->name }}</td>
                                        <td id="post-cate-list">
                                            @if(!empty($post->categories))
                                                @foreach($post->categories as $category)
                                                    <span>{{ $category }}@if(!$loop->last), @endif</span>
                                                @endforeach
                                        @endif
                                        </td>
                                        <td>
                                            @if($post->status == 1)
                                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </td>
                                        <td>{{ $post->getViews() }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('posts.edit', $post->id) }}">
                                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('posts.delete', $post->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button href="" class="text-danger w-4 h-4 mr-1 border-0 outline-o bg-transparent">
                                                    <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        
                        </tbody>
                    </table>										
                </div>
                <div class="card-footer clearfix">
                        {{ $posts->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</section>

@endsection
