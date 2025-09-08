<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $admins = User::where('role', User::ROLE_ADMIN)->orderBy('name')->paginate(15);
        return view('admin.users.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_ADMIN,
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Admin created');
    }

    public function block(User $user)
    {
        $user->blocked_at = now();
        $user->save();
        return back()->with('status', 'User blocked');
    }

    public function unblock(User $user)
    {
        $user->blocked_at = null;
        $user->save();
        return back()->with('status', 'User unblocked');
    }
}
