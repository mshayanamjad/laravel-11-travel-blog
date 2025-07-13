<?php

namespace App\Http\Controllers\admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function create(Request $request)
    {
        $tags = Tag::latest();

        if (!empty($request->get('keyword'))) {
            $tags = $tags->where('name', 'like', '%' . $request->get('keyword') . '%');
        }

        $tags = $tags->paginate(10);

        return view('admin.tag.create', compact('tags'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:tags'
        ]);

        if ($validator->passes()) {

            $tag = new Tag();

            $tag->name = $request->name;
            $tag->slug = $request->slug;
            $tag->status = $request->status;
            $tag->save();

            session()->flash('success', 'Tag Added Successfuly');

            return response()->json([
                'status' => true,
                'message' => 'Tag Added Successfuly'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function edit($id)
    {
        $tag = Tag::find($id);
        if (empty($tag)) {
            return redirect()->route('tags.create')->with('error', 'Record Not Found');
        }

        return view('admin.tag.edit', compact('tag'));
    }

    public function update($id, Request $request)
    {

        $tag = Tag::find($id);


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:tags,slug,' . $id
        ]);

        if ($validator->passes()) {


            $tag->name = $request->name;
            $tag->slug = $request->slug;
            $tag->status = $request->status;
            $tag->save();

            session()->flash('success', 'Tag Uodated Successfuly');

            return response()->json([
                'status' => true,
                'message' => 'Tag Uodated Successfuly'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);

        if (empty($tag)) {
            return redirect()->route('tags.create')->with('error', 'Record Not Found');
        }

        $tag->delete();

        return redirect()->back()->with('success', 'Record Deleted');
    }
}
