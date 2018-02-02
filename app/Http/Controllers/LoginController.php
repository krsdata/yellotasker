<?php

namespace App\Http\Controllers;

use Auth, Input;
use App\User;
use App\Admin;

class LoginController extends Controller
{
    public function userLogin(){
        $input = Input::all();
        if(count($input) > 0){
            $auth = auth()->guard('user');

            $credentials = [
                'email' =>  $input['email'],
                'password' =>  $input['password'],
            ];

            if ($auth->attempt($credentials)) {
                return redirect()->action('LoginController@profile');
            } else {
                echo 'Error';
            }
        } else {
            return view('user.login');
        }
    }

    public function adminLogin(){
        $input = Input::all();
        if(count($input) > 0){
            $auth = auth()->guard('admin');

            $credentials = [
                'email' =>  $input['email'],
                'password' =>  $input['password'],
            ];

            if ($auth->attempt($credentials)) {
                 return redirect()->action('LoginController@profile');                     
            } else {
                echo 'Error';
            }
        } else {
            return view('admin.login');
        }
    }

    public function profile(){
        if(auth()->guard('admin')->check()){
             pr(auth()->guard('admin')->user()->toArray());
        }         
        if(auth()->guard('user')->check()){
            pr(auth()->guard('user')->user()->toArray());
        } 
    }
}