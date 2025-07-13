<?php

namespace App\Http\Controllers\editor;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class EditorCategoryController extends Controller
{

    /*============================= Category Create Function =============================*/
    public function create(Request $request)
    {
        $categories = Category::latest();

        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name', 'like', '%' . $request->get('keyword') . '%');
        }

        $categories = $categories->paginate(10);

        return view('editor.category.create', compact('categories'));
    }


    /*============================= Category Store Function =============================*/
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048' // Validate image input
        ]);

        if ($validator->passes()) {
            // Create a new category instance
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;

            // Save the category to the database
            $category->save();

            // Handle image upload
            if ($request->hasFile('image')) { // Check if an image was uploaded
                $image = $request->file('image'); // Use file method for file input

                // Generate a name for the image using only the category ID
                $imagename = $category->id . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/category-images'), $imagename); // Move the uploaded file to the public/images directory
                $category->image = $imagename; // Save the image name to the category
                $category->save(); // Save changes to include the image name
            }

            session()->flash('success', 'Category Added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category Added Successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    /*============================= Category Edit Function =============================*/
    public function edit($id)
    {
        $category = Category::find($id);
        if (empty($category)) {
            return redirect()->route('editor-categories.index')->with('error', 'Category Not Found');
        }

        return view('editor.category.edit', compact('category'));
    }


    /*============================= Category Update Function =============================*/
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $id, // Allow the same slug for the current category
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048' // Validate image input
        ]);

        if ($validator->passes()) {
            // Find the category to update
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image'); // Use file method for file input

                // Define the path to the current image
                $imagePath = public_path('uploads/category-images/' . $category->image);

                // Delete the old image if it exists using File facade
                if ($category->image && File::exists($imagePath)) {
                    File::delete($imagePath);
                }

                // Generate a name for the new image using only the category ID
                $imagename = $category->id . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/category-images'), $imagename); // Move the uploaded file
                $category->image = $imagename; // Save the new image name to the category
            }

            // Save the updated category to the database
            $category->save();

            session()->flash('success', 'Category Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category Updated Successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    /*============================= Category Destroy Function =============================*/
    public function destroy($id, Request $request)
    {
        $category = Category::find($id);

        if (empty($category)) {
            return redirect()->back()->with('error', 'Record Not Found');
        }

        // Ensure $category->image is not empty and is a file
        if (!empty($category->image)) {
            // Define the path to the image
            $imagePath = public_path('uploads/category-images/' . $category->image);

            // Check if the path is a file and exists, then delete it
            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath); // Delete the file from the directory
            }
        }

        // Delete the category from the database
        $category->delete();

        return redirect()->back()->with('success', 'Record Deleted Successfully');
    }
}
