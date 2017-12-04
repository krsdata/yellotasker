<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Admin\Models\Group;
use Modules\Admin\Models\Position;
use Auth;

class Tasks extends Authenticatable {

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_tasks';
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

    //protected $dates = ['due_date'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $guarded = ['created_at' , 'updated_at' , 'id' ];


    public  function userDetail()
    {
        return $this->hasOne('App\User','id','userId') ;
    }

    public function OfferTask()
    {
        return $this->hasMany('App\Models\Offers','taskId','id');
    }

    public function reportedDetails()
    {
        return $this->hasMany('App\Models\Complains','taskId')->with('reportedUser');
    }

     public function interestedUsers() {
        return $this->belongsToMany('App\User', 'offers', 'taskId', 'interestedUsreId');
    }

    public function saveTask()
    {
         return $this->hasMany('App\Models\SavedTask','taskId','id');
    }

    
}