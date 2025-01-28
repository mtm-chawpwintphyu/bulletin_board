<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function login(Request $request)
    {
        $request->session()->forget('old');
        $messages = [
            'email.required' => 'Email cannot be blank',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password cannot be empty.',
            'password.min' => 'Password must be at least 6 characters.',
        ];



        // Validation rules
        $validated = $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|min:6',
        ], $messages);

        // Check if the user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {

            return back()->withErrors([
                'error' => 'Email does not exit!',
            ]);
        }

        // Check if the password is correct
        if (!Hash::check($request->password, $user->password)) {

            return back()->withErrors([
                'error' => 'Incorrect Password!',
            ]);
        }

        // If email and password are correct, attempt to log the user in
        Auth::login($user);


        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
            // Authentication passed, redirect to intended page
            return redirect()->intended('/home');
        }

    }


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
