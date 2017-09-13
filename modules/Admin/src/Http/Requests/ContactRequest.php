<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class ContactRequest  extends Request {

    /**
     * The metric validation rules.
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
                            'name' => 'required', 
                             'email'     => "required|email|unique:contacts,email" , 
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $contact = $this->contact) {

                        return [
                            'name' => 'required', 
                             'email' => 'required' , 
                            
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
