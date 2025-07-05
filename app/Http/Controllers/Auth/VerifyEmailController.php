<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        Log::info('Verification request started for user: ' . $request->user()->id);

        if ($request->user()->hasVerifiedEmail()) {
            Log::info('User ' . $request->user()->id . ' was already verified.');
            return redirect()->intended(config('fortify.home').'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            Log::info('markEmailAsVerified was successful for user: ' . $request->user()->id);
            event(new Verified($request->user()));
        } else {
            Log::error('markEmailAsVerified FAILED for user: ' . $request->user()->id);
        }

        Log::info('Verification request finished. Redirecting user: ' . $request->user()->id);
        return redirect()->intended(config('fortify.home').'?verified=1');
    }
}
