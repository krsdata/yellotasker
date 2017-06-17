<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\SyllabusRequest;
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
use Modules\Admin\Models\Syllabus;
use Modules\Admin\Models\Assignment;
 


/**
 * Class AdminController
 */
class SyllabusController extends Controller {
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

    protected $syllabus;

    /*
     * Dashboard
     * */

    public function index(Syllabus $syllabus, Request $request) 
    { 
        
        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');
        if ((isset($search) && !empty($search)) OR  (isset($status) && !empty($status)) ) {

            $search = isset($search) ? Input::get('search') : '';
               
            $syllabus = Syllabus::with('course')->where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('syllabus_title', 'LIKE', "%$search%");
                        }
                        
                    })->get();
            $status  =  1;
            $code    =  200;
            $message =  "Course list !"; 
            if($syllabus->count()==0){
                $status  =  0;
                $code    =  404;
                $message =  "syllabus record not found!"; 
             }

        } else {
            $syllabus = Syllabus::with('course')->orderBy('id','desc')->get();
            $status  =  1;
            $code    =  200;
            $message =  "syllabus list !"; 

             if($syllabus->count()==0){
                $status  =  0;
                $code    =  404;
                $message =  "syllabus record not found!"; 
             } 
        } 

          return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$syllabus
                            ]
                        );

         
    }

    /*
     * create Group method
     * */

    public function create(Syllabus $syllabus) 
    { 
        $course     =   Course::get(['id as course_id','course_name']);

        if($course->count()>0){
            $status  =  1;
            $code    =  200;
            $message =  "Course list !"; 
        }else{
            $status  =  0;
            $code    =  500;
            $message =  "There is no Course.Please add course first"; 
        }

        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>['course'=>$course]
                            ]
                        );
    }

    /*
     * Save Group method
     * */

    public function store(Request $request, Syllabus $syllabus) 
    { 
            
         //Server side valiation
        $validator = Validator::make($request->all(), [

           'syllabus_title' => 'required', 
           'syllabus_description' => 'required',
           'course_id' => 'required',
           'grade_weight' => 'required'

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
 
        $syllabus->fill(Input::all());
        $syllabus->save();

         $syllabus = Syllabus::with('course')->where(function($query) use($request,$syllabus)  {
                            $query->Where('course_id',$request->get('course_id'));
                            $query->Where('id',$syllabus->id);
                    })->get(); 


        if($syllabus){
            $status  =  1;
            $code    =  200;
            $message =  "New Syllabus was successfully created."; 
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
                            'data'=>$syllabus
                            ]
                        );
        
        
    }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(Request $request, Syllabus $syllabus) {

          //Server side valiation
        $validator = Validator::make($request->all(), [
 
           'syllabus_id' => 'required', 

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
        $syllabus = Syllabus::with('course')->where(function($query) use($request,$syllabus)  {
                            $query->Where('id',$request->get('syllabus_id'));
                    })->get(); 

        if($syllabus->count()>0){
            $status  =  1;
            $code    =  200;
            $message =  "syllabus details !"; 
        }else{
            $status  =  0;
            $code    =  500;
            $message =  "Invalid Syllabus id!"; 
        }

        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$syllabus
                            ]
                        );


    }

    public function update(SyllabusRequest $request, Course $syllabus) 
    {
          //Server side valiation
        $validator = Validator::make($request->all(), [

           'syllabus_title' => 'required', 
           'syllabus_description' => 'required',
           'syllabus_id' => 'required', 
           'grade_weight' => 'required'

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
 
        $syllabus->fill(Input::all());
        $syllabus->save();

         $syllabus = Syllabus::with('course')->where(function($query) use($request,$syllabus)  {
                            $query->Where('id',$syllabus->id);
                    })->get(); 


        if($syllabus){
            $status  =  1;
            $code    =  200;
            $message =  "Syllabus was successfully updated."; 
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
                            'data'=>$syllabus
                            ]
                        ); 
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Request $request ,Syllabus $syllabus) 
    { 
         $validator = Validator::make($request->all(), [
 
           'syllabus_id' => 'required', 

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
        $syllabus = Syllabus::where('id',$request->get('syllabus_id'))->delete(); 
        if($syllabus){
            $status  =  1;
            $code    =  200;
            $message =  "Syllabus was successfully deleted."; 
        }else{
            $status  =  0;
            $code    =  500;
            $message =  "Syllabus already deleted!"; 
        }
       
        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$syllabus
                            ]
                        );   

    }
    public function cloneSyllabus(Request $request , Syllabus $syllabus)
    {
         $validator = Validator::make($request->all(), [
                'syllabus_id' => 'required|exists:syllabus,id'
                ]
            );

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
        }else{
            $syllabus = Syllabus::with('assignment')->where('id',$request->get('syllabus_id'))->first();
            
            $syllabus_clone         = new Syllabus;
            $syllabus_clone_count   = 0;
            $assignment_clone_count = 0;

                foreach ($syllabus->getattributes() as $key => $value) {
                    $feild = $key;
                    switch ($feild) {
                        case 'id':
                            # code...
                            break;
                        case 'created_at':
                            # code...
                            break;
                        case 'updated_at':
                            # code...
                            break;
                        
                        default:
                           $syllabus_clone->$key = $value;
                           break;
                    } 
                }
                $syllabus_clone_result = $syllabus_clone->save();
                if($syllabus_clone_result){
                    ++$syllabus_clone_count;
                    $syllabus_id = $syllabus_clone->id;
                   
                    foreach ($syllabus->assignment as $key => $sa) {

                        $assignment_clone = new Assignment;    
                        foreach ($sa->getattributes() as $key => $value) {
                            $feild = $key;
                            switch ($feild) {
                                case 'id':
                                    # code...
                                    break;
                                case 'created_at':
                                    # code...
                                    break;
                                case 'updated_at':
                                    # code...
                                    break;
                                
                                default:
                                   $assignment_clone->$key = $value;
                                    break;
                            }
                        }
                        $assignment_clone->syllabus_id = $syllabus_id;
                        $result =  $assignment_clone->save();
                   }
                }
                $syllabus       =   [];
                if($syllabus_clone_count>0)
                {
                    $syllabus    =   $syllabus = Syllabus::with('assignment')->where('id',$syllabus_id)->first();
                    $code        =   200;
                    $status      =   1;
                    $message     =   "Syllabus Clone successfully created."; 
                   
                }else{
                   $code        =   500;
                   $status      =   0;
                   $message     =   "Syllabus Clone is not created.";
                }
        }
                return response()->json(
                            [ 
                                "status"    =>  $status,
                                'code'      =>  $code,
                                "message"   =>  $message,
                                'data'      =>  $syllabus
                            ]
                        ); 
            
    }
    public function show(Request $request , Syllabus $syllabus) {
       
        $validator = Validator::make($request->all(), [
 
           'syllabus_id' => 'required', 

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
        $syllabus = Syllabus::with('course')->where(function($query) use($request,$syllabus)  {
                            $query->Where('id',$request->get('syllabus_id'));
                    })->get(); 

        if($syllabus->count()>0){
            $status  =  1;
            $code    =  200;
            $message =  "syllabus details !"; 
        }else{
            $status  =  0;
            $code    =  500;
            $message =  "Invalid Syllabus id!"; 
        }

        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$syllabus
                            ]
                        );
    }

}
