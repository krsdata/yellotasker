<?php
namespace Modules\Admin\Http\Controllers;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Modules\Admin\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Modules\Admin\Models\User;
use Input;
use Validator;
use Auth;
use Paginate;
use Grids;
use HTML;
use Form;
use View;
use URL;
use Lang;
use Route;
use App\Http\Controllers\Controller; 

/**
 * Class AdminController
 */
class HomeController extends Controller { 
    /**
     * @var  Repository
     */ 
    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
   /*
    * Dashboard
    **/
    public function index(User $user) { 
         
       return view('packages::auth.create', compact('user'));
    } 

}
