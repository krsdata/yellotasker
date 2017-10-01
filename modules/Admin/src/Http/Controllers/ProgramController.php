<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Models\User; 
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
use Route;
use Crypt; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher; 
use App\Helpers\Helper;
use Modules\Admin\Models\Contact; 
use Modules\Admin\Models\Category;
use Modules\Admin\Models\ContactGroup;
use Modules\Admin\Models\Program;
use Response; 
use Modules\Admin\Http\Requests\ProgramRequest;
/**
 * Class AdminController
 */
class ProgramController extends Controller {
    /**
     * @var  Repository
     */

    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct(Contact $contact) { 
        $this->middleware('admin');
        View::share('viewPage', 'Program');
        View::share('sub_page_title', 'Program');
        View::share('helper',new Helper);
        View::share('heading','Program');
        View::share('route_url',route('program')); 
        $this->record_per_page = Config::get('app.record_per_page'); 
    }

   
    /*
     * Dashboard
     * */

    public function index(Contact $contact, Request $request) 
    { 
        $page_title = 'Program';
        $sub_page_title = 'View Program';
        $page_action = 'View Program'; 


        if ($request->ajax()) {
            $id = $request->get('id'); 
            $category = Program::find($id); 
            $category->status = $s;
            $category->save();
            echo $s;
            exit();
        }

        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');
        if ((isset($search) && !empty($search))) {

            $search = isset($search) ? Input::get('search') : '';
               
            $programs = Program::where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('program_name', 'LIKE', "%$search%");
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $programs = Program::Paginate($this->record_per_page);
        }
         
        
        return view('packages::program.index', compact('result_set','programs','data', 'page_title', 'page_action','sub_page_title'));
    }

    /*
     * create Group method
     * */

    public function create(Program $program) 
    {
        $page_title     = 'Program';
        $page_action    = 'Create Program';
        $program       = Program::all(); 
        $status         = [
                            'last_15_days'=>'inactive from last 15 days',
                            'last_30_days'=>'inactive from last 30 days',
                            'last_45_days'=>'inactive from last 45 days'
                        ];

        return view('packages::program.create', compact( 'program','status','page_title', 'page_action'));
    }

    

    /*
     * Save Group method
     * */

    public function store(ProgramRequest $request, Program $program) 
    {   
        $program->fill(Input::all()); 
        $program->save();   
         
        return Redirect::to(route('program'))
                            ->with('flash_alert_notice', 'New program  successfully created!');
    }

    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Program $program) {
        $page_title     = 'Program';
        $page_action    = 'Edit Program'; 
        $status         = [
                            'last_15_days'=>'inactive from last 15 days',
                            'last_30_days'=>'inactive from last 30 days',
                            'last_45_days'=>'inactive from last 45 days'
                        ];
        return view('packages::program.edit', compact( 'url','program','status', 'page_title', 'page_action'));
    }

    public function update(Request $request, Program $program) {
        
        $program->fill(Input::all()); 
        $program->save();  
        return Redirect::to(route('program'))
                        ->with('flash_alert_notice', 'program  successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Program $program) { 
        
         Program::where('id',$program->id)->delete();
        return Redirect::to(route('program'))
                        ->with('flash_alert_notice', 'program  successfully deleted.');
    }

    public function show($id) {
        
        return Redirect::to('admin/program');

    }

}