<?php

namespace  Modules\Admin\Models; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Syllabus extends Model
{
    
     /**
     * The database table used by the model.
     *
     * @var string
     */
    
    protected $table = 'syllabus';

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

    protected $fillable = ['id','syllabus_title','syllabus_description','course_id','grade_weight']; 

    public function course() 
    {
        return $this->belongsTo('Modules\Admin\Models\Course','course_id','id');
    }

}
