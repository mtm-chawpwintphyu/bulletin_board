<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users with optional filtering.
     *
     * This method retrieves a list of users from the database. It applies filters based on the parameters
     * received in the request, such as `name`, `email`, and a date range (`from_date` and `to_date`). 
     * If no filters are applied, it will return all users. The results are paginated with 5 users per page.
     *
     * @param \Illuminate\Http\Request $request The request object containing filter parameters such as `name`, `email`, and date range (`from_date`, `to_date`).
     *
     * @return \Illuminate\View\View The view for displaying the users, passing the paginated list of users to it.
     */
    public function index(Request $request)
    {
        $users = User::all();
        $query = User::query();

        if ($request->has('name') && $request->get('name') !== '') {
            $query->where('name', 'like', '%' . $request->get('name') . '%');
        }
        if ($request->has('email') && $request->get('email') !== '') {
            $query->where('email', 'like', '%' . $request->get('email') . '%');
        }
        if ($request->has('from_date') && $request->has('to_date') && $request->get('from_date') !== '' && $request->get('to_date') !== '') {
            $query->whereBetween('created_at', [
                $request->get('from_date'),
                $request->get('to_date'),
            ]);
        }
        $users = $query->paginate(5);
        return view('users.index', compact('users'));
    }
    /**
     * Show the form for creating a new user.
     *
     * This method returns the view for creating a new user. The view typically contains a form
     * where the user can input their details to register a new user.
     *
     * @return \Illuminate\View\View The view to display the user creation form.
     */
    public function create()
    {
        return view('users.create');
    }
    /**
     * Display the authenticated user's profile.
     *
     * This method retrieves the currently authenticated user using `auth()->user()` and passes it to
     * the `profile` view, allowing the user to view and possibly edit their profile.
     *
     * @return \Illuminate\View\View The view to display the authenticated user's profile.
     */
    public function profile()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }
    /**
     * Show the form for editing the specified user.
     *
     * This method retrieves the user by their ID and passes the user data to the `users.edit` view
     * to allow the user to edit their details. If the user is not found, a `ModelNotFoundException` 
     * will be thrown by the `findOrFail` method.
     *
     * @param int $id The ID of the user to be edited.
     *
     * @return \Illuminate\View\View The view to display the user edit form, passing the user data to it.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user with the specified ID is not found.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    /**
     * Update the specified user in the database.
     *
     * This method validates the request input, checks for changes in the user's details, and then
     * updates the user's record in the database. If a new profile picture is uploaded, it will
     * be stored, and the old one (if any) will be deleted. After the update, the user is redirected 
     * back to the user index page with a success message.
     *
     * @param \Illuminate\Http\Request $request The request object containing the updated user data.
     * @param int $id The ID of the user to be updated.
     *
     * @return \Illuminate\Http\RedirectResponse A redirect to the user index page with a success message.
     *
     * @throws \Illuminate\Validation\ValidationException If the validation of the request data fails.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user with the specified ID is not found.
     */
    public function update(Request $request, $id)
    {
        $message = [
            'name.required' => 'Name cannot be blank.',
            'email.required' => 'Email cannot be blank.',
            'email.email' => 'Email format is invalid.',
        ];

        $request->validate([
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
    /**
     * Handle the user registration or profile update confirmation.
     *
     * This method validates the incoming request data, processes the uploaded profile picture (if any), 
     * and returns a confirmation view with the user's details.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing form data.
     * 
     * @return \Illuminate\View\View The view to confirm the user's details.
     */
    public function confirm(Request $request)
    {
        $message = [
            'name.required' => 'Name cannot be blank.',
            'email.required' => 'Email cannot be blank.',
            'password.required' => 'Password cannot be blank.',
            'password_confirmation.required' => 'Password confirmation cannot be blank.',
            'profile_picture.required' => 'Profile picture cannot be blank.',
        ];
        $request->validate([
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
    /**
     * Store a newly created user in the database.
     *
     * This method validates and stores a new user's data in the database, 
     * including their name, email, password, phone, dob, address, and type.
     * The password is hashed using bcrypt, and the type is determined 
     * based on the user role (Admin or user). The method also sets 
     * creator and updater IDs based on the currently authenticated user.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing the form data.
     * 
     * @return \Illuminate\Http\RedirectResponse A redirect to the user index page with a success message.
     */
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
    /**
     * Delete a user from the database.
     *
     * This method attempts to find the user by ID. If found, it deletes the user from the database.
     * If the user does not exist, a ModelNotFoundException will be thrown.
     * After deletion, the user is redirected to the user index page with a success message.
     *
     * @param int $id The ID of the user to be deleted.
     * 
     * @return \Illuminate\Http\RedirectResponse A redirect to the user index page with a success message.
     */
    public function destroy($id)
    {

        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
    /**
     * Show the form to change a user's password.
     *
     * This method finds the user by ID and returns a view to change the user's password.
     * The view includes the user's information for editing purposes.
     *
     * @param int $id The ID of the user whose password needs to be changed.
     * 
     * @return \Illuminate\View\View A view to allow the user to change their password.
     */
    public function showPasswordForm($id)
    {
        $user = User::findOrFail($id);
        return view('users.change-password', compact('user'));
    }
    /**
     * Update the password for the given user.
     *
     * This method validates the current password, new password, and confirm password fields. 
     * If the current password is correct, and the new password and confirm password match, 
     * the password is updated. If any validation fails, an appropriate error message is returned.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing the password data.
     * @param int $id The ID of the user whose password needs to be updated.
     *
     * @return \Illuminate\Http\RedirectResponse A redirect to the user index page with a success message or error messages.
     */
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
                return back()->withErrors(['new_password' => 'The password is not matched.']);
            }

        } else {

            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    }
}
