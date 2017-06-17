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
use Modules\Admin\Models\Course; 
use Modules\Admin\Models\Assignment;
use Modules\Admin\Models\Syllabus;
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
         
        $student = User::where('role_type',2)->count();  
        $course = Course::count();  
        $assignment = Assignment::count();  
        $syllabus = Syllabus::count();  
        $viewPage = "Admin";
        return view('packages::dashboard.index',compact('syllabus','course','assignment','professor','student','page_title','page_action','viewPage'));
    }

   public function profile(Request $request,Admin $users)
   {
        $users = Admin::find(Auth::guard('admin')->user()->id);
        $page_title = "Profile";
        $page_action = "My Profile";
        $viewPage = "Admin";
        $method = $request->method();
        $msg = "Update your information!";
        $error_msg = [];
        if($request->method()==='POST'){
            $messages = ['password.regex' => "Your password must contain 1 lower case character 1 upper case character one number"];

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'min:6' 
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {

            $error_msg  =   $validator->messages()->all(); 
        }
            $users->name= $request->get('name');
            $users->email= $request->get('email');
            $users->password=  Hash::make($request->get('password'));
            $users->save();
            $method = $request->method();
            $msg = "Information successfully updated!";
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
