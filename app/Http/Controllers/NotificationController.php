<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tasks;
use App\Models\Offers;
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
use Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher; 
use Modules\Api\Resources\TaskResource; 
use App\User;
use App\Models\Comments;
use App\Notification;

/**
 * Class AdminController
 */
class NotificationController extends Controller {

    protected $stockSettings = array();
    protected $modelNumber = '';
  
    public function getAllNotification(Request $request)
    {
    
    $notifications =  \DB::table('notifications')->orderBy('id', 'desc')->limit(50)->get();
    return  response()->json([
                "status"=>($notifications)?1:0,
                "code"=> ($notifications)?200:404,
                "message"=>($notifications)?"Notification list found":"Record not found for given input!",
                'data' => $notifications
               ]
            );  

    }


}