<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class Tasks extends Authenticatable {

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_tasks';

    public $is_paid = 0;

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

    public  function taskPostedUser()
    {
         return $this->belongsTo('App\User', 'userId', 'id')->with('posterReview');
    }

    public  function taskAssignedUser()
    {
         return $this->belongsTo('App\User', 'taskDoerId', 'id');
    }

    public  function taskFollowedUser()
    {
         return $this->belongsTo('App\User', 'userId', 'id');
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
        return $this->belongsToMany('App\User', 'offers', 'taskId', 'interestedUserId')->orderBy('offers.id','desc'); 
    }

    public function offerDetails(){
        return $this->hasMany('App\Models\Offers','taskId','id')->with('interestedUser');
    }

  
    public function saveTask()
    {
         return $this->hasMany('App\Models\SavedTask','taskId','id');
    }

    public function allOffers2()
    {
         
        return $this->hasMany('App\Models\Offers','taskId','id')->with('interestedUser');

      //  return $this->belongsToMany('App\User', 'offers', 'taskId', 'interestedUserId');

    }



    public function allOffers()
    {
       return $this->belongsToMany('App\User', 'offers','taskId','interestedUserId');
    }


    public function saveTasStatus()
    {
       return $this->hasMany('App\Models\SavedTask','taskId','id')->select('status');
    }

    public function postUserDetail()
    {
        return $this->belongsTo('App\User', 'taskOwnerId','id');//->select('id','first_name','rating');
    } 
    public function seekerUserDetail()
    {
        return $this->belongsTo('App\User', 'taskDoerId','id');//->select('id','first_name','rating');
    } 

    public function doerUserDetail()
    {
        return $this->belongsTo('App\User', 'taskDoerId','id')->with('doerReview');//->select('id','first_name','rating');
    } 


    public function avgRatingByDoer()
    {
         return $this->hasMany('App\Models\Review', 'taskId','id');
    } 

    public function avgRatingByPoster()
    {
         return $this->hasMany('App\Models\Review', 'taskId','id');
    } 



    public function offer_count()
    {
         return   $this->hasMany('App\Models\Offers','taskId','id'); //->select(\DB::raw('count(*) as total_offer'));
    }
    
}