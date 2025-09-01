<?php

// path: app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak sesuai, arahkan ke halaman yang sesuai
        // Contoh: jika tenan mencoba akses halaman admin, arahkan ke dashboard tenan
        if ($user->role === 'tenant') {
            return redirect('/tenant/dashboard');
        } elseif ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        // Default fallback
        return redirect('/dashboard');
    }
}