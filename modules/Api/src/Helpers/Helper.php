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
use Modules\Admin\Helpers\Helper as Helper;
 

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
/* @method : createCompanyGroup
    * @param : email,user_id
    * Response :  string
    * Return : company name
    */
    public function createCompanyGroup($email=null,$user_id=null)
    {
        $request = new Request;
        $fps =  strripos($email,"@");
        $lps =  strpos(substr($email,$fps),".");
        $company_url = substr($email,$fps+1);
        $company_name = substr($email,$fps+1,$lps-1);
        
        //Server side valiation
        $validator = Validator::make(array('company_name'=>$company_name), [
            'company_name' => 'unique:t_corporate_profile',
           
        ]);
        // Return Error Message
        if ($validator->fails()) {
            $cp_record  = CorporateProfile::where('company_name',$company_name)
                            ->where('companyID',0)->get();
            $company_id      =  isset($cp_record[0]->id)?$cp_record[0]->id:'';
            $company_profile = new CorporateProfile;
            $company_profile->company_name =  $company_name;
            $company_profile->userID = $user_id;
            $company_profile->companyID =$company_id ;
            $company_profile->company_url = $company_url;
            $company_profile->user_email  = $email;
            $company_profile->save(); 
            return $company_name;

        }else{

            $company_profile = new CorporateProfile;
            $company_profile->company_name =  $company_name;
            $company_profile->userID = $user_id;
            $company_profile->companyID =0;
            $company_profile->company_url = $company_url;
            $company_profile->user_email  = $email;
            $company_profile->save();
            return $company_name;
        } 
    }
/* @method : getCorporateGroupName
    * @param : email
    * Response :  string
    * Return : company name
    */
    public function getCorporateGroupName($email=null)
    {
        $fps =  strripos($email,"@");
        $lps =  strpos(substr($email,$fps),".");
        $company_name = substr($email,$fps+1,$lps-1);
        return  $company_name;       
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

/* @method : getUserGroupedID
    * @param : user id
    * Response :  all user id associate with same compnay
    * Return : user id as array(1,2,3)
    */

    static public function getUserGroupedID($user_id=null)
    {
        $corp_profile       = CorporateProfile::where('userID',$user_id)->get();
        $corp_profile_id  = $corp_profile->lists('company_url','userID');
        $user_from_same_company = CorporateProfile::where('company_url',$corp_profile_id[$user_id])->get();
        
        return $user_from_same_company->lists('userID');
    }
/* @method : isUserExist
    * @param : user_id
    * Response : number
    * Return : count
    */
    static public function isUserExist($user_id=null)
    {
        $user = User::where('userID',$user_id)->count(); 
        return $user;
    }
/* @method : getpassword
    * @param : email
    * Response :  
    * Return : true or false
    */
    
    public static function getPassword(){
        $password = "";
        $user = Auth::user();
        if(isset($user)){
            $password = Auth::user()->Password;
        }
        return $password;
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
