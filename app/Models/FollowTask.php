<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class FollowTask extends Authenticatable {

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'follow_tasks';
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

    public function user()
    {
        return $this->belongsTo('App\User','userId','id');
    }

    public function task()
    {
        return $this->hasMany('App\Models\Tasks','id','taskId');
    }

    public function followTask()
    {
        return $this->hasOne('App\Models\Tasks','id','taskId');
    }

    
}