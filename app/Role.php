<?php 
namespace App;

use Auth;
use Session;
use Illuminate\Foundation\Auth\User;
use Eloquent;

class Role extends Eloquent
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';
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
}