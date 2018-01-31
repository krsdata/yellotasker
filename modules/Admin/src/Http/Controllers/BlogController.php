<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Settings;
use Modules\Admin\Http\Requests\BlogRequest;
use Modules\Admin\Models\Blogs;
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
class BlogController extends Controller {
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
        View::share('viewPage', 'page');
        View::share('helper',new Helper);
        View::share('route_url',route('blog'));
        View::share('heading','Blog');

        $this->record_per_page = Config::get('app.record_per_page');
    }

    public function ajax(Request $request, Blogs $blog){
        
        if ($request->file('file')) {  

            $photo = $request->file('file');
            $destinationPath = storage_path('blog');
            $photo->move($destinationPath, time().$photo->getClientOriginalName());
            $blog_image = time().$photo->getClientOriginalName();
            $blog->blog_image   =   $blog_image;
        }  
       exit();
    }
    /*
     * Dashboard
     * */

    public function index(Blogs $blog, Request $request) 
    { 
        
        $page_title = 'Blog';
        $page_action = 'View Blog'; 
        
        // Search by name ,email and group
        $search = Input::get('search'); 
        if ((isset($search) && !empty($search)) ) {

            $search = isset($search) ? Input::get('search') : '';
               
            $blog = Blogs::where(function($query) use($search) {
                        if (!empty($search)) {
                            $query->Where('blog_title', 'LIKE', "%$search%");
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $blog  = Blogs::orderBy('id','desc')->Paginate(10);
            
        } 
        
         return view('packages::blog.index', compact('blog', 'page_title', 'page_action'));
   
    }

    /*
     * create  method
     * */

    public function create(Blogs $blog)  
    {
        $page_title = 'Blog';
        $page_action = 'Create Blog';

        return view('packages::blog.create', compact('blog','page_title', 'page_action'));
     }

    /*
     * Save Group method
     * */

    public function store(BlogRequest $request, Blogs $blog) 
    {   
        if ($request->file('blog_image')) {  

            $photo = $request->file('blog_image');
            $destinationPath = storage_path('blog');
            $photo->move($destinationPath, time().$photo->getClientOriginalName());
            $blog_image = time().$photo->getClientOriginalName();
            $blog->blog_image   =   $blog_image;
            
        } 

        $blog->blog_title     =   $request->get('blog_title');
        $blog->blog_description   =   $request->get('blog_description');
        $blog->blog_created_by = $request->get('blog_created_by');
        $blog->save();
       return Redirect::to('admin/blog')
                            ->with('flash_alert_notice', 'Blog was successfully created !');
    }
    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Blogs $blog) {

        $page_title = 'Blog';
        $page_action = 'Edit Blog'; 
         
         return view('packages::blog.edit', compact( 'blog','banner' ,'page_title', 'page_action'));
    }

    public function update(BlogRequest $request, Blogs $blog) 
    {
        
        if ($request->file('blog_image')) {  

            $photo = $request->file('blog_image');
            $destinationPath = storage_path('blog');
            $photo->move($destinationPath, time().$photo->getClientOriginalName());
            $blog_image = time().$photo->getClientOriginalName();
            $blog->blog_image   =   $blog_image; 
        } 

        $blog->blog_title       =   $request->get('blog_title');
        $blog->blog_description =   $request->get('blog_description');
        $blog->blog_created_by  = $request->get('blog_created_by');
        $blog->save();
        return Redirect::to('admin/blog')
                        ->with('flash_alert_notice', 'Page was successfully updated!');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Blogs $blog) 
    {
        Blogs::where('id',$blog->id)->delete();
        return Redirect::to('admin/blog')
                        ->with('flash_alert_notice', 'Blog was successfully deleted!');
    }

    public function show(Page $blog) {
        
    }

}
