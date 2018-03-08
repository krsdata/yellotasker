<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon; 
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

    public function submitSupportRequest(Request $request,\Modules\Admin\Models\SupportTicket $support_ticket){

        $validator = Validator::make($request->all(), [
               'support_type' => 'required|numeric',
               'email'  => 'required',
               'subject' => 'required',
               'description'  => 'required'

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

        $table_cname = \Schema::getColumnListing('support_tickets');
        $except = ['id','created_at','updated_at'];
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
           $support_ticket->$value = $request->get($value);
        }
        $support_ticket->status     = 'open';
        $tid  = random_int(111111, 999999);
        $support_ticket->ticket_id = $tid;


        $attachment = $request->get('attachment');
        $url = []; 
        
        if(is_array($attachment)){
            foreach ($attachment as $key => $value) {
                $url[] = $this->createDocFromBase64($base64);
            }
        }elseif($attachment){
           $url[] = $this->createDocFromBase64($base64); 
        }

        if(count($url)){
            $fileName = implode(',', $url);
            $support_ticket->attachment = $fileName;
        }
       

        $support_ticket->save();

        $request->merge(['status'=>'open','ticket_id'=>$tid]);

        return Response::json(array(
                'status' => 1,
                'code'=>200,
                'message' => 'request submit successfully with ticket id '.$tid.'.Team will get back to you shortly',
                'data'  =>  $request->all()
                )
            ); 


    }

    public function createDocFromBase64($base64)
    {  
        $dtype = ['spreadsheetml',
                    'excel',
                    'pdf',
                    'msword',
                    'jpeg',
                    'png',
                    'gif',
                    'officedocument',
                    'wordprocessingml'
                    ];
        
        $file = explode(',', $base64);
        
        if(count($file)<=0)
        {
            return false;
        }
        
        
        if(isset($file[0]) && str_contains($file[0], 'spreadsheetml')){
            $file_name = time() . '.xlsx'; 
        }
        if(isset($file[0]) && str_contains($file[0], 'excel')){
            $file_name = time() . '.csv'; 
        }
        if(isset($file[0]) && str_contains($file[0], 'pdf')){
            $file_name = time() . '.pdf'; 
        }
        if(isset($file[0]) && str_contains($file[0], 'msword')){
            $file_name = time() . '.doc'; 
        }
        if(isset($file[0]) && (str_contains($file[0], 'jpeg') || str_contains($file[0], 'jpg'))){
            $file_name = time() . '.jpeg'; 
        }
        if(isset($file[0]) && (str_contains($file[0], 'png') || str_contains($file[0], 'PNG'))){
            $file_name = time() . '.png'; 
        }
        if(isset($file[0]) && str_contains($file[0], 'gif')){
            $file_name = time() . '.gif'; 
        }
        
        if(isset($file[0]) && str_contains($file[0], 'wordprocessingml')){
            $file_name = time() . '.docx'; 
        } 
        
        $final_file = base64_decode($file[1]); 
        $path = storage_path() . "/docs/" . $file_name;

        file_put_contents($path, $final_file);
        return 'storage/docs/' . $file_name; 
    }
    

    public function getArticleCategory(Request $request){

        $data = \DB::table('article_type')->select('id','article_type as article_category','resolution_department')->get();
        return Response::json(array(
                'status' => count($data)?1:0,
                'code'=>count($data)?200:404,
                'message' => count($data)?'Article category list':'not found',
                'data'  =>  $data
                )
            ); 

    }
    public function supportListing(Request $request){
        
         $data = \Modules\Admin\Models\ArticleType::with('article')->get();
        return Response::json(array(
                'status' => count($data)?1:0,
                'code'=>count($data)?200:404,
                'message' => count($data)?'Article list':'not found',
                'data'  =>  $data
                )
            );
    }
    public function getRelatedArticle(Request $request,$id=null){

        $data = \Modules\Admin\Models\Article::whereHas('articleCategory',function($q) use($id){
                    $q->where('id',$id);
                })->get();


        return Response::json(array(
                'status' => count($data)?1:0,
                'code'=> count($data)?200:404,
                'message' => count($data)?'Article list':'not found',
                'data'  =>  $data
                )
            );
       

    }
    public function getArticle(Request $request,$id=null){

        $data = \DB::table('articles')->where('id',$id)->get();
        return Response::json(array(
                'status' => count($data)?1:0,
                'code'=>count($data)?200:404,
                'message' => count($data)?'Article list':'not found',
                'data'  =>  $data
                )
            );

    }
 
}