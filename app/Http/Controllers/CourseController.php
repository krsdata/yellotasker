<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CourseRequest as CourseRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Course;
use Input;
use Validator;
use Auth;
use Paginate;
use Grids;
use HTML;
use Form;
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
use App\Helpers\Helper; 
use App\ProfessorProfile;
use App\StudentProfile;
 


/**
 * Class AdminController
 */
class CourseController extends Controller {
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

    protected $course;

    /*
     * Dashboard
     * */

    public function index(Course $course, Request $request) 
    { 
     
        // Search by name ,email and group
        $course_name = Input::get('course_name');
        $professor_id = Input::get('professor_id');
        if ((isset($course_name) && !empty($course_name)) OR  (isset($professor_id) && !empty($professor_id)) ) {

            $search = isset($search) ? Input::get('search') : '';
               
            $course = Course::where(function($query) use($course_name,$professor_id) {
                        if (!empty($course_name)) {
                            $query->Where('course_name', 'LIKE', "%$course_name%");
                        }
                        if (!empty($professor_id)) {
                            $query->Where('professor_id', '=', "$professor_id");
                        }
                        
                    })->get();
            $status  =  1;
            $code    =  200;
            $message =  "Course list !"; 
            if($course->count()==0){
                $status  =  0;
                $code    =  404;
                $message =  "Course record not found!"; 
             }
        } else {
            $course = Course::orderBy('id','desc')->get();
            $status  =  1;
            $code    =  200;
            $message =  "Course list !"; 

             if($course->count()==0){
                $status  =  0;
                $code    =  404;
                $message =  "Course record not found!"; 
             }
            
        } 
       
        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$course
                            ]
                        );
    }

    /*
     * create Group method
     * */

    public function create(Request $request, Course $course) 
    {
        if($request->get('professor_id'))
        {
            $users  =   User::where('role_type',1)->where('id',$request->get('professor_id'))->get();
            
        }else{
           $users  =   User::where('role_type',1)->get(['id as professor_id','name']);
        }
        
        if($users){
            $status  =  1;
            $code    =  200;
            $message =  "Professor list !"; 
        }else{
            $status  =  0;
            $code    =  500;
            $message =  "There is no professor exist!"; 
        }
       
        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>['professor'=>$users]
                            ]
                        );
    }

    /*
     * Save Group method
     * */

    public function store(Request $request, Course $course) 
    { 
        
        //Server side valiation
        $validator = Validator::make($request->all(), [

           'course_name' => 'required', 
           'professor_id' => 'required',
           'session_id' => 'required'

        ]);

         /** Return Error Message **/
        if ($validator->fails()) {
                    $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return response()->json(array(
                'status' => 0,
                'code'   => 500,
                'message' => $error_msg[0],
                'data'  =>  $request->all()
                )
            );
        }   

        $course->fill(Input::all()); 
        $course->save(); 
        if($course){
            $status  =  1;
            $code    =  200;
            $message =  "New Course was successfully created."; 
        }else{
            $status  =  0;
            $code    =  500;
            $message =  "Something went wrong!"; 
        }
       
        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$course
                            ]
                        );

        }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(Request $request,Course $course) {

       if($request->get('course_id'))
        {
            $course  =   Course::where('id',$request->get('course_id'))->get(['id as course_id','professor_id','course_name','session_id','general_info']);
            
            if($course->count()){
                    $status  =  1;
                    $code    =  200;
                    $message =  "Course found."; 
            }else{
                $status  =  0;
                $code    =  400;
                $message =  "Course ID  not found!";   
            } 
        }else{
            $status  =  0;
            $code    =  500;
            $message =  "Invalid course ID!"; 
        }  
        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$course
                            ]
                        );
    }

    public function update(Request $request, Course $course) 
    {
        $validator = Validator::make($request->all(), [
           'course_id'  =>  'required',
           'course_name' => 'required',
           'session_id' => 'required'

        ]);

         /** Return Error Message **/
        if ($validator->fails()) {
                    $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return response()->json(array(
                'status' => 0,
                'code'   => 500,
                'message' => $error_msg[0],
                'data'  =>  $request->all()
                )
            );
        }   

        $course->fill(Input::all()); 
        $course->save(); 

        if($course){
            $status  =  1;
            $code    =  200;
            $message =  " Course was successfully updated."; 
        }else{
            $status  =  0;
            $code    =  500;
            $message =  "Something went wrong!"; 
        }
       
        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$course
                            ]
                        );
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Course $course) {
        
        Course::where('id',$course->id)->delete();

        return Redirect::to(route('course'))
                        ->with('flash_alert_notice', 'Course was successfully deleted!');
    }

    public function show(Course $course) {
        
    }

}
