<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CategoryRequest;
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
use DB;
use Route;
use Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher;
use App\Helpers\Helper;
use Modules\Admin\Models\Roles;
use Modules\Admin\Models\Category;
class PaymentController extends Controller {


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
    // View::share('viewPage', 'Press');
    // View::share('helper',new Helper);
     View::share('heading','Payment');
    // $this->record_per_page = Config::get('app.record_per_page');
     View::share('route_url',url('admin/payment/release-fund'));

   }
	public function index()
	{
      $page_title = 'Payment';
      $page_action = 'Release Fund';
    //dd('here');
		return view('packages::payment.index', compact('page_title' ,'page_action'));
	}
  public function userReport(Request $request)
  {
      $page_title = 'Payment';
      $page_action = 'User Report';
    //dd('here');
    return view('packages::payment.userreport', compact('page_title' ,'page_action'));
  }
  public function yellotaskerReport(Request $request)
  {

      $page_title = 'Payment';
      $page_action = 'Yellotasker Report';
    //dd('here');
    return view('packages::payment.yellotaskerreport', compact('page_title' ,'page_action'));
  }
  public function configServiceCharge(Request $request)
  {

      $page_title = 'Payment';
      $page_action = 'Service Charge';
    //dd('here');
    return view('packages::payment.servicecharge', compact('page_title' ,'page_action'));
  }
  public function closeTask(Request $request) {

    $page_title = 'Payment';
    $page_action = 'Close Task';

    return view('packages::payment.closetask', compact('page_title' ,'page_action'));

  }
}
