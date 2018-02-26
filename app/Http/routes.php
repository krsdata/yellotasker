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
header("Access-Control-Allow-Origin: *");

Route::get('/', function () {

   // dd(Hash::make('admin'));
     return redirect('admin');
});

Route::get('sendMail','ApiController@sendMail'); 

/*
* Rest API Request , auth  & Route
*/ 
Route::group(['prefix' => 'api/v1'], function()
{   
    Route::group(['middleware' => 'api'], function () {

        Route::match(['post','get'],'user/signup','ApiController@register');  
        Route::match(['post','get'],'user/updateProfile/{id}','ApiController@updateProfile'); 
        Route::match(['post','get'],'user/login', 'ApiController@login'); 
        Route::match(['post','get'],'email_verification','ApiController@emailVerification');   
        Route::match(['post','get'],'user/forgotPassword','ApiController@forgetPassword'); 
        Route::post('password/reset','ApiController@resetPassword');  
        Route::match(['post','get'],'validate_user','ApiController@validateUser');
        Route::match(['post','get'],'categoryDashboard','ApiController@categoryDashboard');
        Route::match(['post','get'],'category','ApiController@category');
        Route::match(['post','get'],'getTaskByDueDate','ApiController@getTaskByDueDate');
        Route::match(['post','get'],'user/updatePassword','ApiController@changePassword'); 
        
        Route::match(['post','get'],'account/deactivate/{id}','ApiController@deactivateUser'); 
        
        Route::match(['post','get'],'userDetail/{id}','ApiController@userDetail'); 
        Route::match(['get'],'notifications','NotificationController@getAllNotification');
        Route::match(['get','post'],'molpay','MolpayPaymentController@index'); 
       
       
        Route::group(['middleware' => 'jwt-auth'], function () 
        { 
            Route::match(['post','get'],'get_condidate_record','APIController@getCondidateRecord'); 
            Route::match(['post','get'],'user/logout','ApiController@logout'); 
          
        });   


          /*---------End---------*/   

          Route::match(['post','get'],'getBlog',[
                'as' => 'getBlog',
                'uses' => 'TaskController@getBlog'
                ]
            );  

          Route::match(['post','get'],'postTask/createTask',[
                'as' => 'post_task_create',
                'uses' => 'TaskController@createTask'
                ]
            );  

           Route::match(['post','get'],'updatePostTask',[
                'as' => 'updatePostTask',
                'uses' => 'TaskController@updatePostTask'
                ]
            );  

            Route::match(['post','get'],'postTask/delete/{id}',[
                'as' => 'post_task_delete',
                'uses' => 'TaskController@deletePostTask'
                ]
            ); 


            Route::match(['post','get'],'postTask/deleteByUser/{id}',[
                'as' => 'post_task_delete_buyser',
                'uses' => 'TaskController@deletePostTaskByUser'
                ]
            );    

            Route::match(['get'],'getUserTasks/{user_id}',[
                'as' => 'get_user_tasks',
                'uses' => 'TaskController@getUserTasks'
                ]
            );
            
            Route::match(['get','post'],'getPostTask',[
                'as' => 'getPostTask',
                'uses' => 'TaskController@getPostTask'
                ]
            );

            Route::match(['get'],'getOpenTasks',[
                'as' => 'get_open_tasks',
                'uses' => 'TaskController@getOpenTasks'
                ]
            );

            Route::match(['get'],'getRecentTasks',[
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

           
            Route::match(['get','post'],'comment/post',[
                'as' => 'commentPost',
                'uses' => 'TaskController@comment'
                ]
            );

            Route::match(['get','post'],'makeOffer',[
                'as' => 'makeOffer',
                'uses' => 'TaskController@makeOffer'
                ]
            );

             Route::match(['get','post'],'deleteOffer',[
                'as' => 'deleteOffer',
                'uses' => 'TaskController@deleteOffer'
                ]
            );

              Route::match(['get','post'],'getAlloffers',[
                'as' => 'Alloffers',
                'uses' => 'TaskController@getAlloffers'
                ]
            );

              Route::match(['get','post'],'getMyPendingOffers',[
                'as' => 'MyPendingOffers',
                'uses' => 'TaskController@getMyPendingOffers'
                ]
            );

             

            Route::match(['get','post'],'updateOffer/{id}',[
                'as' => 'updateOffer',
                'uses' => 'TaskController@updateOffer'
                ]
            );

             Route::match(['get','post'],'taskOffer/{id}',[
                'as' => 'taskOffer',
                'uses' => 'TaskController@taskOffer'
                ]
            );

             Route::match(['get','post'],'saveTask',[
                'as' => 'saveTask',
                'uses' => 'TaskController@saveTask'
                ]
            );


             Route::match(['get','post'],'saveTask/delete',[
                'as' => 'saveTaskDelete',
                'uses' => 'TaskController@saveTaskDelete'
                ]
            );
             

            Route::match(['get','post'],'updateTaskStatus',[
                'as' => 'updateTaskStatus',
                'uses' => 'TaskController@updateTaskStatus'
                ]
            );

             

             Route::match(['get','post'],'getSaveTask/{id}',[
                'as' => 'getSaveTask',
                'uses' => 'TaskController@getSaveTask'
                ]
            ); 

            Route::match(['get','post'],'getUserTask/{id}',[
                'as' => 'getUserTask',
                'uses' => 'TaskController@getTask'
                ]
            ); 

              Route::match(['get','post'],'getReason',[
                'as' => 'getReason',
                'uses' => 'ReasonController@getReason'
                ]
            );

           Route::match(['get','post'],'getReport/user/{id}',[
                'as' => 'getReport',
                'uses' => 'ComplainController@getReport'
                ]
            );
           Route::match(['get','post'],'getReport/task/{id}',[
                'as' => 'getReport',
                'uses' => 'ComplainController@getReport'
                ]
            );

           Route::match(['get','post'],'report/{name}',[
                'as' => 'reportBy',
                'uses' => 'ComplainController@reportBy'
                ]
            ); 

            Route::match(['get','post'],'getMyOffer',[
                'as' => 'getMyOffer',
                'uses' => 'TaskController@getMyOffer'
                ]
            ); 

            Route::match(['get','post'],'assignTask',[
                'as' => 'assignTask',
                'uses' => 'TaskController@assignTask'
            ]);


            Route::match(['get','post'],'taskCompleteFromPoster',[
                'as' => 'taskCompleteFromPoster',
                'uses' => 'TaskController@taskCompleteFromPoster'
            ]);

            Route::match(['get','post'],'taskCompleteFromDoer',[
                'as' => 'taskCompleteFromDoer',
                'uses' => 'TaskController@taskCompleteFromDoer'
            ]);

            
            Route::match(['get','post'],'followTask',[
                'as' => 'followTask',
                'uses' => 'TaskController@followTask'
            ]);

            Route::match(['get','post'],'getFollowedTask/{uid}',[
                'as' => 'getFollowedTask',
                'uses' => 'TaskController@getFollowedTask'
            ]);

			Route::match(['get','post'],'reviewRating',[
                'as' => 'reviewRating',
                'uses' => 'TaskController@reviewRating'
            ]);

            Route::match(['get','post'],'generateOtp',[
                'as' => 'generateOtp',
                'uses' => 'ApiController@generateOtp'
            ]);

            Route::match(['get','post'],'verifyOtp',[
                'as' => 'verifyOtp',
                'uses' => 'ApiController@verifyOtp'
            ]);

             Route::match(['get','post'],'getArticle/{id}',[
                'as' => 'verifyOtp',
                'uses' => 'ComplainController@getArticle'
            ]);

          	Route::match(['get','post'],'getRelatedArticle/{id}',[
                'as' => 'verifyOtp',
                'uses' => 'ComplainController@getRelatedArticle'
            ]);

            Route::match(['get','post'],'supportListing',[
                'as' => 'verifyOtp',
                'uses' => 'ComplainController@supportListing'
            ]);

             Route::match(['get','post'],'getArticleCategory',[
                'as' => 'verifyOtp',
                'uses' => 'ComplainController@getArticleCategory'
            ]);

         	Route::match(['get','post'],'submitSupportRequest',[
                'as' => 'verifyOtp',
                'uses' => 'ComplainController@submitSupportRequest'
            ]);
            
            


            Route::match(['post','get'],'getPersonalMessage', 'ApiController@getPersonalMessage'); 
            Route::match(['post','get'],'addPersonalMessage', 'ApiController@addPersonalMessage'); 
            
    });
});    

/*
* Admin Based Auth
*/  
  

Route::get('/login','Adminauth\AuthController@showLoginForm'); 
//Route::post('password/reset','Adminauth\AuthController@resetPassword'); 
Route::post('password/reset','ApiController@resetPassword');  

 Route::post('password/email','ApiController@resetPassword'); 
 Route::get('molpay','MolpayPaymentController@index'); 
 Route::post('molpay/return_ipn','MolpayPaymentController@return_ipn'); 
 Route::post('molpay/notification_ipn','MolpayPaymentController@notification_ipn'); 
 Route::get('molpay/payment/success','MolpayPaymentController@success'); 
 Route::post('molpay/payment/failed','MolpayPaymentController@failed'); 

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