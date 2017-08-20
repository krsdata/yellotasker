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
use Modules\Admin\Models\CategoryDashboard; 
 

/**
 * Class AdminController
 */
class CategoryDashboardController extends Controller {
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
        View::share('viewPage', 'category');
        View::share('sub_page_title', 'Category Dashboard');
        View::share('helper',new Helper);
        View::share('heading','Category Dashboard');
        View::share('route_url',route('category'));

        $this->record_per_page = Config::get('app.record_per_page');
    }

   
    /*
     * Dashboard
     * */

    public function index(Category $category, Request $request) 
    { 

        $page_title = 'Category';
        $sub_page_title = 'Category Dashboard';
        $page_action = 'Category Dashboard'; 

        if ($request->ajax()) {
            $id = $request->get('id'); 
            $category = Category::find($id); 
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
               
            $categories = Category::with('subcategory')->where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('category_group_name', 'LIKE', "%$search%")
                                    ->OrWhere('category_name', 'LIKE', "%$search%");
                        }
                        
                    })->where('parent_id',0)->get();
        } else {
            $categories = Category::with('subcategory')->where('parent_id',0)->get();
        }

        $category = '';
        $sub_categories = Category::with('subcategory')->where('parent_id','!=',0)->get(); 
        $categoryDashboard = CategoryDashboard::all();
        $cat_id = [];
        foreach ($categoryDashboard as $key => $value) {
             $cat_id[]= $value->category_id;
        }
        
        return view('packages::category-dashboard.index', compact('cat_id','categoryDashboard','category','sub_categories','categories','page_title', 'page_action','sub_page_title'));
    }
 

    /*
     * Save Group method
     * */

               
    public function store(CategoryDashboard $categoryDashboard, Request $request){

        $i=1;
        if($request->get('name')){

            foreach ($request->get('name') as $key => $results) {
                foreach ($results as $key => $value) {
                     
                   $cat = explode('_', $value);
                   $categoryDashboard = CategoryDashboard::firstOrNew(['category_id' => $cat[0]]);
                   $categoryDashboard->name = $cat[1];
                   $categoryDashboard->category_id = $cat[0];
                   $categoryDashboard->display_order = $i++;  
                   $categoryDashboard->save();

                }
               
            }
        }else{
            return Redirect::to(route('category-dashboard'))
                            ->with('flash_alert_danger', 'Please select category to move!');
        }

        return Redirect::to(route('category-dashboard'))
                            ->with('flash_alert_notice', 'Category  successfully moved.');
    }

    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Category $category) {

        $page_title = 'Category';
        $page_action = 'Edit Group category'; 
        $url = url::asset('storage/uploads/category/'.$category->category_group_image)  ;
        return view('packages::category.edit', compact( 'url','category', 'page_title', 'page_action'));
    }

    public function update(CategoryRequest $request, Category $category) {
       
        $name = $request->get('category_group_name');
        $slug = str_slug($request->get('category_group_name'));
        $parent_id = 0;

        $validate_cat = Category::where('category_group_name',$request->get('category_group_name'))
                            ->where('parent_id',0)
                            ->where('id','!=',$category->id)
                            ->first();
         
        if($validate_cat){
              return  Redirect::back()->withInput()->with(
                'field_errors','The Group Category name already been taken!'
            );
        } 


        if ($request->file('category_group_image')) {
            $photo = $request->file('category_group_image');
            $destinationPath = storage_path('uploads/category');
            $photo->move($destinationPath, time().$photo->getClientOriginalName());
            $photo_name = time().$photo->getClientOriginalName();
            $request->merge(['photo'=>$photo_name]);
        } 

        $cat                        = Category::find($category->id);
        $cat->category_group_name   =  $request->get('category_group_name');
        $cat->slug                  =  strtolower(str_slug($request->get('category_group_name')));
        $cat->parent_id             =  $parent_id;
        $cat->category_name         =  $request->get('category_group_name'); 
        $cat->level                 =  1;
        $cat->description           =  $request->get('description');

        if(isset($photo_name))
        {
          $cat->category_group_image  =  $photo_name; 
        }
         
        $cat->save();    


        return Redirect::to(route('category'))
                        ->with('flash_alert_notice', 'Group Category  successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Category $category) {
        $d = CategoryDashboard::where('id',$category->id)->delete(); 
        return Redirect::to(route('category-dashboard'))
                        ->with('flash_alert_notice', 'Default Category successfully deleted.');
    }

    public function show(CategoryDashboard $category) {
         $d = CategoryDashboard::where('id',$category->id)->delete(); 
        return Redirect::to(route('category-dashboard'))
                        ->with('flash_alert_notice', 'Default Category successfully deleted.');
    }

}
