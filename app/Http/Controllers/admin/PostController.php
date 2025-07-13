<?php

namespace App\Http\Controllers\admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\PostGallery;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewPostNotification;

class PostController extends Controller
{

    /*============================= Post View Function =============================*/
    public function index(Request $request)
    {
        // Fetch posts with their associated user (using eager loading)
        $posts = Post::with('user')->latest('id');

        // Filter posts by keyword (optional)
        if (!empty($request->get('keyword'))) {
            $posts = $posts->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('keyword') . '%');
            });
        }

        // Get the posts with pagination
        $posts = $posts->paginate(10);

        // Decode the categories field and fetch category names
        $getCategories = function ($post) {
            // Decode categories from JSON string to an array
            $categoryIds = json_decode($post->categories, true);

            // If there are category IDs, fetch category names from the Category model
            if ($categoryIds) {
                // Retrieve category names for the decoded IDs
                $categoryNames = Category::whereIn('id', $categoryIds)->pluck('name')->toArray();
                $post->categories = $categoryNames; // Assign the names to the categories property
            }
        };

        // Apply the categories function to each post
        $posts->each($getCategories);

        return view('admin.posts.list', compact('posts'));
    }




    /*============================= Post Create Function =============================*/
    public function create()
    {
        $data = [];

        $categories = Category::orderBy('name', 'ASC')->get();
        $sub_categories = SubCategory::orderBy('name', 'ASC')->get();
        $tags = Tag::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['sub_categories'] = $sub_categories;
        $data['tags'] = $tags;

        return view('admin.posts.create', $data);
    }


    /*============================= Post Store Function =============================*/
    public function store(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:posts',
            'is_featured' => 'required|in:Yes,No',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'nullable|array', // Ensure category is an array if provided
            'category.*' => 'integer', // Ensure each category is an integer
            'sub_category' => 'nullable|array', // Same for sub_category
            'sub_category.*' => 'integer', // Ensure sub_category items are integers
            'tags' => 'nullable|array', // Same for tags
            'tags.*' => 'string', // Ensure tags are strings
        ]);

        // Check if validation passes
        if ($validator->passes()) {
            $data = new Post();

            // Determine which guard is being used and get the user ID
            $user = null;
            if (Auth::guard('admin')->check()) {
                $user = Auth::guard('admin')->user(); // Admin user
            } elseif (Auth::guard('editor')->check()) {
                $user = Auth::guard('editor')->user(); // Editor user
            }

            // If no user is authenticated, return an error response
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User is not authenticated',
                ]);
            }

            // Assign the authenticated user ID to the post
            $data->title = $request->title;
            $data->slug = $request->slug;
            $data->description = $request->description;
            $data->status = $request->status;
            $data->is_featured = $request->is_featured;
            $data->user_id = $user->id;

            // Store categories as JSON if provided
            $data->categories = $request->has('category') ? json_encode($request->category) : null;

            // Store sub_categories as JSON if provided
            $data->sub_categories = $request->has('sub_category') ? json_encode($request->sub_category) : null;

            // Store tags as JSON if provided
            $data->tags = $request->has('tags') ? json_encode($request->tags) : null;

            // Store the short description
            $data->short_description = $request->short_description;

            // Save the post
            $data->save();

            // Handle featured image upload
            if ($request->hasFile('image')) { // Check if an image was uploaded
                $image = $request->file('image'); // Use file method for file input

                // Generate a name for the image using the post ID
                $imagename = $data->id . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/post-images'), $imagename); // Move the uploaded file to the public/images directory
                $data->image = $imagename; // Save the image name to the post
                $data->save(); // Save changes to include the image name
            }

            // Notify all subscribers
            Subscription::where('is_subscribed', true)->each(function ($subscriber) use ($data) {
                // Notify the subscriber only if they are subscribed
                $subscriber->notify(new NewPostNotification($data)); 
            });


            return response()->json([
                'status' => true,
                'message' => 'Post Published Successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }


    /*============================= Post Edit Function =============================*/
    public function edit($id)
    {
        // Fetch the post by ID
        $post = Post::find($id);

        // Redirect if the post is not found
        if (!$post) {
            return redirect()
                ->route('posts.index')
                ->with('error', 'Category Not Found');
        }

        // Decode selected data
        $selectedCategories = json_decode($post->categories, true) ?? [];
        $selectedSubCategories = json_decode($post->sub_categories, true) ?? [];
        $selectedTags = json_decode($post->tags, true) ?? [];

        // Prepare data for the view
        $data = [
            'post' => $post,
            'selectedCategories' => $selectedCategories,
            'availableCategories' => Category::all()->sortByDesc(function ($category) use ($selectedCategories) {
                return in_array($category->id, $selectedCategories) ? 1 : 0;
            }),
            'selectedSubCategories' => $selectedSubCategories,
            'availableSubCategories' => SubCategory::all()->sortByDesc(function ($subCategory) use ($selectedSubCategories) {
                return in_array($subCategory->id, $selectedSubCategories) ? 1 : 0;
            }),
            'selectedTags' => $selectedTags,
            'availableTags' => Tag::all()->sortByDesc(function ($tag) use ($selectedTags) {
                return in_array($tag->id, $selectedTags) ? 1 : 0;
            }),
        ];

        // Return the view with the data
        return view('admin.posts.edit', $data);
    }


    public function update($id, Request $request)
    {
        $data = Post::find($id);

        if (empty($data)) {

            session()->flash('error', 'Post Not Found');

            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Post Not Found'
            ]);
        }

        // Validate input data
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:posts,slug,' . $data->id . ',id',
            'is_featured' => 'required|in:Yes,No',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Check if validation passes
        if ($validator->passes()) {

            // Assign the authenticated user ID to the post
            $data->title = $request->title;
            $data->slug = $request->slug;
            $data->description = $request->description;
            $data->status = $request->status;
            $data->is_featured = $request->is_featured;
            $data->short_description = $request->short_description;

            // Store categories only if they are selected
            $data->categories = $request->has('category') ? json_encode($request->category) : null;

            $data->sub_categories = $request->has('sub_category') ? json_encode($request->sub_category) : null;
            $data->tags = $request->has('tags') ? json_encode($request->tags) : null;



            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image'); // Use file method for file input

                // Define the path to the current image
                $imagePath = public_path('uploads/post-images/' . $data->image);

                // Delete the old image if it exists using File facade
                if ($data->image && File::exists($imagePath)) {
                    File::delete($imagePath);
                }

                $imagename = $data->id . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/post-images'), $imagename); // Move the uploaded file
                $data->image = $imagename; // Save the new image name to the category
            }

            // Save the post
            $data->save();


            return response()->json([
                'status' => true,
                'message' => 'Post Updated Successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }


    /*============================= Category Destroy Function =============================*/
    public function destroy($id)
    {
        $post = Post::find($id);

        if (empty($post)) {
            return redirect()->back()->with('error', 'Record Not Found');
        }

        if (!empty($post->image)) {
            $imagePath = public_path('uploads/post-image/' . $post->image);

            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        $post->delete();
        return redirect()->back()->with('success', 'Record Deleted');
    }
}
