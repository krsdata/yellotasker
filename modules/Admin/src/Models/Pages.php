<?php
namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 
use Modules\Admin\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class Pages extends Eloquent { 

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';
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
     protected $fillable = ['title','page_content','banner_image1']; // All field of user table here    



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     
  
}
