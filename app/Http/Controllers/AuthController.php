<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'role' => 'nullable|string|in:b2c,b2b' // Default to b2c if empty
        ]);

        $role = $fields['role'] ?? 'b2c';
        // B2B requires approval, B2C is auto-approved
        $isApproved = $role === 'b2b' ? false : true;

        $user = \App\Models\User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'role' => $role,
            'is_approved' => $isApproved
        ]);

        // If not approved, return message without token
        if (!$isApproved) {
            return response()->json([
                'message' => 'Account created successfully. Your dealer account is pending admin approval.',
                'user' => $user,
                'role' => $role
            ], 201);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'role' => $user->role
        ], 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'role' => 'nullable|string|in:admin,b2c,b2b' // Optional check if user selected role
        ]);

        // Check email
        $user = \App\Models\User::where('email', $fields['email'])->first();

        // Check password
        if (!$user || !\Illuminate\Support\Facades\Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'Bad credentials'
            ], 401);
        }

        // Check Role if provided
        if (isset($fields['role']) && $user->role !== $fields['role']) {
             return response()->json([
                'message' => 'Invalid role selected for this user.'
            ], 403);
        }

        // Check Approval
        if (!$user->is_approved) {
            return response()->json([
                'message' => 'Account pending approval. Please contact support.'
            ], 403);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'role' => $user->role
        ], 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
