<?php
namespace App\Http\Controllers;

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
use Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher; 
use Modules\Api\Resources\TaskResource; 
use App\User;

/**
 * Class AdminController
 */
class TaskController extends Controller {

    protected $stockSettings = array();
    protected $modelNumber = '';

    // return object of userModel
    protected function getModel() {
        return new Task();
    }
    // get all user
    public function getUser($id=null) {

    //    return $this->getModel()->getUserDetail($id);
    }

    public function createTask(Request $request)
    {
        $post_request = $request->all();

         //Server side valiation
        $validator = Validator::make($request->all(), [
           'userId' => 'required',
           'title' => 'required'
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {
                    $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return Response::json(array(
                'status' => 0,
                'code'=>500,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }   
         
        if ($request->get('userId')==null) {

            $user_id = $request->get('userId');
            $user_data = User::find($user_id);
            if (empty($user_data)) {
                return
                    [ 
                    "status"  => '0',
                    'code'    => '500',
                    "message" => 'No match found for the given user id.',
                    'data'    => []
                    ];
                
            } 
        }   
        $task = new Tasks;

        $table_cname = \Schema::getColumnListing('post_tasks');
        $except = ['id','created_at','updated_at','status'];
        
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
           $task->$value = $request->get($value);
        }
        $task->save();
        $status  = 1;
        $code    = 200;
        $message = 'Task  created successfully.';
        $data    = $task; 
        
        return 
                [ 
                "status"  =>$status,
                'code'    => $code,
                "message" =>$message,
                'data'    => $data
                ];
                       

    }

    public function getPostTask(Request $request){

        $status = $request->get('taskStatus');
        $limit  = $request->get('limit');
        $userId = $request->get('userId');
        $title  = $request->get('title');
        
        $tasks  = Tasks::where(function($q)use($status,$limit,$userId,$title){
                    if($title){
                        $q->where('title','LIKE',"%".$title."%"); 
                    }
                    if($status){
                        $q->where('status', $status); 
                    }
                   
                    if($userId){
                        $q->where('userId', $userId); 
                    }
                     
                })->orderBy('id', 'desc');

        if($limit){
           $task = $tasks->take($limit)->get();  
        }else{
           $task =  $tasks->get();
        }
        if(count($task)){
            $status  =  1;
            $code    =  200;
            $message =  "List of tasks.";
            $data    =  $task;
        } else {
            $status  =  0;
            $code    =  404;
            $message =  "No task found.";
            $data    =  [];
        }

        return [ 
                    "status"  =>$status,
                    'code'    => $code,
                    "message" =>$message,
                    'data'    => $data
                    ];
    }

    public function getOpenTasks(){
        $tasks = Tasks::where('status', 0)->get();

        if(count($tasks)){
            $status  =  1;
            $code    =  200;
            $message =  "List of all open tasks.";
            $data    =  $tasks;
        } else {
            $status  =  0;
            $code    =  204;
            $message =  "No open tasks found.";
            $data    =  [];
        }

        return [ 
                    "status"  =>$status,
                    'code'    => $code,
                    "message" =>$message,
                    'data'    => $data
                    ];
    }

  

    public function getUserTasks(Request $request,$usrt_id)
    {
       $user_id = $request->user_id;

        if($user_id)
        {
            $user_tasks  =   Tasks::where('user_id',$user_id)->get();

            if(count($user_tasks)){
                $status  =  1;
                $code    =  200;
                $message =  "List of tasks posted by user";
                $data    =  $user_tasks;
            } else {
                $status  =  0;
                $code    =  204;
                $message =  "No tasks found for the given user.";
                $data    =  [];
            }
            
        } else {

            $status  =  0;
            $code    =  500;
            $message =  "Invalid User ID."; 
            $data    =  [];

        }
        return [ 
                "status"  =>$status,
                'code'    => $code,
                "message" =>$message,
                'data'    => $data
                ];
    }
       // delete Blog
    public function deletePostTask(Request $request,$id=null)
    {
        Tasks::where('id',$id)->delete();

        return  response()->json([ 
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"Post deleted successfully.",
                    'data' => []
                   ]
                );
    }
    public function deletePostTaskByUser(Request $request, $id=null)
    {
        
        $user_id = $request->get('user_id');
        
        $validator = Validator::make($request->all(), [
           'user_id' => 'required'
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {
                    $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return Response::json(array(
                'status' => 0,
                'code'=>500,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }  


        Tasks::where('id',$id)->where('user_id',$user_id)->delete();

        return  response()->json([ 
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"Post deleted successfully.",
                    'data' => []
                   ]
                );
    }
}