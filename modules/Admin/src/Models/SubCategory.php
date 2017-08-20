<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 

use Nestable\NestableTrait; 

class SubCategory extends Eloquent {

     use NestableTrait;

     protected $parent = 'parent_id';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';
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
   protected $fillable = ['sub_category_name'];  // All field of user table here    


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
  
}
