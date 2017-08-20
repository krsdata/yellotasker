<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\ProductRequest;
use Modules\Admin\Models\User; 
use Modules\Admin\Models\Product;
use Input;
use Validator;
use Auth;
use Paginate;
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
class ProductController extends Controller {
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
        View::share('viewPage', 'product');
        View::share('helper',new Helper);
        $this->record_per_page = Config::get('app.record_per_page');
    }

    protected $categories;

    /*
     * Dashboard
     * */

    public function index(Product $product, Request $request) 
    { 
        
       $page_title = 'Product';
        $page_action = 'View Product'; 
        if ($request->ajax()) {
            $id = $request->get('id'); 
            $category = Product::find($id); 
            $category->status = $s;
            $category->save();
            echo $s;
            exit();
        }
         
        $products = $product->with('category')->orderBy('id','desc')->Paginate($this->record_per_page);
 

        return view('packages::product.index', compact('products', 'page_title', 'page_action','helper'));
   
    }

    /*
     * create  method
     * */

    public function create(Product $product) 
    {
        $page_title = 'Product';
        $page_action = 'Create Product';
        $sub_category_name  = Product::all();
        $cat = [];
        $categories = [];
        $category = [];
        $product = [];
        $sub_category_name = [];
  
        return view('packages::product.create', compact('categories','cat','category','product','sub_category_name', 'page_title', 'page_action'));
     }

    /*
     * Save Group method
     * */

    public function store(ProductRequest $request, Product $product) 
    {
        if ($request->file('image')) { 
            $photo = $request->file('image');
            $destinationPath = storage_path('uploads/products');
            $photo->move($destinationPath, time().$photo->getClientOriginalName());
            $photo_name = time().$photo->getClientOriginalName();
            $request->merge(['photo'=>$photo_name]);
           
            $product->product_title      =   $request->get('product_title');
            $product->product_category   =   $request->get('product_category');
            $product->description        =   $request->get('description');
            $product->price              =   $request->get('price');
            $product->discount              =   $request->get('discount');
            $product->photo              =   $photo_name;
 
            $product->save(); 
           
        } 
       
        return Redirect::to(route('product'))
                            ->with('flash_alert_notice', 'New Product was successfully created !');
    }
    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Product $product) {

        $page_title = 'Product';
        $page_action = 'Show Product'; 
        $category   = Category::all();  
        $cat = [];
        foreach ($category as $key => $value) {
             $cat[$value->category_name][$value->id] =  $value->sub_category_name;
        } 
        
        $categories =  Category::attr(['name' => 'product_category','class'=>'form-control form-cascade-control input-small'])
                        ->selected(['id'=>$product->product_category])
                        ->renderAsDropdown();

        return view('packages::product.edit', compact( 'categories','product', 'page_title', 'page_action'));
    }

    public function update(ProductRequest $request, Product $product) 
    {
           
         if ($request->file('image')) { 

            $photo = $request->file('image');
            //$destinationPath = base_path() . '/public/uploads/products/';
            $destinationPath = storage_path('uploads/products');
            $photo->move($destinationPath, time().$photo->getClientOriginalName());
            $photo_name = time().$photo->getClientOriginalName();
            $request->merge(['photo'=>$photo_name]);
           
            $product->product_title      =   $request->get('product_title');
            $product->product_category   =   $request->get('product_category');
            $product->description        =   $request->get('description');
            $product->photo              =   $photo_name;
            $product->price              =   $request->get('price');
            $product->discount              =   $request->get('discount');
            $product->save(); 
        }else{
            $product->product_title      =   $request->get('product_title');
            $product->product_category   =   $request->get('product_category');
            $product->description        =   $request->get('description');
            $product->photo              =   $request->get('photo');
            $product->price              =   $request->get('price');
            $product->discount              =   $request->get('discount');
            $product->save(); 
        }
        return Redirect::to(route('product'))
                        ->with('flash_alert_notice', 'Product was  successfully updated !');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Product $product) {
        
        Product::where('id',$product->id)->delete();

        return Redirect::to(route('product'))
                        ->with('flash_alert_notice', 'Product was successfully deleted!');
    }

    public function show(Product $product) {
        
    }

}
