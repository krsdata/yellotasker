<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
      protected $table = 'withdrawal';
    
    public  function userDetail(){
    return $this->hasOne('App\User','id','userId') ;
    }

    //
}
