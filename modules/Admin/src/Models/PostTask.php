<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 
use Modules\Admin\Models\Group;
use Modules\Admin\Models\Position; 

class PostTask extends Eloquent {

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_tasks';
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
        return $this->hasOne('Modules\Admin\Models\User','id','userId');
    }

}