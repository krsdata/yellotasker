<?php
namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;
use Input;

class CorporateProfileRequest extends Request {

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
                            'company_name'   => "",  
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                    if ( $position = $this->position ) {

                        return [
                           'company_name'   => "", 
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
