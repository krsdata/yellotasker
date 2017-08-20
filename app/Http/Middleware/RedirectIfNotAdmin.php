<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth; 
use Hash;
use App\User;
use App\Admin;
class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    protected $redirectTo = 'admin';
    protected $guard = 'admin';

    public function handle($request, Closure $next, $guard = 'admin')
    {   

      // dd(Auth::guard('admin')->attempt($credentials,true));
        if (!Auth::guard($guard)->check()) {

            return redirect('admin/login');
        }
        
        return $next($request);
    }
}