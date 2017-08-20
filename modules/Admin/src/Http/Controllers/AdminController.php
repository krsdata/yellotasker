<?php
namespace Modules\Admin\Http\Controllers; 

use Modules\Admin\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;  
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Dispatcher; 
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Requests\UserRequest;
use Auth;
use Input;
use Redirect; 
use Response;   
use Crypt; 
use View;
use Cookie;
use Closure; 
use Hash;
use URL;
use Lang;
use Validator;
use App\Http\Requests;
use App\Helpers\Helper as Helper;
//use Modules\Admin\Models\User; 
use Modules\Admin\Models\Category;
use Modules\Admin\Models\CategoryDashboard;
use App\Admin;
use Illuminate\Http\Request;
use Session;

use App\User;
use App\ProfessorProfile;
use App\StudentProfile;
 
/**
 * Class : AdminController
 */
class AdminController extends Controller { 
    /**
     * @var  Repository
     */ 
    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */ 
    protected $guard = 'admin';
    public function __construct()
    {  
        $this->middleware('admin');  
        View::share('heading','dashboard');
        View::share('route_url','admin');
    }
    /*
    * Dashboard
    **/
    public function index(Request $request) 
    { 
       // dd(Session::getId());
        $page_title = "";
        $page_action = "";
        $professor = User::where('role_type',1)->count();
         
        $user = User::count();
        $viewPage = "Admin";

        $users_count        =  User::count();
        $category_grp_count =  Category::where('parent_id',0)->count();
        $category_count     =  Category::where('parent_id','!=',0)->count();
        $category_dashboard_count = CategoryDashboard::count();


        return view('packages::dashboard.index',compact('category_count','users_count','category_grp_count','page_title','page_action','viewPage','category_dashboard_count'));
    }

   public function profile(Request $request,Admin $users)
   {
        $users = Admin::find(Auth::guard('admin')->user()->id);
        $page_title = "Profile";
        $page_action = "My Profile";
        $viewPage = "Admin";
        $method = $request->method();
        $msg = "";
        $error_msg = [];
        if($request->method()==='POST'){
            $messages = ['password.regex' => "Your password must contain 1 lower case character 1 upper case character one number"];

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'min:6',
                'name' => 'required', 
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {

            $error_msg  =   $validator->messages()->all(); 
           return view('packages::users.admin.index',compact('error_msg','method','users','page_title','page_action','viewPage'))->with('flash_alert_notice', $msg)->withInput($request->all());
        }
            $users->name= $request->get('name');
            $users->email= $request->get('email');
            if($request->get('password')!=null){
                $users->password=    Hash::make($request->get('password'));
            }
            $users->save();
            $method = $request->method();
            $msg = "Profile details successfully updated.";
        } 
       return view('packages::users.admin.index',compact('error_msg','method','users','page_title','page_action','viewPage'))->with('flash_alert_notice', $msg)->withInput($request->all());
       
     
   }
   public function errorPage()
   {
        $page_title = "Error";
        $page_action = "Error Page";
        $viewPage = "404 Error";
        $msg = "page not found";
        return view('packages::auth.page_not_found',compact('page_title','page_action','viewPage'))->with('flash_alert_notice', $msg);

   }  
}
