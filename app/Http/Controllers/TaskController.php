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
use Modules\Admin\Models\Category;
use Modules\Admin\Models\CategoryDashboard; 
use App\Models\Review;
use App\Models\Reviews;
use App\Models\Portfolio;

/**
 * Class AdminController
 */
class TaskController extends Controller {

    protected $stockSettings = array();
    protected $modelNumber = '';

    private    $sub_sql =  "( case when status = 'completed' then 0 when  COALESCE(dueDate,CURRENT_DATE) < current_date then 1 when status = 'open'then 3 when status = 'assigned' then 2    end )as rank";
    private    $sub_sql_offer_count     = '(SELECT COUNT(*) as count from   offers where offers.taskId=post_tasks.id) as offer_count';
    private    $sub_sql_comment_count   = '(SELECT COUNT(*) as count from   comments where comments.taskId=post_tasks.id) as comment_count';

    private $sub_status = '(
                        CASE 
                        when COALESCE(dueDate,CURRENT_DATE) < current_date AND status ="open" then "expired"
                        ELSE 
                        status end) as status'; 


    private $doerRating     = '(SELECT ROUND( AVG(doerRating),1) from reviews LEFT  JOIN post_tasks on review.taskId=post_tasks.id ) as doerAvgRating';
    private $posterRating   = '(SELECT ROUND(AVG(posterRating),1) from reviews LEFT JOIN post_tasks on review.posterUserId=post_tasks.userId) as posterAvgRating';
                                         
    private $trns_status = '(
                        CASE 
                        when  status=-1 then "Failed"
                        when  status=1 then "Success"
                        when  status=2 then "Pending"
                        when  status=3 then "Failed" 
                        ELSE 
                        status end) as status';
    // constructor
    public function __construct(Request $request) {

        try{
            $uid = $request->get('user_id');
            $user   =   User::where('id',$uid)->first();
            if($user){ 
                $u      =   User::where('id',$uid)->first(['first_name','last_name','about_me','profile_image','tagLine','location','email','role_type','birthday'])->toArray();
               
                $count=0;
                foreach ($u as $key => $value) {
                    $col[] = $key;
                     if($value===null){
                        ++$count;
                     }
                } 
                
                $user->profile_completion  = intval(((9-$count)/9)*100).'%';

                $u = User::where('id',$uid)->first(['skills','language','qualification','workExperience'])->toArray();

                $count=0;
                foreach ($u as $key => $value) {
                    $col[] = $key;
                     if($value===null){
                        ++$count;
                     }
                }  
                $user->skill_completion  = intval(((4-$count)/4)*100).'%'; 
                $user->badges = "0%";
                
                $user->save(); 
                
            } 
        } catch(\Exception $e){ 

             //
        }
    }

    // return object of userModel
    protected function getModel() {
        return new Task();
    }

    public function getPublic(Request $request, $uid=null){

        $user = User::with('task')->where('id',$uid)->get();

        return $user;

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
        $task->fund_released=0;
        $task->funded_by_poster= "No";
        $task->payment_status = "Not initiated";
        $task->taskOwnerId = $request->get('userId');
        
        $task->save();
        $status  = 1;
        $code    = 200;
        $message = 'Task  created successfully.';
        $data    = $task; 
        
        if($task){

        $notification = new Notification;
        $notification->addNotification('task_add',$task->id,$request->get('userId'),'New Task Added',$task->title);
   
        }
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

        if($task){
            $notification = new Notification;
            $notification->addNotification('task_update',$task->id,$request->get('userId'),'Task updated',$task->title);
        }

        
        return 
                [ 
                "status"  =>$status,
                'code'    => $code,
                "message" =>$message,
                'data'    => $data
                ];
                       

    }

    public function getCategoryByGroup(Request $request, $gid=null){
        $categoryId         =   $gid;
        $data = [];
        $image_url = env('IMAGE_URL',url::asset('storage/uploads/category/'));
       
        try{
            $category       =   Category::where('id',$categoryId)->first();
            $allCategoryId  =   Category::where('parent_id',$category->id)->where('parent_id','!=',0)->get();

            $data['category_id']            = $category->id;
            $data['group_id']               = ($category->parent_id==0)?$category->id:$category->parent_id;
            $data['category_group_name']    = $category->category_group_name;
            $data['category_group_image']   = $image_url.'/'.$category->category_group_image;
            $data['category']               = $allCategoryId;

           
          
        }catch(\Exception $e){ 
            $data = [];
            $status = 0;
            $code   = 500;
            $msg    = "Category by group Id not  found";
        return 
                [ 
                "status"  => count($data)?1:0,
                'code'    => count($data)?200:500,
                "message" => $msg,
                'data'    => $data
                ];
        }

         return 
                [ 
                "status"  => count($data)?1:0,
                'code'    => count($data)?200:404,
                "message" => count($data)?"Category by group Id found":"Category by group Id not found",
                'data'    => $data
                ];

            

    }

    public function getPostTaskByGroupCategory(Request $request){
        $categoryId         =   $request->get('groupId'); 
        $data = [];
        $image_url = env('IMAGE_URL',url::asset('storage/uploads/category/'));
       
        try{
            $category       =   Category::where('id',$categoryId)->first();
            $allCategoryId  =   Category::where('parent_id',$category->id)->where('parent_id','!=',0)->lists('id');
            $task           =  Tasks::whereIn('categoryId',$allCategoryId)->get(); 


            $data['category_id']            = $category->id;
            $data['group_id']               = ($category->parent_id==0)?$category->id:$category->parent_id;
            $data['category_group_name']    = $category->category_group_name;
            $data['category_group_image']   = $image_url.'/'.$category->category_group_image;
            $data['posted_task'] = $task;

           
          
        }catch(\Exception $e){ 
            $data = [];
            $status = 0;
            $code   = 500;
            $msg    = "Task by group Id not  found";
        return 
                [ 
                "status"  => count($data)?1:0,
                'code'    => count($data)?200:500,
                "message" => $msg,
                'data'    => $data
                ];
        }

         return 
                [ 
                "status"  => count($data)?1:0,
                'code'    => count($data)?200:404,
                "message" => count($data)?"Task by group Id found":"Task by group Id not found",
                'data'    => $data
                ];
    }

    public function getPostTaskByCategory(Request $request){
        $categoryId         =   $request->get('categoryId'); 
        $data = [];
        $image_url = env('IMAGE_URL',url::asset('storage/uploads/category/'));
       
        try{
            $task           =  Tasks::where('categoryId',$categoryId)->get(); 
            $category       =   Category::where('id',$categoryId)->first();
            
            $data['category_id']            = $category->id;
            $data['group_id']               = ($category->parent_id==0)?$category->id:$category->parent_id;
            $data['category_group_name']    = $category->category_group_name;
            $data['category_group_image']   = $image_url.'/'.$category->category_group_image;
            $data['posted_task'] = $task;

           
          
        }catch(\Exception $e){
            $data = [];
            $status = 0;
            $code   = 500;
            $msg    = "Task by category Id not found";
        return 
                [ 
                "status"  => count($data)?1:0,
                'code'    => count($data)?200:500,
                "message" => $msg,
                'data'    => $data
                ];
        }

         return 
                [ 
                "status"  => count($data)?1:0,
                'code'    => count($data)?200:404,
                "message" => count($data)?"Task by category Id found":"Task by category Id not found",
                'data'    => $data
                ];
    }


    public function getPostTask(Request $request){

        $status         =   $request->get('taskStatus');
        $limit          =   $request->get('limit');
        $userId         =   $request->get('userId');
        $title          =   $request->get('title');
        $taskId         =   $request->get('taskId'); 
        $categoryId     =   $request->get('categoryId'); 
        $page_number    =   $request->get('page_num');

       

        if($page_number){
            $page_num   =   ($request->get('page_num'))?$request->get('page_num'):1;
            $page_size  =   ($request->get('page_size'))?$request->get('page_size'):20; 
        }
       
        $start_week     =   \Carbon\Carbon::now()->startOfWeek()->toDateString();
        $end_week       =   \Carbon\Carbon::now()->endOfWeek()->toDateString();
        $today          =   \Carbon\Carbon::today()->toDateString();
        $startOfMonth   =   \Carbon\Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth     =   \Carbon\Carbon::now()->endOfMonth()->toDateString();
        $tomorrow       =   \Carbon\Carbon::tomorrow()->toDateString();

        $due_today          = $request->get('due_today');
        $due_tomorrow       = $request->get('due_tomorrow');
        $due_current_week   = $request->get('due_current_week');
        $due_current_month  = $request->get('due_current_month');
        $search_by_date     = $request->get('search_by_date');

        $search_locationType = $request->get('locationType');
        $search_city         = $request->get('city');
        $search_totalAmount  = $request->get('totalAmount');

        $releasedFund  = $request->get('releasedFund');
        $budgetmax      = $request->get('budgetmax');
        $budgetmin      = $request->get('budgetmin');
        $budgetType     = $request->get('budgetType');
        $locationType   = $request->get('locationType');
                
        
         $validatorFields    = [];
        
        

        $validator = Validator::make($request->all(), $validatorFields);
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
        
        $tasks  = Tasks::with('userDetail','offerDetails')->where(function($q)
                use(
                        $budgetmax,$budgetmin,$budgetType,$locationType,
                        $status,
                        $limit,
                        $taskId,
                        $userId,
                        $categoryId,
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
                        $search_by_date,
                        $search_locationType,
                        $search_city,
                        $search_totalAmount,
                        $releasedFund
                    )
                {
                    if($title){
                        $q->where('title','LIKE',"%".$title."%");
                    }
                    if($status){
                        $q->where('status', $status); 
                    }
                  
                    if($releasedFund || $releasedFund==="0"){
                        $q->where('fund_released', $releasedFund);
                    }
                   
                    if($userId){
                        $q->where('userId', $userId); 
                    }

                    if($categoryId){
                        $q->where('categoryId', $categoryId); 
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
                    if($search_locationType){
                        $q->where('locationType','like',"%$search_locationType%");
                    }
                    if($search_city){
                        $q->where('address','like',"%$search_city%");
                    }
                    //$budgetmax,$budgetmin,$budgetType,$locationType,$categoryId
                    
                    if($locationType){
                        $q->where('locationType','like',"%$locationType%");
                    }
                    if($budgetType){
                        $q->where('budgetType','like',"%$budgetType%");
                    }

                    if($budgetmax && $budgetmin){
                        $q->whereBetween('totalAmount',[$budgetmax,$budgetmin]);
                    }

                    if($search_totalAmount){
                        $search_totalAmountRange = explode('-', $search_totalAmount);
                        if(isset($search_totalAmountRange[1]) && $search_totalAmountRange[1]){
                          $q->whereBetween('totalAmount',$search_totalAmountRange);   
                        }else{
                         $q->where('totalAmount',$search_totalAmount);
                        }    
                    }
                     
                }); 

     
        if($limit){  
           $task = $tasks->take($limit)->orderBy('id', 'desc')->select('*',
                                            \DB::raw($this->sub_sql_offer_count),
                                            \DB::raw($this->sub_sql_comment_count),
                                            \DB::raw($this->sub_status)
                                        )->get()->toArray();  
        }
        elseif($page_number){   
            if($page_number>1){
                  $offset = $page_size*($page_num-1);
            }else{
                  $offset = 0;
            }  
            
            if($status){
            	$task =  $tasks->orderBy('id', 'desc')->skip($offset)->take($page_size)->select('*',
                                            \DB::raw($this->sub_sql_offer_count),
                                            \DB::raw($this->sub_sql_comment_count)
                                        )->get()->toArray();
            }else{

            	$task =  $tasks->orderBy('id', 'desc')->skip($offset)->take($page_size)->select('*',
                                            \DB::raw($this->sub_sql_offer_count),
                                            \DB::raw($this->sub_sql_comment_count),
                                            \DB::raw($this->sub_status)
                                        )->get()->toArray();
            } 
             
        }
        else{
           $task =  $tasks->take(20)->select('*',
                                            \DB::raw($this->sub_sql_offer_count),
                                            \DB::raw($this->sub_sql_comment_count),
                                            \DB::raw($this->sub_status)
                                        )->get()->toArray();
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
                    'total_record'  => count($data),
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

    public function getUserTasks(Request $request,$user_id)
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
        $t = Tasks::where('id',$id)->where('status','open')->delete();

        if($t){
            $delete_savetask = DB::table('saveTask')
                                ->where('taskId',$id)
                                    ->delete(); 

             return  response()->json([ 
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"Post deleted successfully.",
                    'data' => []
                   ]
                );
        }else{

        return  response()->json([ 
                    "status"=>0,
                    "code"=> 500,
                    "message"=>"You can't delete open task.",
                    'data' => []
                   ]
                );
        }


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

    public function commentDelete(Comments $comment, Request $request){
        $post_request = $request->all(); 
         //Server side valiation
        $id =  $request->get('id');
        $taskId =  $request->get('taskId');
        $userId =  $request->get('userId');
        
         

        $validator = Validator::make($request->all(), [
           'taskId' => 'required',
           'userId' => 'required',
           'id'     => 'required'
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

        Comments::where('taskId',$request->get('taskId'))
                    ->where('userId',$request->get('userId'))
                        ->where('id',$request->get('id'))
                            ->delete();

         return Response::json(array(
                'status' => 1,
                'code'=>200,
                'message' => 'Comment deleted successfully.',
                'data'  =>  []
                )
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
        if($comment){
            $notification = new Notification;
            $notification->addNotification('comment_add',$comment->id,$request->get('userId'),'Comment Added',$comment->commentDescription);

        }

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
        if($comment){
            $notification = new Notification;
            $userId  = isset($request['userId'])?$request['userId']:null;
            $notification->addNotification('comment_replied',$comment->id,$userId,'Comment replied',$comment->commentDescription);
        }
        $cid = isset($request['commentId'])?$request['commentId']:null;
        $comments = Comments::with('userDetail','commentReply')
                        ->where('id',$cid)
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

      public function taskCompleteFromDoer(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'taskId' => 'required',
            'taskDoerId'=>'required',
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
                    'data'  =>  $request->all()
                    )
                );
         }   

        $task =  Tasks::find($request->get('taskId'));
        if($task){
            $task   = Tasks::find($task->id);
            $task->taskDoerId = $request->get('taskDoerId');
            $task->status = $request->get('status');
            $task->save();
            $msg    = "Task completed successfully from doer";
        }else{
            $msg    = "Invalid input";
        }
        return  response()->json([ 
                "status"=>($task)?1:0,
                "code"=> ($task)?200:404,
                "message"=>$msg,
                'data' => $task
               ]
            ); 
    }
    /*
    taskCompleteFromPoster
    */
    public function taskCompleteFromPoster(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'taskId' => 'required',
            'taskPosterId'=>'required',
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
                    'data'  =>  $request->all()
                    )
                );
         }   

        $task =  Tasks::find($request->get('taskId')); 
        if($task){
            $task   = Tasks::find($task->id);
            $task->taskOwnerId = $request->get('taskPosterId');
            $task->status = $request->get('status');
            $task->save();
            $msg    = "Task completed successfully from poster";
        }else{
            $msg    = "Invalid input";
        }
        return  response()->json([ 
                "status"=>($task)?1:0,
                "code"=> ($task)?200:404,
                "message"=>$msg,
                'data' => $task
               ]
            ); 
    }
    /*
    getMyPendingOffers
    */
   public function getMyPendingOffers(Request $request)
    {
       $uid = $request->get('userId');
        $validator = Validator::make($request->all(), [
               'userId' => 'required',
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
    	  $offers = User::with(['offers_pending'=>function($q) use($uid)
                    {
                      $q->where('taskDoerId','!=',$uid);
                    }
                ])->where('id',$uid)
                        ->get();
                
    return  response()->json([ 
                "status"=>($offers->count())?1:0,
                "code"=> ($offers->count())?200:404,
                "message"=>($offers->count())?"All task list":"Record not found",
                'data' => $offers
               ]
            );

    }

    public function deleteOffer(Request $request)
    {

    	$offers = Offers::where('interestedUserId',$request->get('userId'))
    				->where('id',$request->get('offerId'))
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
            if ($id==null || !$id) {                
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
        if($data){
            $rs =  DB::table('offers')
                    ->where('id',$id) 
                            ->update($data);
        }
         
      /*  $offetData =  Tasks::with(['interestedUsers'=>function($q) use($request){
            $q->where('users.id',$request->get('interestedUserId'));
        }])->where('id',$request->get('taskId'))->get(); */


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
               'interestedUserId'=>'required',
               'offerPrice' => 'required'
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

        $is_savtask = DB::table('offers')
                        ->where('taskId',$request->get('taskId'))
                            ->where('interestedUserId',$request->get('interestedUserId'))
                                ->first(); 


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
        
        if($request->get('interestedUserId') == $request->get('assignUserId')){

                return Response::json(array(
                            'status' => 0,
                            'code'=>500,
                            'message' => "interested User and assigned user can't be same",
                            'data'  =>  $request->all()
                            )
                        );    
            }

       // $rs =  DB::table('offers')->insert($data); 

        if($is_savtask!=null && $task_action=='update'){

            $rs =  DB::table('offers')
                    ->where('id',$request->get('taskId'))
                        ->where('interestedUserId',$request->get('interestedUserId'))
                            ->update($data); 
            
        }else{

            $id =  DB::table('offers')->insertGetId($data); 
            $notification = new Notification;
            $notification->addNotification('offers_add',$id,$request->get('interestedUserId'),'Offer posted','');

        }

        $offetData =  Tasks::with(['interestedUsers'=>function($q) use($request){
            $q->where('users.id',$request->get('interestedUserId'));
        }])->where('id',$request->get('taskId'))->get(); 


        $msg = "Offer posted successfully.";

        if($task_action){
            $msg = "Offer updated successfully.";            
        }

        return Response::json(array(
                    'status' => 1,
                    'code'=>200,
                    'message' => $msg,
                    'data'  =>  $offetData
                    )
                );

    }

    public function taskOffer(Request $request, $taskId=null)
    {
      $offers =  Tasks::with('seekerUserDetail')->with(['offerDetails'=>function($q)use($taskId){
                        $q->where('taskId',$taskId);
                    }])->where('id',$taskId)->get(); 
 
      return  response()->json([ 
                    "status"=>($offers->count())?1:0,
                    "code"=> ($offers->count())?200:404,
                    "message"=>($offers->count())?"Task offer list":"Record not found",
                    'data' => $offers
                   ]
                );
    }
    /*getSaveTaskByUser*/
    public function getSaveTaskByUser(Request $request, $uid=null){
        
        $saveTask = User::with(['saveTask'=>function($q){
                            $q->whereDate('dueDate','<=',Carbon::today()->toDateString());
                            $q->where('status','open');
                        }])->where('id',$uid)
                            ->get();

        return  response()->json([ 
                    "status"=>($saveTask->count())?1:0,
                    "code"=> ($saveTask->count())?200:404,
                    "message"=>($saveTask->count())?"Saved offer list":"Record not found",
                    'data' => $saveTask
                   ]
                );
    }
    /*getSaveTask*/
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
               'taskId'     => 'required',
               'taskOwnerID'=>'required',
               'taskDoerID' => 'required',
               'status'     => 'required'
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

        if(isset($task->taskDoerId) && $task->taskDoerId!=null){
            return Response::json(array(
                    'status' => 0,
                    'code'=>500,
                    'message' => 'Task already assigned',
                    'data'  =>  $request->all()
                    )
                );
        }    

        $task   = Tasks::find($taskId);
            
        if($task){
            $task->taskOwnerId = $request->get('taskOwnerID');
            $task->taskDoerId  = $request->get('taskDoerID');
            $task->status      = $request->get('status'); 
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

    //
    public function getTask(Request $request, $uid=null)
    { 
        $action     =   $request->get('action');
        
        $data = [];
        switch ($action) {
            case 'saveTask':
                $data['save_task']  = User::with(['save_task'=>function($q) {
                                        $q->select('*',\DB::raw($this->sub_sql),
                                            \DB::raw($this->sub_sql_offer_count),
                                            \DB::raw($this->sub_sql_comment_count),
                                            \DB::raw($this->sub_status)
                                         )->orderBy('rank','DESC')
                                                ->orderBy('post_tasks.id','DESC');
                                        }])
                                            ->where('id',$uid)  
                                            ->get();  

                break;                  
            case 'offerAccepting':      
                  $data['offers_accepting'] = User::with(['offers_accepting'=>function($q) use($uid)
                        {               
                          $q->where('taskDoerId','=',$uid)
                                ->select('*',\DB::raw($this->sub_sql),
                                            \DB::raw($this->sub_sql_offer_count),
                                            \DB::raw($this->sub_sql_comment_count),
                                            \DB::raw($this->sub_status)
                                        )
                                     ->orderBy('rank','DESC')
                                     ->orderBy('post_tasks.id','DESC');
                        }               
                    ])->where('id',$uid)
                        ->get();        
                break;
                case 'offersAccepting':      
                  $data['offers_accepting'] = User::with(['offers_accepting'=>function($q) use($uid)
                        {               
                          $q->where('taskDoerId','=',$uid)
                                ->select('*',\DB::raw($this->sub_sql),
                                            \DB::raw($this->sub_sql_offer_count),
                                            \DB::raw($this->sub_sql_comment_count),
                                            \DB::raw($this->sub_status)
                                        )
                                     ->orderBy('rank','DESC')
                                     ->orderBy('post_tasks.id','DESC');
                        }               
                    ])->where('id',$uid)
                        ->get();        
                break;                  
            case 'offerPending':
                 $data['offers_pending'] = User::with(['offers_pending'=>function($q) use($uid)
                        {               
                          $q->where('userId','!=',$uid)
                           ->orWhere('userId',$uid)
                                    ->select('*',\DB::raw($this->sub_sql),
                                            \DB::raw($this->sub_sql_offer_count),
                                            \DB::raw($this->sub_sql_comment_count),
                                            \DB::raw($this->sub_status)
                                        )
                                     ->orderBy('rank','DESC')
                                     ->orderBy('post_tasks.id','DESC');

                        }
                    ])->where('id',$uid)
                        ->get();
                break;
            case 'postedTask':
               // dd($taskId);            
                $data['postedTask'] =  User::with(['postedTask'=>function($q)use($uid){          // $q->  
                                    $q->where('taskOwnerId',$uid)
                                  //  ->whereIn('id',$taskId)
                                    ->where('userId',$uid)
                                    ->select('*',\DB::raw($this->sub_sql),
                                            \DB::raw($this->sub_sql_offer_count),
                                            \DB::raw($this->sub_sql_comment_count),
                                            \DB::raw($this->sub_status)
                                        )
                                     ->orderBy('rank','DESC')
                                     ->orderBy('post_tasks.id','DESC');
                            }])->where('id',$uid)->get();
                break;
            
            default:
                
                return  response()->json([ 
                    "status" => 0,
                    "code"   => 404,
                    "message"=> "action not define",
                    'data'   => $data
                   ]
                );
                break;
        }


        
        return  response()->json([ 
                    "status"    =>  ($data)?1:0,
                    "code"      =>  ($data)?200:404,
                    "message"   =>  ($data)?"All task list":"Record not found",
                    'data'      =>  $data
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
        $blogId = $request->get('blogId'); 
        $blog_title = $request->get('blogTitle'); 
        $blog_type = $request->get('type');

        $category = $request->get('category');
        
        if($page_num>1){
            $offset = $page_size*($page_num-1);
        }else{
           $offset = 0;
        }  
        $data =  \DB::table('blogs')
                 ->Where(function ($query) use($blogId,$blog_title,$category,$blog_type){
                    if($blogId){
                        $query->where('id',$blogId);
                    }
                    if($category){
                        //$query->where(FIND_IN_SET($category, 'blog_category'));
                         $query->whereRaw("FIND_IN_SET($category,blog_category)");
                    }
                    
                    if($blog_type){
                        $query->where('blog_type','LIKE',"%$blog_type%");
                    }
                    
                    if($blog_title){
                        $query->where('blog_title','LIKE',"%$blog_title%");
                    }

                 })
                // ->where('id',21)
                ->orderBy('id', 'desc')
                ->skip($offset)
                ->take($page_size)
                ->get(); 

 
        $input = [];
        $arr=[];

        foreach ($data as $key => $value) {
            $input['id'] =  $value->id;
            $input['blog_title'] = $value->blog_title;
            $input['blog_sub_title'] = $value->blog_sub_title;
            $input['blog_type'] = $value->blog_type;
            $input['blog_description'] = $value->blog_description;
            $input['author'] = ($value->blog_created_by)?$value->blog_created_by:'Admin';
           
            
            if(\File::exists('storage/blog/'.$value->blog_image)){
                 $input['blog_image'] = !empty($value->blog_image)?url('storage/blog/'.$value->blog_image):null; 
            }else{
                 $input['blog_image'] = null; 
            } 

            $input['category_image_basepath'] = url('/storage/uploads/category/');
            $input['created_date'] = $value->created_at;

            $myCategoryIdArray = explode(',', $value->blog_category); 
            $category= [];
            if(count($myCategoryIdArray)){
                $url = url('/');
                $category = Category::whereIn('id',$myCategoryIdArray)->get();
            }
           $input['category'] = $category;

            $arr[] = $input;
            $input = [];
        } 
    
        $c = \DB::table('blogs');
        if($blogId){
        $c->where('id',$blogId);
        }
        if($blog_title){
         $c->where('blog_title','LIKE',"%$blog_title%");
        }

        $c = $c->get();

         return Response::json(array(
                    'status' => count($data)?1:0,
                    'total_record' => count($data),
                    'code'=>count($data)?200:404,
                    'message' => count($data)?'blogs found':'blog not found',
                    'data'  =>  ($arr)?$arr:$request->all()
                    )
                );

    }


    public function getFollowedTask(Request $request,$uid=null)
    {
         
        $myTask = Tasks::where('userId',$uid)->lists('id')->toArray();


        $myFollower =  User::with('followTaskDetail')
                    ->where('id',$uid)  
                    ->whereIn('taskId',$myTask)
                    ->get();

        $data['my_task_follower'] = $myFollower;

        $taskFollowed =  User::with('followTaskDetail')
                    ->whereNotIn('taskId',$myTask)
                    ->where('id',$uid) 
                    ->get();
       
       $toal_task_followed = \App\Models\FollowTask::whereNotIn('taskId',$myTask)
                            ->where('userId',$uid) 
                                ->get(); 


        $total_follower = \App\Models\FollowTask::whereIn('taskId',$myTask)
                                        ->get();


        $data['task_followed'] = $taskFollowed;

        if(count($total_follower)==0 || count($toal_task_followed)==0){
            $msg = "Follow Task not found";
            $code = 404;
            $status =0;
        }

         return Response::json(array(
                    'status' => isset($status)?:1,
                    'total_follower' => count($total_follower),
                    'toal_task_followed' =>(count($toal_task_followed)),
                    'code'=>isset($code)?:200,
                    'message' => isset($msg)?:'Task followed list',
                    'data'  =>  $data
                    )
                );       
    }


    public function followTask(Request $request)
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
    
        $data['taskId'] = $request->get('taskId');
        $data['userId'] = $request->get('userId');

        
        $isFollowed = DB::table('follow_tasks')->where($request->all())->get();         

        if($isFollowed){
            return Response::json(array(
                    'status' =>0,
                    'code'=>500,
                    'message' => 'Task already followed',
                    'data'  =>  []
                    )
                );             
        }

        $id =  DB::table('follow_tasks')->insertGetId($data); 

        return Response::json(array(
                    'status' =>1,
                    'code'=>200,
                    'message' => 'Task followed successfully',
                    'data'  =>  []
                    )
                ); 
        
    }

    public function reviewRating(Request $request){

        $validator = Validator::make($request->all(), [
               'taskId' => 'required'
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
    
               
        if($request->get('taskDoerId')==null && $request->get('posterUserId')==null){
            return Response::json(array(
                    'status' => 0,
                    'code'=>500,
                    'message' => "taskDoerId or posterUserId is required",
                    'data'  =>  $request->all()
                    )
                );
        }

        $table_cname = \Schema::getColumnListing('review');

        $except = ['id','created_at','updated_at','status','IsDoerFeedbackEntered','IsPosterFeedbackEntered'];

         
        $review = Reviews::firstOrNew(
                    [
                        'taskId'=> $request->get('taskId')
                    ]);  
        $review->IsDoerFeedbackEntered = "false"; 
        $review->IsPosterFeedbackEntered = "false";  

        $status = Reviews::where('taskId',$request->get('taskId'))->first();

        if($status){
            if($status->taskDoerId){
               $review->IsDoerFeedbackEntered = "true";   
            }
            if($status->posterUserId){
                $review->IsPosterFeedbackEntered = "true"; 
            }

            if($request->get('taskDoerId')){
                $review->IsDoerFeedbackEntered = "true";   
            }
            if($request->get('posterUserId')){
                $review->IsPosterFeedbackEntered = "true";   
            }
        }
       

        foreach ($table_cname as $key => $value) {
               
           if(in_array($value, $except )){
                continue;
           }  
            if($request->get($value)){
                $review->$value = $request->get($value);
           }

        } 
        $review->save();
        return Response::json(array(
                    'status' =>1,
                    'code'=>200,
                    'message' => 'Feedback submitted successfully',
                    'data'  =>  $request->all()
                    )
                ); 
    }

    //Get Review    
    public function getReview(Request $request, $userId=null)
    {
        $user = User::with('taskAsPoster')
                                    ->with('taskAsDoer')
                                    ->where('id',$userId)
                                    ->first();
        $user->completion_rate_doer  =0;
        $user->completion_rate_poster  =0;
                

        return Response::json(array(
                'status' => ($user)?1:0,
                'code' => ($user)?200:500,
                'message' => ($user)?'Review found':'Record not found!',
                'data'  =>  $user
                )
            ); 
    }

    public function getTransaction(Request $request, $tid=null)
    {
        $order = \App\Order::with('userDetails','taskDetails')->where('transaction_id',$tid)
                    ->select('*',\DB::raw($this->trns_status),\DB::raw('DATE_FORMAT(created_at,"%m-%d-%Y") as order_date,DATE_FORMAT(created_at,"%h:%i:%s %p") as order_time'  ) )->get();
        
        return Response::json(array(
                'status' => ($order)?1:0,
                'code' => ($order)?200:500,
                'message' => ($order)?'Transaction details!':'record not found',
                'data'  =>  $order
                )
            ); 
    }

    public function getPortfolioImage(Request $request){

        $validator = Validator::make($request->all(), [
               'userId' => 'required', 

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

        $result = Portfolio::where('userId',$request->get('userId'))->get();
        $arr  = [];
        $data = [];
        foreach ($result as $key => $value) {

            $data['imageId'] = $value->id;
            $data['userId'] = $value->userId;
            $data['taskId'] = $value->taskId;
            $data['images'] = url($value->images);

            $arr[] =  $data;
               
        }
        
        return Response::json(array(
                'status' => count($result)?1:0,
                'code' => count($result)?200:500,
                'message' => count($result)?'Portfolio Image found':'Record not found',
                'data'  =>  $arr
                )
            );

    }

    public function deletePortfolioImage(Request $request){

        $validator = Validator::make($request->all(), [
               'imageId' => 'required',
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

        $result = Portfolio::where('id',$request->get('imageId'))->where('userId',$request->get('userId'))->delete();

        return Response::json(array(
                'status' => ($result)?1:0,
                'code' => ($result)?200:500,
                'message' => ($result)?'Portfolio Image deleted':'record not found',
                'data'  =>  $result
                )
            ); 
    }

    public function updatePortfolioImage(Request $request){
        $validator = Validator::make($request->all(), [
               'imageId' => 'required',
               'image' => 'required'

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

        $result = Portfolio::find($request->get('imageId'));
         
        $table_cname = \Schema::getColumnListing('portfolio');
        $except = ['id','created_at','updated_at','image'];
        
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
            if($request->get($value)){
                $result->$value = $request->get($value);
           }
        }
        
        if($request->get('image')){  ;
            $profile_image = $this->createImage($request->get('image')); 
            if($profile_image==false){
                return Response::json(array(
                    'status' => 0,
                     'code' => 500,
                    'message' => 'Invalid Image format!',
                    'data'  =>  $request->all()
                    )
                );
            }
            $result->images  = $profile_image;       
        }        
           

        try{
            $result->save();
            $status = 1;
            $code  = 200;
            $message ="Portfolio Images updated successfully";
        }catch(\Exception $e){
            $status = 0;
            $code  = 500;
            $message =$e->getMessage();
        }
         
        return response()->json(
                            [ 
                            "status" =>$status,
                            'code'   => $code,
                            "message"=> $message,
                            'data'=>isset($result)?$result:[]
                            ]
                        );
    }

    public function uploadPortfolioImage(Request $request){

        $validator = Validator::make($request->all(), [
               //'taskId' => 'required',
               'userId' => 'required',
               'image' => 'required'

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

        $result = new Portfolio;
         
        $table_cname = \Schema::getColumnListing('portfolio');
        $except = ['id','created_at','updated_at','image'];
        
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
            if($request->get($value)){
                $result->$value = $request->get($value);
           }
        }
        
        if($request->get('image')){  ;
            $profile_image = $this->createImage($request->get('image')); 
            if($profile_image==false){
                return Response::json(array(
                    'status' => 0,
                     'code' => 500,
                    'message' => 'Invalid Image format!',
                    'data'  =>  $request->all()
                    )
                );
            }
            $result->images  = $profile_image;       
        }        
           

        try{
            $result->save();
            $status = 1;
            $code  = 200;
            $message ="Portfolio Images uploaded successfully";
        }catch(\Exception $e){
            $status = 0;
            $code  = 500;
            $message =$e->getMessage();
        }
         
        return response()->json(
                            [ 
                            "status" =>$status,
                            'code'   => $code,
                            "message"=> $message,
                            'data'=>isset($result)?$result:[]
                            ]
                        );
    }
    // 
    public function userDashboard(Request $request,$uid=0){
        $user =  User::where('id',$uid)->first();

        $u = User::where('id',$uid)->first(['first_name','last_name','about_me','profile_image','tagLine','location','email','role_type','birthday'])->toArray();
        $count=0;
        foreach ($u as $key => $value) {
            $col[] = $key;
             if($value===null){
                ++$count;
             }
        } 
        
        $user->profile_completion  = intval(((9-$count)/9)*100).'%';

        $u = User::where('id',$uid)->first(['skills','language','qualification','workExperience'])->toArray();

        $count=0;
        foreach ($u as $key => $value) {
            $col[] = $key;
             if($value===null){
                ++$count;
             }
        }  

        $user->skill_completion  = intval(((4-$count)/4)*100).'%'; 
        $user->badges = "0%";
  
        try{
            $data = $user; 
            $arr_doer['posted_offers'] = \DB::table('offers')->where('assignUserId',$uid)->count();

            $arr_doer['assigned']   =  \DB::table('post_tasks')->where('taskDoerId',$uid)->where('status','assigned')->count();
            $arr_doer['awaitingPayment']   = \DB::table('post_tasks')->where('taskDoerId',$uid)->where('status','completed')->count();
            $arr_doer['completed '] =  \DB::table('post_tasks')->where('taskDoerId',$uid)->where('status','closed')->count();
            

          //  $data->as_doer = $arr_doer;

            $arr_poster['posted_offers'] = \DB::table('offers')->where('interestedUserId',$uid)->count();

            $arr_poster['assigned']   = \DB::table('post_tasks')->where('userId',$uid)->where('status','assigned')->count();
            $arr_poster['completed_from_doer']    = \DB::table('post_tasks')->where('userId',$uid)->where('status','completed')->count();
            $arr_poster['closed'] =  \DB::table('post_tasks')->where('userId',$uid)->where('status','closed')->count();
            $arr_poster['reopen']  = \DB::table('post_tasks')->where('userId',$uid)->where('status','reopen')->count();  

            $data->user_Task_Summary = ['as_doer'=>$arr_doer,'as_poster'=>$arr_poster];

            $status = 1;
            $code  = 200;
            $message   = "User dashboard data";

        }catch(\Exception $e){
            $status = 0;
            $code  = 500;
            $message   = "user does not exit";

         }
         
           return response()->json(
                            [ 
                            "status" =>$status,
                            'code'   => $code,
                            "message"=> $message,
                            'data'=>isset($data)?$data:[]
                            ]
                        );   
    }

    public function createImage($base64)
    {
        try{
            $img  = explode(',',$base64);
            if(is_array($img) && isset($img[1])){
                $image = base64_decode($img[1]);
                $image_name= time().'.jpg';
                $path = storage_path() . "/image/" . $image_name;
              
                file_put_contents($path, $image); 
                return 'storage/image/'.$image_name;
            }else{
                return false; 
            }

            
        }catch(Exception $e){
            return false;
        }
        
    }

}