<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class AssignmentRequest extends Request {

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
                            'chapter'       => "required" ,  
                            'paper_title'   => 'required',
                            'duration'      => 'required',
                            'due_date'      =>  'required'
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $assignment = $this->assignment ) {

                        return [
                            'chapter'       => "required" ,  
                            'paper_title'   => 'required',
                            'duration'      => 'required',
                            'due_date'      =>  'required'
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
