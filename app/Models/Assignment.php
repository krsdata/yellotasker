<?php

namespace  Modules\Admin\Models; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    
    protected $table = 'assignments';

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

    protected $fillable = ['id','course_id','paper_title','duration','status','chapter','type','description','grade','marks','due_date','syllabus_id']; 
    
    public function user()
    {
        return $this->belongsTo('Modules\Admin\Models\User','professor_id','id');
    }

    public function course()
    {
        return $this->belongsTo('Modules\Admin\Models\Course','course_id','id');
    }

}
