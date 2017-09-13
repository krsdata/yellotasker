<?php
namespace Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;

/**
 * @author amanda
 */
abstract class BaseController extends Controller{

    protected abstract function getResource();
    
    public function createErrorResponse($errors='error', $status=0,$code=500,$data=null) {
        $response = array();
        
        $response['status'] 	= $status;
        $response['code']   	= $code;
        $response['message'] 	= $errors;
        $response['data'] 		= $data;
        
        return $response;
    }
    
    public function createSuccessResponse($errors='success', $status=1,$code=200,$data=null) {
        $response = array();
        
        $response['status'] 	= $status;
        $response['code']   	= $code;
        $response['message'] 	= $errors;
        $response['data'] 		= $data;
        
        return $response;
    }
}