<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class ProgramRequest  extends Request {

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
                            'program_name' => 'required', 
                             'start_date'  => "required" , 
                             'end_date'    => "required" , 
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $program = $this->program) {

                        return [
                            'program_name'  => 'required', 
                            'start_date'    => "required" , 
                            'end_date'      => "required" , 
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
