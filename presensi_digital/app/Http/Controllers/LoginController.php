<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate request
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Try to find user by email (username field in form)
        $user = User::where('email', $credentials['username'])->first();

        // Check if user exists and password matches (PLAIN TEXT - DEVELOPMENT ONLY)
        if (!$user || $credentials['password'] !== $user->password) {
            return redirect()->route('login')->withErrors([
                'username' => 'Email atau password salah.',
            ])->withInput($request->only('username'));
        }

        // Login the user
        Auth::login($user, $request->filled('remember'));

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        // Redirect based on role
        return $this->redirectToRole($user->role);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }

    /**
     * Redirect user based on their role
     */
    private function redirectToRole(string $role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'kepsek':
                return redirect()->route('kepalasekolah.dashboard');
            case 'guru':
                return redirect()->route('guru.dashboard');
            case 'ortu':
                return redirect()->route('orangtua.dashboard');
            default:
                return redirect()->route('index');
        }
    }
}

