<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 
use Modules\Admin\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class Transaction extends Eloquent {

   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';
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
    protected $fillable = [
                            'user_id',
                            'product_id',
                            'product_key_id',
                            'payment_mode',
                            'status',
                            'coupan_id',
                            'discount',
                            'total_price',
                            'discount_price',
                            'transaction_id',
                            'product_details'
                        ]; 

                         // All field of user table here    


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    

    public function user()
    {
       
        return $this->belongsTo('Modules\Admin\Models\User','user_id','id');
    }
    /*---product---*/
    public function product()
    {
       
        return $this->belongsTo('Modules\Admin\Models\Product','product_id','id');
    }
    /*---Product key--------*/
    public function productkey()
    {
       
        return $this->belongsTo('Modules\Admin\Models\ProductKey','product_key_id','id');
    }
    /*-----Coupam-------*/
    public function coupan()
    {
       
        return $this->belongsTo('Modules\Admin\Models\Coupan','coupan_id','id');
    }
  
}
