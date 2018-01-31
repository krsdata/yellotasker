<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request; 
 

class ProductRequest  extends Request {

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
                            'product_title'     => "required|unique:products,product_title" ,  
                            'product_category'  => 'required', 
                            'description'       => 'required',
                            'price'             =>  'required|numeric|min:0',
                            'discount'             =>  'required|numeric|min:0',
                            'image'             => 'required|mimes:jpeg,bmp,png,gif'
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $product = $this->product ) {

                        return [
                            'product_title'     => "required" ,  
                            'product_category'  => 'required', 
                            'description'       => 'required',
                            'price'             =>  'required|numeric|min:0',
                            'discount'             =>  'required|numeric|min:0',
                            'image'             => 'mimes:jpeg,bmp,png,gif'
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
