<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,role_id',
            'is_active' => 'required|boolean',
        ]);

        User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'password_hash' => Hash::make($request->password_hash),
            'role_id' => $request->role_id,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $user->user_id . ',user_id',
            'password_hash' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,role_id',
            'is_active' => 'required|boolean',
        ]);

        $user->update([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'password' => $request->password_hash ? Hash::make($request->password_hash) : $user->password_hash,
            'role_id' => $request->role_id,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
