<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    
    
    public function storeComment(Request $request)
    {
        // Validate the input
        $request->validate([
            'post_id' => 'required|exists:posts,id', // Ensure the post ID exists in the posts table
            'comment' => 'required|string|max:500', // Validate the comment
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to post a comment.');
        }

        if (Auth::check() == false) {

            session(['url.intended' => url()->previous()]);
        }

            // Save the comment
            $comment = new Comment(); // Assuming you have a Comment model
            $comment->post_id = $request->post_id; // Assign the post ID
            $comment->user_id = Auth::user()->id; // Get current logged-in user's ID
            $comment->comment = $request->comment; // Assign the comment content
            $comment->save();    
        // Redirect or return a response
        return back()->with('success', 'Comment posted successfully!');
    }    

    public function editComment($id) {

        $editComment = Comment::find($id);

        return view('front.single_post', compact('editComment'));
    }

}
