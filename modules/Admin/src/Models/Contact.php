<?php
namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contact extends Model {

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contacts';
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
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstName','lastName','name','email','phone'];  // All field of user table here    
    public function contactGroup()
    {
        return $this->hasMany('Modules\Admin\Models\ContactGroup','contactId','id')->groupBy('contactId');
    }
    
    
  
}
