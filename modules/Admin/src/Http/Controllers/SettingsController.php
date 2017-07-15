<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\Product;
use Modules\Admin\Models\Settings;
use Modules\Admin\Http\Requests\SettingRequest;
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
class SettingsController extends Controller {
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
        View::share('viewPage', 'setting');
        View::share('helper',new Helper);
        $this->record_per_page = Config::get('app.record_per_page');
    }

    protected $categories;

    /*
     * Dashboard
     * */

    public function index(Settings $setting, Request $request) 
    { 
        
        $page_title = 'setting';
        $page_action = 'View setting'; 
        
        $website_title      = $setting::where('field_key','website_title')->first();
        $website_email      = $setting::where('field_key','website_email')->first();
        $website_url        = $setting::where('field_key','website_url')->first();
        $contact_number     = $setting::where('field_key','contact_number')->first();
        $company_address    = $setting::where('field_key','company_address')->first();

        $banner             = $setting::where('field_key','LIKE','%banner_image%')->get();
 

        $setting = Settings::first();

        if($setting)
        {
            $setting->id;
        }else{
            return Redirect::to(route('setting.create'));
        }
      

        return view('packages::setting.edit', compact('setting','website_title','website_email','website_url','contact_number','company_address','banner', 'page_title', 'page_action','helper'));
   
    }

    /*
     * create  method
     * */

    public function create(Settings $setting) 
    {
        $page_title = 'setting';
        $page_action = 'Create setting';
        
         $website_title      = $setting::where('field_key','website_title')->first();
        $website_email      = $setting::where('field_key','website_email')->first();
        $website_url        = $setting::where('field_key','website_url')->first();
        $contact_number     = $setting::where('field_key','contact_number')->first();
        $company_address    = $setting::where('field_key','company_address')->first();

        $banner             = $setting::where('field_key','LIKE','%banner_image%')->get();



        return view('packages::setting.create', compact('setting','website_title','website_email','website_url','contact_number','company_address','banner', 'page_title', 'page_action','helper'));
     }

    /*
     * Save Group method
     * */

    public function store(SettingRequest $request, Settings $setting) 
    {
       
       foreach ($request->except('_token') as $key => $value) {
            
            $setting = Settings::firstOrCreate(['field_key' => $key]);

            $setting->field_key     =   $key;
            $setting->field_value   =   $value;
            $setting->save();  

           
            if ($request->file($key)) {  

                $photo = $request->file($key);
                $destinationPath = storage_path('files/banner/');
                $photo->move($destinationPath, time().$photo->getClientOriginalName());
                $banner_image1 = time().$photo->getClientOriginalName();
                
                $setting = Settings::firstOrCreate(['field_key' => $key]);

                $setting->field_key     =   $key;
                $setting->field_value   =   $banner_image1;
                $setting->save(); 
               
            } 

        }
         

       
       return Redirect::to(route('setting'))
                            ->with('flash_alert_notice2', 'Site settigs was successfully created !');
    }
    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Settings $settings) {

        $page_title = 'setting';
        $page_action = 'Show setting'; 
        $category   = Category::all();  
        $cat = [];
        foreach ($category as $key => $value) {
             $cat[$value->category_name][$value->id] =  $value->sub_category_name;
        } 
        
        $categories =  Category::attr(['name' => 'product_category','class'=>'form-control form-cascade-control input-small'])
                        ->selected(['id'=>$product->product_category])
                        ->renderAsDropdown();

        return view('packages::setting.edit', compact( 'categories','product', 'page_title', 'page_action'));
    }

    public function update(SettingRequest $request, Settings $setting) 
    {
        
        foreach ($request->except('_token') as $key => $value) {
            
            $setting = Settings::firstOrCreate(['field_key' => $key]);

            $setting->field_key     =   $key;
            $setting->field_value   =   $value;
            $setting->save();  

           
            if ($request->file($key)) {  

                $photo = $request->file($key);
                $destinationPath = storage_path('files/banner/');
                $photo->move($destinationPath, time().$photo->getClientOriginalName());
                $banner_image1 = time().$photo->getClientOriginalName();
                
                $setting = Settings::firstOrCreate(['field_key' => $key]);

                $setting->field_key     =   $key;
                $setting->field_value   =   $banner_image1;
                $setting->save(); 
               
            } 

        }

        return Redirect::to(route('setting'))
                        ->with('flash_alert_notice2', 'Site settigs was successfully updated!');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Settings $setting) {
        
        Product::where('id',$product->id)->delete();

        return Redirect::to(route('setting'))
                        ->with('flash_alert_notice', 'Product was successfully deleted!');
    }

    public function show(Settings $setting) {
        
    }

}
