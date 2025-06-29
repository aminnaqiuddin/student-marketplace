<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'checkout/success/*', // Allow Stripe to redirect here
        'stripe/webhook'
    ];

    public function handle($request, Closure $next)
    {
        if (str_starts_with($request->path(), 'admin')) {
            config(['session.cookie' => 'filament_admin_session']);
        }
        return parent::handle($request, $next);
    }
}
