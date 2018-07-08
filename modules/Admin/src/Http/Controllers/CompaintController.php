<?php

namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Input;
use App\Models\Complains;
use View;
use URL;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Config;
use Modules\Admin\Models\Reason;


class CompaintController extends Controller
{
    
    public function __construct(Request $request,Complains $complains) { 
        $this->middleware('admin');
        View::share('viewPage', 'Compaint Managment');
        View::share('sub_page_title', 'Compaint');
        View::share('helper',new Helper);

        $heading = $request->get('reasonType');

        if($heading=='user'){
            $heading="Reported User";
        }else{
             $heading="Reported task ";
        }

        View::share('heading',$heading);
        View::share('route_url',route('compaint')); 
        $this->record_per_page = Config::get('app.record_per_page'); 
    }
    
    public function index(Complains $complains, Request $request) 
    {
        $page_title = 'Complaint';
        $sub_page_title = 'View Complaint';
        $page_action = 'View Complaint'; 

        $reason = $request->get('reasonType');
        if($request->get('reasonType')){
            $reason = Reason::where('reasonType','LIKE','%'.$request->get('reasonType').'%')->lists('id');

        }
        
        $search = trim($request->get('search'));
        $taskdate = $request->get('taskdate');  
        if ((isset($search) && !empty($search)) || (isset($taskdate) && !empty($taskdate)) ) { 
            $search = isset($search) ? Input::get('search') : null; 
            $comments = Complains::where(function($query) use($search,$taskdate,$reason) {
                // if (!empty($search)) {
                //     $query->whereHas('taskDetail', function($query) use($search) {
                //             $query->where('title', $search);
                //         }); 
                // } 
                if($reason){
                    $query->whereIn('reasonId',$reason);
                } 
                if (!empty($taskdate)) {
                     $query->where('created_at', 'LIKE', "%".$taskdate."%"); 
                } 
            })->where(function($query) use($search){
                if($search){
                    $query->where('compainId',$search);   
                } 
            })->with('userDetail','taskDetail','reportedUserDetail','reason')->Paginate($this->record_per_page);

        } else {
            $comments = Complains::with('taskDetail','reportedUserDetail','reason')
            ->where(function($query) use($search,$taskdate,$reason) {
                if($reason){
                    $query->whereIn('reasonId',$reason);
                }
            })
            ->orderBy('id','desc')->Paginate($this->record_per_page);
        }
        $reason = $request->get('reasonType'); 
        return view('packages::complains.index', compact('comments', 'page_title', 'page_action','reason')); 
    }


    public function complainDetail(Complains $complains, Request $request) 
    {
        $page_title = 'Complaint';
        $sub_page_title = 'View Complaint';
        $page_action = 'View Complaint'; 
        $ticketId = $request->get('ticketId');
        $reason = $request->get('reasonType');
        if($request->get('reasonType')){
            $reason = Reason::where('reasonType','LIKE','%'.$request->get('reasonType').'%')->lists('id');

        }
        
        $search = ($ticketId)?$ticketId:null;  
        if ($search) {
             
            $comments = Complains::where(function($query) use($search,$reason) {
                
                if($reason){
                    $query->whereIn('reasonId',$reason);
                } 
                  
            })->where(function($query) use($search){
                if($search){
                    $query->where('compainId',$search);   
                } 
            })->with('userDetail','taskDetail','reportedUserDetail','reason')->first();

        }   
        //dd($comments);
        $status = $request->get('status');
        $allReply = \DB::table('support_conversation')->where('parent_id',$comments->id)->where('reason_type','!=','')->get(); 
        $result = $complains;
        return view('packages::support.suportform', compact('comments', 'page_title', 'page_action','reason','ticketId','result','allReply','status'));
      }
  
    public function supportReply(Request $request)
    {
        
        $status = $request->get('status');
        \DB::table('complains')
                ->where('id',$request->get('parent_id'))
                ->update(['status'=>$status]);


        $data = $request->only('ticket_id','subject','email','status','user_comments','support_comments','reason_type','parent_id');;
       
        $data['details'] = json_encode($request->all());

        \DB::table('support_conversation')
                ->insert($data);

        return \Redirect::to(URL::previous())->with('msg','Ticket replied successfully');
    }
}
