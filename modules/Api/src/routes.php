<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//use Redirect;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, auth-token');
header('Access-Control-Allow-Credentials: true');

Route::get('/', function () {

   // dd(Hash::make('admin'));
     return redirect('admin');
});

/*
* Rest API Request , auth  & Route
*/ 
Route::group(['prefix' => 'api/v1'], function()
{   
    Route::group(['middleware' => 'api'], function () {
        
        /*-------------Task API Route -------------*/

        Route::group(array('namespace' => 'Modules\Api\Controllers'), function()
        {
            Route::match(['post','get'],'user/signup','ApiController@register');  
            Route::match(['post','get'],'user/updateProfile','ApiController@updateProfile'); 
            Route::match(['post','get'],'user/login', 'ApiController@login'); 
            Route::match(['post','get'],'email_verification','ApiController@emailVerification');   
            Route::match(['post','get'],'user/forgotPassword','ApiController@forgetPassword');  
            Route::match(['post','get'],'validate_user','ApiController@validateUser');
            Route::group(['middleware' => 'jwt-auth'], function () 
            { 
               Route::match(['post','get'],'get_condidate_record','APIController@getCondidateRecord'); 
               Route::match(['post','get'],'user/logout','ApiController@logout'); 
               Route::match(['post','get'],'change_password','ApiController@changePassword');
               Route::match(['post','get'],'get_interviewer','ApiController@getInterviewer');
               Route::match(['post','get'],'add_interview','ApiController@addInterview');
               Route::match(['post','get'],'user/details','ApiController@getUserDetails');
            }); 

            Route::match(['post','get'],'post-task/create',[
                'as' => 'post-task_create',
                'uses' => 'TaskController@create'
                ]
            );      

            Route::match(['get'],'get-user-tasks/{user_id}',[
                'as' => 'get_user_tasks',
                'uses' => 'TaskController@getUserTasks'
                ]
            );
 
            Route::match(['get'],'get-all-tasks',[
                'as' => 'get_all_tasks',
                'uses' => 'TaskController@getAllTasks'
                ]
            );

            Route::match(['get'],'get-open-tasks',[
                'as' => 'get_open_tasks',
                'uses' => 'TaskController@getOpenTasks'
                ]
            );

            Route::match(['get'],'get-recent-tasks',[
                'as' => 'get_recent_tasks',
                'uses' => 'TaskController@getRecentTasks'
                ]
            );
            /*-------------Dashbord API Route -------------*/

            Route::match(['get'],'dashboard/categories',[
                'as' => 'dashboard_get_categories',
                'uses' => 'DashboardController@getCategories'
                ]
            );

            Route::match(['post','get'],'course',[
                'as' => 'course_index',
                'uses' => 'CourseController@index'
                ]
            );    
        });
    });
});    

/*
* Admin Based Auth
*/  
  

Route::get('/login','Adminauth\AuthController@showLoginForm'); 
Route::post('password/reset','Adminauth\AuthController@resetPassword'); 
