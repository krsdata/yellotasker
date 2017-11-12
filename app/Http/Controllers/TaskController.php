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

    public function updatePostTask(Request $request)
    { 
        $post_request = $request->all(); 
         //Server side valiation
        $validator = Validator::make($request->all(), [
           'taskId' => 'required',
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
        $taskId = $request->get('taskId'); 
        $task = Tasks::find($taskId);
        if ($task==null) {
            $task_data = Tasks::find($taskId);
            if (empty($task_data)) {
                return
                    [ 
                    "status"  => '0',
                    'code'    => '500',
                    "message" => 'No match found for the given task id.',
                    'data'    => []
                    ];
                
            } 
        }   
         
        $table_cname = \Schema::getColumnListing('post_tasks');
        $except = ['id','created_at','updated_at'];
        
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
           if($request->get($value)){
                $task->$value = $request->get($value);
           }
           
        }
        $task->save();
        $status  = 1;
        $code    = 200;
        $message = 'Task  updated successfully.';
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
        $taskId  = $request->get('taskId'); 
        $page_number = $request->get('page_num');
        if($page_number){
            $page_num = ($request->get('page_num'))?$request->get('page_num'):1;
            $page_size = ($request->get('page_size'))?$request->get('page_size'):20; 
        }
       
            

        $start_week = \Carbon\Carbon::now()->startOfWeek()->toDateString();
        $end_week   = \Carbon\Carbon::now()->endOfWeek()->toDateString();
        $today      = \Carbon\Carbon::today()->toDateString();
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = \Carbon\Carbon::now()->subMonth()->toDateString();
        $tomorrow   = \Carbon\Carbon::tomorrow()->toDateString();

        $due_today          = $request->get('due_today');
        $due_tomorrow       = $request->get('due_tomorrow');
        $due_current_week   = $request->get('due_current_week');
        $due_current_month  = $request->get('due_current_month');
        $search_by_date     = $request->get('search_by_date');
        
        $tasks  = Tasks::with('userDetail')->where(function($q)
                use(
                        $status,
                        $limit,
                        $taskId,
                        $userId,
                        $title,
                        $start_week,
                        $end_week ,
                        $today,
                        $startOfMonth,
                        $endOfMonth,
                        $tomorrow,
                        $due_today,
                        $due_tomorrow,
                        $due_current_week,
                        $due_current_month,
                        $search_by_date
                    )
                {
                    if($title){
                        $q->where('title','LIKE',"%".$title."%"); 
                    }
                    if($status){
                        $q->where('status', $status); 
                    }
                   
                    if($userId){
                        $q->where('userId', $userId); 
                    }

                    if($due_today){
                        $q->where('dueDate', $today); 
                    }
                    if($due_tomorrow){
                         $q->where('dueDate', $tomorrow); 
                    }
                    if($due_current_week){
                         $q->whereBetween('dueDate',[$start_week,$end_week]);
                    }
                    if($due_current_month){
                         $q->whereBetween('dueDate',[$startOfMonth,$endOfMonth]);
                    }
                    if($search_by_date){
                        $q->where('dueDate',$search_by_date);
                    }
                    if($taskId){
                        $q->where('id',$taskId);
                    }
                     
                });
               

      
        if($limit){  
           $task = $tasks->take($limit)->orderBy('id', 'desc')->get()->toArray();  
        }
        elseif($page_number){
            if($page_number>1){
                  $offset = $page_size*($page_num-1);
            }else{
                  $offset = 0;
            }  
            $task =  $tasks->orderBy('id', 'desc')->skip($offset)->take($page_size)->get(); 
        }
        else{
           $task =  $tasks->take(20)->get()->toArray();
        }  
        $my_data = $this->array_msort($task, array('dueDate'=>SORT_ASC));
        $data = array_values($my_data);
         
        
        if(count($task)){
            $status  =  1;
            $code    =  200;
            $message =  "List of tasks.";
            $data    =  $data;
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

    public function array_msort($array, $cols)
    {
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval,0,-1).');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k,1);
                if (!isset($ret[$k])) $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;

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