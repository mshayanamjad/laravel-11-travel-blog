<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FavPost;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(
                ['email' => $request->email, 'password' => $request->password],
                $request->get('remember')
            )) {

                $user = Auth::user();

                // If the user is an admin or editor, deny access and redirect them to the login page
                if ($user->role == 'admin' || $user->role == 'editor') {
                    Auth::logout(); // Log out the user immediately
                    return redirect()->route('front.login')
                        ->with('error', 'Admins and editors cannot log in as a regular user.');
                }

                if (session()->has('url.intended')) {
                    return redirect(session()->get('url.intended'));
                }

                return redirect()->route('front.home');
            }

            return redirect()->route('front.login')->with('error', 'Invalid Credentials');
        }

        return redirect()->route('front.login')
            ->withInput()->withErrors($validator);
    }

    public function register()
    {
        return view('front.account.register');
    }

    public function userRegisteration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'gender' => 'required|in:male,female',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'password' => 'required|min:5',
        ]);


        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->password = Hash::make($request->password);
            $user->role = 'user';
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

    public function profile()
    {
        $users = Auth::user();

        return view('front.account.profile', compact('users'));
    }

    public function updateProfile(Request $request, $id)
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


            session()->flash('success', 'Profile Updated');

            return response()->json([
                'status' => true,
                'message' => 'Profile Updated'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('success', 'Your Logged out');
        return redirect()->route('front.login');
    }


    public function ChangeUserPassword()
    {
        return view('front.account.change-password');
    }

    public function changePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);


        if ($validator->passes()) {
            $user = User::Select('id', 'password')->where('id', Auth::user()->id)->first();

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

    public function favPost()
    {
        $favPosts = FavPost::where('user_id', Auth::user()->id)->with('post')->get();

        $favPostCount = $favPosts->count();

        $data = [
            'favPosts' => $favPosts,
            'favPostCount' => $favPostCount, // Pass the count of favorite posts
        ];




        return view('front.account.favourite', $data);
    }

    public function removeFavPosts(Request $request)
    {
        $favPost = FavPost::where('user_id', Auth::user()->id)->where('post_id', $request->id)->first();

        if ($favPost == null) {
            session()->flash('error', 'Post not found in your favourite list');
            return response()->json([
                'status' => false,
            ]);
        } else {
            FavPost::where('user_id', Auth::user()->id)->where('post_id', $request->id)->delete();
            session()->flash('success', 'Post removed from your favourite list');
            return response()->json([
                'status' => true,
            ]);
        }
    }


    public function deleteUser()
    {
        return view('front.account.delete-account');
    }

    public function showDeleteForm()
    {

        return view('front.account.confirm-acc-deletion');
    }

    public function processDeleteAcc(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'given_password' => 'required',
        ]);
    
        if (!$user) {
            return redirect()->route('front.deleteUser')->with('error', 'User not found.');
        }
    
        if (auth()->check() && !Hash::check($request->given_password, auth()->user()->password)) {
            return redirect()->route('front.showDeleteForm')->with('error', $validator->errors()->first());
        }

        if ($validator->passes()) {

            
        // Delete user image
    
        if (!empty($user->image)) {
            $imagePath = public_path('uploads/profile-pic/' . $user->image);
            
            if (!file_exists($imagePath)) {
                dd('Image not found at path: ' . $imagePath);
            }
    
            if (is_file($imagePath)) {
                $deleted = unlink($imagePath); 
                if (!$deleted) {
                    dd('Failed to delete image at path: ' . $imagePath);
                }
            } else {
                dd('Path is not a file: ' . $imagePath);
            }
        }
    
        $user->delete();
        // DB::table('account_deletion_tokens')->where('token', $token)->delete();
    
        if (auth()->check()) {
            Auth::logout();
        }
    
        return redirect()->route('front.login')->with('success', 'Your account has been deleted.');

        }
    }
    

    public function userComment()
    {
        $comments = Comment::where('user_id', Auth::user()->id)->with('post')->get();

        $data = [];

        $data['comments'] = $comments;

        return view('front.account.comment-list', $data);
    }
}
