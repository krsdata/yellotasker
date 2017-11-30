<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;
 
use Auth;

class Complains extends Authenticatable {

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'complains';
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
    

    protected $guarded = ['created_at' , 'updated_at' , 'id' ];


    public  function reportedUser()
    {
        return $this->hasMany('App\User','id','reportedUserId') ;
    }

    public  function postedUser()
    {
        return $this->hasOne('App\User','id','postedUserId') ;
    }

    public function task()
    {
        return $this->belongsTo('App\Models\Tasks','taskId','id');
    }

    public function reason()
    {
        return $this->belongsTo('Modules\Admin\Models\Reason','reasonId','id');
    }

    
}