<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\ArticleRequest;
use Modules\Admin\Models\User; 
use Modules\Admin\Models\Article;
use Modules\Admin\Models\ArticleType;
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
class ArticleController extends Controller { 

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
        View::share('viewPage', 'Article');
        View::share('helper',new Helper);
        View::share('heading','Article');
        $this->record_per_page = Config::get('app.record_per_page');
        View::share('route_url',route('article'));

    }

    protected $article;

    /*
     * Dashboard
     * */

    public function index(Article $article, Request $request) 
    { 
        $page_title = 'Article'; 
        $page_action = 'View Article'; 
        if ($request->ajax()) {
            $id = $request->get('id'); 
            $Article = Article::find($id); 
            $Article->status = $s;
            $catArticleegory->save();
            echo $s;
            exit();
        }

        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');
        if ((isset($search) && !empty($search))) {

            $search = isset($search) ? Input::get('search') : '';


            $article_type = ArticleType::where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('article_type', 'LIKE', "%$search%")
                                    ->OrWhere('resolution_department', 'LIKE', "%$search%");
                        }
                    })->lists('id');

            
            $results = Article::with('articleCategory')
                    ->where(function($query) use($search,$article_type) {
                        if (!empty($search)) {
                            $query->where('article_title', 'LIKE', "%$search%");
                            $query->orWhereIn('article_type', $article_type);
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $results = Article::with('articleCategory')->Paginate($this->record_per_page);
        }
        return view('packages::article.index', compact('results','Article','page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(Article $result,Request $request) 
    {
        $id =  $request->get('id');
        $page_title = 'Article';
        $page_action = 'Create Article'; 
        $article_types = ArticleType::all();
         
        return view('packages::article.create', compact('id','article_types','result','page_title', 'page_action'))->withInput(Input::all());
    }

    /*
     * Save Group method
     * */
  
    public function store(ArticleRequest $request, Article $result) 
    {                   
        $result->fill(Input::all()); 
        $result->save(); 
        return Redirect::to(route('article'))
                            ->with('flash_alert_notice', 'New Article Type  successfully created.');
    }

    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit(Article $result,Request $request) {

        $page_title = 'Article';  
        $page_action = 'Edit Article'; 
        $article_types = ArticleType::all();

 
        return view('packages::article.edit', compact('article_types','result', 'page_title', 'page_action'));
    }

    public function update(Request $request, Article $result) {
         
        $result->fill(Input::all()); 
        $result->save();    
        return Redirect::to(route('article'))
                        ->with('flash_alert_notice', 'Article successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy(Article $article) {
        
        $del = Article::where('id',$article->id)->delete(); 
        return Redirect::to(URL::previous())
                        ->with('flash_alert_notice', 'Article successfully deleted.');
    }

    public function show(Article $article) {
        
        //Article::with('articleCategory')->Paginate($this->record_per_page);
        $result = $article->with('articleCategory')->first();
        $page_title  = 'Article';
        $page_action  = 'Show Article';
        return view('packages::article.show', compact('result','data', 'page_title', 'page_action','html'));

    }

}
