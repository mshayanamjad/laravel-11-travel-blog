<?php

namespace App\Http\Controllers\editor;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class EditorController extends Controller
{
    public function index()
    {
        return view('editor.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $AuthAttempt = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
        // Get the "remember me" checkbox value
        $remember = $request->has('remember');

        if ($validator->passes()) {

            if (Auth::guard('editor')->attempt($AuthAttempt, $remember)) {

                if (Auth::guard('editor')->user()->role != 'editor') {

                    Auth::guard('editor')->logout();
                    return redirect()->route('editor.login')->with('error', 'You are not authorized to access this page');
                }

                return redirect()->route('editor.dashboard');
            } else {
                return redirect()->route('editor.login')->with('error', 'Either Email/Password is incorrect');
            }
        } else {
            return redirect()->route('editor.login')
                ->withInput()->withErrors($validator);
        }
    }

    public function dashboard()
    {
        // Collect relevant metrics
        $dashboardMetrics = [
            'total_views' => Post::sum('views'),
            'total_comments' => Comment::count(),
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'total_categories' => Category::count(),
            'total_subscribers' => Subscription::count(),
        ];
        return view('editor.dashboard', $dashboardMetrics);
    }

    public function logout()
    {
        Auth::guard('editor')->logout();;
        return redirect()->route('editor.login')->with('success', 'Your Logged out');
    }


    public function edit($id)
    {
        $user = User::find($id);
        return view('editor.account.edit', compact('user'));
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



    public function showChangePassword()
    {
        return view('editor.account.change_password');
    }

    public function changePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);


        if ($validator->passes()) {
            $user = User::Select('id', 'password')->where('id', Auth::guard('editor')->user()->id)->first();

            if (!Hash::check($request->old_password, $user->password)) {

                session()->flash('error', 'Old Password is incorrect');
                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id', $user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            session()->flash('success', 'Password Changed Successfully');
            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
