<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Modules\Admin\Http\Requests\SyllabusRequest;
use App\Models\Tasks;
use Input;
use Validator;
use Auth;
use Hash;
use View;
use URL;
use Lang;
use Session;
use DB;
use Route;
use Crypt;
use Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher; 
use Modules\Api\Resources\TaskResource; 
use App\User;
use App\Models\Comments;
use Modules\Admin\Models\Reason;

/**
 * Class AdminController
 */
class ReasonController extends Controller {

   

    public function getReason(Request $request)
    { 
       $reason = Reason::all();
       $data1['reasonType'] = [];
       $data2['reasonType'] = [];
        foreach ($reason as $key => $value) {
            if($value->reasonType=="task reason")
            {
                $data1['reasonType'][] = $value ; 
            }

            elseif($value->reasonType=="user reason")
            {
                $data2['reasonType'][] = $value  ;
            } 
        }
        $arr = ['userReason'=>$data2['reasonType'],'taskReason'=>$data1['reasonType']];


        return Response::json(array(
                'status' => 1,
                'code'=>200,
                'message' => 'reason list',
                'data'  =>  $arr 
                )
            );
        
    } 

}