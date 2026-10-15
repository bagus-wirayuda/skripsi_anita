<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                return $this->redirectToRole($user->role);
            }
        }

        return $next($request);
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
