<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messges extends Model
{
     /**
     * The metrics table.
     * 
     * @var string
     */
    protected $table = 'messges';
    protected $guarded = ['created_at' , 'updated_at' , 'id' ];
    
    public function commentPostedUser()
    {
        return $this->belongsTo('App\Models\Tasks', 'userId','id');
    } 
    
    public function taskDetails()
    {
        return $this->belongsTo('App\Models\Tasks', 'taskId','id')->with('taskPostedUser','seekerUserDetail');
    }

}
