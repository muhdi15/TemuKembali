<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Format penggunaan di route:
     * middleware('role:admin') -> hanya admin
     * middleware('role:user') -> hanya user
     * middleware('role:guest') -> hanya tamu (belum login)
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Jika user belum login
        if (!Auth::check()) {
            // Jika route ini hanya boleh diakses oleh guest
            if ($role === 'guest') {
                return $next($request);
            }
            // Kalau tidak, arahkan ke halaman login
            return redirect()->route('login.form');
        }

        // Jika user sudah login dan role route adalah 'guest' (login/register)
        if ($role === 'guest') {
            // Redirect sesuai role user
            $user = Auth::user();
            return $user->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.dashboard');
        }

        // Jika role route cocok
        if ($role === Auth::user()->role) {
            return $next($request);
        }

        // Jika role tidak cocok, arahkan ke dashboard sesuai role user
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
}
