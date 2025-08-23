<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Admin creates staff
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'company_id' => 'required|string|unique:users,company_id',
            'password' => [
                'required',
                'string',
                'min:8',             // at least 8 characters
                'regex:/[a-z]/',     // at least one lowercase
                'regex:/[A-Z]/',     // at least one uppercase
                'regex:/[0-9]/',     // at least one digit
                'regex:/[@$!%*?&]/', // at least one special char
            ],
            'role' => 'in:staff,admin'
        ]);

        $user = User::create([
            'username' => $request->username,
            'company_id' => $request->company_id,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'staff',
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'company_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('company_id', $request->company_id)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'company_id' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}

