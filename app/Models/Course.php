<?php

namespace  Modules\Admin\Models; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    
     /**
     * The database table used by the model.
     *
     * @var string
     */
    
    protected $table = 'courses';

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
 
    protected $guarded = ['created_at' , 'updated_at' , 'id' ];

    protected $fillable = ['id','course_name','course_code','professor_id','status','session_id','general_info']; 

    public function user() 
    {
        return $this->belongsTo('Modules\Admin\Models\User','professor_id','id');
    }

}
