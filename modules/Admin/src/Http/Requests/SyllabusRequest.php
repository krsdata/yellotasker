<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class SyllabusRequest extends Request {

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
                            'syllabus_title'   => "required",
                            'grade_weight'  =>  'required'  
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $syllabus = $this->syllabus ) {

                        return [
                            'syllabus_title'   => "required",
                            'grade_weight'  =>  'required'  
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
