<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Auth;

class CheckConcurrentLogin
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->is_logged_in) {
            Auth::logout(); // Logout the user if already logged in elsewhere
            return redirect()->route('loginview')->with('error', 'Concurrent login is not allowed.');
        }

        return $next($request);
    }
}