<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function showForgotPassword()
    {
        return view('account.forgot-password');
    }


    public function processForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.forgotPassword')->withInput()->withErrors($validator);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Send Email

        $user = User::where('email', $request->email)->first();

        $formData = [
            'token' => $token,
            'user' => $user,
            'mailSubject' => 'You have requested to Reset your Password'
        ];

        Mail::to($request->email)->send(new ResetPasswordEmail($formData));
        return redirect()->route('account.forgotPassword')->with('success', 'Reset Password Link has been sent to your email inbox');
    }

    public function resetPassword($token)
    {
        $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first();

        if ($tokenExist === null) {
            return redirect()->route('account.forgotPassword')->with('error', 'Invalid Token');
        }

        return view('account.reset-password', compact('token'));
    }

    public function processResetPassword(Request $request)
    {

        $token = $request->token;

        $tokenObj = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if ($tokenObj === null) {
            return redirect()->route('account.forgotPassword')->with('error', 'Invalid Token');
        }

        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user = User::where('email', $tokenObj->email)->first();

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        if ($user->role === 'admin') {
            return redirect()->route('admin.login')->with('success', 'Password Reset Successfully');
        } elseif ($user->role === 'editor') {
            return redirect()->route('editor.login')->with('success', 'Password Reset Successfully');
        } else {
            return redirect()->route('front.login')->with('success', 'Password Reset Successfully');
        }

        return redirect()->route('account.forgotPassword')->with('success', 'Password Reset Successfully');
    }
}
