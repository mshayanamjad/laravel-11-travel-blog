<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\FavPost;
use App\Models\Comment;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{

    public function home(Request $request)
    {
        $categories = Category::where('status', 1)
            ->orderBy('name', 'ASC')
            ->with('sub_categories')
            ->get();
    
        $latestPosts = Post::where('status', 1)
            ->take(9)
            ->latest()
            ->get();
    
        $hikeCategoryId = Category::where('name', 'Hiking')->value('id');
        if (!$hikeCategoryId) {
            $hikePosts = collect(); // No hiking category, return an empty collection
        } else {
            $hikePosts = Post::where('status', 1)
                ->whereJsonContains('categories', (string)$hikeCategoryId) // Match string IDs
                ->take(6)
                ->latest()
                ->get();
        }
    
        return view('front.home', [
            'latestPosts' => $latestPosts,
            'hikePosts' => $hikePosts,
            'categories' => $categories,
        ]);
    }
    


    public function blog(Request $request)
    {
        // Initialize the query for non-featured posts
        $query = Post::where('status', 1)->orderBy('id', 'DESC');


        // Apply search filter if keyword is provided
        if (!empty($request->get('keyword'))) {
            $query = $query->where('title', 'like', '%' . $request->get('keyword') . '%');
        }

        // Apply category filter if selected
        if ($request->has('category')) {
            $query->whereJsonContains('categories', $request->category);
        }

        // Apply sub category filter if selected
        if ($request->has('sub_category')) {
            $query->whereJsonContains('sub_categories', $request->sub_category);
        }

        // Paginate the results to ensure you get the right number of posts
        $latestPosts = $query->paginate(30);

        // Ensure short description has a consistent word limit
        foreach ($latestPosts as $post) {
            $description = $post->short_description ?: $post->description;
            $post->short_description = $this->getShortDescription($description);
        }

        // Decode the categories field and fetch category names
        $getCategories = function ($latestPost) {
            // Decode categories from JSON string to an array
            $categoryIds = json_decode($latestPost->categories, true);

            // If there are category IDs, fetch category names from the Category model
            if ($categoryIds) {
                // Retrieve category names for the decoded IDs
                $categoryNames = Category::whereIn('id', $categoryIds)->pluck('name')->toArray();
                $latestPost->categories = $categoryNames; // Assign the names to the categories property
            }
        };

        // Decode the categories field and fetch category names
        $getSubCategories = function ($latestPost) {
            // Decode categories from JSON string to an array
            $subCategoryIds = json_decode($latestPost->sub_categories, true);

            // If there are category IDs, fetch category names from the Category model
            if ($subCategoryIds) {
                // Retrieve category names for the decoded IDs
                $subCategoryNames = SubCategory::whereIn('id', $subCategoryIds)->pluck('name')->toArray();
                $latestPost->sub_categories = $subCategoryNames; // Assign the names to the categories property
            }
        };

        // Apply the categories function to each post
        $latestPosts->each($getCategories);
        $latestPosts->each($getSubCategories);

        // Pass data to the view
        return view('front.post', [
            'latestPosts' => $latestPosts,
        ]);
    }

    // Helper function to get a short description with word limit
    private function getShortDescription($description, $wordLimit = 30)
    {
        $words = explode(' ', strip_tags($description));
        if (count($words) > $wordLimit) {
            $words = array_slice($words, 0, $wordLimit);
            return implode(' ', $words);
        }
        return implode(' ', $words);
    }



    public function singlePost($slug, Request $request)
    {
        // Fetch the specific post by slug
        $postsData = Post::where('slug', $slug)->first();
    
        // Check if the post exists
        if (!$postsData) {
            return abort(404, 'Post not found');
        }
    
        // Decode the categories field and fetch category names for the main post
        if (!empty($postsData->categories)) {
            $categoryIds = json_decode($postsData->categories, true);
    
            if (is_array($categoryIds) && !empty($categoryIds)) {
                $categoryNames = Category::whereIn('id', $categoryIds)->pluck('name')->toArray();
                $postsData->categories = $categoryNames;
            } else {
                $postsData->categories = [];
            }
        } else {
            $postsData->categories = [];
        }
    
        // Decode the sub-categories field and fetch category names for the main post
        if (!empty($postsData->sub_categories)) {
            $subCategoryIds = json_decode($postsData->sub_categories, true);
    
            if (is_array($subCategoryIds) && !empty($subCategoryIds)) {
                $categoryNames = SubCategory::whereIn('id', $subCategoryIds)->pluck('name')->toArray();
                $postsData->sub_categories = $categoryNames;
            } else {
                $postsData->sub_categories = [];
            }
        } else {
            $postsData->sub_categories = [];
        }
    
        // Fetch the latest 8 non-featured posts
        $latestPosts = Post::with('user')
            ->where('is_featured', 'No')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();
    
        // Fetch comments related to the current post
        $comments = Comment::where('post_id', $postsData->id)
            ->with('user')
            ->latest()
            ->get();
    
        // Check if the post has already been viewed by this user in the session
        $viewedPosts = $request->session()->get('viewed_posts', []);
    
        if (!in_array($postsData->id, $viewedPosts)) {
            // Increment the view count if not already viewed
            $postsData->incrementViews();
    
            // Add the post ID to the session
            $viewedPosts[] = $postsData->id;
            $request->session()->put('viewed_posts', $viewedPosts);
        }
    
        // Pass data to the view
        return view('front.single_post', [
            'postsData' => $postsData,
            'latestPosts' => $latestPosts,
            'comments' => $comments
        ]);
    }
    
    

    public function addToFav(Request $request)
    {

        if (Auth::check() == false) {

            session(['url.intended' => url()->previous()]);
            return response()->json([
                'status' => false,
            ]);
        }

        $post = Post::where('id', $request->id)->first();

        if ($post == null) {
            session()->flash('error', 'Post not found');
            return response()->json([
                'status' => true,
                'message' => '<div class="alert alert-danger">Post Not Found</div>',
            ]);
        }

        FavPost::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'post_id' => $request->id
            ],
            [
                'user_id' => Auth::user()->id,
                'post_id' => $request->id
            ]
        );

        // $favPost = new FavPost();
        // $favPost->user_id = Auth::user()->id;
        // $favPost->post_id = $request->id;
        // $favPost->save();

        session()->flash('success', 'Post added to favorites');

        return response()->json([
            'status' => true,
            'message' => '<div class="alert alert-success"><strong>' . $post->title . '</strong><br> Post added to favorites</div>'

        ]);
    }


    public function gallery()
    {
        $imagesPath = public_path('uploads/post-images');
        $images = File::files($imagesPath);

        // Sort images in descending order by last modified time
        usort($images, function ($a, $b) {
            return $b->getMTime() <=> $a->getMTime(); // Descending order
        });

        // Map images to URLs
        $galleryImages = array_map(function ($file) {
            return asset('uploads/post-images/' . $file->getFilename());
        }, $images);

        return view('front.gallery', compact('galleryImages'));
    }



    public function about() {
       return view('front.about');
    }

    public function contact() {
       return view('front.contact');
    }

    public function travelGear() {
       return view('front.travel-gear');
    }
}
