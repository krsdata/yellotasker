<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 

 
class Press extends Eloquent {
 
    /*
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'press_master';
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
   protected $fillable = ['pressName','link','articleDescription'];  // All field of user table here    
  
}
