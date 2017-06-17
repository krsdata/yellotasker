<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessorProfile extends Model
{
    protected $table = 'professor_profiles';
    protected $guarded = ['created_at' , 'updated_at' , 'id' ];
    protected $fillable = ['name','email','designation','office_hours','location','professor_id'];
}
