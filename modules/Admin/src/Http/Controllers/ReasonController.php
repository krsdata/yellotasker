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
use Modules\Admin\Models\Reason;
use Modules\Admin\Models\Complains;
use Response; 
use Modules\Admin\Http\Requests\ReasonRequest;
/**
 * Class AdminController
 */
class ReasonController extends Controller {
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
        View::share('viewPage', 'Reason');
        View::share('sub_page_title', 'Reason');
        View::share('helper',new Helper);
        View::share('heading','Reason');
        View::share('route_url',route('reason')); 
        $this->record_per_page = Config::get('app.record_per_page'); 
    }

   
    /*
     * Dashboard
     * */

    public function index(Contact $contact, Request $request) 
    { 
        $page_title = 'Reason';
        $sub_page_title = 'View Reason';
        $page_action = 'View Reason'; 


        if ($request->ajax()) {
            $id = $request->get('id'); 
            $category = Reason::find($id); 
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
               
            $reasons = Reason::where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('reasonDescription', 'LIKE', "%$search%");
                            $query->orWhere('reasonType', 'LIKE', "%$search%");
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $reasons = Reason::Paginate($this->record_per_page);
        }
         
        
        return view('packages::reason.index', compact('result_set','reasons','data', 'page_title', 'page_action','sub_page_title'));
    }

    /*
     * create Group method
     * */

    public function create(Reason $reason) 
    {
        $page_title     = 'Reason';
        $page_action    = 'Create Reason';
        $program       = Reason::all(); 
        $status         = [
                            'user reason'=>'User Reason',
                            'task reason'=>'Task Reason', 
                        ];

        return view('packages::reason.create', compact( 'reason','status','page_title', 'page_action'));
    }

    

    /*
     * Save Group method
     * */

    public function store(ReasonRequest $request, Reason $reason) 
    {   
        $reason->fill(Input::all()); 
        $reason->save();   
         
        return Redirect::to(route('reason'))
                            ->with('flash_alert_notice', 'New reason  successfully created!');
    }

    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Reason $reason) {
        $page_title     = 'Reason';
        $page_action    = 'Edit Reason'; 
        $status         = [
                            'user reason'=>'User Reason',
                            'task reason'=>'Task Reason', 
                        ];
        return view('packages::reason.edit', compact( 'url','reason','status', 'page_title', 'page_action'));
    }

    public function update(Request $request, Reason $reason) {
        
        $reason->fill(Input::all()); 
        $reason->save();  
        return Redirect::to(route('reason'))
                        ->with('flash_alert_notice', 'reason  successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Reason $reason) { 
        

        $Complains = Complains::where('reasonId',$reason->id)->get();
       
        if($Complains->count()){
            return Redirect::to(route('reason'))
                        ->with('flash_alert_notice', "This reason is associated with existing complaint so You can't delete.");
        }
 
        Reason::where('id',$reason->id)->delete();
        return Redirect::to(route('reason'))
                        ->with('flash_alert_notice', 'Reason  successfully deleted.');
    }

    public function show($id) {
        
        return Redirect::to('admin/reason');

    }

}