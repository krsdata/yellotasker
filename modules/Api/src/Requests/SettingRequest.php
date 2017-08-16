<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request; 
 

class SettingRequest  extends Request {

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
                            'website_title'     => 'required' ,  
                            'website_email'     => 'required|email', 
                            'website_url'       => 'required|url',
                            'contact_number'    =>  "required|min:10",
                            'company_address'   =>  'required',
                            'banner_image1'     => 'required|mimes:jpeg,bmp,png,gif|dimensions:min_width=800,min_height=350',
                            'banner_image2'     => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=800,min_height=350',
                            'banner_image3'     => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=800,min_height=350'
                        ];
                    }
                case 'PUT':
                case 'PATCH': {

                    if ( $setting = $this->setting ) {

                        return [

                            'website_title'     => 'required' ,  
                            'website_email'     => 'required|email', 
                            'website_url'       => 'required|',
                            'contact_number'    => 'required|min:0',
                            'company_address'   => 'required',
                            'banner_image1'     => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=800,min_height=350',
                            'banner_image2'     => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=800,min_height=350',
                            'banner_image3'     => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=800,min_height=350'
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
