<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class CourseRequest extends Request {

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
                            'session_id' => 'required',
                            'course_name'   =>  'required' 
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $course = $this->course ) {

                        return [
                            'session_id' => 'required',
                            'course_name'   =>  'required' 
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
