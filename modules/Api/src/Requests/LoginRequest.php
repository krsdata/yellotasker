<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class LoginRequest extends Request {

    /**
     * The login validation rules.
     *
     * @return array
     */
    public function rules() {
         
            switch ( $this->method() ) {
                case 'GET':
                case 'DELETE': {
                        return [ ];
                    }
                case 'POST': {
                        return [
                            'email'   => "required|email" ,
                            'password' => "required|min" ,
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $admin = $this->admin ) {

                        return [
                            'email'   => "required|email" ,
                            'password' => "required" ,
                        ];
                    }
                }
                default:break;
            }
         
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
