<?php
namespace Modules\Api\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Modules\Admin\Http\Requests\SyllabusRequest;
use App\Models\Tasks;
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
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher; 
use Modules\Api\Resources\TaskResource; 

/**
 * Class AdminController
 */
class TaskController extends Controller {
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

    protected function getResource() {
        return new TaskResource();
    }
    /*
     * create Task
     * */

    public function create(Request $request)
    {
         $data = $this->getResource()->createTask($request);
         return $data;
    }

    public function getAllTasks(Request $request){

         $data = $this->getResource()->getAllTasks($request);
         return $data;
    }
 
    public function getRecentTasks(Request $request){

         $data = $this->getResource()->getRecentTasks($request);
         return $data;
    }

    public function getUserTasks(Request $request)
    {
         $data = $this->getResource()->getRecentTasks($request);
         return $data;

    }
    public function getOpenTasks(Request $request)
    {
         $data = $this->getResource()->getOpenTasks($request);
         return $data;
    }
}