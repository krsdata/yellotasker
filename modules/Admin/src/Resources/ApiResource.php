<?php

namespace Modules\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests; 
use Illuminate\Contracts\Encryption\DecryptException;
use Config,Mail,View,Redirect,Validator,Response; 
use Auth,Crypt,okie,Hash,Lang,JWTAuth,Input,Closure,URL; 
use JWTExceptionTokenInvalidException; 
use App\Helpers\Helper as Helper;

use Modules\Admin\Models\User;


/**
 * @author 
 */
class ApiResource extends BaseApiResource {

    protected $stockSettings = array();
    protected $modelNumber = '';

    // return object of userModel
    protected function getUserModel() {
        return new User();
    }
    // get all user
    public function getUser($id=null) {

        return $this->getUserModel()->getUserDetail($id);
    }
       public function validateUser(Request $request,User $user){

        $input['first_name']    = $request->input('first_name');
        $input['last_name']     = $request->input('last_name'); 
        $input['email']         = $request->input('email'); 
        $input['password']      = Hash::make($request->input('password'));
          //Server side valiation
        if($request->input('user_id')){
            $validator = Validator::make($request->all(), [
                  
            ]); 
        } 
        else{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users' 
            ]); 
        }
       
        // Return Error Message
        if ($validator->fails()) {
                    $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return Response::json(array(
                'status' => 0,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }

        $helper = new Helper;
        $group_name =  $helper->getCorporateGroupName($input['email']);
        $email_allow = array('gmail','yahoo','ymail','aol','hotmail');

        if(in_array($group_name, $email_allow))
        {
           return Response::json(array(
                'status' => 0,
                'message' => 'Only corporate email is allowed!',
                'data'  =>  ''
                )
            ); 
        }

        return response()->json(
                            [ 
                                "status"=>1,
                                "message"=>"User validated successfully.",
                                'data'=>$request->all()
                            ]
                        );  
    }   
    
   /* @method : register
    * @param : email,password,deviceID,firstName,lastName
    * Response : json
    * Return : token and user details
    * Author : kundan Roy
    * Calling Method : get  
    */

    public function register(Request $request,User $user)
    {   

        $user->first_name    = $request->get('first_name');
        $user->last_name     = $request->get('last_name'); 
        $user->email         = $request->get('email'); 
        $user->password      = Hash::make($request->input('password'));
        $user->role_type     = ($request->input('role_type'))?$request->input('role_type'):'';
         
        if($request->input('user_id')){
            $u = $this->updateProfile($request,$user);
            return $u;
        } 

        //Server side valiation
        $validator = Validator::make($request->all(), [
           'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {
                    $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return Response::json(array(
                'status' => 0,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }  
        
        $helper = new Helper;
        /** --Create USER-- **/
        
        $user->save();
        $subject = "Welcome to yellotasker! Verify your email address to get started";
        $email_content = [
                'receipent_email'=> $request->get('email'),
                'subject'=>$subject,
                'greeting'=> 'Yellotasker',
                'first_name'=> $request->get('first_name')
                ];

      //  $verification_email = $helper->sendMailFrontEnd($email_content,'verification_link');
       
        return response()->json(
                            [ 
                                "status"=>1,
                                "code" => 200,
                                "message"=>"Thank you for registration. Please verify your email.",
                                'data'=>$request->except('password')
                            ]
                        );
    }

/* @method : update User Profile
    * @param : email,password,deviceID,firstName,lastName
    * Response : json
    * Return : token and user details
    * Author : kundan Roy
    * Calling Method : get  
    */
    public function updateProfile(Request $request,User $user)
    {       
        if(!Helper::isUserExist($request->get('user_id')))
        {
            return Response::json(array(
                'status' => 0,
                'message' => 'Invalid user Id!',
                'data'  =>  ''
                )
            );
        } 
        $user = User::find($request->get('user_id')); 
        $role_type  = $user->role_type;

        $data = [
                    'user_id'=>$user->id,
                    'first_name'=>$user->first_name,
                    'last_name'=>$user->first_name,
                    'email'=>$user->email,
                    'role_type' => $user->role_type
                ];
         
        foreach ($request->all() as $key => $value) {
             if($key=="email" || $key=="user_id")
             {
                continue;
             }else{
               $user->$key=$value; 
             }
        }

        try{
            $user->save();
            $status = 1;
            $code  = 200;
            $message ="Profile updated successfully";
        }catch(\Exception $e){
            $status = 0;
            $code  = 500;
            $message =$e->getMessage();
        }

        return response()->json(
                            [ 
                            "status" =>$status,
                            'code'   => $code,
                            "message"=> $message,
                            'data'=>$data
                            ]
                        );
         
    }

   /* @method : login
    * @param : email,password and deviceID
    * Response : json
    * Return : token and user details
    * Author : kundan Roy   
    */
    public function login(Request $request)
    {    
        $input = $request->all();
        if (!$token = JWTAuth::attempt(['email'=>$request->get('email'),'password'=>$request->get('password')])) {
            return response()->json([ "status"=>0,"message"=>"Invalid email or password. Try again!" ,'data' => '' ]);
        }
         
        $user = JWTAuth::toUser($token); 

        $data['id']             = $user->id; 
        $data['first_name']    = $request->input('first_name');
        $data['last_name']     = $request->input('last_name'); 
        $data['email']         = $request->input('email'); 
        $data['role_type']     = ($request->input('role_type'))?$request->input('role_type'):'';
        $data['token']          = $token;

        return response()->json([ "status"=>1,"code"=>200,"message"=>"Successfully logged in." ,'data' => $data ]);

    } 
   /* @method : get user details
    * @param : Token and deviceID
    * Response : json
    * Return : User details 
   */
   
    public function getUserDetails(Request $request)
    {
        $user = JWTAuth::toUser($request->input('token'));
        $data = [];
        $data['userId']         = $user->id;
        $data['name']           = $user->name;
        $data['email']          = $user->email;
        $data['roleType']       = ($user->role_type==1)?"professor":"student";
       
         

        return response()->json(
                [ "status"=>1,
                  "code"=>200,
                  "message"=>"Record found successfully." ,
                  "data" => $data 
                ]
            ); 
    }
   /* @method : Email Verification
    * @param : token_id
    * Response : json
    * Return :token and email 
   */
   
    public function emailVerification(Request $request)
    {
        $verification_code = $request->input('verification_code');
        $email    = $request->input('email');

        if (Hash::check($email, $verification_code)) {
           $user = User::where('email',$email)->get()->count();
           if($user>0)
           {
              User::where('email',$email)->update(['status'=>1]);  
           }else{
            echo "Verification link is Invalid or expire!"; exit();
                return response()->json([ "status"=>0,"message"=>"Verification link is Invalid!" ,'data' => '']);
           }
           echo "Email verified successfully."; exit();  
           return response()->json([ "status"=>1,"message"=>"Email verified successfully." ,'data' => '']);
        }else{
            echo "Verification link is Invalid!"; exit();
            return response()->json([ "status"=>0,"message"=>"Verification link is invalid!" ,'data' => '']);
        }
    }
   
   /* @method : logout
    * @param : token
    * Response : "logout message"
    * Return : json response 
   */
    public function logout(Request $request)
    {   
        $token = $request->input('token');
         
        JWTAuth::invalidate($request->input('token'));

        return  response()->json([ 
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"You've successfully signed out.",
                    'data' => ""
                    ]
                );
    }
   /* @method : forget password
    * @param : token,email
    * Response : json
    * Return : json response 
    */
    public function forgetPassword(Request $request)
    {  
        $email = $request->input('email');
        //Server side valiation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        $helper = new Helper;
       
        if ($validator->fails()) {
            $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return Response::json(array(
                'status' => 0,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }

        $user =   User::where('email',$email)->get();

        if($user->count()==0){
            return Response::json(array(
                'status' => 0,
                'message' => "Oh no! The address you provided isn't in our system",
                'data'  =>  ''
                )
            );
        }
        $user_data = User::find($user[0]->userID);
        $temp_password = Hash::make($email);
       
        
      // Send Mail after forget password
        $temp_password =  Hash::make($email);
 
        $email_content = array(
                        'receipent_email'   => $request->input('email'),
                        'subject'           => 'Reset account password link!',
                        'first_name'        => $user[0]->first_name,
                        'temp_password'     => $temp_password,
                        'encrypt_key'       => Crypt::encrypt($email),
                        'greeting'          => 'Yellotasker'

                    );
        $helper = new Helper;
        $email_response = $helper->sendMail(
                                $email_content,
                                'forgot_password_link'
                            ); 
       
       return   response()->json(
                    [ 
                        "status"=>1,
                        "code"=> 200,
                        "message"=>"Reset password link has sent. Please check your email.",
                        'data' => ''
                    ]
                );
    }

   /* @method : change password
    * @param : token,oldpassword, newpassword
    * Response : "message"
    * Return : json response 
   */
    public function changePassword(Request $request)
    {   
        $user = JWTAuth::toUser($request->input('deviceToken'));
        $user_id = $user->userID; 
        $old_password = $user->password;
     
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6'
        ]);
        // Return Error Message
        if ($validator->fails()) {
            $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);     
                    }
                            
            return Response::json(array(
                'status' => 0,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }

         
        if (Hash::check($request->input('oldPassword'),$old_password)) {

           $user_data =  User::find($user_id);
           $user_data->password =  Hash::make($request->input('newPassword'));
           $user_data->save();
           return  response()->json([ 
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"Password changed successfully.",
                    'data' => ""
                    ]
                );
        }else
        {
            return Response::json(array(
                'status' => 0,
                'message' => "Old password mismatch!",
                'data'  =>  ''
                )
            );
        }         
    }
 
    /*SORTING*/
    public function array_msort($array, $cols)
    {
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval,0,-1).');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;

    }   
   
  
    public function InviteUser(Request $request,InviteUser $inviteUser)
    {   
        $user =   $inviteUser->fill($request->all()); 
       
        $user_id = $request->input('userID'); 
        $invited_user = User::find($user_id); 
        
        $user_first_name = $invited_user->first_name ;
        $download_link = "http://google.com";
        $user_email = $request->input('email');

        $helper = new Helper;
        $cUrl =$helper->getCompanyUrl($user_email);
        $user->company_url = $cUrl; 
        /** --Send Mail after Sign Up-- **/
        
        $user_data     = User::find($user_id); 
        $sender_name     = $user_data->first_name;
        $invited_by    = $invited_user->first_name.' '.$invited_user->last_name;
        $receipent_name = "User";
        $subject       = ucfirst($sender_name)." has invited you to join";   
        $email_content = array('receipent_email'=> $user_email,'subject'=>$subject,'name'=>'User','invite_by'=>$invited_by,'receipent_name'=>ucwords($receipent_name));
        $helper = new Helper;
        $invite_notification_mail = $helper->sendNotificationMail($email_content,'invite_notification_mail',['name'=> 'User']);
        $user->save();

        return  response()->json([ 
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"You've invited your colleague, nice work!",
                    'data' => ['receipentEmail'=>$user_email]
                   ]
                );

    }
}