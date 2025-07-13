<?php

namespace App\Http\Controllers\editor;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EdPanelCommentController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');

        // Start the query for comments
        $comments = Comment::query()
            ->with('user', 'post'); // Eager load user and post relationships

        // Apply search for comment content
        if ($keyword) {
            $comments = $comments->where('comment', 'like', '%' . $keyword . '%')
            ->orWhereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })->orWhereHas('post', function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            });
        }

        // Get the results
        $comments = $comments->paginate(10);

        // Return the view with the filtered comments
        return view('editor.comment.list', ['comments' => $comments]);
    }

    public function edit($id) {
        $comment = Comment::findOrFail($id);

        return view('editor.comment.edit', compact('comment'));
    }


    public function update(Request $request, $id) {
        // Validate the input
        $request->validate([
            'comment' => 'required|string|max:500', // Validate the comment
        ]);

            // Save the comment
            $comment = Comment::findOrFail($id); // Assuming you have a Comment model
            $comment->comment = $request->comment; // Assign the comment content
            $comment->save(); 

            return redirect()->route('comment.index')->with('success', 'Comment Updated'); 
    }

    public function destroy($id) {
        $comment = Comment::findOrFail($id);

        if(empty($comment)) {
            return redirect()->back()->with('error', 'Record Not Found');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Record Deleted');
    }
}
