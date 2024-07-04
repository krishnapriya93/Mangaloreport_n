<?php namespace App\Http\Middleware;

use Closure;

class CORS {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // header("Access-Control-Allow-Origin: *");

        // ALLOW OPTIONS METHOD
    //     $response = $next($request);
    // $response->headers->set('Access-Control-Allow-Origin', '*');
    // $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
    // $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-XSRF-TOKEN');
    // return $response;
        $headers = [
            // 'Access-Control-Allow-Origin' => '*',
            // 'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            // 'Access-Control-Allow-Headers'=> 'Content-Type, Accept, Authorization, X-Requested-With, Application',
        
            // 'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
        ];
        if($request->getMethod() == "OPTIONS") {
            // The client-side application can set only headers allowed in Access-Control-Allow-Headers
            return \Response::stream($callback, 200, $headers);
        }

        $response = $next($request);
        foreach($headers as $key => $value)
        // dd($key.$value);
        $response->headers->set($key, $value);
            // $response->header($key, $value);
        return $response;
    }

}