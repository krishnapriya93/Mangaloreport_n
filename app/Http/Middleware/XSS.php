<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Crypt;

class XSS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userInput = $request->all();
//   dd(Crypt::decrypt($request->hidden_id));
        array_walk_recursive($userInput, function (&$userInput,$key) {
           
            // if(($key!="_token")){
                // if($key!="hidden_id"){
                    // echo "<pre>".$key.' : his :'.$userInput;
                    // $userInput = strip_tags($userInput, '<a><strong><em><hr><br><p><u><ul><ol><li><dl><dt><dd><table><thead><tr><th><tbody><td><tfoot><b><h1><h2><h3><h4><h5><h6><img>');
                    $userInput = strip_tags($userInput, '<a><strong><em><hr><br><p><u><ul><ol><li><dl><dt><dd><table><thead><tr><th><tbody><td><tfoot><b><h1><h2><h3><h4><h5><h6>');

                    // $userInput= Crypt::decrypt($userInput);
                // }
                // else{
                    // $userInput.= $userInput;

                // }
            
            // }
            // else{
            //     if($key!="hidden_id"){
            //         $userInput= $userInput;
            //     }
            // }
       
           
        });
//   dd(true);
        $request->merge($userInput);
        return $next($request);
    }
}
