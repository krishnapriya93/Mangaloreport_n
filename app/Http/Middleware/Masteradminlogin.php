<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Masteradminlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth()->check()){
            if(Auth::user()->role_id==3)
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
