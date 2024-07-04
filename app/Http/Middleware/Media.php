<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class Media
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if((Auth::user()->usertypes_id==5)||(Auth::user()->usertypes_id==7)||(Auth::user()->usertypes_id==3)){
            return $next($request);

        }else{
            return back()->withErrors("Sorry!. You are not authenticated");
        }
    }
}
