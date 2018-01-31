<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class SubCategoryRequest  extends Request {

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
                            'category_group_name' => 'required', 
                            'category_name' => 'required', 
                            'category_image'             => 'required|mimes:jpeg,bmp,png,gif'
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $category = $this->category ) {

                        return [
                            'category_group_name' => 'required', 
                            'category_name' => 'required', 
                            'category_image'             => 'required|mimes:jpeg,bmp,png,gif' 
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
