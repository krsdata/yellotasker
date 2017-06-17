<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
     /**
     * The metrics table.
     * 
     * @var string
     */
    protected $table = 'student_profiles';
    protected $guarded = ['created_at' , 'updated_at' , 'id' ];
    protected $fillable = ['name','email','phone','address'];
}
