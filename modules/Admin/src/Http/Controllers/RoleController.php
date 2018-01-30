<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Settings;
use Modules\Admin\Http\Requests\RoleRequest;
use App\Role;
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
use Modules\Admin\Helpers\Helper as Helper;
use Response;

/**
 * Class AdminController
 */
class RoleController extends Controller {
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
        View::share('viewPage', 'role');
        View::share('helper',new Helper);
        View::share('route_url',route('role'));
        View::share('heading','Roles');

        $this->record_per_page = Config::get('app.record_per_page');
    }

    protected $categories;

    /*
     * Dashboard
     * */

    public function index(Role $role, Request $request) 
    { 
        
        $page_title = 'Role';
        $page_action = 'View Role'; 
        
        // Search by name ,email and group
        $search = Input::get('search'); 
        if ((isset($search) && !empty($search)) ) {

            $search = isset($search) ? Input::get('search') : '';
               
            $role = Role::where(function($query) use($search) {
                        if (!empty($search)) {
                            $query->Where('name', 'LIKE', "%$search%");
                            $query->orWhere('display_name', 'LIKE', "%$search%");
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $role  = Role::orderBy('id','desc')->Paginate(10);
            
        } 

         return view('packages::role.index', compact('role', 'page_title', 'page_action'));
   
    }

    /*
     * create  method
     * */

    public function create(Role $role)  
    {
        $page_title = 'Role';
        $page_action = 'Create Role';

        return view('packages::role.create', compact('role','page_title', 'page_action'));
     }

    /*
     * Save Group method
     * */

    public function store(Request $request, Role $role) 
    {   


          $validator = Validator::make($request->all(), [
           'name' => 'required',
           'role_type' => 'required|unique:roles,name',
           'permission' => 'required'
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {
             return redirect()
                        ->back()
                        ->withInput()  
                        ->withErrors($validator);
        }
        


        $role->name         =   $request->get('role_type');
        $role->display_name =   $request->get('name');
        $role->permission   =   json_encode($request->get('permission'));
        $role->description  =   $request->get('description');
        $role->modules      =   json_encode($request->get('modules'));
        $role->save();
       return Redirect::to('admin/role')
                            ->with('flash_alert_notice', 'Role was successfully created !');
    }
    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Role $role) {

        $page_title = 'Role';
        $page_action = 'Edit Role'; 
         
         return view('packages::role.edit', compact( 'role','page_title', 'page_action'));
    }

    public function update(Request $request, Role $role) 
    {
        $role->name         =   $request->get('role_type');
        $role->display_name =   $request->get('name');
        $role->permission   =   json_encode($request->get('permission'));
        $role->description  =   $request->get('description');
        $role->modules      =   json_encode($request->get('modules'));

        $role->save();
       
        return Redirect::to('admin/role')
                        ->with('flash_alert_notice', 'Role was successfully updated!');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Role $role) 
    {
        Role::where('id',$role->id)->delete();
        return Redirect::to('admin/role')
                        ->with('flash_alert_notice', 'Role was successfully deleted!');
    }

    public function show(Role $role) {
        
    }

}
