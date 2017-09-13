<?php
    
    Route::get('abc',function(){
        echo "test";
    });

    Route::get('admin/login','Modules\Admin\Http\Controllers\AuthController@index');
    Route::get('admin/forgot-password','Modules\Admin\Http\Controllers\AuthController@forgetPassword');
    Route::post('password/email','Modules\Admin\Http\Controllers\AuthController@sendResetPasswordLink');
    Route::get('admin/password/reset','Modules\Admin\Http\Controllers\AuthController@resetPassword');  
    Route::get('admin/logout','Modules\Admin\Http\Controllers\AuthController@logout');  

    Route::post('admin/login',function(App\Admin $user){
   
    $credentials = ['email' => Input::get('email'), 'password' => Input::get('password')]; 
    
   // $credentials = ['email' => 'kundan@gmail.com', 'password' => 123456]; 
    $auth = auth()->guard('admin');
    

        if ($auth->attempt($credentials)) {
            return Redirect::to('admin');
        }else{ 
           //return Redirect::to('admin/login')->withError(['message'=>'Invalid Credential!']);
            return redirect()
                        ->back()
                        ->withInput()  
                        ->withErrors(['message'=>'Invalid email or password. Try again!']);
            } 
    }); 
      
    Route::group(['middleware' => ['admin']], function () { 

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

         Route::get('admin/createGroup', 'Modules\Admin\Http\Controllers\ContactController@createGroup');  



         Route::bind('contacts', function($value, $route) {
            return Modules\Admin\Models\Contact::find($value);
        });

        Route::resource('admin/contacts', 'Modules\Admin\Http\Controllers\ContactController', [
            'names' => [
                'edit' => 'contacts.edit',
                'show' => 'contacts.show',
                'destroy' => 'contacts.destroy',
                'update' => 'contacts.update',
                'store' => 'contacts.store',
                'index' => 'contacts',
                'create' => 'contacts.create',
            ]
                ]
        );  




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


          Route::bind('page', function($value, $route) {
            return Modules\Admin\Models\Pages::find($value);    
        });
 
        Route::resource('admin/page', 'Modules\Admin\Http\Controllers\PageController', [
            'names' => [
                'edit'      => 'page.edit',
                'show'      => 'page.show',
                'destroy'   => 'page.destroy',
                'update'    => 'page.update',
                'store'     => 'page.store',
                'index'     => 'page',
                'create'    => 'page.create',
            ]
                ]
        ); 


        /*----------End---------*/    
        
        Route::match(['get','post'],'admin/profile', 'Modules\Admin\Http\Controllers\AdminController@profile'); 
        
        Route::match(['get','post'],'admin/monthly-report/{name}', 'Modules\Admin\Http\Controllers\MonthlyReportController@corporateUser'); 
        Route::match(['get','post'],'admin/corporate-monthly-report', 'Modules\Admin\Http\Controllers\MonthlyReportController@index'); 
             
  });



 
 
     
 
  