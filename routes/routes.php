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


          /*---------End---------*/   
 
        /*-------------Course API Route -------------*/

        Route::match(['post','get'],'course',[
            'as' => 'course_index',
            'uses' => 'CourseController@index'
            ]
        );

      
        Route::match(['post','get'],'course/create',[
            'as' => 'course_create',
            'uses' => 'CourseController@create'
            ]
        );
        Route::match(['post','get'],'course/edit',[
            'as' => 'course_edit',
            'uses' => 'CourseController@edit'
            ]
        );

        Route::match(['post','get'],'course/update',[
            'as' => 'course_update',
            'uses' => 'CourseController@update'
            ]
        );

         Route::match(['post','get'],'course/store',[
            'as' => 'course_store',
            'uses' => 'CourseController@store'
            ]
        );
 
        /*-------------Course API Route END-------------*/


        /*-------------Syllabus API Route -------------*/

        Route::match(['post','get'],'syllabus',[
            'as' => 'syllabus_index',
            'uses' => 'SyllabusController@index'
            ]
        );

      
        Route::match(['post','get'],'syllabus/create',[
            'as' => 'syllabus_create',
            'uses' => 'SyllabusController@create'
            ]
        );

        Route::match(['post','get'],'syllabus/edit',[
            'as' => 'syllabus_edit',
            'uses' => 'SyllabusController@edit'
            ]
        );

        Route::match(['post','get'],'syllabus/update',[
            'as' => 'syllabus_update',
            'uses' => 'SyllabusController@update'
            ]
        );

         Route::match(['post','get'],'syllabus/store',[
            'as' => 'syllabus_store',
            'uses' => 'SyllabusController@store'
            ]
        );

        Route::match(['post','get'],'syllabus/destroy',[
            'as' => 'syllabus_destroy',
            'uses' => 'SyllabusController@destroy'
            ]
        );

         Route::match(['post','get'],'syllabus/show',[
            'as' => 'syllabus_show',
            'uses' => 'SyllabusController@show'
            ]
        );

        Route::match(['post','get'],'syllabus/clone',[
            'as' => 'syllabus_clone',
            'uses' => 'SyllabusController@cloneSyllabus'
            ]
        );
 
        /*-------------Syllabus API Route END-------------*/


        /*-------------Assignment API Route -------------*/

        Route::match(['post','get'],'assignment',[
            'as' => 'assignment_index',
            'uses' => 'AssignmentController@index'
            ]
        ); 
      
        Route::match(['post','get'],'assignment/create',[
            'as' => 'assignment_create',
            'uses' => 'AssignmentController@create'
            ]
        );
        
        Route::match(['post','get'],'assignment/edit',[
            'as' => 'assignment_edit',
            'uses' => 'AssignmentController@edit'
            ]
        );

        Route::match(['post','get'],'assignment/update',[
            'as' => 'assignment_update',
            'uses' => 'AssignmentController@update'
            ]
        );

         Route::match(['post','get'],'assignment/store',[
            'as' => 'assignment_store',
            'uses' => 'AssignmentController@store'
            ]
        );

          Route::match(['post','get'],'assignment/show',[
            'as' => 'assignment_show',
            'uses' => 'AssignmentController@show'
            ]
        );

        Route::match(['post','get'],'assignment/destroy',[
            'as' => 'assignment_destroy',
            'uses' => 'AssignmentController@destroy'
            ]
        );
        /*----------Student API-----------------*/
        Route::match(['post','get'],'student',[
            'as' => 'assignment_index',
            'uses' => 'StudentController@index'
            ]
        );

        Route::match(['post','get'],'student/course',[
            'as' => 'student_course',
            'uses' => 'StudentController@course'
            ]
        );

        Route::match(['post','get'],'student/course/syllabus',[
            'as' => 'student_syllabus',
            'uses' => 'StudentController@syllabus'
            ]
        );

        Route::match(['post','get'],'student/course/syllabus/assignment',[
            'as' => 'student_assignment',
            'uses' => 'StudentController@assignment'
            ]
        );
 
        /*-------------Syllabus API Route END-------------*/

        
            
    });
});    

/*
* Admin Based Auth
*/  
  

Route::get('/login','Adminauth\AuthController@showLoginForm'); 
Route::post('password/reset','Adminauth\AuthController@resetPassword'); 


Route::get('admin/404',function(){
    if(Auth::guard('admin')->check()==false){
        return redirect('admin');
    }

    $page_title = "404 Error";
              $page_action = "Page";
              $viewPage = "404 Error";
              $msg = "page not found";
              $error_msg = "Page not found!"; 
              return view('packages::auth.page_not_found',compact('error_msg','page_title','page_action','viewPage'))->with('flash_alert_notice', $msg);
});
