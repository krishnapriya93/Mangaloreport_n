<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Mediaadminlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth()->check()){
            if(Auth::user()->role_id==4)
             {
                  return $next($request); 
              }
             }else
             {
                 dd(Auth::user()->role_id);
               return response()->json('Login Authentication failed');
           }  
    }
}
