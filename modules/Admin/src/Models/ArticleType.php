<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent; 

 
class ArticleType extends Eloquent {
 
    /*
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'article_type';
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
   protected $fillable = ['article_type','resolution_department'];  // All field of user table here    


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function article()
    {  
        return $this->hasMany('Modules\Admin\Models\Article','article_type');
    }
    
    public function relatedArticle()
    {  
        return $this->hasMany('Modules\Admin\Models\Article','article_type');
    }
    
    
    
    
  
}
