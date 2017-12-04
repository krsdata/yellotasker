<?php

namespace Modules\Admin\Helpers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Mail;
use Auth;
use Config;
use View;
use Input;
use session;
use Crypt;
use Hash;
use Menu;
use Html;
use Illuminate\Support\Str;
use App\User; 
use Illuminate\Support\Facades\Lang;
use App\CorporateProfile;
use Validator; 
use App\Position; 
use Modules\Admin\Models\Contact; 
use Modules\Admin\Models\ContactGroup;
 

class Helper {

    /**
     * function used to check stock in kit
     *
     * @param = null
     */

    public function generateRandomString($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

         return $key;
    } 
 
 
/* @method : getCompanyUrl
    * @param : email
    * Response :  string
    * Return : company URL
    */
    public function getCompanyUrl($email=null)
    {
        $fps =  strripos($email,"@");
        $lps =  strpos(substr($email,$fps),".");
        $company_url = substr($email,$fps+1);
        return  $company_url;       
    } 
/* @method : isUserExist
    * @param : user_id
    * Response : number
    * Return : count
    */
    static public function isUserExist($user_id=null)
    {
        $user = User::where('id',$user_id)->count(); 
        return $user;
    }
/* @method : getpassword
    * @param : email
    * Response :  
    * Return : true or false
    */

    public static function contactName($id=null)
    {
        $contacts = ContactGroup::with('contact')->where('parent_id',$id)->get();
        $gname = ContactGroup::find($id)->groupName;
        
        $contact_list = ContactGroup::where('parent_id',$id)->lists('contactId');
        $contact_not_id = Contact::whereNotIn('id',$contact_list)->get();

        $html = view::make('packages::contactGroup.group_pop',compact('contacts','contact_not_id','gname'));
        return $html->render();  

    }
    
    
/* @method : check mobile number
    * @param : mobile_number
    * Response :  
    * Return : true or false
    */     
   
    
    public static function FormatPhoneNumber($number){
        return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $number). "\n";
    }
 /* @method : getPositionNameById
    * @param : position_id
    * Response :  string
    * Return : string
    */   
    public static function getPositionNameById($position_id=null)
    {
        $position = Position::find($position_id);
        return $position->position_name;
    }
   
/* @method : send Mail
    * @param : email
    * Response :  
    * Return : true or false
    */
    public  function sendMailFrontEnd($email_content, $template, $template_content)
    {        
        $template_content['verification_token'] =  Hash::make($email_content['receipent_email']);
        $template_content['email'] = isset($email_content['receipent_email'])?$email_content['receipent_email']:'';
        
        return  Mail::send('emails.'.$template, array('content' => $template_content), function($message) use($email_content)
          {
            $name = "Udex";
            $message->from('udex@indianic.com',$name);  
            $message->to($email_content['receipent_email'])->subject($email_content['subject']);
            
          });
    }
  /* @method : send Mail
    * @param : email
    * Response :  
    * Return : true or false
    */
    public  function sendMail($email_content, $template)
    {        
        
        return  Mail::send('emails.'.$template, array('content' => $email_content), function($message) use($email_content)
          {
            $name = "Udex";
            $message->from('no-reply@indianic.com',$name);  
            $message->to($email_content['receipent_email'])->subject($email_content['subject']);
            
          });
    }
}
