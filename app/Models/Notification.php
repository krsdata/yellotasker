<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Notification extends Eloquent{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';
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
    
    /**
     * 
     * @param string $event_type =task_add, task_update, task_delete, comment_add, comment_replied, comment_delete, user_register, offers_add, offers_update, offers_delete
     * @param int $event_type -task id, user id, comment id
     * @param string $title Notification Title
     * @param string $message Message
     * @param int $status -0 Delete, 1-Unread , 2- Read
     */
    public function addNotification($event_type, $event_id, $user_id, $title, $message,$notified_user=0, $status=1){
        $this->title = $title;
        $this->message = $message;
        
        $this->entity_type = $event_type;
        $this->entity_id = $event_id;
        $this->user_id = $user_id;
        $this->notified_user = $notified_user;
        
        $this->status = $status;
        $this->save();
    }

    public function userDetails()
    {
        return $this->belongsTo('App\User','user_id','id')->select('id','first_name','last_name','email');
    }

    public function taskDetails()
    {
        return $this->hasMany('App\Models\Tasks','id','entity_id');
    }
 
}