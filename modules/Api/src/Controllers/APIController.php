<?php

namespace Modules\Api\Controllers;

use Illuminate\Http\Request;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests; 
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Config,Mail,View,Redirect,Validator,Response; 
use Auth,Crypt,okie,Hash,Lang,JWTAuth,Input,Closure,URL; 
use JWTExceptionTokenInvalidException; 
use Modules\Api\Helpers\Helper as Helper;
use Modules\Api\Resources\ApiResource;
 
/**
 * @author 
 */
class APIController extends BaseController {

    protected function getResource() {
        return new ApiResource();
    }

    protected function getUser($user_id=null) {
        
        $user = $this->getResource()->getUser($user_id);
        $message = "Success";
        $code = 200;
        $status = 1;
        $data  = $user;
        return APIController::createSuccessResponse($message,$status,$code,$data) ;
    }

     

}