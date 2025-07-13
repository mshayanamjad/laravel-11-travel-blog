<?php

namespace App\Http\Controllers\editor;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EditorSubCategoryController extends Controller
{
    /*============================= Category Create Function =============================*/
    public function create(Request $request)
    {

        $categories = Category::orderBy('name', 'ASC')->get();

        $data['categories'] = $categories;


        $subCategories = SubCategory::select('sub_categories.*', 'categories.name as categoryName')->latest('id')
        ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');

        if (!empty($request->get('keyword'))) {

            $subCategories = $subCategories->where('sub_categories.name', 'like', '%' . $request->get('keyword') . '%');
            $subCategories = $subCategories->orWhere('categories.name', 'like', '%' . $request->get('keyword') . '%');
        }
        $subCategories = $subCategories->paginate(10);

        return view('editor.sub-category.create', $data, compact('subCategories'));
    }


    /*============================= Category Store Function =============================*/
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required',
            'status' => 'required',
        ]);


        if ($validator->passes()) {

            $subCategory = new SubCategory();

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->category_id = $request->category;
            $subCategory->status = $request->status;

            $subCategory->save();

            session()->flash('success', 'Sub Category Added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Sub Category Added Successfully'
            ]);
        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }


    /*============================= Category Edit Function =============================*/
    public function edit($id)
    {
        $subCategory = SubCategory::find($id);

        if (empty($subCategory)) {
            return redirect()->route('editor-sub-categories.index')->with('error', 'Category Not Found');
        }

        $categories = Category::orderBy('name', 'ASC')->get();

        $data['categories'] = $categories;
        $data['subCategory'] = $subCategory;

        return view('editor.sub-category.edit', $data);
    }


    /*============================= Category Update Function =============================*/
    public function update($id, Request $request)
    {
        $subCategory = SubCategory::find($id);

        if (empty($subCategory)) {

            session()->flash('error', 'Category Not Found');

            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category Not Found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,' . $subCategory->id . ',id',
            'category' => 'required',
            'status' => 'required',
        ]);


        if ($validator->passes()) {

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->category_id = $request->category;
            $subCategory->status = $request->status;

            $subCategory->save();

            session()->flash('success', 'Sub Category Added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Sub Category Added Successfully'
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
        $subCategory = SubCategory::find($id);

        if (empty($subCategory)) {
            return redirect()->back()->with('error', 'Record Not Found');
        }

        $subCategory->delete();

        return redirect()->back()->with('success', 'Sub Category ' . '<strong>' . $subCategory->name . '</strong>' . ' Deleted');
    }
}
