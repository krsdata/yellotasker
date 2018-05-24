<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class PressRequest  extends Request {

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
                            'pressName' => 'required', 
                            'link'=> 'required'

                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $result = $this->result) {

                        return [
                            'pressName'   => "required", 
                            'link'=> 'required'
                            
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
