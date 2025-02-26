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

        $validated = $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|min:6',
        ], $messages);

        $user = User::where('email', $request->email)->first();

        if (!$user) {

            return back()->withErrors([
                'error' => 'Email does not exit!',
            ]);
        }


        if (!Hash::check($request->password, $user->password)) {

            return back()->withErrors([
                'error' => 'Incorrect Password!',
            ]);
        }

        Auth::login($user);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
     
            return redirect()->intended('/users');
        }

    }
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login';

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
