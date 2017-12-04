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
                            'firstName' => 'required', 
                            'email'     => "required|email" , 
                            'categoryName' => 'required'
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $contact = $this->contact) {

                        return [
                            'firstName' => 'required', 
                             'email' => 'required' , 
                            'categoryName' => 'required'
                            
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
