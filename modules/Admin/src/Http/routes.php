<?php
   
    Route::get('admin/login','Modules\Admin\Http\Controllers\AuthController@index');
    Route::get('admin/forgot-password','Modules\Admin\Http\Controllers\AuthController@forgetPassword');
    Route::post('password/email','Modules\Admin\Http\Controllers\AuthController@sendResetPasswordLink');
    Route::get('admin/password/reset','Modules\Admin\Http\Controllers\AuthController@resetPassword');  
    Route::get('admin/logout','Modules\Admin\Http\Controllers\AuthController@logout'); 


    Route::post('admin/blog/ajax', 'Modules\Admin\Http\Controllers\BlogController@ajax');

    Route::post('admin/login',function(App\Admin $user){
   
    $credentials = ['email' => Input::get('email'), 'password' => Input::get('password')]; 
    
   // $credentials = ['email' => 'kundan@gmail.com', 'password' => 123456]; 
    
   // $auth = auth()->guard('web');
   // Session::set('role','admin');
   
    $admin_auth = auth()->guard('admin'); 
    $user_auth =  auth()->guard('web'); //Auth::attempt($credentials); 

    if ($admin_auth->attempt($credentials) OR $user_auth->attempt($credentials)) {
            return Redirect::to('admin');
        }else{ 
            return redirect()
                        ->back()
                        ->withInput()  
                        ->withErrors(['message'=>'Invalid email or password. Try again!']);
            } 
    }); 
    
    Route::group(['middleware' => ['admin','userpermission']], function () {

        Route::get('admin', 'Modules\Admin\Http\Controllers\AdminController@index');
        
        /*------------User Model and controller---------*/

        Route::bind('user', function($value, $route) {
            return Modules\Admin\Models\User::find($value);
        });

        Route::resource('admin/user', 'Modules\Admin\Http\Controllers\UsersController', [
            'names' => [
                'edit' => 'user.edit',
                'show' => 'user.show',
                'destroy' => 'user.destroy',
                'update' => 'user.update',
                'store' => 'user.store',
                'index' => 'user',
                'create' => 'user.create',
            ]
                ]
        );
        Route::resource('admin/clientuser', 'Modules\Admin\Http\Controllers\ClientUsersController', [
            'names' => [
                'edit' => 'clientuser.edit',
                'show' => 'clientuser.show',
                'destroy' => 'clientuser.destroy',
                'update' => 'clientuser.update',
                'store' => 'clientuser.store',
                'index' => 'clientuser',
                'create' => 'clientuser.create',
            ]
                ]
        );


       
        /*------------User Category and controller---------*/

            Route::bind('category', function($value, $route) {
                return Modules\Admin\Models\Category::find($value);
            });
     
            Route::resource('admin/category', 'Modules\Admin\Http\Controllers\CategoryController', [
                'names' => [
                    'edit'      => 'category.edit',
                    'show'      => 'category.show',
                    'destroy'   => 'category.destroy',
                    'update'    => 'category.update',
                    'store'     => 'category.store',
                    'index'     => 'category',
                    'create'    => 'category.create',
                ]
                    ]
            );
        /*---------End---------*/   


        /*------------User Category and controller---------*/

            Route::bind('sub-category', function($value, $route) {
                return Modules\Admin\Models\Category::find($value);
            });
     
            Route::resource('admin/sub-category', 'Modules\Admin\Http\Controllers\SubCategoryController', [
                'names' => [
                    'edit' => 'sub-category.edit',
                    'show' => 'sub-category.show',
                    'destroy' => 'sub-category.destroy',
                    'update' => 'sub-category.update',
                    'store' => 'sub-category.store',
                    'index' => 'sub-category',
                    'create' => 'sub-category.create',
                ]
                    ]
            );
             /*------------User Category and controller---------*/

            Route::bind('category-dashboard', function($value, $route) {
                return Modules\Admin\Models\CategoryDashboard::find($value);
            });
     
            Route::resource('admin/category-dashboard', 'Modules\Admin\Http\Controllers\CategoryDashboardController', [
                'names' => [
                    'edit' => 'category-dashboard.edit',
                    'show' => 'category-dashboard.show',
                    'destroy' => 'category-dashboard.destroy',
                    'update' => 'category-dashboard.update',
                    'store' => 'category-dashboard.store',
                    'index' => 'category-dashboard',
                    'create' => 'category-dashboard.create',
                ]
                    ]
            );
        /*---------Contact Route ---------*/    

        Route::bind('contact', function($value, $route) {
            return Modules\Admin\Models\Contact::find($value);
        });
 
        Route::resource('admin/contact', 'Modules\Admin\Http\Controllers\ContactController', [
            'names' => [
                'edit' => 'contact.edit',
                'show' => 'contact.show',
                'destroy' => 'contact.destroy',
                'update' => 'contact.update',
                'store' => 'contact.store',
                'index' => 'contact',
                'create' => 'contact.create',
            ]
                ]
        );  

         Route::bind('comment', function($value, $route) {
            return App\Models\Comments::find($value);
        });
 
        Route::resource('admin/comment', 'Modules\Admin\Http\Controllers\CommentController', [
            'names' => [
                'edit' => 'comment.edit',
                'show' => 'comment.show',
                'destroy' => 'comment.destroy',
                'update' => 'comment.update',
                'store' => 'comment.store',
                'index' => 'comment',
                'create' => 'comment.create',
            ]
                ]
        );  

        Route::resource('admin/compaint', 'Modules\Admin\Http\Controllers\CompaintController', [
            'names' => [
                'index' => 'compaint',
            ]
                ]
        );


         Route::bind('postTask', function($value, $route) {
            return Modules\Admin\Models\PostTask::find($value);
        });
 
        Route::resource('admin/postTask', 'Modules\Admin\Http\Controllers\PostTaskController', [
            'names' => [
                'edit' => 'postTask.edit',
                'show' => 'postTask.show',
                'destroy' => 'postTask.destroy',
                'update' => 'postTask.update',
                'store' => 'postTask.store',
                'index' => 'postTask',
                'create' => 'postTask.create',
            ]
                ]
        );  

        Route::get('admin/mytask/{id}','Modules\Admin\Http\Controllers\PostTaskController@mytask');



        // programs
         Route::bind('program', function($value, $route) {
            return Modules\Admin\Models\Program::find($value);
        });
 
        Route::resource('admin/program', 'Modules\Admin\Http\Controllers\ProgramController', [
            'names' => [
                'edit' => 'program.edit',
                'show' => 'program.show',
                'destroy' => 'program.destroy',
                'update' => 'program.update',
                'store' => 'program.store',
                'index' => 'program',
                'create' => 'program.create',
            ]
                ]
        );  


        // programs
         Route::bind('reason', function($value, $route) {
            return Modules\Admin\Models\Reason::find($value);
        });
 
        Route::resource('admin/reason', 'Modules\Admin\Http\Controllers\ReasonController', [
            'names' => [
                'edit' => 'reason.edit',
                'show' => 'reason.show',
                'destroy' => 'reason.destroy',
                'update' => 'reason.update',
                'store' => 'reason.store',
                'index' => 'reason',
                'create' => 'reason.create',
            ]
                ]
        );  


         Route::get('admin/createGroup', 'Modules\Admin\Http\Controllers\ContactController@createGroup');  
         Route::post('admin/contact/import', 'Modules\Admin\Http\Controllers\ContactController@contactImport');  


        //  Route::bind('contacts', function($value, $route) {
        //     return Modules\Admin\Models\Contact::find($value);
        // });

        // Route::resource('admin/contacts', 'Modules\Admin\Http\Controllers\ContactController', [
        //     'names' => [
        //         'edit' => 'contacts.edit',
        //         'show' => 'contacts.show',
        //         'destroy' => 'contacts.destroy',
        //         'update' => 'contacts.update',
        //         'store' => 'contacts.store',
        //         'index' => 'contacts',
        //         'create' => 'contacts.create',
        //     ]
        //         ]
        // );  



        Route::get('admin/updateGroup', 'Modules\Admin\Http\Controllers\ContactGroupController@updateGroup'); 
         /*---------Contact Route ---------*/    

        Route::bind('contactGroup', function($value, $route) {
            return Modules\Admin\Models\ContactGroup::find($value);
        });
 
        Route::resource('admin/contactGroup', 'Modules\Admin\Http\Controllers\ContactGroupController', [
            'names' => [
                'edit' => 'contactGroup.edit',
                'show' => 'contactGroup.show',
                'destroy' => 'contactGroup.destroy',
                'update' => 'contactGroup.update',
                'store' => 'contactGroup.store',
                'index' => 'contactGroup',
                'create' => 'contactGroup.create',
            ]
                ]
        );


        Route::bind('transaction', function($value, $route) {
            return Modules\Admin\Models\Transaction::find($value);
        });
 
        Route::resource('admin/transaction', 'Modules\Admin\Http\Controllers\TransactionController', [
            'names' => [
                'edit'      => 'transaction.edit',
                'show'      => 'transaction.show',
                'destroy'   => 'transaction.destroy',
                'update'    => 'transaction.update',
                'store'     => 'transaction.store',
                'index'     => 'transaction',
                'create'    => 'transaction.create',
            ]
                ]
        ); 

        Route::bind('setting', function($value, $route) {
            return Modules\Admin\Models\Settings::find($value);
        });
 
        Route::resource('admin/setting', 'Modules\Admin\Http\Controllers\SettingsController', [
            'names' => [
                'edit'      => 'setting.edit',
                'show'      => 'setting.show',
                'destroy'   => 'setting.destroy',
                'update'    => 'setting.update',
                'store'     => 'setting.store',
                'index'     => 'setting',
                'create'    => 'setting.create',
            ]
                ]
        ); 


         Route::bind('blog', function($value, $route) {
            return Modules\Admin\Models\Blogs::find($value);
        });
 
        Route::resource('admin/blog', 'Modules\Admin\Http\Controllers\BlogController', [
            'names' => [
                'edit' => 'blog.edit',
                'show' => 'blog.show',
                'destroy' => 'blog.destroy',
                'update' => 'blog.update',
                'store' => 'blog.store',
                'index' => 'blog',
                'create' => 'blog.create',
            ]
                ]
        );


        Route::bind('role', function($value, $route) {
            return App\Role::find($value);
        });
 
        Route::resource('admin/role', 'Modules\Admin\Http\Controllers\RoleController', [
            'names' => [
                'edit' => 'role.edit',
                'show' => 'role.show',
                'destroy' => 'role.destroy',
                'update' => 'role.update',
                'store' => 'role.store',
                'index' => 'role',
                'create' => 'role.create',
            ]
                ]
        );
		
	 
        Route::match(['get','post'],'admin/permission', 'Modules\Admin\Http\Controllers\RoleController@permission');

        /*----------End---------*/    
        
        Route::match(['get','post'],'admin/profile', 'Modules\Admin\Http\Controllers\AdminController@profile'); 
        
        Route::match(['get','post'],'admin/monthly-report/{name}', 'Modules\Admin\Http\Controllers\MonthlyReportController@corporateUser'); 
        Route::match(['get','post'],'admin/corporate-monthly-report', 'Modules\Admin\Http\Controllers\MonthlyReportController@index'); 
             
  });



 
 
     
 
  
