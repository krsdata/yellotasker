<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class AdminLogin extends BaseModel {

    /**
     * The metrics table.
     * 
     * @var string
     */
    protected $table = 'admin';
    protected $guarded = ['created_at' , 'updated_at' , 'id' ];
    protected $fillable = ['email','password'];

}


