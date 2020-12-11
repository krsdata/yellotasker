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
use Mail;
use App\Helpers\Helper;

/**
 * Class AdminController
 */
class NotificationController extends Controller {

    protected $stockSettings = array();
    protected $modelNumber = '';

    public function getAllNotification(Request $request)
    {
        $arr = [];
        
        $validator = Validator::make($request->all(), [
           'user_id' => 'required'
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {
                    $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            /*return Response::json(array(
                'status' => 0,
                'code'=>500,
                'message' => $error_msg[0],
                'data'  =>  $request->user_id
                )
            );*/
            $notifications = Notification::with('userDetails')->orderBy('id', 'desc')->limit(50)->get();
        }else{
             $notifications = Notification::with('userDetails')->orderBy('id', 'desc')->where('user_id',$request->user_id)->get();     
        }   

       

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
        return  response()->json([
                    "status"=>count($arr)?1:0,
                    "code"=> count($arr)?200:404,
                    "message"=>count($arr)?"Notification list found":"Record not found for given input!",
                    'data' => $arr
                   ]
                );
    } 
    
    public function getAllNotification2(Request $request)
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
        return  response()->json([
                    "status"=>count($arr)?1:0,
                    "code"=> count($arr)?200:404,
                    "message"=>count($arr)?"Notification list found":"Record not found for given input!",
                    'data' => $arr
                   ]
                );
    } 







    public function sendEmailReminder(Request $request)
    {
        $helper = new Helper;
        $email = ($request->get('email'))?$request->get('email'):'kroy@mailinator.com';
        $email_content = [
                            'email'=>$email,
                            'name'=>'kandy',
                            'receipent_email'=>'kroy@mailinator.com',
                            'subject'=>'test email'
                        ];
       $data = $helper->sendMailFrontEnd($email_content, 'reminder');
       echo "mail sent";
    }

}