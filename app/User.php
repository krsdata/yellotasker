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

        return $this->belongsToMany('App\Models\Tasks', 'saveTask','userId','taskId')->groupBy('saveTask.taskId')->orderBy('saveTask.id','desc');
    }

   
    public function reportedDetails()
    {
        return $this->hasMany('App\Models\Complains','postedUserId')->with('reportedUser');
    }

    public function openTask()
    {
        return $this->hasMany('App\Models\Tasks','userId')->where('status','open');
    }
    public function pendingTask()
    {
        return $this->hasMany('App\Models\Tasks','userId')->where('status','pending');
    }
    public function assignedTask()
    {
        return $this->hasMany('App\Models\Tasks','userId')->where('status','assigned');
    }
    public function completedTask()
    {
        return $this->hasMany('App\Models\Tasks','userId')->where('status','completed');
    }
    public function offer_task()
    {
       // return $this->hasMany('App\Models\Offers','interestedUsreId')->with('mytask');

         return $this->belongsToMany('App\Models\Tasks', 'offers','interestedUsreId','taskId')->groupBy('offers.taskId')->orderBy('offers.id','desc');
    }


}
