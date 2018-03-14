<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     /**
     * The metrics table.
     * 
     * @var string
     */
    protected $table = 'orders';
    protected $guarded = ['created_at' , 'updated_at' , 'id' ];

    public function userDetails()
	{
	    return $this->belongsTo('App\Models\Tasks', 'user_id','id');
	} 

	public function taskDetails()
	{
	    return $this->belongsTo('App\Models\Tasks', 'task_id','id')->with('taskPostedUser','seekerUserDetail');
	}
}


