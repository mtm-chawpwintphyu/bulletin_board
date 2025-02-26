<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
       
        $request->validate(['email' => 'required|email']);
        Log::info('Password reset request received', ['email' => $request->email]);
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            Log::error('No user found with email', ['email' => $request->email]);
            return back()->withErrors(['email' => 'No user found with this email address.']);
        }
    
      
        $token = app('auth.password.broker')->createToken($user);
        $resetUrl = url('/password/reset/' . $token . '?email=' . urlencode($request->email));

        try {
          
            Mail::to($user->email)->send(new PasswordResetMail($resetUrl, $user->name, $user->email));
            Log::info('Password reset email sent', ['email' => $user->email]);
    
            return back()->with('status', 'Password reset link has been sent to your email address.');
        } catch (\Exception $e) {
            Log::error('Error sending password reset email', ['error' => $e->getMessage()]);
            return back()->withErrors(['email' => 'There was an issue sending the email. Please try again later.']);
        }
    }
    
}
