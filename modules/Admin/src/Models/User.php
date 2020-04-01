<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Admin\Models\Group;
use Modules\Admin\Models\Position;
use Auth;
use URL;

class User extends Authenticatable {

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     /**
     * The primary key used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
                            'first_name',
                            'last_name',
                            'about_me',
                            'profile_image',
                            'phone',
                            'mobile',
                            'email', 
                            'role_type',
                            'password',
                            'status',
                            'tagLine',
                            'address',
                            'birthday',
                            'skills',
                            'modeOfreach',
                            'language',
                            'qualification',
                            'workExperience',
                            'percentageCompletion',
                            'rating', 
                            'position',
                            'extension',
                            'dateOfBirth',
                            'companyLogo',
                            'occupation',
                            'interests'
                        ];  // All field of user table h


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $guarded = ['created_at' , 'updated_at' , 'id' ];

    // Return user record
    public function getUserDetail($id=null)
    {
        if($id){
            return User::find($id); 
        }
        return User::all();
    }

      public static function createImage($request, $fielName)
    {
        try{
           
            if ($request->file($fielName)) {
                $photo = $request->file($fielName);

                $destinationPath = storage_path('uploads/profile/');
                $photo->move($destinationPath, time().$photo->getClientOriginalName());
                $photo_name = time().$photo->getClientOriginalName();
                return  URL::asset('storage/uploads/profile/'.$photo_name);
                //$request->merge(['photo'=>$photo_name]);
            }else{
                 return false;
            }  
            
        }catch(Exception $e){
            return false;
        }
        
    }

    public function role(){
        return $this->belongsTo('Modules\Admin\Models\Role','user_id');
    }


}