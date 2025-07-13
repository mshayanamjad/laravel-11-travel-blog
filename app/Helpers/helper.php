<?php

use App\Models\Post;
use App\Models\Category;
use App\Models\FavPost;
use Illuminate\Support\Facades\Auth;

function getCategories()
{
    return Category::orderBy('name', 'ASC')->with('sub_categories')->where('status', 1)->get();
}

function getFeaturdPost()
{
    // Fetch the latest 8 featured posts
    $featuredPosts = Post::where('is_featured', 'Yes')
        ->where('status', 1)
        ->orderBy('id', 'DESC')
        ->take(8)
        ->get();
    return $featuredPosts;
}


function favPosts()
{
    $favPosts = FavPost::where('user_id', Auth::user()->id)->with('post')->get();

    return $favPosts;
}
