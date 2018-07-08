<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\ArticleTypeRequest;
use Modules\Admin\Models\User; 
use Modules\Admin\Models\ArticleType;
use Modules\Admin\Models\SupportTicket;

//use App\Category;
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

/**
 * Class AdminController
 */
class ArticleTypeController extends Controller { 

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
        View::share('viewPage', 'Article Type');
        View::share('helper',new Helper);
        View::share('heading','Article Type');
        $this->record_per_page = Config::get('app.record_per_page');
        View::share('route_url',route('articleType'));

    }

    protected $articleType;

    /*
     * Dashboard
     * */

    public function index(ArticleType $articleType, Request $request) 
    { 
        $page_title = 'Article Type'; 
        $page_action = 'View Article Type'; 
        if ($request->ajax()) {
            $id = $request->get('id'); 
            $articleType = articleType::find($id); 
            $articleType->status = $s;
            $catarticleTypeegory->save();
            echo $s;
            exit();
        }

        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');
        if ((isset($search) && !empty($search))) {

            $search = isset($search) ? Input::get('search') : '';
               
            $results = ArticleType::where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('article_type', 'LIKE', "%$search%")
                                    ->OrWhere('resolution_department', 'LIKE', "%$search%");
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $results = ArticleType::Paginate($this->record_per_page);
        }
         
        return view('packages::articleType.index', compact('results','articleType','page_title', 'page_action'));
    }
    public function supportTicketAddreply(Request $request){
       
       $req = $request->except('_token');
       $sprt = SupportTicket::where('ticket_id',$request->get('ticket_id'))->first();

        
        $table_cname = \Schema::getColumnListing('support_tickets');
        $except = ['id','created_at','updated_at','support_type'];
        
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
            if($request->get($value)){
                $sprt->$value = $request->get($value);
           }
        }
                
        if($request->get('reply')){
            $sprt->save();
        }

        $data = $request->only('ticket_id','subject','email','status','support_type','parent_id');
        
        $data['support_comments'] =  $request->get('reply');

        $data['details'] = json_encode($request->all());

        \DB::table('support_conversation')
                ->insert($data);
              
       return Redirect::to('admin/supportTicket')
                            ->with('flash_alert_notice', 'Successfully replied on ticket');


    }
    public function supportTicket(ArticleType $articleType, Request $request) 
    {    
        // Search by name ,email and group
        $page_title = 'Support Ticket'; 
        $page_action = 'View Ticket'; 
        $search = Input::get('search');
        $status = Input::get('status'); 
        $ticketId = Input::get('ticketId');
        if($request->get('view')){
           $result = SupportTicket::with('supportType')
                        ->where('ticket_id', $ticketId)
                        ->first();
            $allReply = \DB::table('support_conversation')->where('parent_id',$result->id)->get(); 
           
            if($result){
                return view('packages::articleType.suportform', compact('result','articleType','page_title', 'page_action','ticketId','allReply'));   
            }else{
                return Redirect::back()
                            ->with('flash_alert_notice', 'Ticket details not available');
            }
            
        }

        if ((isset($search) && !empty($search))) {

            $search = isset($search) ? Input::get('search') : '';
            
            $article_type = ArticleType::where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('article_type', 'LIKE', "%$search%")
                                    ->OrWhere('resolution_department', 'LIKE', "%$search%");
                        }
                    })->lists('id');

            $results = SupportTicket::with('supportType')->where(function($query) use($search,$article_type) {
                        if (!empty($search)) {
                            $query->Where('email', 'LIKE', "%$search%")
                                    ->OrWhere('ticket_id', 'LIKE', "%$search%")
                                    ->OrWhere('subject', 'LIKE', "%$search%")
                                    ->OrWhereIn('support_type', $article_type); 
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $results = SupportTicket::with('supportType')->Paginate($this->record_per_page);

        } 

        return view('packages::articleType.support', compact('results','articleType','page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(ArticleType $result) 
    {
        $support =  ['sales team','billing team','technical team','support team','admin team'];

        $page_title = 'Article Type';
        $page_action = 'Create Article Type';  
        return view('packages::articleType.create', compact('support','result','page_title', 'page_action'))->withInput(Input::all());
    }

    /*
     * Save Group method
     * */
    //SubCategoryRequest $request,
    public function store( ArticleType $result, ArticleTypeRequest $request) 
    {                   
        
        $result->article_type          =  $request->get('article_type');
        $result->resolution_department =  $request->get('resolution_department'); 
        $result->save();   
         
        return Redirect::to(route('articleType'))
                            ->with('flash_alert_notice', 'New Article Type  successfully created.');
        }

    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(ArticleType $result) {

        $page_title = 'Article Type';  
        $page_action = 'Edit Article Type';  
        $support =  ['sales team','billing team','technical team','support team','admin team'];

        return view('packages::articleType.edit', compact('support','result', 'page_title', 'page_action'));
    }

    public function update(Request $request, ArticleType $result) {
         
        $result->article_type          =  $request->get('article_type');
        $result->resolution_department =  $request->get('resolution_department'); 
        $result->save();    
        return Redirect::to(route('articleType'))
                        ->with('flash_alert_notice', 'Article Type   successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(ArticleType $articleType) {
        
        $del = ArticleType::where('id',$articleType->id)->delete(); 
        return Redirect::to(URL::previous())
                        ->with('flash_alert_notice', 'Article Type  successfully deleted.');
    }

    public function show(ArticleType $articleType) {
        
        try{
            $result = $articleType;
            $page_title  = 'articleType';
            $page_action  = 'Show articleType';
            return view('packages::articleType.show', compact('result_set','result','data', 'page_title', 'page_action','html'));

        }catch(\ModelNotFoundException  $e){
            dd($e->getMessage());
        }
            
    }
}
