<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MolpayPayment extends Model
{
    protected $table = 'molpay_payments';
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
}
