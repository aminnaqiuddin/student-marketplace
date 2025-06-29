<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Gate;

class EnsureUserIsAdmin
{
    public function handle($request, Closure $next)
    {
        // Skip for login page
        if ($request->is('admin/login')) {
            return $next($request);
        }

        // Check if logged in AND is admin (role_id = 1)
        if (auth()->check() && auth()->user()->role_id === 1) {
            return $next($request);
        }

        // If not admin, redirect to home
        return redirect('/');
    }
}
