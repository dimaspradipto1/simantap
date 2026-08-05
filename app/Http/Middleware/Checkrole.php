<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }

        // Check if user role matches allowed roles
        if (!empty($roles)) {
            if (in_array($user->role, $roles)) {
                return $next($request);
            }
        } else {
            // Default check for all authenticated active roles
            if (in_array($user->role, ['admin', 'petugas', 'user'])) {
                return $next($request);
            }
        }

        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}
