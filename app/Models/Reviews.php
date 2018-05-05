<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class Reviews extends Authenticatable {

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'review';
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
        return $this->belongsTo('App\User','taskDoerId','id');
    }


    public function taskDoerUser()
    {
        return $this->belongsTo('App\User','taskDoerId','id');
    }

    public function taskPostUser()
    {
        return $this->belongsTo('App\User','posterUserId','id');
    }

    public function task()
    {
        return $this->hasMany('App\Models\Tasks','id','taskId');
    }

    
}