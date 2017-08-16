<?php

namespace Modules\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests; 
use Illuminate\Contracts\Encryption\DecryptException;
use Config,Mail,View,Redirect,Validator,Response; 
use Auth,Crypt,okie,Hash,Lang,JWTAuth,Input,Closure,URL; 
use JWTExceptionTokenInvalidException; 
use App\Helpers\Helper as Helper;

use Modules\Admin\Models\User;


/**
 * @author 
 */
class ApiResource extends BaseApiResource {

    protected $stockSettings = array();
    protected $modelNumber = '';

    // return object of userModel
    protected function getUserModel() {
        return new User();
    }
    // get all user
    public function getUser($id=null) {

        return $this->getUserModel()->getUserDetail($id);
    }
}