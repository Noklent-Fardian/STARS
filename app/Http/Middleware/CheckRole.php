<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get authenticated user
        $user = Auth::user();

        // Check if user role is in allowed roles
        if (in_array($user->user_role, $roles)) {
            return $next($request);
        }

        // Redirect based on role if unauthorized
        if ($user->user_role === 'Admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->user_role === 'Dosen') {
            return redirect()->route('dosen.dashboard');
        } elseif ($user->user_role === 'Mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        }

        // Fallback to login
        Auth::logout();
        return redirect()->route('login')->with('error', 'You do not have permission to access this page.');
    }
}