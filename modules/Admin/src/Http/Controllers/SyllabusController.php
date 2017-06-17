<?php
namespace Modules\Admin\Http\Controllers;

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
        $this->middleware('admin');
        View::share('viewPage', 'Syllabus');
        View::share('helper',new Helper);
        $this->record_per_page = Config::get('app.record_per_page');
    }

    protected $syllabus;
 
    /*
     * Dashboard
     * */

    public function index(Syllabus $syllabus, Request $request) 
    { 
        $page_title = 'Syllabus';
        $page_action = 'View Syllabus'; 
        if ($request->ajax()) {
            $id = $request->get('id');
            $status = $request->get('status');
            $user = Syllabus::find($id);
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
               
            $syllabus = Syllabus::with('course')->where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('syllabus_title', 'LIKE', "%$search%");
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $syllabus = Syllabus::with('course')->orderBy('id','desc')->Paginate($this->record_per_page);
            
        } 
        return view('packages::syllabus.index', compact('status','syllabus', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(Syllabus $syllabus) 
    {
        $page_title     =   'Syllabus';
        $page_action    =   'Create Syllabus';
        $course         =   Course::all();
        return view('packages::syllabus.create', compact('syllabus','course', 'page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(SyllabusRequest $request, Syllabus $syllabus) 
    { 
              
        $syllabus->fill(Input::all());
        $syllabus->save();
        
        return Redirect::to(route('syllabus'))
                            ->with('flash_alert_notice', 'New syllabus was successfully created !');
        }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(Syllabus $syllabus) { 

        $page_title  = 'Syllabus';
        $page_action = 'Show Syllabus';
        $course      =   Course::all();
        
        return view('packages::syllabus.edit', compact('course','syllabus', 'page_title', 'page_action'));
    }

    public function update(SyllabusRequest $request, Syllabus $syllabus) 
    {    
        $syllabus->fill(Input::all()); 
        $syllabus->save();
        return Redirect::to(route('syllabus'))
                        ->with('flash_alert_notice', 'Syllabus was  successfully updated !');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Syllabus $syllabus) 
    { 
        Syllabus::where('id',$syllabus->id)->delete();  
        return Redirect::to(route('syllabus'))
                        ->with('flash_alert_notice', 'Syllabus was successfully deleted!');
    }

    public function show(Syllabus $syllabus) {
        
    }

}
