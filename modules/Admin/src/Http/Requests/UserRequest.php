<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class UserRequest extends Request {

    /**
     * The metric validation rules.
     *
     * @return array
     */
    public function rules() {
        //if ( $metrics = $this->metrics ) {
            switch ( $this->method() ) {
                case 'GET':
                case 'DELETE': {
                        return [ ];
                    }
                case 'POST': {
                        return [
                            
                            'first_name'      => 'required|min:3', 
                            'last_name'      => 'required|min:2',
                            'email'     => "required|email|unique:users,email" ,   
                            'password'  => 'required|min:6', 
                            'role_type' => 'required',
                             'phone' => 'required'
                             //size:10
                            //'role'  => 'required'
                            /*'confirm_password' => 'required|same:password'*/ 
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $user = $this->user ) {

                        return [
                            'first_name' => 'required|min:3', 
                            'last_name'  => 'required|min:2', 
                            'email'      => "required|email" ,  
                            'phone'      => 'required',
                            'role_type'  => 'required'
                           // 'role'  => 'required'
                        ];
                    }
                }
                default:break;
            }
        //}
    }

    /**
     * The
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

}
