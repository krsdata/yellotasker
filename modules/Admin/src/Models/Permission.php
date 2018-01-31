<?php 
namespace  Modules\Admin\Models;

use Auth;
use Session;
use Illuminate\Foundation\Auth\User;
use Eloquent;

class Permission extends Eloquent
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';
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