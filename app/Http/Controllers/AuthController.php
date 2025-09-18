<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    
    // Existing login methods...

    public function logout(Request $request)
    {
        Auth::logout(); // Log out the user
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/login'); // Redirect to login page
    }


   public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('username', $credentials['username'])
               ->where('is_active', true)
               ->first();

    if ($user) {
        // Skip password check completely
        Auth::login($user);
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'username' => 'User not found or account is inactive.',
    ]);
}

}