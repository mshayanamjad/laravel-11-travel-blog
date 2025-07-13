<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function submitForm(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->passes()) {
            
            // Prepare form data to send via email
            $data = $request->all();

            // Send the email (using a mailable class)
            Mail::to('mianshayan197@gmail.com')->send(new ContactMail($data));

            session()->flash('success', 'Thank you for your message!');
            return response()->json([
                'status' => true,
                'message' => 'Thank you for your message!'
            ]);

        }
    }

    public function subscribe(Request $request) {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscriptions,email',
        ]);

        if ($validator->passes()) {
            $subscribe = new Subscription();
            $subscribe->email = $request->email;
            $subscribe->save();
            return redirect()->route('front.home')->with('success', 'Subscribe successful!');
        }

        return redirect()->route('front.home')->withInput()->withErrors($validator);
    }

    public function unsubscribe($email) {

        $subscriber = Subscription::where('email', $email)->first();

        if ($subscriber) {
            // Toggle the subscription status (unsubscribe if they are subscribed, and resubscribe if they are not)
            $subscriber->delete();

            return redirect()->route('front.home')->with('success', 'You have successfully unsubscribed from notifications.');

        }


        return redirect()->route('front.home')->with('error', 'You were not subscribed or this email is invalid.');
    }



}
