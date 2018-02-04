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
        if (!Auth::guard('admin')->user()) {
          return $next($request);
        }
        
        $validAccess =false;
        $user = Auth::guard($guard)->user();
        $role_type = isset($user->role_type) && $user->role_type?$user->role_type:'Guest';
        $role = \App\Role::find($role_type);
        $controllerAction = class_basename(Route::getCurrentRoute()->getActionName());
        list($controller, $action) = explode('@', $controllerAction);
        $routeName = Route::currentRouteName();
      
        $controller = str_replace('Controller', '', $controller);
                
        $permission =$role?(array)json_decode($role->permission):array();
     
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
        }else{
         $validAccess =TRUE;   
        }
       
        if($validAccess){
         return $next($request);
        }else{
         $page_title = '403';
         $heading  = 'Permission Denied.';
         $sub_page_title = '403';
         $page_action = '403'; 
         $route_url = Route::getCurrentRoute()->getPath(); 
         return view('packages::errors.403', compact('route_url','heading','page_title', 'page_action','sub_page_title'));
        }
        
        
    }
}
