<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List all users (both admin & staff)
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Show user detail by id
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Create new user (admin or staff)
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'company_id' => 'required|string|unique:users,company_id',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'role' => 'required|in:admin,staff'
        ]);

        $user = User::create([
            'username' => $request->username,
            'company_id' => $request->company_id,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'sometimes|string|max:255',
            'company_id' => 'sometimes|string|unique:users,company_id,' . $user->id,
            'password' => [
                'sometimes',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'role' => 'sometimes|in:admin,staff'
        ]);

        $user->update([
            'username' => $request->username ?? $user->username,
            'company_id' => $request->company_id ?? $user->company_id,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role ?? $user->role,
        ]);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}


