<?php

namespace Modules\Api\Resources;

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
use Modules\Admin\Models\CategoryDashboard;


/**
 * @author 
 */
class DashboardResource extends BaseApiResource {

    // return object of CategoryDashboard
    protected function getModel() {
        return new CategoryDashboard();
    }
    // get all getDashboardCategory
    public function getDashboardCategory() {

        return $this->getModel()->getCategories();
    }
}