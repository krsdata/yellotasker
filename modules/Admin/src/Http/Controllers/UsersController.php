<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\UserRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Position;
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

//use App\User;
use App\ProfessorProfile;
use App\StudentProfile;
 

/**
 * Class AdminController
 */
class UsersController extends Controller {
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
        View::share('viewPage', 'user');
        View::share('helper',new Helper);
        $this->record_per_page = Config::get('app.record_per_page');
    }

    protected $users;

    /*
     * Dashboard
     * */

    public function index(User $user, Request $request) 
    { 
        $page_title = 'User';
        $page_action = 'View User'; 
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
               
            $users = User::where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('name', 'LIKE', "%$search%")
                                    ->OrWhere('email', 'LIKE', "%$search%");
                        }
                        if (!empty($status)) {
                            $status =  ($status=='active')?1:0;
                            $query->Where('status',$status);
                        }
                    })->Paginate($this->record_per_page);
        } else {
            $users = User::orderBy('id','desc')->Paginate($this->record_per_page);
            
        }
        //dd($users[0]->group);
       // dd($users[0]->position->position_name);
         //dd($users);
        return view('packages::users.user.index', compact('status','users', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(User $user) 
    {
        $page_title = 'User';
        $page_action = 'Create User';
        return view('packages::users.user.create', compact('position', 'user', 'page_title', 'page_action', 'groups'));
    }

    /*
     * Save Group method
     * */

    public function store(UserRequest $request, User $user) {

        $user->fill(Input::all());
        $user->password = Hash::make($request->get('password'));
        $user->save();
        
        return Redirect::to(route('user'))
                            ->with('flash_alert_notice', 'New user was successfully created !');
        }

    /*
     * Edit Group method
     * @param 
     * object : $user
     * */

    public function edit(User $user) {

        $page_title = 'User';
        $page_action = 'Show Users';
      
        return view('packages::users.user.edit', compact('user', 'page_title', 'page_action'));
    }

    public function update(Request $request, User $user) {
        
        $user->fill(Input::all());
        $user->password = Hash::make($request->get('password'));
        $user->save();
        return Redirect::to(route('user'))
                        ->with('flash_alert_notice', 'User was  successfully updated !');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(User $user) {
        
        User::where('id',$user->id)->delete();

        return Redirect::to(route('user'))
                        ->with('flash_alert_notice', 'User was successfully deleted!');
    }

    public function show(User $user) {
        
    }

}
