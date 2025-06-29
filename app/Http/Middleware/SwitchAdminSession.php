<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;

class SwitchAdminSession
{
    public function handle($request, Closure $next)
    {
        if (str_starts_with($request->path(), 'admin')) {
            Config::set([
                'session.cookie' => 'filament_admin_session',
                'session.path' => '/admin',
                'auth.defaults.guard' => 'admin',
                'session.lifetime' => 1440, // 24 hours
                'session.expire_on_close' => false,
                'session.secure' => env('SESSION_SECURE_COOKIE', false),
                'session.http_only' => true,
                'session.same_site' => 'lax',
            ]);

            // Force new session if coming from non-admin area
            if (session()->isStarted() && !str_starts_with(session()->previousUrl(), url('/admin'))) {
                session()->regenerate(true);
            }
        }
        return $next($request);
    }
}
