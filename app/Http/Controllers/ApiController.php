<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests; 
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Config,Mail,View,Redirect,Validator,Response; 
use Auth,Crypt,okie,Hash,Lang,JWTAuth,Input,Closure,URL; 
use JWTExceptionTokenInvalidException; 
use App\Helpers\Helper as Helper;
use App\User; 
use App\Model\Tasks;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\CategoryDashboard; 

use App\Http\Requests\UserRequest;  
use Illuminate\Http\Dispatcher;   
use Cookie; 



class ApiController extends Controller
{
    
   /* @method : validateUser
    * @param : email,password,firstName,lastName
    * Response : json
    * Return : token and user details
    * Author : kundan Roy
    * Calling Method : get  
    */

    public function __construct(Request $request) {

        if ($request->header('Content-Type') != "application/json")  {
            $request->headers->set('Content-Type', 'application/json');
        }
        $user_id =  $request->input('user_id');
       
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
        $input['first_name']    = $request->input('first_name');
        $input['last_name']     = $request->input('last_name'); 
        $input['email']         = $request->input('email'); 
        $input['password']      = Hash::make($request->input('password'));
        $input['role_type']     = ($request->input('role_type'))?$request->input('role_type'):'';
         
        if($request->input('user_id')){
            $u = $this->updateProfile($request,$user);
            return $u;
        } 

        //Server side valiation
        $validator = Validator::make($request->all(), [
           'first_name' => 'required',
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
                'code'=>500,
                'message' => $error_msg[0],
                'data'  =>  $request->all()
                )
            );
        }  
        
        $helper = new Helper;
        /** --Create USER-- **/
        $user = User::create($input); 

        $subject = "Welcome to yellotasker! Verify your email address to get started";
        $email_content = [
                'receipent_email'=> $request->input('email'),
                'subject'=>$subject,
                'greeting'=> 'Yellotasker',
                'first_name'=> $request->input('first_name')
                ];

        //$verification_email = $helper->sendMailFrontEnd($email_content,'verification_link');
       
        return response()->json(
                            [ 
                                "status"=>1,
                                "code"=>200,
                                "message"=>"Thank you for registration",
                                'data'=>$user
                            ]
                        );
    }

    public function createImage($base64)
    {
        try{
            $img  = explode(',',$base64);
            if(is_array($img) && isset($img[1])){
                $image = base64_decode($img[1]);
                $image_name= time().'.jpg';
                $path = storage_path() . "/image/" . $image_name;
              
                file_put_contents($path, $image); 
                return url::to(asset('storage/image/'.$image_name));
            }else{
                return false; 
            }

            
        }catch(Exception $e){
            return false;
        }
        
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
                'code' => 500,
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

        if($request->get('profile_image')){  ;
            $profile_image = $this->createImage($request->get('profile_image')); 
            if($profile_image==false){
                return Response::json(array(
                    'status' => 0,
                     'code' => 500,
                    'message' => 'Invalid Image format!',
                    'data'  =>  $request->all()
                    )
                );
            }
            $user->profile_image  = $profile_image;       
        }        
          
         
        foreach ($request->all() as $key => $value) {
             if($key=="email" || $key=="user_id" || $key == "profile_image")
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
        $data = User::find($request->get('user_id'));  

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
        
        return response()->json([ "status"=>1,"code"=>200,"message"=>"Successfully logged in." ,'data' => $user,'token'=>$token ]);

    } 
   /* @method : get user details
    * @param : Token and deviceID
    * Response : json
    * Return : User details 
   */
   
    public function getUserDetails(Request $request)
    {
        $user = JWTAuth::toUser($request->input('token'));
        
        return response()->json(
                [ "status"=>1,
                  "code"=>200,
                  "message"=>"success." ,
                  "data" => $user 
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

        $user =   User::where('email',$email)->first();

        if($user==null){
            return Response::json(array(
                'status' => 0,
                'code' => 500,
                'message' => "Oh no! The address you provided isn't in our system",
                'data'  =>  $request->all()
                )
            );
        }
        $user_data = User::find($user->id);
        $temp_password = Hash::make($email);
        
      // Send Mail after forget password
        $temp_password =  Hash::make($email);
       
        $email_content = array(
                        'receipent_email'   => $request->input('email'),
                        'subject'           => 'Your Yellotasker Account Password',
                        'name'              => $user->first_name,
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
                        'data' => $request->all()
                    ]
                );
    }


    public function resetPassword(UserRequest $request)
    { 

        $encryptedValue = ($request->get('key'))?$request->get('key'):''; 
        $method_name = $request->method();
        $token = $request->get('token');
       // $email = ($request->get('email'))?$request->get('email'):'';

        if($method_name=='GET')
        {    
            try {
                $email = Crypt::decrypt($encryptedValue); 
                
                if (Hash::check($email, $token)) {
                    return view('admin.auth.passwords.reset',compact('token','email')); 
                }else{

                    return Response::json(array(
                        'status' => 0,
                        'message' => "Invalid reset password link!",
                        'data'  =>  ''
                        )
                    );
                } 
                
            } catch (DecryptException $e) {
                   
            //   return view('admin.auth.passwords.reset',compact('token','email')) 
              //              ->withErrors(['message'=>'Invalid reset password link!']);  

                return Response::json(array(
                        'status' => 0,
                        'message' => "Invalid reset password link!",
                        'data'  =>  ''
                        )
                    );
    
            }
            
        }else
        {   
            try {
                $email = Crypt::decrypt($encryptedValue); 
                
                if (Hash::check($email, $token)) {
                        $password =  Hash::make($request->get('password'));
                        $user = User::where('email',$request->get('email'))->update(['password'=>$password]);
                      
                        return Response::json(array(
                                'status' => 0,
                                'message' => "Password reset successfully.",
                                'data'  =>  ''
                                )
                            );
                }else{

                    return Response::json(array(
                        'status' => 0,
                        'message' => "Invalid reset password link!",
                        'data'  =>  ''
                        )
                    );
                } 
                
            } catch (DecryptException $e) {
                   
                return Response::json(array(
                        'status' => 0,
                        'message' => "Invalid reset password link!",
                        'data'  =>  ''
                        )
                    );
    
            }

 
            
        }
        
    }

   /* @method : change password
    * @param : token,oldpassword, newpassword
    * Response : "message"
    * Return : json response 
   */
    public function changePassword(Request $request)
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
                "code" => 201,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }

        $user =   User::where('email',$email)->first();

        if($user==null){
            return Response::json(array(
                'status' => 0,
                'code' => 500,
                'message' => "The email address you provided isn't in our system",
                'data'  =>  $request->all()
                )
            );
        }

        $user = User::where('email',$request->get('email'))->first();
        
        $user_id = $user->id; 
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
                "code"=> 500,
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
   /* @method : Get Condidate rating
    * @param : Interviewer ID
    * Response : json
    * Return :   getCondidateRecord
    */
    public function get_condidate_record(Request $request, Interview $interview)
    {   
        $condidate_id   =  $request->input('directoryID');
        $condidate_name =  Helper::getCondidateNameByID($condidate_id);
        if($condidate_name==null){
            return  json_encode(
                        [  
                            "status"=>0,
                            "code"=> 404,
                            "message"=>"Record not found", 
                            'data' => ""
                        ] 
                    );  
        }
        $interview_data     =  InterviewRating::where('condidateID',$condidate_id)->get();
        $interview_details  = [];
        $c_details          = Interview::find($condidate_id);
        $interviewerComment = [];
        $date           = \Carbon\Carbon::parse($c_details->created_at)->format('m/d/Y');
       /* $date_diff      = \Carbon\Carbon::parse('27-07-2016')->diffForHumans();  
        $is_tomorrow    = \Carbon\Carbon::parse('28-07-2016')->isTomorrow();
        $is_today       = \Carbon\Carbon::parse('28-07-2016')->isTomorrow();
       */
        if($interview_data->count()>0){
            $interview_criteriaID =[];
            foreach ($interview_data as $key => $result) {

                $rating_value    = str_getcsv($result->rating_value);
                $interviewerName = Helper::getUserDetails($result->interviewerID);
                
                if( !empty($result->comment))
                {
                  $interviewerComment[]  =[
                            'firstName' => $interviewerName['firstName'],
                            'lastName'  => $interviewerName['lastName'],
                            'comment'   => $result->comment];
                }    
                
                $interview_details[]   =  Helper::getCriteriaById(str_getcsv($result->interview_criteriaID),$rating_value,$interviewerName,$result->comment); 
                 
            }
        }else{ 
             return  response()->json([  
                            "status"=>1,
                            "code"=> 200,
                            "message"=>"Record found successfully.",  
                            "data"  =>  array(
                                "date"=>$date,
                                "details"=>$interview_details,
                                "comment"=>$interviewerComment,
                                ) 
                        ] 
                    );  
        } 
        return  response()->json([ 
                    "status"=>1,
                    "code"=> 200, 
                    "message"=>"Record found successfully.",  
                    "data"  =>  array(
                        "date"=>$date,
                        "details"=>$interview_details,
                        "comment"=>$interviewerComment,
                        )  
                    ]    
                );  

         // "comment" => $comment,
                               // "ratingDetail"=>$interview_details]
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
    public function categoryDashboard(){ 

       // $cd = CategoryDashboard::all 
        $image_url = env('IMAGE_URL',url::asset('storage/uploads/category/'));
        $categoryDashboard = CategoryDashboard::with('category')->take(8)->get();
        $data = [];
        $category_data = [];
        foreach ($categoryDashboard as $key => $value) {
            $data['category_id']            = $value->category->id;
            $data['category_name']          = $value->category->category_name;
            $data['category_image']         = $image_url.'/'.$value->category->category_image;
            $data['group_id']               = $value->category->parent->id;
            $data['category_group_name']    = $value->category->parent->category_group_name;
            $data['category_group_image']   = $image_url.'/'.$value->category->category_group_image;
            
            $category_data[] = $data;

        } 

        if(count($data)){
            $status = 1;
            $code   = 200;
            $msg    = "Category dashboard list";
        }else{
            $status = 0;
            $code   = 404;
            $msg    = "Category dashboard list not  found!";
        }

        return  response()->json([ 
                "status"=>$status,
                "code"=> $code,
                "message"=> $msg,
                'data' => $category_data
            ]
        );

    }


    public function category(){ 

       // $cd = CategoryDashboard::all 
        $image_url = env('IMAGE_URL',url::asset('storage/uploads/category/'));
        $categoryDashboard = Category::with('children')->where('parent_id',0)->get();
        
        $data = [];
        $category_data = [];
        foreach ($categoryDashboard as $key => $value) {
            $data['group_id']               = $value->id;
            $data['category_group_name']    = $value->category_group_name;
            $data['category_group_image']   = $image_url.'/'.$value->category_group_image;

            foreach ($value->children as $key => $result) {
                $data2['category_id']      = $result->id;
                $data2['category_name']    = $result->category_name;
                $data2['category_image']   = $image_url.'/'.$result->category_image;
                $data2['category_group_id'] = $result->parent_id;
                $data2['category_group_name'] = $value->category_group_name;
                $data['category'][] = $data2;
            }
            
            $category_data[] = $data;

        } 
        if(count($data)){
            $status = 1;
            $code   = 200;
            $msg    = "Category dashboard list";
        }else{
            $status = 0;
            $code   = 404;
            $msg    = "Category dashboard list not  found!";
        }

        return  response()->json([ 
                "status"=>$status,
                "code"=> $code,
                "message"=> $msg,
                'data' => $category_data
            ]
        );

    }

    public function sendMail()
    {
        $emails = ['kroy@mailinator.com'];

        Mail::send('emails.welcome', [], function($message) use ($emails)
        {    
            $message->to($emails)->subject('This is test e-mail');    
        });
        var_dump( Mail:: failures());
        exit;
    }
    //array_msort($array, $cols)

    
} 