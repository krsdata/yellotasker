<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Input;
use Validator;
use Response;
use App\MolpayPayment;
use App\Http\Requests;
use \App\Models\Tasks;
use App\User;
use App\Order;
use App\PaymentHistory;
use App\Withdrawal;
use App\BankAccount;
class MolpayPaymentController extends Controller
{
    private $molpay_vkey = 'f1d0fd1176dafad977b52a52a2ba2e24';
    private $molpay_skey = '6b959200bb1233fce28e069422e23ece';
    private $molpay_mid = 'SB_yellotasker';
    private $payment_success_url =null;
    private $payment_failed_url =null;
    private $sandbox =true;
    private $molpay_completed_status_id =1;
    private $molpay_failed_status_id =3;
    private $molpay_pending_status_id =2;
    private $molpay_default_status_id =0;
    private $molpay_withdrawal_status_pending =1;
    private $molpay_withdrawal_status_proccess =2;
    private $molpay_withdrawal_status_completed =3;
    private $molpay_withdrawal_status_declined =4;
    private $molpay_withdrawal_status_cancel =0;
    private $paymnet_currency='MYR';
    private $payment_service_commision=10;//10%
    private $withdrawal_service_charge=0;//flat
    private $payment_minimum_withdrawal=1;//Any Minimum Flat amount.
    protected $input = array();
private $trns_status = '(
                CASE 
                when  status=-1 then "Failed"
                when  status=1 then "Success"
                when  status=2 then "Pending"
                when  status=3 then "Failed" 
                ELSE 
                status end) as status'; 

    public function __construct()
    {
            $input = Input::all();
            $this->payment_minimum_withdrawal = 1;
            $this->input = $input;
            $this->payment_success_url = ('http://yellotasker.com/#/payment/acknowledgement');
          //  $this->payment_failed_url = ('http://yellotasker.co/#/paymentFailied');
            $this->payment_failed_url = ('http://yellotasker.com/#/payment/acknowledgement');

    }
    public function index(Request $request) {
            $data['molpay_mid']=$this->molpay_mid;

            if($this->sandbox){
            $data['action'] = 'https://sandbox.molpay.com/MOLPay/pay/'.$this->molpay_mid.'/';
            }else{//Production
             $data['action'] = 'https://www.onlinepayment.com.my/MOLPay/pay/'.$this->molpay_mid.'/';
            }



        $validator = Validator::make($request->all(), [
           'userId' => 'required',
           'taskId' => 'required',
           'amount' => 'required',
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
                'data'  =>  ''
                )
            );
        }

            $userId = $request->get('userId');
            $taskId = $request->get('taskId');
            $show_html_flag =(int)$request->get('show_html');

            $user = User::find($userId);
            if(!$user) return Response::json(array(
                'status' => 0,
                'code'=>500,
                'message' =>'User Not found.',
                'data'  =>  ''
                )
            );

            $task = Tasks::find($taskId);
            if(!$task) return Response::json(array(
                'status' => 0,
                'code'=>500,
                'message' =>'Task Not found.',
                'data'  =>  ''
                )
            );

            $amount = $request->get('amount');
            $order =  $this->createOrder($task, $user,$amount,'Task Payment : '.$task->title,'Online');

            $data['amount'] =$amount;
            $data['orderid'] =strval($order->order_id);
            $data['order_id'] = $order->order_id;
            $data['bill_name'] = $user->first_name.' '.$user->last_name;
            $data['bill_email'] = $user->email;
            $data['bill_mobile'] = $user->phone;
            $data['country'] = '';
            $data['currency'] = '';
            $data['vcode'] = md5($data['amount'].$this->molpay_mid.$data['orderid'].$this->molpay_vkey);

            $data['prod_desc'] =array($order->order_details);
            $data['lang'] = "en-US";
            $data['button_confirm'] = 'Pay With MolPay';

            $data['returnurl'] = url('molpay/return_ipn');
            $data['notification_url'] = url('molpay/notification_ipn');
            $data['returnurl'] = url('molpay/return_ipn');
            $output = view('molpay',$data);

            extract($data)  ;
        $fields = array(
        'action_url'=>$action,
        'orderid?'=>$orderid,
        'order_id?'=> strval($order_id),
        'oid'=> strval($order_id),
        'amount'=>(float)$amount,
        'bill_name'=>$bill_name,
        'bill_email'=>$bill_email,
        'bill_mobile'=>$bill_mobile,
        'country'=>$country,
        'currency'=>$currency,
        'vcode'=>$vcode,
        'returnurl'=> ($returnurl),
        'bill_desc'=>implode("\n",$prod_desc),
        );
        $query= http_build_query($fields);

        $fields['href']=$action;
        if($show_html_flag==0)
        return Response::json(array(
            'status' => 1,
            'code'=>200,
            'message' =>'Success',
            'data'  =>$fields
            )
        );
       return  $output;  //HTML return
    }

    public function return_ipn() {
     $vkey = $this->molpay_vkey;
    $this->input['treq']=   1;
    
    $tranID = (isset($this->input['tranID']) && !empty($this->input['tranID'])) ? $this->input['tranID'] : '';
    $orderid = (isset($this->input['orderid']) && !empty($this->input['orderid'])) ? $this->input['orderid'] : '';
    $status = (isset($this->input['status']) && !empty($this->input['status'])) ? $this->input['status'] : '';
    $domain = (isset($this->input['domain']) && !empty($this->input['domain'])) ? $this->input['domain'] : '';
    $amount = (isset($this->input['amount']) && !empty($this->input['amount'])) ? $this->input['amount'] : '';
    $currency = (isset($this->input['currency']) && !empty($this->input['currency'])) ? $this->input['currency'] : '';
    $appcode = (isset($this->input['appcode']) && !empty($this->input['appcode'])) ? $this->input['appcode'] : '';
    $paydate = (isset($this->input['paydate']) && !empty($this->input['paydate'])) ? $this->input['paydate'] : '';
    $skey = (isset($this->input['skey']) && !empty($this->input['skey'])) ? $this->input['skey'] : '';
    /***********************************************************
    * Backend acknowledge method for IPN (DO NOT MODIFY)
    ************************************************************/
    while ( list($k,$v) = each($this->input) ) {
      $postData[]= $k."=".$v;
    }
    $postdata   = implode("&",$postData);
    $url        = "https://www.onlinepayment.com.my/MOLPay/API/chkstat/returnipn.php";
    $ch         = curl_init();
    curl_setopt($ch, CURLOPT_POST           , 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS     , $postdata);
    curl_setopt($ch, CURLOPT_URL            , $url);
    curl_setopt($ch, CURLOPT_HEADER         , 1);
    curl_setopt($ch, CURLINFO_HEADER_OUT    , TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , FALSE);
    //curl_setopt($ch, CURLOPT_SSLVERSION     , 3);
    $result = curl_exec( $ch );
    curl_close( $ch );
    /***********************************************************
    * End of Acknowledge method for IPN
    ************************************************************/

    $key0 = md5($tranID.$orderid.$status.$domain.$amount.$currency);
    $key1 = md5($paydate.$domain.$key0.$appcode.$vkey);
    $task_id = 0;
    $ordObj = Order::where('order_id',$orderid)->first();

    if($ordObj){
        $task_id = $ordObj->task_id;
    }

    $responseURL ='';
        if ( $skey != $key1 )
            $status = -1 ;
        $order_status_id = $this->molpay_default_status_id;

        if ( $status == "00" )  {
            $order_status_id = $this->molpay_completed_status_id;
            if($task_id){
                \DB::table('post_tasks')->where('id',$task_id)->update(['funded_by_poster'=>'Yes','payment_status'=>'completed']);
            }
            $responseURL = $this->payment_success_url;
        } 
        elseif( $status == "22" ) 
        {
            $order_status_id = $this->molpay_pending_status_id;
            if($task_id){
                \DB::table('post_tasks')->where('id',$task_id)->update(['funded_by_poster'=>'Yes','payment_status'=>'pending_from_bank']);
            }
            $responseURL = $this->payment_success_url;
        }else 
        {
            $order_status_id = $this->molpay_failed_status_id;
            $responseURL = $this->payment_failed_url;

            if($task_id){
                \DB::table('post_tasks')->where('id',$task_id)->update(['payment_status'=>'failed']);
            }
        }

        $this->save();
        $this->updateOrderStatus($orderid, $order_status_id,$tranID);
       
            echo '<html>' . "\n";
            echo '<head>'  . "\n";
            echo '  <meta http-equiv="Refresh" content="0; url=' . $responseURL . '?txnID='.$tranID.'">' . "\n";
            echo '</head>' . "\n";
            echo '<body>' . "\n";
            echo '  <p><center>Please Don\'t refresh browser '. "</center>\n";
            echo '  <p><center>Please follow <a href="' . $responseURL . '?txnID='.$tranID.'">link</a>!<center></p>' . "\n";
            echo '</body>' . "\n";
            echo '</html>' . "\n";
            exit();
    }

    /*****************************************************
    * Callback with IPN(Instant Payment Notification)
    ******************************************************/
    public function callback_ipn()   {

    $this->load->model('checkout/order');

    $vkey = $this->molpay_vkey;

    $nbcb = (isset($this->input['nbcb']) && !empty($this->input['nbcb'])) ? $this->input['nbcb'] : '';
    $tranID = (isset($this->input['tranID']) && !empty($this->input['tranID'])) ? $this->input['tranID'] : '';
    $orderid = (isset($this->input['orderid']) && !empty($this->input['orderid'])) ? $this->input['orderid'] : '';
    $status = (isset($this->input['status']) && !empty($this->input['status'])) ? $this->input['status'] : '';
    $domain = (isset($this->input['domain']) && !empty($this->input['domain'])) ? $this->input['domain'] : '';
    $amount = (isset($this->input['amount']) && !empty($this->input['amount'])) ? $this->input['amount'] : '';
    $currency = (isset($this->input['currency']) && !empty($this->input['currency'])) ? $this->input['currency'] : '';
    $appcode = (isset($this->input['appcode']) && !empty($this->input['appcode'])) ? $this->input['appcode'] : '';
    $paydate = (isset($this->input['paydate']) && !empty($this->input['paydate'])) ? $this->input['paydate'] : '';
    $skey = (isset($this->input['skey']) && !empty($this->input['skey'])) ? $this->input['skey'] : '';

    $key0 = md5($tranID.$orderid.$status.$domain.$amount.$currency);
    $key1 = md5($paydate.$domain.$key0.$appcode.$vkey);

    if ( $skey != $key1 )
        $status = -1 ;

    if ($nbcb == 1) {
        echo "CBTOKEN:MPSTATOK";

                    if ( $status == "00" )  {
                            $order_status_id = $this->molpay_completed_status_id;

                    } elseif( $status == "22" ) {
                            $order_status_id = $this->molpay_pending_status_id;

                    } else {
                            $order_status_id = $this->molpay_failed_status_id;

                    }
          $this->updateOrderStatus($orderid, $order_status_id);
          $this->save();

    }
    }

    /*****************************************************
    * Notification with IPN(Instant Payment Notification)
    ******************************************************/
    public function notification_ipn()   {
    $vkey = $this->molpay_vkey;
    $nbcb = (isset($this->input['nbcb']) && !empty($this->input['nbcb'])) ? $this->input['nbcb'] : '';
    $tranID = (isset($this->input['tranID']) && !empty($this->input['tranID'])) ? $this->input['tranID'] : '';
    $orderid = (isset($this->input['orderid']) && !empty($this->input['orderid'])) ? $this->input['orderid'] : '';
    $status = (isset($this->input['status']) && !empty($this->input['status'])) ? $this->input['status'] : '';
    $domain = (isset($this->input['domain']) && !empty($this->input['domain'])) ? $this->input['domain'] : '';
    $amount = (isset($this->input['amount']) && !empty($this->input['amount'])) ? $this->input['amount'] : '';
    $currency = (isset($this->input['currency']) && !empty($this->input['currency'])) ? $this->input['currency'] : '';
    $appcode = (isset($this->input['appcode']) && !empty($this->input['appcode'])) ? $this->input['appcode'] : '';
    $paydate = (isset($this->input['paydate']) && !empty($this->input['paydate'])) ? $this->input['paydate'] : '';
    $skey = (isset($this->input['skey']) && !empty($this->input['skey'])) ? $this->input['skey'] : '';

    $key0 = md5($tranID.$orderid.$status.$domain.$amount.$currency);
    $key1 = md5($paydate.$domain.$key0.$appcode.$vkey);

    if ( $skey != $key1 )
        $status = -1 ;

    if ($nbcb == 2) {
        echo "CBTOKEN:MPSTATOK";

        $order_status_id = 0;

        if ( $status == "00" )  {
                $order_status_id = $this->molpay_completed_status_id;

        } elseif( $status == "22" ) {
                $order_status_id = $this->molpay_pending_status_id;

        } else {
                $order_status_id = $this->molpay_failed_status_id;

        }
        $this->updateOrderStatus($orderid, $order_status_id);
        $this->save();
    }
    }

    /**
     * Save all payment transaction
     *
     * @access  protected
     * @return  Eloquent
     */
    protected function save()
    {
            $input = $this->input;

            // check for transaction id.
            $molpay = MolpayPayment::where('transaction_id', '=', $input['tranID'])->first();

            if (is_null($molpay))
            {
                    $molpay = new MolpayPayment;
                    $molpay->transaction_id       = $input['tranID'];
            }

            $molpay->amount       = $input['amount'];
            $molpay->domain       = $input['domain'];
            $molpay->app_code     = $input['appcode'];
            $molpay->order_id     = $input['orderid'];
            $molpay->channel      = $input['channel'];
            $molpay->status       = $input['status'];
            $molpay->currency     = $input['currency'];
            $molpay->paid_at      = $input['paydate'];
            $molpay->security_key = $input['skey'];

            if ('00' !== $input['status'])
            {
                    $input['error_code'] and $molpay->error_code = $input['error_code'];
                    $input['error_desc'] and $molpay->error_description = $input['error_desc'];
            }

            $molpay->save();

            return $molpay;
    }

    protected function createOrder($task,$user,$amount,$order_details='',$payment_method='molpay'){

        $order= Order::where('status', '=', -1)
                ->where('user_id', '=', $user->id)
                ->where('task_id', '=', $task->id)
                ->first();
          if (is_null($order)){
                 $order = new Order;

            }
       $order->transaction_id= '';
       $order->order_id= time();
       $order->user_id  = $user->id;
       $order->task_id   = $task->id;
       $order->task_title   = $task->title;
       $order->payment_mode  =$payment_method ;
       $order->status= -1;//temp order
       $order->total_price=$amount;
       $order->discount_price=$amount;
       $order->order_details= $order_details;

       $order->save();
     return $order;
    }

    protected function updateOrderStatus($molpay_order_id,$order_status,$txn_id){

    $order= Order::where('order_id', '=', $molpay_order_id)->first();
    if (is_null($order)){
     return false;
     }
      $order->status = $order_status;
      $order->transaction_id = $txn_id;
      $order->save();
      return $order;
    }

    public function releaseTaskFund(Request $request) {
        $validator = Validator::make($request->all(), [
                    'userId' => 'required',
                    'taskId' => 'required',
        ]);

        /** Return Error Message * */
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => ''
                            )
            );
        }

        $userId = $request->get('userId');
        $taskId = $request->get('taskId');
        $user = User::where('id', $userId)->first(['current_balance', 'total_balance']);
        $task = Tasks::where('id', $taskId)->first(['id', 'title', 'status', 'userId', 'taskDoerId', 'taskOwnerId', 'totalAmount', 'fund_released']);

        $status = 0;
        $message = 'Something Wrong with Server.';
        if (!$user) {
            $message = 'User Not Found.';
        } else if (!$task) {
            $message = 'Task Not Found.';
        } else {
            $status = 1;
            if ($task['fund_released'] == 0) {
                $taskDoer = User::find($task['taskDoerId']);
                if (!$taskDoer) {
                    $message = 'Task is not assigned to any doer.';
                } else {
                    $message = $this->addTaskPaymentCredit($user, $task, $taskDoer);
                }
            } else {
                $message = 'Task is already paid.';
            }
        }

        return Response::json(array(
                    'status' => $status,
                    'code' => $status ? 200 : 500,
                    'message' => $message,
                    'data' => ''
        ));
    }

    private function addTaskPaymentCredit($user, $task, $taskDoer) {
        $message = 'Task Payment done succesfully.';

        $taskId = $task['id'];
        $taskDoerId = $task['taskDoerId'];
        $taskOwnerId = $task['taskOwnerId'];
        $totalAmount = $task['totalAmount'];
        $commisionAmount = (float) $totalAmount * (float) $this->payment_service_commision / 100;
        $netAmount = $totalAmount - $commisionAmount;
        //Add Credit
        $model = User::find($taskDoerId);
        if ($model) {
            $model->increment('current_balance', $netAmount);
            $model->increment('total_balance', $netAmount);

            $remarks = 'You Have received payment:$' . $netAmount . ' For task ' . $task['title'];
            Tasks::find($taskId)->update(['fund_released'=>1]);//change status
            $this->addPaymentHistory($taskDoerId, $taskId, $totalAmount, $commisionAmount, $netAmount, 'CR', $this->paymnet_currency, 1, $remarks);
            $this->notifyUserOnTaskPaymentRelease($user,$model,$task);
        }
        return $message;
    }

    public function getCurrentBalance(Request $request) {
        $validator = Validator::make($request->all(), [
                    'userId' => 'required',
        ]);
        /** Return Error Message * */
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => ''
                            )
            );
        }

        $userId = $request->get('userId');
        $user = User::where('id', $userId)->first(['current_balance', 'total_balance']);
        $status = 0;
        $message = 'User Not found.';
        if ($user) {
            $status = 1;
            $message = "Record found.";
            $user['currency'] = $this->paymnet_currency;
        }
        return Response::json(array(
                    'status' => $status,
                    'code' => $status ? 200 : 500,
                    'message' => $message,
                    'data' => $user
                        )
        );
    }

    //Used to show all withdrawal request
    public function getPaymentHistory(Request $request) {
        $validator = Validator::make($request->all(), [
                    'userId' => 'required',
        ]);
        /** Return Error Message * */
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => ''
                            )
            );
        }

        $page_num = ($request->get('page_num'))?$request->get('page_num'):1;
        $page_size = ($request->get('page_size'))?$request->get('page_size'):20; 
        if($page_num>1){
            $offset = $page_size*($page_num-1);
        }else{
           $offset = 0;
        }   
        $userId = $request->get('userId');
        $paymentHistory = PaymentHistory::where('userId', $userId)->with('taskDetails')->orderBy('created_at', 'DESC')
                 ->select('*',\DB::raw($this->trns_status),\DB::raw('DATE_FORMAT(created_at,"%m-%d-%Y") as order_date,DATE_FORMAT(created_at,"%h:%i:%s %p") as order_time'  ) )
                    ->where('taskId','!=',0); // 15-07-2018
        $total_record= $paymentHistory->count();
        $earned =$paymentHistory->skip($offset)
                ->take($page_size)
                ->get()->toArray();
        $data['earned'] =$earned;
        return Response::json(array(
                    'status' => 1,
                    'code' => 200,
                    'total_record' => $total_record,
                    'message' => $earned ? 'Payment histroy found.' : 'No Result found.',
                    'data' => $earned
                        )
        );
    }

    public function getOrderHistry(Request $request){
            $validator = Validator::make($request->all(), [
                    'userId' => 'required',
        ]);
        /** Return Error Message * */
        $userId = $request->get('userId');
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => ''
                            )
            );
        }

        $net_outgoing = \DB::table('post_tasks')->where(function($q) use($userId){
            $q->where('taskOwnerId',$userId);
            $q->where('fund_released',1);
        })->sum('totalAmount');

        
        $net_incoming = \DB::table('payment_history')->where(function($q) use($userId){
            $q->where('userId',$userId);
        })->sum('payable_amount');




        $userId = $request->get('userId');
        $page_num = ($request->get('page_num'))?$request->get('page_num'):1;
        $page_size = ($request->get('page_size'))?$request->get('page_size'):20; 

        if($page_num>1){
            $offset = $page_size*($page_num-1);
        }else{
           $offset = 0;
        }        
        $orders = Order::where('user_id', $userId)->with('taskDetails')->orderBy('created_at', 'DESC')
                 ->select('*',\DB::raw($this->trns_status),\DB::raw('DATE_FORMAT(created_at,"%m-%d-%Y") as order_date,DATE_FORMAT(created_at,"%h:%i:%s %p") as order_time'  ) );
        
        $total_record= $orders->count();
        $orders =$orders->skip($offset)
                ->take($page_size)
                ->get()->toArray();
        $data['outgoing'] =$orders;
        return Response::json(array(
                    'status' => 1,
                    'code' => 200,
                    'net_outgoing' => isset($net_outgoing)?$net_outgoing:'0.00',
                    'net_incoming' => isset($net_incoming)?$net_incoming:'0.00',
                    'total_record' => $total_record,
                    'message' => $orders ? 'Payment histroy found.' : 'No Result found.',
                    'data' => $data
                        )
        );   
    }
    
    private function addPaymentHistory($userId, $taskId, $amount, $service_charge, $payable_amount, $mode, $currency, $status, $remarks) {

        $transition = new PaymentHistory;
        $transition->userId = $userId;
        $transition->taskId = $taskId;
        $transition->amount = $amount;
        $transition->service_charge = $service_charge;
        $transition->payable_amount = $payable_amount;
        $transition->mode = $mode; //CR/DR
        $transition->currency = $currency;
        $transition->status = (int) $status;
        $transition->remarks = $remarks;
        $transition->save();

        return $transition;
    }

    public function addWithdrawalRequest(Request $request) {
        $validator = Validator::make($request->all(), [
                    'userId' => 'required',
                    'amount' => 'required',
                    'bankId' => 'required',
        ]);
        /** Return Error Message * */
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => ''
                            )
            );
        }
        $data = array();
        $userId = $request->get('userId');
        $amount = (float) $request->get('amount');
        $currency = $this->paymnet_currency;
        $bankId = $request->get('bankId');
        $user = User::where('id', $userId)->first(['current_balance', 'total_balance']);
        $current_balance = isset($user['current_balance']) ? $user['current_balance'] : 0;
        $service_charge = $this->withdrawal_service_charge; //flat charge now
        $payable_amount = $amount - $service_charge;
        $actual_amount = $current_balance - $service_charge;
        $bank = BankAccount::where('id', $bankId)->where('user_id', $userId)->first();
        $status = 0;
        $message = 'Something Wrong with Server.';
        if (!$user) {
            $message = 'User Not Found.';
        } else if (!$current_balance) {
            $message = 'Your wallet balance is empty.';
        } else if ($current_balance < $this->payment_minimum_withdrawal) {
            $message = 'Your wallet balance is empty.';
            $min = $this->formatePrice($this->payment_minimum_withdrawal,$currency) ;
            $minCB = $this->formatePrice($current_balance , $currency) ;
            $message = 'You wallet balance('.$minCB.') is lower than minimum required amount (' . $min . ').';
        } else if ($amount > $current_balance) {
            $min = $this->formatePrice( $current_balance,$currency) ;
            $message = 'You are not allowed to withdrawal amount more than your current wallet balance(' . $min . ').';
        } else if ($amount < $this->payment_minimum_withdrawal) {
            $min = $this->formatePrice($this->payment_minimum_withdrawal,$currency) ;
            $message = 'You can\'t withdrawal lower than minimum required amount (' . $min . ').';
        } else if (!$bank) {
            $message = 'Bank Not Found.';
        } else {
            $status = 1;
            $model = User::find($userId);

            if ($model) {
                $model->increment('current_balance', -$amount);
                $txnId = strtoupper(str_random(10));
                $remarks = 'You have intiate withdrawal request(' . $txnId . ') for $' . $amount;
                $withdrawal = $this->saveWithdrawal($txnId, $userId, $bank, $amount, $service_charge, $payable_amount, $this->paymnet_currency, $remarks);
                $this->addPaymentHistory($userId, 0, $amount, $service_charge, $payable_amount, 'DR', $this->paymnet_currency, 1, $remarks);
                $message = 'Withdrawal request added succesfully.';
                $data = User::where('id', $userId)->first(['current_balance', 'total_balance']);
                $data['currency'] =$currency;
                $data['txnID'] = $txnId;
                $data['amount'] =  $this->formatePrice($amount,$currency);
                $this->notifyOnWithdrawal($user,$withdrawal);
            }
        }


        return Response::json(array(
                    'status' => $status,
                    'code' => $status ? 200 : 500,
                    'message' => $message,
                    'data' => $data
        ));
    }

    private function saveWithdrawal($txnId, $userId, $bank, $amount, $service_charge, $payable_amount, $currency, $remarks) {

        $transition = new Withdrawal;
        $transition->userId = $userId;
        $transition->txn_id = $txnId;
        $transition->amount = $amount;
        $transition->service_charge = $service_charge;
        $transition->payable_amount = $payable_amount;
        $transition->currency = $currency;
        $transition->paymentMethod = json_encode($bank);
        $transition->status = 1;
        $transition->remarks = $remarks;
        $transition->save();
        return $transition;
    }

    public function approveWithdrawal(Request $request){
         $validator = Validator::make($request->all(), [
                    'withdrawalId' => 'required',
        ]); 
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => ''
                            )
            );
        }
        $withdrawalId = $request->get('withdrawalId');
        $withdrawal   = Withdrawal::find($withdrawalId);
        
        $message ='Error Occured. Please try again.';
        $status = 0;
        if(!$withdrawal){
         $message ='withdrawal request not found.';   
        }else if($withdrawal['status']== $this->molpay_withdrawal_status_pending){ //pending
           $paymentMethod= json_decode($withdrawal['paymentMethod']);
            if (json_last_error() !==JSON_ERROR_NONE) {
            $message ='Payment withdrawal method is not valid.';        
            }else{
             $message ='Payment withdrawal method is  valid.'; 
             $reference_id = $withdrawal['txn_id'];
             $amount = $withdrawal['payable_amount'];
             $currency = $withdrawal['currency'];
             $payee = User::where('id',$withdrawal['userId'])->get(['email','phone'])->first()->toArray();
             if($payee){
             $payee_email =$payee['email'];
             $payee_mobile =$payee['phone'];
             $payee_bank_name = $paymentMethod->bank_name;
             $payee_bank_code = $paymentMethod->ifsc_code;
             $payee_back_acc_name = $paymentMethod->account_name;
             $payee_bank_acc_number = $paymentMethod->account_number;
             $payeeID = 0;//$paymentMethod->molplayProfile_id;
             if($payeeID){ //Let do
                $response = $this->payMolepayPayeeByPayeeID($payeeID, $amount, $currency);
             }else{
              $response = $this->payMolepayPayeeByBank($reference_id, $amount, $currency, $payee_email, $payee_mobile, $payee_bank_name, $payee_bank_code, $payee_back_acc_name, $payee_bank_acc_number);

              if(isset($response['StatCode']) && $response['StatCode']=='00'){
                 $status=1;
                 $message ='Withdrawal request initialize successfully.'; 
                  $withdrawal = Withdrawal::find($withdrawalId);
                  if($withdrawal){
                  $withdrawal->api_response = json_encode($response);
                  $withdrawal->status = $this->molpay_withdrawal_status_proccess;
                  $withdrawal->save(); 
                  }
              }else if(isset($response['StatCode']) && $response['StatCode']=='11'){
                  $message ='Withdrawal request failed.';  
              }else{
                   $message ='Error Occured. Please try again.'; 
              }
              
             }
             }else{
              $message ='User not register in the system.';   
             }
            }              
        }else if($withdrawal['status']== $this->molpay_withdrawal_status_proccess){ //proccess
            $message ='Withdrawal request already in progress.';
            $status=1;
            $withdrawal['status']='In Progress';
         
        }else if($withdrawal['status']== $this->molpay_withdrawal_status_completed){ //completed
         
            $message ='Withdrawal request completed successfully.';
            $status=1;
            $withdrawal['status']='Completed';
        }else if($withdrawal['status']== $this->molpay_withdrawal_status_declined){ //declined
         
        }else if($withdrawal['status']== $this->molpay_withdrawal_status_cancel){ //cancel
         
        }
        
        if($withdrawal){
            unset($withdrawal['paymentMethod']);
            unset($withdrawal['api_response']);
            unset($withdrawal['remarks']);
        }
          return Response::json(array(
                    'status' => $status,
                    'code' =>$status? 200:500,
                    'message' => $message,
                    'data' => $withdrawal,
                        )
        );

    }

    public function adminWithdrawals( Request $request){
        
        $withdrawals = Withdrawal::orderBy('created_at', 'DESC')->get();
        $withdrawals =$withdrawals->toArray();
        return Response::json(array(
                    'status' => 1,
                    'code' => 200,
                    'message' => $withdrawals ? 'Withdrawals List found.' : 'No Result found.',
                    'data' => $withdrawals
                        )
        );
    }
    
    public function getWithdrawals(Request $request) {
        $validator = Validator::make($request->all(), [
                    'userId' => 'required',
        ]);
        /** Return Error Message * */
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => ''
                            )
            );
        }

        $userId = $request->get('userId');
        $withdrawals = Withdrawal::where('userId', $userId)->orderBy('created_at', 'DESC')->get();
        $withdrawals =$withdrawals->toArray();
        return Response::json(array(
                    'status' => 1,
                    'code' => 200,
                    'message' => $withdrawals ? 'Withdrawals List found.' : 'No Result found.',
                    'data' => $withdrawals
                        )
        );
    }

    public function addBankDetail(Request $request) {
        $validator = Validator::make($request->all(), [
                    'userId' => 'required',
                    'bankName' => 'required',
                    'accountName' => 'required',
                    'accountNumber' => 'required',
                    'ifscCode' => 'required',
                    'bankBranch' => 'required',
        ]);
        /** Return Error Message * */
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => ''
                            )
            );
        }

        $userId = $request->get('userId');
        $bankName = $request->get('bankName');
        $accountName = $request->get('accountName');
        $accountNumber = $request->get('accountNumber');
        $ifscCode = $request->get('ifscCode');
        $bankBranch = $request->get('bankBranch');
        $user = User::where('id', $userId)->first(['id']);
        $status = 0;
        $data = array();
        if ($user) {

            $bankAccount = new BankAccount;
            $bankAccount->user_id = $userId;
            $bankAccount->bank_name = $bankName;
            $bankAccount->account_name = $accountName;
            $bankAccount->account_number = $accountNumber;
            $bankAccount->ifsc_code = $ifscCode;
            $bankAccount->bank_branch = $bankBranch;
            $bankAccount->status = 1;
            $bankAccount->bankdetails = '';
            $bankAccount->save();
            $status = 1;
            $message = 'Bank Details added succesfully.';
            $data = $bankAccount;
        } else {
            $message = 'User not found.';
        }
        return Response::json(array(
                    'status' => $status,
                    'code' => $status ? 200 : 500,
                    'message' => $message,
                    'data' => $data
                        )
        );
    }

    public function removeBankDetail(Request $request) {
        $validator = Validator::make($request->all(), [
                    'userId' => 'required',
                    'bankId' => 'required',
        ]);
        /** Return Error Message * */
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => ''
                            )
            );
        }

        $userId = $request->get('userId');
        $bankId = $request->get('bankId');
        $user = User::where('id', $userId)->first(['id']);
        $bank = BankAccount::where('id', $bankId)->where('user_id', $userId)->first(['id']);
        $status = 0;
        if (!$user) {
            $message = 'User not found.';
        } else if (!$bank) {
            $message = 'Bank Detail not found.';
        } else {
            $status = 1;
            $bank = BankAccount::where('id', $bankId)->where('user_id', $userId)->delete();
            $message = 'Bank Detail deleted succesfully.';
        }
        return Response::json(array(
                    'status' => $status,
                    'code' => $status ? 200 : 500,
                    'message' => $message,
                    'data' => ''
                        )
        );
    }

    public function getBankDetailList(Request $request){
       $validator = Validator::make($request->all(), [
                    'userId' => 'required',
        ]);
        /** Return Error Message * */
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }

            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => ''
                            )
            );
        }
        
        $userId = $request->get('userId');        
        $user = User::where('id', $userId)->first(['id']);
        $banks = BankAccount::where('user_id', $userId)->get();
        $status = 0;
        if (!$user) {
            $message = 'User not found.';
            $banks=[];
        }else {
            $status = 1;
            $message = $banks?'Records found.':'Result not found';
        }
        return Response::json(array(
                    'status' => $status,
                    'code' => $status ? 200 : 500,
                    'message' => $message,
                    'data' => $banks
                        )
        );
    }
    
    private function createMolepayPayee() {

        $profile = array(
            'payeeID' => '9', // (empty for new registration)
            'Type' => 'Individual', //: Individual / Business *
            'Full_Name' => 'Naru LAL',
            'NRIC_Passport' => 'TEST',
            'Company_Name' => 'PUNE',
            'ROB_ROC' => '',
            'Country' => 'INDIA',
            'Bank_Name' => 'State bank of india', //required *
            'Bank_Code' => 'SBIN0000256', // required *
            'Bank_AccName' => 'SBi', // required *
            'Bank_AccNumber' => '200885411223', // required *     
            'Email' => 'nlkeer@mailinator.com', //required *
            'Mobile' => '9799733954', //required **/
        );
        $profile = json_encode($profile);
        $operator = $this->molpay_mid;
        $func = 'new';
        $profile_hash = str_random(10);
        $skey = md5($func . $operator . $profile . $profile_hash . SHA1($this->molpay_vkey));
        $inputs = array(
            'operator' => $this->molpay_mid,
            'skey' => $skey,
            'func' => $func, //modify,new,disable
            'profile' => $profile,
            'profile_hash' => $profile_hash,
        );

        while (list($k, $v) = each($inputs)) {
            $postData[] = $k . "=" . $v;
        }

        if ($this->sandbox) {
            $url = 'https://sandbox.molpay.com';
        } else {//Production
            $url = 'https://www.onlinepayment.com.my';
        }
        $url .= '/MOLPay/API/MassPayment/payee_profile.php';
        $postdata = implode("&", $postData);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //curl_setopt($ch, CURLOPT_SSLVERSION     , 3);
        $result = @curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function payMolepayPayeeByPayeeID($payeeID,$amount,$currency) {

        $operator = $this->molpay_mid;
        $skey = md5($operator . $payeeID . $amount . $currency . SHA1($this->molpay_vkey));
        $inputs = array(
            'operator' => $operator,
            'skey' => $skey,
            'payeeID' => $payeeID,
            'amount' => $amount,
            'currency' => $currency,
        );

        while (list($k, $v) = each($inputs)) {
            $postData[] = $k . "=" . $v;
        }

        if ($this->sandbox) {
            $url = 'https://sandbox.molpay.com';
        } else {//Production
            $url = 'https://www.onlinepayment.com.my';
        }
        $url .= '/MOLPay/API/MassPayment/SI_by_payee.php';

        $postdata = implode("&", $postData);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSLVERSION     , 3);
        $result = curl_exec($ch);
        curl_close($ch);
        $response= (array)json_decode($result);
        if (json_last_error() ===JSON_ERROR_NONE) {
         return $response;
        }
        return false;
    }

    private function payMolepayPayeeByBank($reference_id,$amount,$currency,$payee_email,$payee_mobile,$payee_bank_name,$payee_bank_code,$payee_back_acc_name,$payee_bank_acc_number) {

        $payee = array(
            'Country' => '',//INR
            'Bank_Name' => $payee_bank_name, //required*
            'Bank_Code' => $payee_bank_code, //Bank_Code/Swift_Code 
            'Bank_AccName' =>$payee_back_acc_name, //required*
            'Bank_AccNumber' => $payee_bank_acc_number, //required*,
            'Bank_Address'=>'',// (non-Malaysian)
            'Beneficery_Address'=>'',// (non-Malaysian)
            'Email' => $payee_email, //required*
            'Mobile' => $payee_mobile //required*
        );
     
        $payee = json_encode($payee);
        $operator = $this->molpay_mid;
        $notify_url = url('molpay/masspay/notify');
        $skey = md5($operator . $amount . $currency . $payee . $reference_id . $notify_url . SHA1($this->molpay_vkey));
        $inputs = array(
            'operator' => $operator,
            'skey' => $skey,
            'amount' => $amount,
            'currency' => $currency,
            'payee' => $payee,
            'reference_id' => $reference_id,
            'notify_url' => $notify_url,
        );

        while (list($k, $v) = each($inputs)) {
            $postData[] = $k . "=" . $v;
        }

        if ($this->sandbox) {
            $url = 'https://sandbox.molpay.com';
        } else {//Production
            $url = 'https://www.onlinepayment.com.my';
        }
        $url .= '/MOLPay/API/MassPayment/direct_SI.php';

        $postdata = implode("&", $postData);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, FALSE); //TRUE TO SHOW HEADER RESPONSE
       // curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //curl_setopt($ch, CURLOPT_SSLVERSION     , 3);
        $result = curl_exec($ch);
        curl_close($ch);
        
        $response= (array)json_decode($result);
        if (json_last_error() ===JSON_ERROR_NONE) {
            return $response;
        }
        return false;
    }

    public function massPayPaymentNotify(Request $request){
        
    }
    private function notifyOnWithdrawal($user,$withdrawal){
        //TODO
    }
    
    private function notifyUserOnTaskPaymentRelease($user,$doer,$task){
        //TODO
    }
    
    private function formatePrice($amount,$currency){
        $prefix = '';
        $suffix = '';
     if($currency =='USD'){
          $prefix = '$';
          $suffix = '';
     }else if($currency =='MYR'){
         $prefix = '';
         $suffix = 'RM';  
     }else if($currency =='INR'){
         $prefix = 'Rs.';
         $suffix = '';  
     }  
     return $prefix.$amount.$suffix;
    }
    public function success(){
     return "success";
    }

    public function failed(){
     return "failed";
    }

    public function totalIncome(Request $request)
    {
        $startDate = $request->get('startDate');
        $endDate   = $request->get('endDate');

        if($startDate && $endDate){
            $earnTaskId = \DB::table('orders')
            ->where('status',1)
               ->whereBetween(\DB::raw("STR_TO_DATE(created_at,'%Y-%m-%d')"), [$startDate, $endDate])->lists('task_id');
            
        }

        $service_charge = \DB::table('payment_history')->where(function($q) use($startDate,$endDate){
            if($startDate && $endDate){
                $q->whereBetween(\DB::raw("STR_TO_DATE(created_at,'%Y-%m-%d')"), [$startDate, $endDate]);
            }
        })->select(\DB::raw('GROUP_CONCAT(taskId) as taskId'),\DB::raw('SUM(amount) as earn'),\DB::raw('SUM(payable_amount) as spend'),\DB::raw('SUM(service_charge) as profit'))
          ->first();

            $data = [];
            foreach ($service_charge as $key => $value) {
                if($value==null){
                    $data[$key] = "0.00";
                }else{
                    $data[$key] = $value;
                }
            }

        if(isset($data['taskId'])){
            unset($data['taskId']);
        }
      // Earn Task
        $erned_task_list = [];
        if(isset($earnTaskId)){
            $erned_task_list = \DB::table('post_tasks')->where('fund_released',1)->whereIn('id',$earnTaskId)->get();
            
        }
        // Spend Task 
        $taskId =  explode(',', $service_charge->taskId);
        if($taskId){
            $spend_task_list = \DB::table('post_tasks')->whereIn('id',$taskId)->get();  
        }else{
           $spend_task_list=[];
        }  
        return response()->json(
                            [ 
                                "status"=>($service_charge)?1:0,
                                "code"=>($service_charge)?200:500,
                                "message"=>"Yellotasker income details",
                                "income_details" => $data,
                                'data'=>['spend_task_list'=>$spend_task_list,
                                        'erned_task_list'=>$erned_task_list]

                            ]
                        );     
    }

    public function widthDrawFundRequest(Request $request){

       $data = \DB::table('withdrawal')->get();
       return response()->json(
                            [ 
                                "status"=>($data)?1:0,
                                "code"=>($data)?200:500,
                                "message"=>"Widthdraw Fund Request",
                                'data'=>$data
                            ]
                        );
 
    }



    public function serviceCharge(Request $request ){

        if($request->method()=='GET'){
            $data = \DB::table('settings')->where('field_key','service_charge')->first(); 
            $message = "Service charge"; 
        }

         if($request->method()=='POST' && $request->get('service_charge')){
 
            if($request->get('service_charge')){
                 $data = \DB::table('settings')
                ->where('field_key','service_charge')
                    ->update(['field_value'=>$request->get('service_charge')]);

                $data = \DB::table('settings')->where('field_key','service_charge')->first();

                $message = "Service charge updated";
            }else{
                $data = [];
                $message = "Service charge field is required";
            }
         }

       return response()->json(
                            [ 
                                "status"=>($data)?1:0,
                                "code"=>($data)?200:500,
                                "message"=>$message,
                                'data'=>$data
                            ]
                        );
    }
}
