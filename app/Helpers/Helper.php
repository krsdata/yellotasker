<?php

namespace App\Helpers;

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
use Phoenix\EloquentMeta\MetaTrait; 
use Illuminate\Support\Facades\Lang;
use App\CorporateProfile;
use Validator; 
use App\Position;
use App\InterviewRating;
use App\Interview;
use App\Criteria;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\RatingFeedback;
use PHPMailerAutoload;
use PHPMailer; 

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
 
 
/* @method : getCondidateNameByID
    * @param : condidate_id
    * Response :  string
    * Return : string
    */
    public static function getCondidateNameByID($condidate_id=null)
    {    
        $rating = Interview::find($condidate_id);
        if($rating==null)
        {
            return  null;
        }
        $total_evalution_required = count(str_getcsv($rating->interviewerID));
        $total_evaluated = InterviewRating::where('condidateID',$condidate_id)->count();
        $avg_rating = Helper::getRatingByCondidateID($condidate_id);
        $ratingStatus = "Pending";
        if($total_evalution_required==$total_evaluated)
        {
            $ratingStatus = "Evaluated";
        }
        if($rating!=null)
        {
             return $rating = [
                                'condidateID'=>$rating->id,
                                'condidateName'=>$rating->condidate_name,
                                'shortDescription'=>$rating->short_description,
                                'rating' => $avg_rating,
                                'ratingStatus'=>$ratingStatus
                                ];
        } 
        return  null;   
        
    }
/* @method : getRatingDataByCondidateID
    * @param : condidate_id
    * Response :  string
    * Return : string
    */
    public static function getRatingDataByCondidateID($condidate_id=null)
    {
        $rating = InterviewRating::find($condidate_id);
        return $rating->rating;
    }

    public static function getIndividualCompanyUser($id=null)
    {
        $company = CorporateProfile::where('userID',$id)->first();
        $company_user=   CorporateProfile::selectRaw('userID')->where('company_url',$company->company_url)->get();    
        return $company_user->lists('userID')->toArray();
    }
    public static function getRatingData($criteria_id = null,$rating_value=null)    
    {    
        $total_criteria = count($criteria_id);
        $criteria =  Criteria::whereIn('id',$criteria_id)->get();
        $rating_value_record  = number_format(floatval((array_sum($rating_value)/$total_criteria)),1);
        $feedback_data = RatingFeedback::lists('feedback','rating_value');
        if($criteria->count()>0)
        {   
            foreach ($criteria as $key => $value) {
                $rating_val =  isset($rating_value[$key])?$rating_value[$key]:0;
                $date   =  date('m/d/Y',strtotime($value->updated_at)); 
                //$rating_value = isset($rating_value[$key])?$rating_value[$key]:"";
                
                $data[] =  [ 
                            'criteriaID'    => $value->id,
                            'criteria'      => $value->interview_criteria,
                            'ratingValue'   => $rating_val
                         ];
                   
            }
           
            return    $data;
                     
        }
        return null;  

    }

  

   /* @method : get user details
    * @param : userid
    * Response : json
    * Return : User details 
   */
   
    public static function getUserDetails($user_id=null)
    {
        $user = User::find($user_id);
        $data['userID'] = $user->userID;
        $data['firstName'] = $user->first_name;
        $data['lastName'] = $user->last_name;
       return  $data;
    }
/* @method : send Mail
    * @param : email
    * Response :  
    * Return : true or false
    */
     
     public  function sendMailFrontEnd($email_content, $template)
    {        
        $email_content['verification_token'] =  Hash::make($email_content['receipent_email']);
        $email_content['email'] = isset($email_content['receipent_email'])?$email_content['receipent_email']:''; 

        $mail = new PHPMailer;
        $html = view::make('emails.'.$template,['content' => $email_content]);
        $html = $html->render(); 

        try {
            $mail->isSMTP(); // tell to use smtp
            $mail->CharSet = "utf-8"; // set charset to utf8
             

            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->Host       = "mail.infowaynic.com"; // sets the SMTP server
            $mail->Port       = 587;   
            $mail->SMTPSecure = 'false';                 // set the SMTP port for the GMAIL server
            $mail->Username   = "no-reply@infowaynic.com"; // SMTP account username
            $mail->Password   = "no-reply@123!"; 

            $mail->setFrom("admin@gsure.in", "gsure");
            $mail->Subject = $email_content['subject'];
            $mail->MsgHTML($html);
            $mail->addAddress($email_content['receipent_email'], "yellotasker");
            $mail->addAddress("kroy.iips@gmail.com","yellotasker"); 

            //$mail->addAttachment(‘/home/kundan/Desktop/abc.doc’, ‘abc.doc’); // Optional name
            $mail->SMTPOptions= array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
            );

            $mail->send();
            //echo "success";
            } catch (phpmailerException $e) {
             
            } catch (Exception $e) {
             
            }



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
            $name = 'Yellotasker';
            $message->from('no-reply@admin.com',$name);  
            $message->to($email_content['receipent_email'])->subject($email_content['subject']);
            
          });
    }
    /* @method : send Mail
    * @param : email
    * Response :  
    * Return : true or false
    */
    public  function sendNotificationMail($email_content, $template)
    {        
        
        return  Mail::send('emails.'.$template, array('content' => $email_content), function($message) use($email_content)
          {
            $name = $_SERVER['SERVER_NAME'];
            $message->from('no-reply@indianic.com',$name);  
            $message->to($email_content['receipent_email'])->subject($email_content['subject']);
            
          });
    }

    public static function send_ios_notification($deviceToken,$message)
    {
        // var_dump($notification_id, $owner_id, $member_id); exit;
        
        // $deviceToken = '9e88aba24a3981635b2620f7a9762fb97a10cbb694f37e93b212035138872bd6';
        
        // Put your private key's passphrase here:
        $passphrase = 'pushchat';
        
        // Put your alert message here:
        // $message = 'Myredfolder notification!';
        
        ////////////////////////////////////////////////////////////////////////////////
        
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', app_path().'/PushUDEX.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        
        // Open a connection to the APNS server
        $fp = stream_socket_client(
                                   'ssl://gateway.sandbox.push.apple.com:2195', $err,
                                   $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        
        if (!$fp)
        exit("Failed to connect: $err $errstr" . PHP_EOL);
        
        //echo 'Connected to APNS' . PHP_EOL;
        
        // Create the payload body
        $body['aps'] = array(
                             'alert' => trim($message),
                             'sound' => 'default',
                             );
        
        // Encode the payload as JSON
        $payload = json_encode($body);
        
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', trim($deviceToken)) . pack('n', strlen($payload)) . $payload;
        
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));
        
        if (!$result){
        //echo 'Message not delivered' . PHP_EOL;
        }
        else
        {
        //echo 'Message successfully delivered' . PHP_EOL;
        }
        
        // Close the connection to the server
        fclose($fp);
    }

    public static function getRatingFeedback($rating_value=null)
    {
        
        $feedback_data = RatingFeedback::lists('feedback','rating_value');

        $rating_value = isset($rating_value)?$rating_value:"";
                switch ($rating_value) {
                    case 1:
                        $feedback = isset($feedback_data[1])?$feedback_data[1]:'Terrible';
                        return $feedback;
                        break;
                    case 2:
                        $feedback = isset($feedback_data[2])?$feedback_data[2]:'Poor';
                        return $feedback;
                        break;
                    case 3:
                        $feedback = isset($feedback_data[3])?$feedback_data[3]:'Average';
                        return $feedback;
                        break;
                    case 4:
                        $feedback = isset($feedback_data[4])?$feedback_data[4]:'Good';
                        return $feedback;
                        break;
                    case 5:
                        $feedback = isset($feedback_data[5])?$feedback_data[5]:'Excellent';
                        return $feedback;
                        break;                
                    
                    default:
                        $feedback = "Not rated";
                        return $feedback;
                        break;
                }
    }

    public static function getCondidateCountByUserID($user_id=null){
        
        $query  = CorporateProfile::query();
        $corp_profile       = $query->where('userID',$user_id)->first();
        $query  = CorporateProfile::query();
        $total_cuser = $query->where('company_url',$corp_profile->company_url)->get();
        $user_arr = $total_cuser->lists('userID'); 
        $c = [];
        foreach ($user_arr as $key => $userid) {
          # code...
       
            $interviewD = Interview::where(function($query) use($userid){
                $query->whereRaw('FIND_IN_SET('.$userid.',interviewerID)');
                }
            )
            ->get(); 
           foreach ($interviewD as $key => $value) {
              $c[$value->id] = $value->condidate_name; 
           } 
         }

        return count($c); 
    }
   /*
    *Method : getActiveUserCount
    * Parameter : company_url
    * Response : active user Count
    */
    public function getActiveUserCount($company_url=null){

        $arr1 =   CorporateProfile::where('company_url',$company_url)->lists('userID')->toArray();
        $user_arr = User::whereIn('userID',$arr1)->where('status',1)->lists('userID');
        return $user_arr->count();
    }
   /*
    *Method : getEvaulationCount
    * Parameter : User ID
    * Response : condidate Evaluation Count
    */

    public function getEvaulationCount($userid=null){ 
        $evaluated = InterviewRating::where('interviewerID',$userid)->count(); 
        return $evaluated;
    }
   /*
    *Method : getPendingEvaulationCount
    * Parameter : User ID
    * Response : condidate Evaluation Count
    */

    public function getPendingEvaulationCount($userid=null){ 
        $evaluated_count = InterviewRating::where('interviewerID',$userid)->count(); 
        $pending_count   = Interview::whereRaw('FIND_IN_SET('.$userid.',interviewerID)')->count();
        $actual_pending = $pending_count-$evaluated_count;
        return  $pending_count;
    }

    /*
    *Method : getLastEvaluationDate
    * Parameter : User ID
    * Response : last Evaluation date
    */

    public function getLastEvaluationDate($userid=null){ 
        $evaluated_count = InterviewRating::where('interviewerID',$userid)
                            ->orderBy('id','desc')->first();
        $date =  "N/A";
        if($evaluated_count!=null){                    
            $date = (\Carbon\Carbon::parse($evaluated_count->created_at)->format('m-d-Y H:i:s A'));
        }                    
        return  $date;
    }
   /*
    *Method : getEvaluationCountByMonth
    * Parameter : User ID, month
    * Response : last Evaluation date
    */
    public function getEvaluationCountByMonth($userid=null,$month=null){
        $year = Input::get('year');
        $year =  isset($year)?$year:date('Y');  
        
        $count = InterviewRating::where('interviewerID',$userid)
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)->count(); 
        return $count;
    }
    /*
    *Method : getCorporateEvaluationCountByMonth
    * Parameter : User ID, month
    * Response : last Evaluation date
    */
    public function getCorporateEvaluationCountByMonth($userid=null,$month=null){ 
        
        $year = Input::get('year');
        $year =  isset($year)?$year:date('Y'); 
        $cp = CorporateProfile::where('userID',$userid)->first();
        $org_domain = $cp->company_url;
        $cp_user = CorporateProfile::where('company_url',$org_domain)->lists('userID')->toArray();
        $user = User::whereIn('userID',$cp_user)->count();
        $count = InterviewRating::whereIn('interviewerID',$cp_user)
                            ->whereYear('created_at', '=', $year)
                            ->whereMonth('created_at', '=', $month)->count();
        return $count;  
    }
     
}
