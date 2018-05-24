<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class ArticleTypeRequest  extends Request {

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
                            'article_type' => 'required|unique:article_type,article_type', 
                            'resolution_department'=> 'required'
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $result = $this->result) {

                        return [
                            'article_type'   => "required" , 
                            'resolution_department'=> 'required'
                            
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
