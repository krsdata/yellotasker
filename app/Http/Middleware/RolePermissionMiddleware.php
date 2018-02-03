<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth; 
use Hash;
use App\User;
use App\Admin;
use Route;
use URL;

class RolePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = 'web')
    {   

      // dd(Auth::guard('admin')->attempt($credentials,true));
        if (!Auth::guard($guard)->check()) {

            return redirect('admin/login');
        }
        
        $validAccess =false;
        $user = Auth::guard($guard)->user();
        $role = \App\Role::find(Auth::guard($guard)->user()->role_type);
        $controllerAction = class_basename(Route::getCurrentRoute()->getActionName());
        list($controller, $action) = explode('@', $controllerAction);
        $routeName = Route::currentRouteName();
      
        $controller = str_replace('Controller', '', $controller);
                
        $permission = (array)json_decode($role->permission);
     
        $isControllerExist= key_exists($controller,$permission);
        if($controller && $isControllerExist){
            $accessMode= $permission[$controller];
            $userCanRead= isset($accessMode->read)?true:false;
            $userCanWrite= isset($accessMode->write)?true:false;
            $userCanDelete= isset($accessMode->delete)?true:false;
        switch ($request->method()){
            case 'POST': $validAccess =$userCanWrite;
                break;
            case 'PUT':
                 $validAccess =$userCanWrite;
                break;
            case 'PATCH':
                $validAccess =$userCanWrite;
                break;
            case 'DELETE':
                 $validAccess =$userCanDelete;
                break;
            case 'GET': 
                $validAccess =$userCanRead;
                break;
            default :
                break;
            
        }
        }else if(in_array($controller,array('Admin','Role'))){
         $validAccess=$request->method()=='GET'?true:false;
        }
       
        if($validAccess){
         return $next($request);
        }else{
         return redirect('admin')->withErrors(['message'=>'Invalid email or password. Try again!']);; 
        }
        
        
    }
}
