<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\AssignmentRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Assignment;
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
use Modules\Admin\Models\Course;
use Modules\Admin\Models\Syllabus;
 

/**
 * Class AdminController
 */
class AssignmentController extends Controller {
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
    /*
     * Assignment
     * */
    public function index(Assignment $assignment, Request $request) 
    { 
        $search         = Input::get('search');
        $professor_id   = $request->get('professor_id');
        $syllabus_id    = $request->get('syllabus_id');
        $course_id      = $request->get('course_id');

        $assignment = Assignment::with('course','professor','syllabus')->whereHas('syllabus',function($query) use($course_id,$search,$syllabus_id,$professor_id) {
                    if (!empty($search)) {
                        $query->Where('paper_title', 'LIKE', "%$search%")
                                ->OrWhere('chapter', 'LIKE', "%$search%");
                    }
                     if (!empty($syllabus_id)) {
                        $query->Where('syllabus_id',$syllabus_id);
                    }
                    if (!empty($professor_id)) {
                        $query->Where('professor_id', $professor_id)->where('role_type',1);
                    }
                    if (!empty($course_id)) {
                        $query->Where('course_id', $course_id);
                    }  
                }
            )->get(); 

        if($assignment->count()>0){
            $status  =  1;
            $code    =  200;
            $message =  "All created Assignment lists found."; 
        }else{
            $status  =  0;
            $code    =  404;
            $message =  "Assignment not found!";; 
        }
        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$assignment
                            ]
                        );


    }

    /*
     * create  method
     * */

    public function create(Request $request ,Assignment $assignment) 
    {
        $professor_id   =   $request->get('professor_id');
        $course_id      =   Course::where(function($q)use($professor_id){
                                if(!empty($professor_id)){
                                    $q->where('professor_id',$professor_id);  
                                }
                                
                        })->get(['id'])->toArray();
       
        $syllabus = Syllabus::with('course')->where(function($q)use($professor_id,$course_id){
                    if(count($course_id )>0){
                      $q->whereIn('course_id',$course_id);
                    }
                })->get(['id','syllabus_title']);
        $data = [];
        foreach ($syllabus as $key => $result) {
            $data[] = ['id'=>$result->id,'syllabus_title'=>$result->syllabus_title];
        }

        if(count($data)>0){
            $status  =  1;
            $code    =  200;
            $message =  "Syllabus lists."; 
        }else{
            $status  =  0;
            $code    =  404;
            $message =  "Syllabus not found. Please create syllabus!"; 
        }

         return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$data
                            ]
                        );
       
    }

    /*
     * Save Group method
     * */

    public function store(Request $request, Assignment $assignment) 
    {
        $validator = Validator::make($request->all(), [

           'syllabus_id' => 'required', 
           'paper_title' => 'required',
           'duration' => 'required',
           'chapter' => 'required',
           'description' => 'required',
           'marks' => 'required',
           'due_date' => 'required'

        ]);

         /** Return Error Message **/
        if ($validator->fails()) {
                    $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
           /*  foreach ( $validator->messages()->messages() as $key => $value) {
                        $error_msg[$key]  = $value[0];
                    }  */      
                            
            return response()->json(array(
                'status' => 0,
                'code'   => 500,
                'message' => $error_msg[0],
                'data'  =>  $request->all()
                )
            );
        }   


        $sys =  Syllabus::with('course')->where('id',$request->get('syllabus_id')) ->first();
        if($sys){
            $course_id = $sys->course->id;
            $professor_id = $sys->course->professor_id;

            $assignment->fill(Input::all()); 
            $assignment->professor_id = $professor_id;
            $assignment->course_id = $course_id;
            $assignment->save();

            $status  =  1;
            $code    =  200;
            $message =  "Assignment successfully created."; 

        }else{

            $status  =  0;
            $code    =  404;
            $message =  "Syllabus id does not exit!"; 
            $assignment = [];
        }
        
        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$assignment
                            ]
                        );
        
    }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(Request $request ,Assignment $assignment) 
    {
 
        $assignment =   Assignment::find($request->get('assignment_id')); 
        $data       =   [];
        if($assignment->count()>0){ 
            $professor_id   =   $assignment->professor_id;
            $course_id      =   Course::where(function($q)use($professor_id){
                                    if(!empty($professor_id)){
                                        $q->where('professor_id',$professor_id);  
                                    }
                            })->get(['id'])->toArray();
           
            $syllabus = Syllabus::with('course')->where(function($q)use($professor_id,$course_id){
                        if(count($course_id )>0){
                          $q->whereIn('course_id',$course_id);
                        }
                    })->get(['id','syllabus_title']);

            $data = [];
            foreach ($syllabus as $key => $result) {
                $data[] = ['id'=>$result->id,'syllabus_title'=>$result->syllabus_title];
            }


            $status  =  1;
            $code    =  200;
            $message =  "Result found."; 
        }else{
            $status  =  0;
            $code    =  404;
            $message =  "Result not found or invalid assignment ID"; 
        }


        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'syllabus' =>$data,
                            'data'=>$assignment
                            ]
                        );
   
    }

    public function update(Request $request, Assignment $assignment) {
        
        $validator = Validator::make($request->all(), [
            'assignment_id' => 'required',
            'paper_title' => 'required',
            'duration' => 'required',
            'chapter' => 'required',
            'description' => 'required',
            'marks' => 'required',
            'due_date' => 'required'
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

        $assignment =   Assignment::find($request->get('assignment_id')); 
        if($assignment){

            $course_id = $assignment->course_id;
            $professor_id = $assignment->professor_id;
            $assignment->fill(Input::all()); 
            $assignment->professor_id = $professor_id;
            $assignment->course_id = $course_id;
            $assignment->save();

            $status  =  1;
            $code    =  200;
            $message =  "Assignment successfully updated."; 

        }else{

            $status  =  0;
            $code    =  404;
            $message =  "Assignment id does not exit!"; 
            $assignment = [];
        }  
        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$assignment
                            ]
                        );
    }
/****
    * delete assignment record by assignment ID
    * request : json
    * return : json
    * @method : destroy
    * @param : assignment_id
    */
    public function destroy(Request $request, Assignment $assignment) {
       $result = Assignment::where('id',$request->get('assignment_id'))->delete();
      
       if($result){
            $status  =  1;
            $code    =  200;
            $message =  "Assignment successfully deleted."; 
       }else{
            $status  =  0;
            $code    =  500;
            $message =  "Assignment already deleted!";; 
       }
 

        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$request->all()
                            ]
                        );
    }
/****
    * Show assignment record by assignment ID
    * request : json
    * return : json
    * @method : show
    */
    public function show(Request $request, Assignment $assignment) {
        
       $result = Assignment::with('syllabus','course','professor')->where('id',$request->get('assignment_id'))->get();
        
       if($result){
            $status  =  1;
            $code    =  200;
            $message =  "Assignment found."; 
       }else{
            $status  =  0;
            $code    =  404;
            $message =  "Assignment not found!";; 
       }
        return response()->json(
                            [ 
                            "status"=>$status,
                            'code'   => $code,
                            "message"=>$message,
                            'data'=>$result
                            ]
                        );
    }

}
