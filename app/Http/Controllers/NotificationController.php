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
use App\Models\Notification;


/**
 * Class AdminController
 */
class NotificationController extends Controller {

    protected $stockSettings = array();
    protected $modelNumber = '';
    
    public function getAllNotification(Request $request)
    {
        $arr = [];
        $notifications = Notification::with('userDetails')->orderBy('id', 'desc')->limit(50)->get();

        foreach ($notifications as $key => $value) {

                if($value->entity_type=="offers_add"){
                     $offers = Offers::with('task','assignUser','interestedUser')->where('id',$value->entity_id)->first();
                     $data  = $value;
                     $data['offerDetails'] = $offers; 
                }
                if($value->entity_type=="task_add" || $value->entity_type=="task_update"){
                     $task = Tasks::with('postUserDetail','seekerUserDetail')->where('id',$value->entity_id)->first();
                     $data  = $value;
                     $data['taskDetails'] = $task; 
                } 

                if($value->entity_type=="comment_replied" || $value->entity_type=="comment_add"){
                    $comments = Comments::with('userDetail','commentReply','taskDetail')
                                ->where('id',$value->entity_id)
                                ->first();

                     $data  = $value;
                     $data['commentsDetails'] = $comments; 
                }

                if($value->entity_type=="user_register"){
                    $user_register =User::where('id',$value->entity_id)->first();

                     $data  = $value;
                     $data['userRegisterd'] = $user_register; 
                }  

                 $arr[] =   $data;              
        }
 

      //  dd($arr);

        return  response()->json([
                    "status"=>count($arr)?1:0,
                    "code"=> count($arr)?200:404,
                    "message"=>count($arr)?"Notification list found":"Record not found for given input!",
                    'data' => $arr
                   ]
                );  

        } 

}