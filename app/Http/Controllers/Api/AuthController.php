<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * API Login - Returns Sanctum token
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)
                   ->where('is_active', true)
                   ->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'error' => 'Unauthorized'
            ], 401);
        }

        // Create token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->user_id,
                'full_name' => $user->full_name,
                'username' => $user->username,
                'role' => $user->role->role_name ?? null,
                'is_active' => $user->is_active,
            ],
            'token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }

    /**
     * API Logout - Revoke current token
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }

    /**
     * Get current authenticated user
     */
    public function me(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'user' => [
                'id' => $user->user_id,
                'full_name' => $user->full_name,
                'username' => $user->username,
                'role' => $user->role->role_name ?? null,
                'is_active' => $user->is_active,
            ]
        ], 200);
    }
}
