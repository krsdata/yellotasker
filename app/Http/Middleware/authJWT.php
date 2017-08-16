<?php

namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Exception;
use Input;
use Request;
use Auth; 

class authJWT
{
    public function handle($request, Closure $next)
    {    
        try {
           
            $user = JWTAuth::toUser($request->input('token'));
        } catch (Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                //return response()->json(['error'=>'Token is Invalid']);
                return response()->json([ "status"=>0,"message"=>"Token is Invalid!" ,'data' => '' ]);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json([ "status"=>0,"message"=>"Token is Expired!" ,'data' => '' ]);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException){
                return response()->json([ "status"=>0,"message"=>"Token is Expired!" ,'data' => '' ]);
            }else{
                return response()->json([ "status"=>0,"message"=>"Token required!" ,'data' => '' ]);
            }
        }
        return $next($request);
    }
}


//TokenInvalidException 