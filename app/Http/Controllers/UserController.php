<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Controllers\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {

        return view('profile');
    }

    public function index()
    {
        // Fetch all users from the database
        $users = User::all();

        // Return the 'users.index' view with the users data
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }


}
