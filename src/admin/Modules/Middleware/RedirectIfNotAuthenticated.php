<?php
namespace Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth; 
use Hash;
use Session;
use Request;

class RedirectIfNotAuthenticated
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
        return $next($request);
    }
}
