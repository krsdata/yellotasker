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

        
        if (!empty($post_request)) 
        {
            if ($request->get('user_id')) {

                $user_id = $request->get('user_id');
                $user_data = User::find($user_id);
                if (empty($user_data)) {
                    return
                        [ 
                        "status"  => '0',
                        'code'    => '200',
                        "message" => 'No match found for the given user id.',
                        'data'    => []
                        ];
                    
                } else {
                  
                        $task = new Tasks;

                        $task->title = $request->get('title');
                        $task->description = $request->get('description');
                        $task->user_id = $request->get('user_id');
                        $date = $request->get('due_date');
                        $task->people_required = $request->get('people_required');
                        $due_date = $request->get('due_date'); //Carbon::createFromFormat('m/d/Y', $date);
                        $task->due_date = $due_date;
                        $task->budget = $request->get('budget');
                        $task->budget_type = $request->get('budget_type');
                        $task->save();

                        $status  = 1;
                        $code    = 200;
                        $message = 'Task  successfully inserted.';
                        $data    = $task; 
                }
            } else {
                 $status  = 0;
                $code    = 400;
                $message = 'Unable to add task, user id field is empty.';
                $data    = [];
            }  
        } else {
            $status  = 0;
            $code    = 400;
            $message = 'Unable to add task, no post data found.';
            $data    = [];
        }
        return 
                            [ 
                            "status"  =>$status,
                            'code'    => $code,
                            "message" =>$message,
                            'data'    => $data
                            ];
                       

    }

    public function getAllTasks(){
        $tasks = Tasks::all();

        if(count($tasks)){
            $status  =  1;
            $code    =  200;
            $message =  "List of all tasks.";
            $data    =  $tasks;
        } else {
            $status  =  0;
            $code    =  204;
            $message =  "No tasks found.";
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

    // status '0'=>'open','1'=>'completed','2'=>'in-progress'
    public function getRecentTasks(){
        $tasks = Tasks::where('status', 1)
               ->orderBy('id', 'desc')
               ->take(8)
               ->get();

        if(count($tasks)){
            $status  =  1;
            $code    =  200;
            $message =  "List of recently completed tasks.";
            $data    =  $tasks;
        } else {
            $status  =  0;
            $code    =  204;
            $message =  "No tasks found.";
            $data    =  [];
        }

        return      [ 
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
}