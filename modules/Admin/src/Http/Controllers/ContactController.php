<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\ContactRequest;
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
use Response; 

/**
 * Class AdminController
 */
class ContactController extends Controller {
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
        View::share('viewPage', 'Contact');
        View::share('sub_page_title', 'Contact');
        View::share('helper',new Helper);
        View::share('heading','Contact');
        View::share('route_url',route('contact')); 
        $this->record_per_page = Config::get('app.record_per_page'); 
    }

   
    /*
     * Dashboard
     * */

    public function index(Contact $contact, Request $request) 
    { 
        $page_title = 'Contact';
        $sub_page_title = 'View Contact';
        $page_action = 'View Contact'; 


        if ($request->ajax()) {
            $id = $request->get('id'); 
            $category = Contact::find($id); 
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
               
            $contacts = Contact::where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('name', 'LIKE', "%$search%")
                                    ->OrWhere('email', 'LIKE', "%$search%")
                                      ->OrWhere('phone', 'LIKE', "%$search%");
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $contacts = Contact::Paginate($this->record_per_page);
        }
         
        
        return view('packages::contact.index', compact('result_set','contacts','data', 'page_title', 'page_action','sub_page_title'));
    }

    /*
     * create Group method
     * */

    public function create(Contact $contact) 
    {
        
        $page_title = 'Contact';
        $page_action = 'Create Contact';
        $category  = Category::all();
        $sub_category_name  = Category::all();
 
        $html = '';
        $categories = '';

        return view('packages::contact.create', compact('categories', 'html','category','sub_category_name', 'page_title', 'page_action'));
    }

    public function createGroup(Request $request)
    {
        $users = $request->get('ids');
        $validator = Validator::make($request->all(), [
                'groupName' => 'required|unique:contact_groups,groupName' 
            ]); 

        if ($validator->fails()) {
            $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return Response::json(array(
                'status' => 0,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }



        foreach ($users as $key => $value) {
            $contact        = Contact::find($value);
            $cg             = new ContactGroup;
            $cg->groupName  = $request->get('groupName');
            $cg->contactId  = $value;
            $cg->email      = $contact->email;
            $cg->name       = $contact->name;
            $cg->save();
        }

        return $cg;

        $contact = Contact::whereIn('id',$request->get('ids'))->get();
        return $contact;
    }

    /*
     * Save Group method
     * */

    public function store(ContactRequest $request, Contact $contact) 
    {   
        $contact->name     =   $request->get('name');
        $contact->phone    =   $request->get('phone');
        $contact->email    =   $request->get('email');
        $contact->address  =   $request->get('address'); 
        
        $contact->save();   
         
        return Redirect::to(route('contact'))
                            ->with('flash_alert_notice', 'New contact  successfully created!');
        }

    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Contact $contact) {
        $page_title     = 'contact';
        $page_action    = 'Edit contact'; 
        return view('packages::contact.edit', compact( 'url','contact', 'page_title', 'page_action'));
    }

    public function update(Request $request, Contact $contact) {
        
        $request = $request->except('_method','_token');
        $contact = Contact::find($contact->id); 
        foreach ($request as $key => $value) {
            $contact->$key = $value;
        }
        $contact->save();
        return Redirect::to(route('contact'))
                        ->with('flash_alert_notice', 'Contact  successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(ontact $contact) { 
        Contact::where('id',$id)->delete(); 
        return Redirect::to(route('contact'))
                        ->with('flash_alert_notice', 'contact  successfully deleted.');
    }

    public function show($id) {
        
        return Redirect::to('admin/contact');

            }

}