<?php

namespace Modules\Api\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 


class CategoryDashboard extends Eloquent {


     protected $parent = 'parent_id';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categoryDashboard';
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
    protected $fillable = ['name','category','display_order','category_id'];  // All field of user table here    


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

     public function subcategory()
    {
       
        return $this->belongsTo('Modules\Admin\Models\Category','parent_id','id');
    }

    public function parent()
    {
        return $this->belongsTo('Modules\Admin\Models\Category', 'parent_id');
    }
 
    
  
}
