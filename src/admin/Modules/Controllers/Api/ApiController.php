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
use URL; 
use Admin\Models\Campaign; 
use Eloquent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Admin\Models\MatchFieldsCriteria;
use Admin\Models\CampaignMatchCriteria; 
use laravelDoctrine\Orm\Types\Json;
use Admin\Models\CampaignMatchFields;
use Admin\Models\Targets;
 
class ApiController extends Controller
{
   /** 
    * Method : __construct
	* Author : kundan Roy
    */
    public function __construct(Request $request) {

        if ($request->header('Content-Type') != "application/json")  {
           $request->headers->set('Content-Type', 'application/json');
        } 
    } 
   /**
    * @method : getCampaignList
    * @method Type : GET
    * Request : null
    * Response Tye: json
    * Route : get-campaign-list
    * Desc : List of all created campaign
    */  
    
    public function campaign(Request $request,$id=null)
    {
        $offset     =  $request->get('page_num');
        $offset     =  isset($offset)?$offset:0;
        $limit      =  $request->get('page_size');
        $limit      =  isset($limit)?$limit:50;
        $search     = $request->get('search'); 
        
        if($offset>=1)
        {
            $offset = ($offset-1)*$limit;
        }

        $query = Campaign::where(function($query) use($search,$id) {
                        if (!empty($search)) {
                            $query->Where('public_campaign_name', 'LIKE', "%$search%"); 
                        }
                        if($id!=null){
                          $query->Where('id', $id);   
                        } 
                    });
        $total_count  = $query->get()->count(); 
        $campaign_result = $query->offset($offset)->limit($limit)->get();

        $data_set   =   [];

        foreach ($campaign_result as $key => $value) {
             $data['id'] = $value->id;
             $data['title'] = $value->public_campaign_name;
             $data['created_at'] = \Carbon\Carbon::parse($value->created_at)->format('Y-m-d') ;
             $data['updated_at'] = \Carbon\Carbon::parse($value->updated_at)->format('Y-m-d');
             $status = $value->status;
             switch ($value->status ) {
                 case '0':
                     $status  = "Draft";
                     break;
                 case '1':
                     $status  = "Published";
                     break;
                 case '2':
                     $status  = "Pause";
                     break;
                 case '3':
                     $status  = "Resume";
                     break;
                 case '4':
                     $status  = "Unpublished";
                     break;            
                 default:
                     # code...
                     break;
             }
             $data['status'] = $status;
             $data_set[] = $data;
        }
       $message = "List of campaign clone.";

                return Response::json(array(
                    'status' => 1, 
                    "code"  => 200,
                    "total_record" => $total_count,
                    "message" =>  $message,
                    "data"  =>  $data_set
                    )
                ); 
    }

    public function target(Request $request)
    {
        $searchBy   =  $request->get('query');
        $party      =  str_getcsv($request->get('party'));
        $channel    =  str_getcsv($request->get('channel'));
        $city       =  str_getcsv($request->get('city'));
        $state      =  str_getcsv($request->get('state'));
        $offset     =  $request->get('offset');
        $offset     =  isset($offset)?$offset:0;
        $limit      =  $request->get('limit');
        $limit      =  isset($limit)?$limit:50;
        if(!is_null($offset)){
            $offset = ($offset-1)*$limit;
        }

        $query     = Targets::where(function($query) use($searchBy,$party,$city,$state,$channel) {
                        if (!empty($party[0])) { 
                            $query->WhereIn('party', $party); 
                        }
                        if (!empty($city[0])) {   
                            $query->WhereIn('target_city', $city); 
                        }
                        if (!empty($state[0])) {
                            $query->WhereIn('representing_state', $state); 
                        }
                        if (!empty($channel[0])) {
                            $query->whereIn('twitter_identifier', $channel)
                            ->orWhere(function ($query) use($channel){
                                $query->orwhereIn('facebook_identifier', $channel);  
                            }); 
                        }
                        if (!empty($searchBy)) {
                            $query->where('first_name','LIKE', "%$searchBy%") 
                            ->orWhere(function ($query) use($searchBy){
                                $query->orwhere('last_name','LIKE', "%$searchBy%");  
                            }); 
                        }
                    });
        $total_count  = $query->get()->count(); 
        $target_result = $query->offset($offset)->limit($limit)->get();
      
        $message    = "List of Targets";
        $code       = 200;
        $status_code = 1;
        if($target_result->count()==0)
        {
            $message = "Record not found";
            $code = 404;
            $status_code =0;
        }            
            return Response::json(array(
                'status' => $status_code,
                "code" => $code,
                'message' =>  $message,
                'total_record' =>$total_count,
                'data'  =>  $target_result
                )
            ); 
    }
} 