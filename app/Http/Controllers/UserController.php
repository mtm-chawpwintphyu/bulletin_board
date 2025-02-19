<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $query = User::query();

        if ($request->has('name') && $request->get('name') != '') {
            $query->where('name', 'like', '%' . $request->get('name') . '%');
        }

        if ($request->has('email') && $request->get('email') != '') {
            $query->where('email', 'like', '%' . $request->get('email') . '%');
        }
        if ($request->has('from_date') && $request->has('to_date') && $request->get('from_date') != '' && $request->get('to_date') != '') {
            $query->whereBetween('created_at', [
                $request->get('from_date'),
                $request->get('to_date'),
            ]);
        }

        $users = $query->paginate(5);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function profile()
    {
        $user = auth()->user();

        return view('profile', compact('user'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $message = [
            'name.required' => 'Name cannot be blank.',
            'email.required' => 'Email cannot be blank.',
            'email.email' => 'Email format is invalid.',
        ];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'type' => 'required|in:0,1',
            'phone' => 'nullable|string',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif',
        ], $message);

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->type = $request->input('type');
        $user->phone = $request->input('phone');
        $user->dob = $request->input('dob');
        $user->address = $request->input('address');

        if ($request->hasFile('profile_picture')) {

            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile);
            }

            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile = $profilePicturePath;
        }

        $user->save();
        return redirect()->route('users.index', $user->id)->with('success', 'Profile updated successfully!');
    }

    public function confirm(Request $request)
    {
        $message = [
            'name.required' => 'Name cannot be blank.',
            'email.required' => 'Email cannot be blank.',
            'password.required' => 'Password cannot be blank.',
            'password_confirmation.required' => 'Password confirmation cannot be blank.',
            'profile_picture.required' => 'Profile picture cannot be blank.',
        ];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'type' => 'required|in:0,1',
            'profile_picture' => 'image|mimes:jpg,png,jpeg,gif',
        ], $message);

        $profile_picture_path = null;

        if ($request->hasFile('profile_picture')) {
            $profile_picture_path = $request->file('profile_picture')->store('profile_pictures', 'public');

            session(['profile_picture_path' => $profile_picture_path]);
        }

        return view('users.confirm', [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'dob' => $request->input('dob'),
            'address' => $request->input('address'),
            'type' => $request->input('type'),
            'profile_picture' => $profile_picture_path,
        ]);
    }

    public function store(Request $request)
    {
        $user = new User();
        $type = ($request->type === 'Admin') ? 0 : 1;

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->phone = $request->input('phone');
        $user->dob = $request->input('dob');
        $user->address = $request->input('address');
        $user->type = $type;
        $user->created_user_name = auth()->user()->name;
        $user->create_user_id = auth()->id();
        $user->updated_user_id = auth()->id();
        $user->profile = $request->input('profile_picture');

        $user->save();

        return redirect()->route('users.index')->with('success', 'User registered successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function showPasswordForm($id)
    {
        $user = User::findOrFail($id);
        return view('users.change-password', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $message = [
            'current_password.required' => 'Current Password cannot be blank.',
            'new_password.required' => 'New Password cannot be blank.',
            'confirm_password.required' => 'Confirm password cannot be blank.',
            'new_password.min' => 'New Password must be at least 6 characters.',
            'confirm_password.confirmed' => 'New Password and Confirm Password do not match.',
        ];

        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'min:6'],
            'confirm_password' => 'required',
        ], $message);


        $hashedPassword = $user->password;
        $enteredPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');
        $confirmPassword = bcrypt($request->input('confirm_password'));

        if (Hash::check($enteredPassword, $hashedPassword)) {

            if (Hash::check($newPassword, $confirmPassword)) {

                $user->password = Hash::make($request->input('new_password'));
                $user->save();

                return redirect()->route('users.index', $user->id)->with('success', 'Password updated successfully.');

            } else {
                return back()->withErrors(['new_password' => 'The  password is not matched.']);
            }

        } else {

            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    }




}
