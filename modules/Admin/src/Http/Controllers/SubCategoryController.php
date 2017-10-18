<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\SubCategoryRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\SubCategory;
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
class SubCategoryController extends Controller { 

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
        View::share('helper',new Helper);
        View::share('heading','Category');
        $this->record_per_page = Config::get('app.record_per_page');
        View::share('route_url',route('sub-category'));

    }

    protected $categories;

    /*
     * Dashboard
     * */

    public function index(Category $category, Request $request) 
    { 
        $page_title = 'Category';
        $sub_page_title = 'Sub Category';
        $page_action = 'View Sub Category'; 
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
               
            $categories = Category::where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('category_group_name', 'LIKE', "%$search%")
                                    ->OrWhere('category_name', 'LIKE', "%$search%");
                        }
                        
                    })->where('parent_id','!=',0)->Paginate($this->record_per_page);
        } else {
            $categories = Category::where('parent_id','!=',0)->Paginate($this->record_per_page);
        }
        
        return view('packages::sub_category.index', compact('sub_page_title','result_set','categories','data', 'page_title', 'page_action','html'));
    }

    /*
     * create Group method
     * */

    public function create(Category $category) 
    {
          
        $page_title = 'Category';
        $page_action = 'Create Sub Category';
        $sub_page_title = 'Sub Category';   
        $category  = Category::all();
        $sub_category_name  = Category::all();
 
        $html = '';
        $categories = Category::where('parent_id',0)->get();

        return view('packages::sub_category.create', compact('sub_page_title','categories', 'html','category','sub_category_name', 'page_title', 'page_action'))->withInput(Input::all());
    }

    /*
     * Save Group method
     * */

    public function store(SubCategoryRequest $request, Category $category) 
    {  
        
        $photo = $request->file('category_image');
        $destinationPath = storage_path('uploads/category');

        $id = $request->get('category_group_name');

        $validate_cat = Category::where('category_name',$request->get('category_name'))
                            ->where('parent_id',$id)->first();
       
        if($validate_cat){
              return  Redirect::back()->withInput()->with(
                'field_errors','The Category name already been taken!'
            );
        }                    

        $photo->move($destinationPath, time().$photo->getClientOriginalName());
        $photo_name = time().$photo->getClientOriginalName();
        $request->merge(['photo'=>$photo_name]);
            
        $grp_cat =  Category::find($request->get('category_group_name'));

        $cat = new Category;

        $cat->slug                  =  strtolower(str_slug($request->get('category')));
        $cat->parent_id             =  $request->get('category_group_name');
        $cat->category_group_name   =  $grp_cat->category_group_name; 
        $cat->category_name         =  $request->get('category_name'); 
        $cat->level                 =  2;
        $cat->category_image        =  $photo_name; 
        $cat->category_group_image  =  $grp_cat->category_group_image;
        $cat->description           =  $request->get('description');
        
        $cat->save();   
         
        return Redirect::to(route('sub-category'))
                            ->with('flash_alert_notice', 'New category  successfully created.');
        }

    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Category $category) {

        $page_title = 'Category';
        $sub_page_title = 'Sub Category';
        $categories = Category::where('parent_id',0)->get();

        $page_action = 'Edit Sub category';  

        $url = url::asset('storage/uploads/category/'.$category->category_image)  ;
        return view('packages::sub_category.edit', compact('sub_page_title','categories','url','category', 'page_title', 'page_action'));
    }

    public function update(Request $request, Category $category) {
       
        $name = $request->get('category_group_name');
        $slug = str_slug($request->get('category_group_name'));
        $parent_id = 0;

        $id = $request->get('category_group_name');

        $validate_cat = Category::where('category_name',$request->get('category_name'))
                            ->where('parent_id',$id)
                            ->where('id','!=',$category->id)
                            ->first();
         
        if($validate_cat){
              return  Redirect::back()->withInput()->with(
                'field_errors','The Category name already been taken!'
            );
        } 

        if ($request->file('category_image')) {
            $photo = $request->file('category_image');
            $destinationPath = storage_path('uploads/category');
            $photo->move($destinationPath, time().$photo->getClientOriginalName());
            $photo_name = time().$photo->getClientOriginalName();
            $request->merge(['photo'=>$photo_name]);
        } 

        $grp_cat =  Category::find($request->get('category_group_name'));

        $cat                        = Category::find($category->id);
       
        $cat->slug                  =  strtolower(str_slug($request->get('category_name')));
        $cat->parent_id             =  $request->get('category_group_name');
        $cat->category_group_name   =  $grp_cat->category_group_name; 
        $cat->category_name         =  $request->get('category_name'); 
        $cat->level                 =  2;
        $cat->category_group_image  =  $grp_cat->category_group_image;
        $cat->description           =  $request->get('description'); 

        if(isset($photo_name))
        {
          $cat->category_group_image  =  $photo_name; 
        } 
        $cat->save();    
        return Redirect::to(route('sub-category'))
                        ->with('flash_alert_notice', 'Category   successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Category $category) {
        
        $d = Category::where('id',$category->id)->delete(); 
        return Redirect::to(route('category'))
                        ->with('flash_alert_notice', 'Category  successfully deleted.');
    }

    public function show(Category $category) {
        
        $result = $category;
        $page_title  = 'Category';
        $page_action  = 'Show Category';
        return view('packages::sub_category.show', compact('result_set','result','data', 'page_title', 'page_action','html'));

    }

}
