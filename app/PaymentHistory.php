<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * USED TO STORE PAYMENT RELEASE UPON TASK COMPLETE
 */
class PaymentHistory extends Model
{
  protected $table = 'payment_history';
    //
      protected $guarded = ['created_at' , 'updated_at' , 'id'];

    public function userDetails() {
        return $this->belongsTo('App\Models\Tasks', 'user_id', 'id');
    }

    public function taskDetails() {
        return $this->belongsTo('App\Models\Tasks', 'taskId', 'id')->with('taskPostedUser', 'seekerUserDetail');
    }

}
