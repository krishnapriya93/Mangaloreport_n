<?php
// app/Http/Middleware/PreventConcurrentLogin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PreventConcurrentLogin
{
    public function handle($request, Closure $next)
    {        
        $session_id =  Auth::user()->session_id;
        if ($session_id != session()->getId()) {
            Auth::logout(); // Log out the user
            return redirect()->route('loginview')->with('error', 'Concurrent login is not allowed.');
        }
        return $next($request);
    }
}