<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class Cmdadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd(Auth::user()->role_id);
        // return $next($request);
        if(Auth()->check()){
            if(Auth::user()->role_id==11)
             {
                // dd(true);
                  return $next($request); 
              }
             }else
             {
                 return redirect()->route('home');
           }  
    }
}
