<?php
namespace Modules\Admin\Http\Controllers;

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
        $this->middleware('admin');
        View::share('viewPage', 'course');
        View::share('helper',new Helper);
        $this->record_per_page = Config::get('app.record_per_page');
    }

    protected $users;

    /*
     * Dashboard
     * */

    public function index(Course $course, Request $request) 
    { 
        $page_title = 'Course';
        $page_action = 'View Course'; 
        if ($request->ajax()) {
            $id = $request->get('id');
            $status = $request->get('status');
            $user = Course::find($id);
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
               
            $course = Course::where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('course_name', 'LIKE', "%$search%");
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $course = Course::orderBy('id','desc')->Paginate($this->record_per_page);
            
        } 
        return view('packages::course.index', compact('status','course', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(Course $course) 
    {
        $page_title     =   'Course';
        $page_action    =   'Create Course';
        $users           =   User::where('role_type',1)->get();
        return view('packages::course.create', compact('users','course', 'page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(CourseRequest $request, Course $course) 
    { 
           
        $course->fill(Input::all());
        $course->save();
        
        return Redirect::to(route('course'))
                            ->with('flash_alert_notice', 'New Course was successfully created !');
        }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(Course $course) {

        $page_title = 'Course';
        $page_action = 'Show Course';
        $users           =   User::all();
        return view('packages::course.edit', compact('course','users', 'page_title', 'page_action'));
    }

    public function update(Request $request, Course $course) 
    {
        $course->fill(Input::all()); 
        $course->save();
        return Redirect::to(route('course'))
                        ->with('flash_alert_notice', 'Course was  successfully updated !');
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
