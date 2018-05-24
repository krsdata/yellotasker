<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class ArticleRequest  extends Request {

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
                            'article_type' => 'required', 
                            'article_title'=> 'required'

                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $result = $this->result) {

                        return [
                            'article_type'   => "required", 
                            'article_title'=> 'required'
                            
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
