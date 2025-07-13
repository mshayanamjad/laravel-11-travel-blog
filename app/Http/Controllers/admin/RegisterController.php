<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function create()
    {
        return view('admin.user.register');
    }

    public function processRegister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'gender' => 'required|in:male,female',
            'role' => 'required|in:admin,editor',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'password' => 'required',
        ]);


        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();

            // Handle image upload
            if ($request->hasFile('image')) { // Check if an image was uploaded
                $image = $request->file('image'); // Use file method for file input

                // Generate a name for the image using only the category ID
                $imagename = $user->id . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/profile-pic'), $imagename); // Move the uploaded file to the public/images directory
                $user->image = $imagename; // Save the image name to the category
                $user->save(); // Save changes to include the image name
            }


            session()->flash('success', 'User Registered Successfully');

            return response()->json([
                'status' => true,
                'message' => 'User Registered Successfully'
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
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required|in:male,female',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);


        if ($validator->passes()) {

            $user = User::find($id);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->role = $request->role;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image'); // Use file method for file input

                // Define the path to the current image
                $imagePath = public_path('uploads/profile-pic/' . $user->image);

                // Delete the old image if it exists using File facade
                if ($user->image && File::exists($imagePath)) {
                    File::delete($imagePath);
                }

                // Generate a name for the new image using only the category ID
                $imagename = $user->id . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/profile-pic'), $imagename); // Move the uploaded file
                $user->image = $imagename; // Save the new image name to the category
            }

            $user->save();

            session()->flash('success', 'User Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'User Updated Successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    /*============================= Category Destroy Function =============================*/
    public function destroy($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect()->back()->with('error', 'Record Not Found');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User Deleted');
    }
}
