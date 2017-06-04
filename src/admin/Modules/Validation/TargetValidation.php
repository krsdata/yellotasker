<?php
namespace Admin\Validation;
 
use Input; 
use Validator;
use Request;

class TargetValidation 
{ 
    /**
     * The campaign validation rules.
     *
     * @return array
     */

    public static function validate($request)
    {
        $target =   $request->get('target');
        $rules  =  [    
                         'target' => 'Required'
                      ]; 
        return Validator::make($request->all(), $rules);
    }
 
}
