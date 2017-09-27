<?php
namespace Modules\Api\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tasks;
use App\Models\CategoryDashboard;
use Modules\Admin\Models\User;
use Input;
use Validator;
use Auth;
use Hash;
use View;
use URL; 
use Lang;
use Session;
use DB;
use Route;
use Crypt;
use Illuminate\Http\Dispatcher; 
use Modules\Api\Helpers\Helper as Helper;
use Modules\Api\Resources\DashboardResource;
 


/**
 * Class AdminController
 */
class DashboardController extends BaseController {
    /**
     * @var  Repository
     */

    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct() {
        
    }
    //
    protected function getResource() {
        return new DashboardResource();
    }

    /*
     * Dashboard
     * */

    protected function getCategories(Request $request) {
        
        $data = $this->getResource()->getDashboardCategory();
        if($data){
            $message = "Success";
            $code = 200;
            $status = 1; 
        }else{
            $message = "Not found";
            $code = 500;
            $status = 0;
        }
        return DashboardController::createSuccessResponse($message,$status,$code,$data) ;
    }
}
