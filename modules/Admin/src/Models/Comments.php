<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 
use Illuminate\Http\Request;
use Input;
use Validator;
use Auth;
use Hash;
use View;
use URL;
use Lang;
use Session;
use DB;
use Route;
use Crypt;
use Illuminate\Http\Dispatcher;

class Comments extends Eloquent {

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';
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

    // user details
    public  function userDetail()
    {
        return $this->hasOne('App\User','id','userId') ;
    }

    public  function commentReply()
    {
        return $this->hasMany('App\Models\Comments','commentId')->with('userDetail') ;
    }

}