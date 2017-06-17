<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\AssignmentRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Assignment;
use Modules\Admin\Models\Syllabus;
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
        $this->middleware('admin');
        View::share('viewPage', 'assignment');
        View::share('helper',new Helper);
        $this->record_per_page = Config::get('app.record_per_page');
    }
  

    /*
     * Dashboard
     * */

    public function index(Assignment $assignment, Request $request) 
    { 
        $page_title = 'Assignment';
        $page_action = 'View Assignment'; 
        if ($request->ajax()) {
            $id = $request->get('id');
            $status = $request->get('status');
            $user = User::find($id);
            $s = ($status == 1) ? $status = 0 : $status = 1;
            $user->status = $s;
            $user->save();
            echo $s;
            exit();
        }
        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');
        if ((isset($search) && !empty($search)) OR  (isset($status) && !empty($status)) ) {

            $search = isset($search) ? Input::get('search') : '';
               
            $assignment = Assignment::with('user')->with('course')->where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('name', 'LIKE', "%$search%")
                                    ->OrWhere('email', 'LIKE', "%$search%");
                        } 
                    })->Paginate($this->record_per_page);
        } else {
            $assignment = Assignment::with('user')->with('course')->orderBy('id','desc')->Paginate($this->record_per_page);
            
        } 

        return view('packages::assignment.index', compact('assignment','status','users', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(Assignment $assignment) 
    {
        $page_title     =   'Assignment';
        $page_action    =   'Create Assignment';
        $users          =   User::where('role_type',1)->get();
        $course         =   Course::all();
        $syllabus       =   Syllabus::all();

        $syl    = Syllabus::with('course')->get();
        $syllabi = [];
        foreach ($syl as $key => $value) {
             $syllabi[$value->course->course_name][$value->id] = ucfirst($value->syllabus_title);
        }
         
        return view('packages::assignment.create', compact('syllabi','syllabus','assignment','users','course', 'page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(AssignmentRequest $request, Assignment $assignment) 
    {
         
        $sid =  Syllabus::with('course')->where('id',$request->get('syllabus_id'))->first(); 
        $assignment->fill(Input::all()); 
        $assignment->professor_id = $sid->course->professor_id; 
        $assignment->course_id = $sid->course_id;
        $assignment->save(); 
        return Redirect::to(route('assignment'))
                            ->with('flash_alert_notice', 'New user was successfully created !');
        }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(Assignment $assignment) {

        $page_title     = 'Assignment';
        $page_action    = 'Show Assignment';
        $users          =   User::where('role_type',1)->get();
        $course         =   Course::all();
        $syllabus       =   Syllabus::all();
        $syl    = Syllabus::with('course')->get();
        $syllabi = [];
        foreach ($syl as $key => $value) {
             $syllabi[$value->course->course_name][$value->id] =ucfirst($value->syllabus_title);
        }
        
        return view('packages::assignment.edit', compact('syllabi','syllabus','assignment','users','course', 'page_title', 'page_action'));
   
    }

    public function update(Request $request, Assignment $assignment) {
        
        $assignment->fill(Input::all());
        $assignment->save();
        return Redirect::to(route('assignment'))
                        ->with('flash_alert_notice', 'Assignment was  successfully updated !');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Assignment $assignment) {
        Assignment::where('id',$assignment->id)->delete();
        return Redirect::to(route('assignment'))
                        ->with('flash_alert_notice', 'Assignment was successfully deleted!');
    }

    public function show(Assignment $assignment) {
        
    }

}
