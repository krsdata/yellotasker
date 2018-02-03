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
        
        $notification = new Notification;
        $notification->addNotification('task_add',$task->id,$request->get('userId'),'New Task Added',$task->title);
        return 
                [ 
                "status"  =>$status,
                'code'    => $code,
                "message" =>$message,
                'data'    => $data
                ]; 
    }

 	public function updateTaskStatus(Request $request)
    { 
        $post_request = $request->all(); 
         //Server side valiation
        $validator = Validator::make($request->all(), [
           'taskId' => 'required', 
           'status' => 'required'
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
        $message = 'Task status changed successfully';
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
        $notification = new Notification;
        $notification->addNotification('task_update',$task->id,$request->get('userId'),'Task updated',$task->title);
     
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
        $endOfMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();
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

    public function Comment(Comments $comment, Request $request){

        $post_request = $request->all(); 
         //Server side valiation
        $action =  $request->get('getCommentBy');
        $taskId =  $request->get('taskId');
        if($action == 'task'){
             $getComment = $this->getComment($taskId); 
              return Response::json($getComment);
        }
         

        $validator = Validator::make($request->all(), [
           'taskId' => 'required',
           'userId' => 'required'
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
                'data'  =>  $post_request
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
                    'data'    => $post_request
                    ];
                
            } 
        }  
 

        $userId = $request->get('userId'); 
        $user = User::find($userId);
        if ($user==null) {
            $user = Tasks::find($user);
            if (empty($user)) {
                return
                    [ 
                    "status"  => '0',
                    'code'    => '500',
                    "message" => 'No match found for the given user id.',
                    'data'    => $post_request
                    ];
                
            } 
        }
        $action =  $request->get('commentReply');
        if($action == 'yes'){ 
            $validator = Validator::make($request->all(), [
               'commentId' => 'required'
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
                    'data'  =>  $post_request
                    )
                );
            }   
 
             $getComment = $this->replyComment($request->all()); 
             
             return Response::json(array(
                    'status' => 1,
                    'code'=>200,
                    'message' => "Comment replied!",
                    'data'  =>  $getComment
                    )
                );
        }

        $table_cname = \Schema::getColumnListing('comments');
        $except = ['id','created_at','updated_at'];
        
        $comment = new Comments;
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
           if($request->get($value)){
                $comment->$value = $request->get($value);
           }
           
        }
        $comment->save();
        $notification = new Notification;
        $notification->addNotification('comment_add',$comment->id,$request->get('userId'),'Comment Added',$comment->commentDescription);

        $comments = Comments::with('userDetail')->where('id',$comment->id)->get();
        $status  = 1;
        $code    = 200;
        $message = 'Reply added successfully.';
        $data    = $comments; 
        
        return 
                [ 
                "status"  =>$status,
                'code'    => $code,
                "message" =>$message,
                'data'    => $data
                ];
    }

    public function replyComment($request)
    {
        $table_cname = \Schema::getColumnListing('comments');
        $except = ['id','created_at','updated_at'];
        
        $comment = new Comments;
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
           if(isset($request[$value]) && $request[$value]){
                $comment->$value = $request[$value];
           }
           
        }
        $comment->save();

        $notification = new Notification;
        $notification->addNotification('comment_replied',$comment->id,$request->get('userId'),'Comment replied',$comment->commentDescription);

        $comments = Comments::with('userDetail','commentReply')
                        ->where('id',$request['commentId'])
                        ->get();
        return $comments;


    }
    public function getComment($taskId=null)
    {
 
        /** Return Error Message **/
        if (empty($taskId)) {
                    
            return [
                'status' => 0,
                'code'=>500,
                'message' => "Task id is required",
                'data'  =>  []
                ];
        }   
     
       
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


        $comment =  Comments::with('userDetail')->where('taskId',$taskId)->get();
        
        if($comment->count()>0){
            return 
                [ 
                "status"  =>1,
                'code'    => 200,
                "message" =>"Comments list",
                'data'    => $comment
                ];
        }else{

            return 
                [ 
                "status"  =>0,
                'code'    => 404,
                "message" =>"Record not found!",
                'data'    => []
                ];

        }

    }

    public function getMyOffer(Request $request)
    {
    	$validator = Validator::make($request->all(), [
               'taskId' => 'required',
               'userId'=>'required'
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
                    'data'  =>  $request->all()
                    )
                );
         }   

        $offers =  User::with('myOffer')->where('id',$request->get('userId'))->get();
 
      	return  response()->json([ 
                    "status"=>($offers->count())?1:0,
                    "code"=> ($offers->count())?200:404,
                    "message"=>($offers->count())?"User Task offer list":"Record not found",
                    'data' => $offers
                   ]
                ); 



    }

    public function getAlloffers(Request $request)
    {
    	$taskId = $request->get('taskId');
    	$taskOwnerId = $request->get('taskOwnerId');

    	$offers = Tasks::with(['allOffers'=>function($q)use($taskId,$taskOwnerId){
    			$q->where('taskId',$taskId);
    	}])->where('userId',$taskOwnerId)->get();

		return  response()->json([ 
                "status"=>($offers)?1:0,
                "code"=> ($offers)?200:404,
                "message"=>($offers)?"All offers list found":"Record not found for given input!",
                'data' => $offers
               ]
            );  

    }

    public function deleteOffer(Request $request)
    {

    	$offers = Offers::where('userId',$request->get('userId'))
    				->where('offerId',$request->get('offerId'))
                    ->where('taskId',$request->get('taskId'))
                    ->delete();

		return  response()->json([ 
                "status"=>($offers)?1:0,
                "code"=> ($offers)?200:404,
                "message"=>($offers)?"offer deleted successfully":"Record not found for given input!",
                'data' => []
               ]
            ); 
		 

    }

    public function updateOffer(Request $request,$id=null)
    {
         /** Return Error Message **/
            if ($id==null) {
                        
                                
                return Response::json(array(
                    'status' => 0,
                    'code'=>500,
                    'message' => 'offerId required',
                    'data'  =>  $request->all()
                    )
                );
         }   

         

        $data = [];
        $table_cname = \Schema::getColumnListing('offers');
        $except = ['id','created_at','updated_at'];
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           }  

           if($request->get($value)){
           			 $data[$value] = $request->get($value);
   			} 

          
        }
         
        $rs =  DB::table('offers')
                    ->where('id',$id) 
                            ->update($data); 
         

        $offetData =  Tasks::with(['interestedUsers'=>function($q) use($request){
            $q->where('users.id',$request->get('interestedUsreId'));
        }])->where('id',$request->get('taskId'))->get(); 



        return Response::json(array(
                    'status' => 1,
                    'code'=>200,
                    'message' => 'Offer updated successfully.',
                    'data'  =>  $request->all()
                    )
                );

    }

    public function makeOffer(Request $request,$id=null)
    {
        $validator = Validator::make($request->all(), [
               'taskId' => 'required',
               'interestedUsreId'=>'required'
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
                    'data'  =>  $request->all()
                    )
                );
         }   

        $is_savtask = DB::table('offers')->where('taskId',$request->get('taskId'))->where('interestedUsreId',$request->get('interestedUsreId'))->first(); 
         
        $task_action = $request->get('action');

         if($is_savtask!=null && $task_action!='update'){
            return Response::json(array(
                    'status' => 0,
                    'code'=>500,
                    'message' => 'Offer already exists.Do you want to update?',
                    'data'  =>  $is_savtask 
                    )
                );
         }

        $data = [];
        $table_cname = \Schema::getColumnListing('offers');
        $except = ['id','created_at','updated_at'];
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
           if($task_action=='update'){
           		if($request->get($value)){
           			 $data[$value] = $request->get($value);
       			} 
           }else{
           		 $data[$value] = $request->get($value);
           }

          
        }
        
       // $rs =  DB::table('offers')->insert($data); 

        if($is_savtask!=null && $task_action=='update'){
            $rs =  DB::table('offers')
                    ->where('id',$request->get('taskId'))
                        ->where('interestedUsreId',$request->get('interestedUsreId'))
                            ->update($data); 
        $notification = new Notification;
        $notification->addNotification('offers_update',$rs->id,$request->get('interestedUsreId'),'Offer updated','');
            
        }else{
            $rs =  DB::table('offers')->insert($data); 
            $notification = new Notification;
            $notification->addNotification('offers_add',$rs->id,$request->get('interestedUsreId'),'Offer posted','');

        }

        $offetData =  Tasks::with(['interestedUsers'=>function($q) use($request){
            $q->where('users.id',$request->get('interestedUsreId'));
        }])->where('id',$request->get('taskId'))->get(); 
        return Response::json(array(
                    'status' => 1,
                    'code'=>200,
                    'message' => 'Offer posted successfully.',
                    'data'  =>  $offetData
                    )
                );

    }

    public function taskOffer(Request $request, $taskId=null)
    {
      $offers =  Tasks::with('interestedUsers')->where('id',$taskId)->get(); 
 
      return  response()->json([ 
                    "status"=>($offers->count())?1:0,
                    "code"=> ($offers->count())?200:404,
                    "message"=>($offers->count())?"Task offer list":"Record not found",
                    'data' => $offers
                   ]
                );
    }

    public function getSaveTask(Request $request, $uid=null){
      
        
        $offers = User::with(['expiredTask'=>function($q){
                        $q->whereDate('dueDate','<',Carbon::today()->toDateString());
                        $q->where('status','open');
                    }])->with(['assignedTask'=>function($q) use($uid){
                        $q->where('taskDoerId','!=',$uid);
                        $q->where('status','!=','open');
                    }])->with(['openTask'=>function($q){
                        $q->whereDate('dueDate','>=',Carbon::today()->toDateString());
                    }])->where('id',$uid)
                    ->get();

        return  response()->json([ 
                    "status"=>($offers->count())?1:0,
                    "code"=> ($offers->count())?200:404,
                    "message"=>($offers->count())?"Saved task offer list":"Record not found",
                    'data' => $offers
                   ]
                );
    }


    public function assignTask(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
               'taskId' => 'required',
               'assignUserId'=>'required',
               'taskStatus' => 'required'
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
                    'data'  =>  $request->all()
                    )
                );
         }  


        $taskId =  $request->get('taskId');
        $task   = Tasks::find($taskId);

        if($task){
            $task->status = $request->get('taskStatus');
            $task->taskDoerId  = $request->get('assignUserId'); 
            $task->save();

            return  response()->json([ 
                    "status"=>1,
                    "code"=> 200,
                    "message"=>'Task Assigned successfully',
                    'data' => $request->all()
                   ]
                );    
        }else{
            return  response()->json([ 
                    "status"=>0,
                    "code"=> 500,
                    "message"=>'Task ID does not exist',
                    'data' => $request->all()
                   ]
                );  
        }
        

    }


    public function getTask(Request $request, $uid=null){ 

        $offers = User::with('save_task')
                    ->with(['offers_accepting'=>function($q) use($uid)
                        {
                          $q->where('taskDoerId','=',$uid);
                        }
                    ])->with(['offers_pending'=>function($q) use($uid)
                    {
                      $q->where('taskDoerId','!=',$uid);
                    }
                ])->with('postedTask')
                    ->where('id',$uid)
                        ->get();
        

        return  response()->json([ 
                    "status"=>($offers->count())?1:0,
                    "code"=> ($offers->count())?200:404,
                    "message"=>($offers->count())?"All task list":"Record not found",
                    'data' => $offers
                   ]
                );
    }

    public function saveTaskDelete(Request $request){
        $validator = Validator::make($request->all(), [
               'taskId' => 'required',
               'userId' => 'required'
        ]); 

         if ($validator->fails()) {
                        $error_msg  =   [];
                foreach ( $validator->messages()->all() as $key => $value) {
                            array_push($error_msg, $value);     
                        }
                                
                return Response::json(array(
                    'status' => 0,
                    'code'=>500,
                    'message' => $error_msg[0],
                    'data'  =>  $request->all()
                    )
                );
         }   

         $delete_savetask = DB::table('saveTask')->where('taskId',$request->get('taskId'))->where('userId',$request->get('userId'))->delete(); 

         if($delete_savetask){
            $status     = 1;
            $code       = 200;
            $message    = "Save Task deleted successfully.";
         }else{
            $status = 0;
            $code = 500;
            $message = "Task ID or user ID does not match!";
         }

         return  response()->json([ 
                    "status"=>$status,
                    "code"=> $code,
                    "message"=>$message,
                    'data' => []
                   ]
                );



    }

    public function saveTask(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
               'taskId' => 'required',
               'userId' => 'required'
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
                    'data'  =>  $request->all()
                    )
                );
         }   

         $is_savtask = DB::table('saveTask')->where('taskId',$request->get('taskId'))->where('userId',$request->get('userId'))->first(); 
         
         $task_action = $request->get('action');

         if($is_savtask!=null && $task_action!='update'){
            return Response::json(array(
                    'status' => 0,
                    'code'=>500,
                    'message' => 'This task already saved.Do you want to update?',
                    'data'  =>  $is_savtask 
                    )
                );
         }

        $data = [];
        $table_cname = \Schema::getColumnListing('saveTask');
        $except = ['id','created_at','updated_at'];
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
           $data[$value] = $request->get($value);
        }
  
        // saveTask update      
        if($is_savtask!=null && $task_action=='update'){
            $rs =  DB::table('saveTask')
                    ->where('id',$request->get('taskId'))
                        ->where('userId',$request->get('userId'))
                            ->update($data); 
        }else{
            $rs =  DB::table('saveTask')->insert($data); 
        }
        
        return $this->getSaveTask($request,$request->get('userId'));
        
        return Response::json(array(
                    'status' => 1,
                    'code'=>200,
                    'message' => 'Offer saved successfully.',
                    'data'  =>  []
                    )
                );

    }

    public function getBlog(Request $request)
    {
        
        $page_num = ($request->get('page_num'))?$request->get('page_num'):1;
        $page_size = ($request->get('page_size'))?$request->get('page_size'):20; 
        
        if($page_num==1 && $page_size==20){  
           $data =  \DB::table('blogs')->take($page_size)->orderBy('id', 'desc')->get();
        }
        elseif($page_num!=1 || $page_size!=20){
            if($page_num>1){
                  $offset = $page_size*($page_num-1);
            }else{
                  $offset = 0;
            }  
            $data =  \DB::table('blogs')->orderBy('id', 'desc')->skip($offset)->take($page_size)->get(); 
        }

        $input = [];
        $arr=[];

        foreach ($data as $key => $value) {
            $input['id'] =  $value->id;
            $input['blog_sub_title'] = $value->blog_sub_title;
            $input['blog_description'] = $value->blog_description;
            $input['blog_image'] = url('storage/blog/'.$value->blog_image); 
            $input['author'] = "Admin";

            $arr[] = $input;
            $input = [];
        } 
    
        $c = \DB::table('blogs')->get();

         return Response::json(array(
                    'status' => 1,
                    'total_record' => count($c),
                    'code'=>200,
                    'message' => 'blogs.',
                    'data'  =>  $arr
                    )
                );

    }


}