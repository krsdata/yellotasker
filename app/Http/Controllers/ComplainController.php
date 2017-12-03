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
use App\Models\Complains;
use Modules\Admin\Models\Reason;

/**
 * Class AdminController
 */
class ComplainController extends Controller {

   

    public function getReport(Request $request,$id)
    { 
        if(str_contains($request->getpathInfo(),'user')){
          $report = User::with('reportedDetails')->where('id',$id)->get();  
        }
        elseif(str_contains($request->getpathInfo(),'task')){
          $report = Tasks::with('reportedDetails')->where('id',$id)->get();  
        }else{
           return Response::json(array(
                'status' => 1,
                'code'=>404,
                'message' => 'Not Report found',
                'data'  =>  []
                )
            ); 
        } 
 
        return Response::json(array(
                'status' => 1,
                'code'=>200,
                'message' => 'Report list',
                'data'  =>  $report
                )
            );
        
    } 

    public function reportBy(Request $request,Complains $report,$reportType)
    { 
         //Server side valiation
        if($reportType=='user'){
             $reportValidation = [
             'reasonId' => 'required',
         //   'postedUserId' => 'required',
               'reportedUserId' => 'required',
               
            ];
        }elseif($reportType=='task'){
            $reportValidation = [
             //   'postedUserId' => 'required',
               'reportedUserId' => 'required',
               'reasonId' => 'required',
               'taskId'=>'required'
            ];
        }else{

            return Response::json(array(
                'status' => 0,
                'code'=>500,
                'message' => 'Invalid report url!',
                'data'  =>  $request->all()
                )
            );
        } 

        $validator = Validator::make($request->all(), $reportValidation);
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
 

            $is_user = User::find($request->get('reportedUserId'));  
         
            if (!$is_user) {
     
                return
                    [ 
                    "status"  => '0',
                    'code'    => '500',
                    "message" => 'No match found for the given reportedUserId.',
                    'data'    => $request->all()
                    ]; 
            } 

        $reason = Reason::find($request->get('reasonId'));

        if (!$reason) {
 
            return
                [ 
                "status"  => '0',
                'code'    => '500',
                "message" => 'No match found for the given reasonId.',
                'data'    => $request->all()
                ];
                 
        }
        if($reportType=='task'){
            $task= Tasks::find($request->get('taskId'));
            if (!$task) {
                return
                    [ 
                    "status"  => '0',
                    'code'    => '500',
                    "message" => 'No match found for the given taskId.',
                    'data'    => $request->all()
                    ];
                     
            }
        }

        $table_cname = \Schema::getColumnListing('complains');
        $except = ['id','created_at','updated_at','compainId'];
        
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
           if($request->get($value)){
                $report->$value = $request->get($value);
           }
           
        } 
        $report->compainId = time(); 
        $report->save();

        $report = Complains::with('reportedUser','postedUser','reason','task')->where('id',$report->id)->get();
        return Response::json(array(
                'status' => 1,
                'code'=>200,
                'message' => 'Report posted successfully',
                'data'  =>  $report
                )
            );
        
    } 
 
}