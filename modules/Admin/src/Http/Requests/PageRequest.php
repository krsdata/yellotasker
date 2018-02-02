<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request; 
 

class PageRequest  extends Request {

    /**
     * The product validation rules.
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
                            'title'             => 'required' ,  
                            'page_content'      => 'required', 
                            'banner_image1'     => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=800,min_height=350', 
                        ];
                    }
                case 'PUT':
                case 'PATCH': {

                    if ( $page = $this->page ) {

                        return [
                            'title'             => 'required' ,  
                            'page_content'      => 'required', 
                            'banner_image1'     => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=800,min_height=350', 
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
