<div class="container">
    <div class="comment-inner col-md-9">
        <!-- Add Comment Form -->
        <div class="add-comment">
            <h3>Leave a Comment</h3>
            <form class="text-end" action="{{ route('front.storeComment') }}" method="post" name="commentForm" id="commentForm">
                @csrf
                <input type="hidden" name="post_id" value="{{ $postsData->id }}"> <!-- Pass post ID -->
                <textarea name="comment" id="comment" class="@error('comment') is-invalid @enderror" placeholder="Write your comment..." required></textarea>
                @error('comment')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
                <button type="submit">Post Comment</button>
            </form>                
        </div>


        <!-- Comments List -->
        <div class="comments-list mt-5">
            <h3>Comments</h3>
            @if($comments->count() > 0)
                @foreach($comments as $comment)
                    <div class="comment">
                        <div class="comment-header d-flex align-items-center justify-content-between">
                            <div class="comment-header-inner d-flex align-items-center gap-3">
                                @if($comment->user->image)
                                    <img src="{{ asset('uploads/profile-pic/'.$comment->user->image) }}" alt="User Avatar" class="avatar">
                                @else
                                    <img src="{{ asset('admin-assets/img/avatar4.png') }}" alt="User Avatar" class="avatar">
                                @endif
                                <div class="comment-meta d-flex flex-column">
                                <h4>{{ $comment->user->name }}</h4>
                                <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="comment-actions position-relative">
                                <span class="comment-actions-dropdown-btn">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </span>
                                <ul class="comment-actions-dropdown">
                                    <li>
                                        <a href="#">Edit</a>
                                    </li>
                                    <li>
                                        <a href="#">Delete</a>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                        <div class="comment-body">
                            <p>{{ $comment->comment }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="comment-body">
                    <p>No comments found for this post.</p>
                </div> 
            @endif
        </div>
    </div>
</div>
