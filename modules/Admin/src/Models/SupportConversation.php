<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;  

use Illuminate\Foundation\Http\FormRequest;
use Response;

class SupportConversation extends Eloquent {

   
    /**
     * The database table SupportConversation by the model.
     *
     * @var string
     */
    protected $table = 'support_conversation';
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
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ticket_id','support_type','subject','description','reply_by','user_support_comments','support_comments','email','attachment','details','status']; // All field of user table here    


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    

    public function user()
    {
        return $this->belongsTo('Modules\Admin\Models\User','user_id','id');
    }

    public function supportType()
    {
        return $this->belongsTo('Modules\Admin\Models\ArticleType','support_type','id');
    }
  
}
