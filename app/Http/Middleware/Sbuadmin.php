<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class Sbuadmin
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
        // return $next($request);
// dd(Auth::user()->role_id);
        if(Auth()->check()){
               if(Auth::user()->role_id==5)
                {
                     return $next($request); 
                 }
                }else
                {
                    return redirect()->route('home');
              }  
            }
    }

