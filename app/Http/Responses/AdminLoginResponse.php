<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class AdminLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Use the 'admin' guard for the session
        Auth::guard('admin')->login(Auth::user());

        return redirect()->intended(filament()->getUrl());
    }
}

