<?php
namespace Admin\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Admin\Helpers\Helper as Helper;
use Config;
use Redirect; 
use Validator;
use Response;
use Auth;
use Crypt;
use Cookie;
use Hash;
use Lang;
use Input;
use Closure;
use URL; 
use Doctrine\ORM\EntityManager;
use Admin\Validation\CampaignValidation;
use Admin\Repository\Masters\PersonalizationTagsRepository as PersonalizationTagsRepository;

class AuthenticationApiController extends Controller
{
    /**
     * @var campaignRepo
     */
    private $campaignRepo;
 
    public function __construct(PersonalizationTagsRepository $PersonalizationTagsRepository,Request $request)
    {   
        $this->personalizationTagsRepo  = $PersonalizationTagsRepository;

        if ($request->method()!="GET" &&  $request->header('Content-Type') != "application/json")  {
            //$request->headers->set('Content-Type', 'application/json');
			$message = Lang::get('lang::messages_admin.invalid_content_type');
            echo  json_encode([
                'status' => 0,
                'code' => 500,
                'message' => $message,
                'data'  =>  []
                ]
            );
            exit();
        } 
    } 
   /** @method : index 
    * Response : json 
    */
    
    public function index(Campaigns $campaign , Request $request)
    {
        
    }
    
     /**
    * @method : login
    * @method Type : POST
    * Request : $data,$id
    * Response Tye: array
    * Route : inner method
    * Desc : update campaign match fields by id
    */  
    public function authentication(Request $request)
    { 
        $data  ='';
       /* static array to match  username & password */
       $uer_array = array(
                        array(
                        "user_name"=>"martin",
                        "password"=>"martin@bsd",
                        "clinet_id"=>"16586",
                        "user_id"=>"16783",
                        "token"=>"16586@16783"
                        ),
                        array(
                        "user_name"=>"ellen",
                        "password"=>"ellen@bsd",
                        "clinet_id"=>"16833",
                        "user_id"=>"16733",
                        "token"=>"16833@16733"
                        ),
                        array(
                        "user_name"=>"test-1",
                        "password"=>"test-1@bsd",
                        "clinet_id"=>"16233",
                        "user_id"=>"14233",
                        "token"=>"16233@14233"
                        ),
                        array(
                        "user_name"=>"test-2",
                        "password"=>"test-2@bsd",
                        "clinet_id"=>"243432",
                        "user_id"=>"44532",
                        "token"=>"243432@44532"
                        ),
                        array(
                        "user_name"=>"martin-ellen",
                        "password"=>"martin-ellen@bsd",
                        "clinet_id"=>"3252543",
                        "user_id"=>"1255252",
                        "token"=>"3252543@1255252"
                        ),
                        array(
                        "user_name"=>"qa-amit",
                        "password"=>"qa-amit@bsd",
                        "clinet_id"=>"2262543",
                        "user_id"=>"1455252",
                        "token"=>"2262543@1455252"
                        ),
                        array(
                        "user_name"=>"qa-kapil",
                        "password"=>"qa-kapil@bsd",
                        "clinet_id"=>"4352543",
                        "user_id"=>"4655252",
                        "token"=>"4352543@4655252"
                        ),
                        array(
                        "user_name"=>"developer",
                        "password"=>"developer@bsd",
                        "clinet_id"=>"2222543",
                        "user_id"=>"3333332",
                        "token"=>"2222543@3333332"
                        )

                    );

        foreach($uer_array as $user_info){
            if(($user_info['user_name'] == $request->get('user_name')) && ($user_info['password'] == $request->get('password'))){
                      $data =  $user_info;
                      unset($data['password']);
                }
            }
            // * check data exist or not */
           if(!empty($data)) {
                 $code      = '200';
                 $status    = 1;
                 $message   = Lang::get('lang::messages_admin.auth_success');
           }else{
                $code       ='401';
                $status     = 0;
                $message    = Lang::get('lang::messages_admin.auth_failed');
           }
        return Response::json(array(
                'status'  => $status,
                'code'    => $code,
                'message' => $message,
                'data'    =>  $data
                )
            ); 
    }
  
} 