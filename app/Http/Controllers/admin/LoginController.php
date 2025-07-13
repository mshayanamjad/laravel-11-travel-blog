<?php

namespace App\Http\Controllers\admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.admin-authentication.login');
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

            if (Auth::guard('admin')->attempt($AuthAttempt, $remember)) {

                if (Auth::guard('admin')->user()->role != 'admin') {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page');
                }

                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin.login')->with('error', 'Either Email/Password is incorrect');
            }
        } else {
            return redirect()->route('admin.login')
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

        // Pass metrics to the dashboard view
        return view('admin.admin-authentication.dashboard', $dashboardMetrics);
    }



    public function logout()
    {
        Auth::guard('admin')->logout();;
        return redirect()->route('admin.login')->with('success', 'You are Logged out');
    }


    /*============================= Getting User Information =============================*/

    public function show(Request $request)
    {
        $query = User::orderBy('id', 'ASC');

        if (!empty($request->get('keyword'))) {
            $query->where('name', 'like', '%' . $request->get('keyword') . '%');
        }

        $users = $query->paginate(10);

        return view('admin.user.list', compact('users'));
    }


    public function showChangePassword()
    {
        return view('admin.account.change_password');
    }

    public function changePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);


        if ($validator->passes()) {
            $user = User::Select('id', 'password')->where('id', Auth::guard('admin')->user()->id)->first();

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
