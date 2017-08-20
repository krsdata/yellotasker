<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class LoginRequest extends Request {

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
                            'email'   => "required|email" ,
                            'password' => "required" ,
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $metrics = $this->metrics ) {

                        return [
                            'email'   => "required|email" ,
                            'password' => "required" ,
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
