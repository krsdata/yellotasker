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
class MolpayPaymentController extends Controller
{
    private $molpay_vkey = 'f1d0fd1176dafad977b52a52a2ba2e24';
    private $molpay_mid = 'SB_yellotasker';
    private $payment_success_url =null;
    private $payment_failed_url =null;
    private $sandbox =true;
    private $molpay_completed_status_id =1;
    private $molpay_failed_status_id =3;
    private $molpay_pending_status_id =2;
    private $molpay_default_status_id =0;
    protected $input = array();

    public function __construct()
    {
            $input = Input::all();

            $this->input = $input;
            $this->payment_success_url = ('http://yellotasker.co/#/paymentSuccess');
            $this->payment_failed_url = ('http://yellotasker.co/#/paymentFailied');
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
            $order =  $this->createOrder($task, $user,$amount,'Task Payment : '.$task->title);

            $data['amount'] =$amount;
            $data['orderid'] =$order->transaction_id;
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
        'orderid​'=>$orderid,
        'amount'=>(float)$amount,
        'bill_name'=>$bill_name,
        'bill_email'=>$bill_email,
        'bill_mobile'=>$bill_mobile,
        'country'=>$country,
        'currency'=>$currency,
        'vcode'=>$vcode,
        'returnurl'=> urlencode($returnurl),
        'bill_desc'=>implode("\n",$prod_desc),
        );
        $query= http_build_query($fields);

        $fields['href']=$action.'?'.$query;
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

    $responseURL ='';
        if ( $skey != $key1 ) 
            $status = -1 ;

        $order_status_id = $this->molpay_default_status_id; 

        if ( $status == "00" )  {
         $order_status_id = $this->molpay_completed_status_id;
        $responseURL = $this->payment_success_url;
        } elseif( $status == "22" ) {
         $order_status_id = $this->molpay_pending_status_id;
        $responseURL = $this->payment_success_url;
        } else {
         $order_status_id = $this->molpay_failed_status_id;
        $responseURL = $this->payment_failed_url;
        }
       
        $this->save();
        $this->updateOrderStatus($orderid, $order_status_id);
            echo '<html>' . "\n";
            echo '<head>'  . "\n";
            echo '  <meta http-equiv="Refresh" content="0; url=' . $responseURL . '?txnID='.$tranID.'">' . "\n";
            echo '</head>' . "\n";
            echo '<body>' . "\n";
            echo '  <p>Please Don\'t refresh browser '. "\n";
            echo '  <p>Please follow <a href="' . $responseURL . '?txnID='.$tranID.'">link</a>!</p>' . "\n";
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
       $order->transaction_id= time();
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
   
    protected function updateOrderStatus($molpay_order_id,$order_status){
    
    $order= Order::where('transaction_id', '=', $molpay_order_id)->first();
    if (is_null($order)){
     return false;
     }
      $order->status = $order_status;
      $order->save();
      return $order;
    }
    
    public function success(){
     return "success";   
    }
    public function failed(){
     return "failed";   
    }
}
