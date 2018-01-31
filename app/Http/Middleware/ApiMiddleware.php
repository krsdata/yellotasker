<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Helper;
use Auth;
 
class ApiMiddleware
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
        
       // dd( Auth::guard('api')->user());
         
        //dd(str_random());
        return $next($request);
    }
}
