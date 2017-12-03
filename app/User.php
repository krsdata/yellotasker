<?php

namespace App;
use Auth;
use Session;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
   
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
    protected $fillable = ['first_name','last_name','email', 'role_type','status','password'];  // All field of user table here    


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    
     public function saveTask()
    {
        return $this->hasMany('App\Models\SavedTask','userId','id')->select(['id','taskId','userId']);//->with('task');
    }
    public function reportedDetails()
    {
        return $this->hasMany('App\Models\Complains','postedUserId')->with('reportedUser');
    }

    public function openTask()
    {
        return $this->hasMany('App\Models\Tasks','userId')->select(['id','id as taskId','userId'])->where('status','open');
    }
    public function pendingTask()
    {
        return $this->hasMany('App\Models\Tasks','userId')->select(['id','id as taskId','userId'])->where('status','pending');
    }
    public function assignedTask()
    {
        return $this->hasMany('App\Models\Tasks','userId')->select(['id','id as taskId','userId'])->where('status','assigned');
    }
    public function completedTask()
    {
        return $this->hasMany('App\Models\Tasks','userId')->select(['id','id as taskId','userId'])->where('status','completed');
    }
    public function offers()
    {
        return $this->hasMany('App\Models\Offers','interestedUsreId')->select(['id','taskId','interestedUsreId']);
    }


}
