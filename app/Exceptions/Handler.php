<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException; 
//use Symfony\Component\HttpKernel\Exception\ErrorException;
use InvalidArgumentException; 
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Auth;
use Response;
use Session;
use Redirect;
use URL;
use ErrorException;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        NotFoundHttpException::class,
        MethodNotAllowedHttpException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {  
       $path_info_url = $request->getpathInfo();
       $api_url ='';
       $web_url ='';
        if (strpos($path_info_url, 'api/v1') !== false) {
            $api_url = $path_info_url;
        }else{
           $web_url = $path_info_url;
        } 
      // dd($e);

        if($e instanceof FatalThrowableError)
        {
          $data['url']        = URL::previous();
          $data['message']    = $e->getMessage();
          $data['error_type'] = 'FatalThrowableError';

          $this->errorLog($data,$e);

          $page_title = "404 Error";
          $page_action = "Page";
          $viewPage = "404 Error";
          $msg = "page not found";
          $error_msg = $e->getMessage(); //"Oops! Server is busy please try later."; 

          return  Redirect::to(URL::previous())->with('flash_alert_notice', $error_msg); 
        }

        if($e instanceof InvalidArgumentException)
        {
          $data['url']        = URL::previous();
          $data['message']    = $e->getMessage();
          $data['error_type'] = 'InvalidArgumentException';

          $this->errorLog($data,$e);
          

            if($api_url)
            {
                echo json_encode(
                    [ "status"=>0,
                      "code"=>500,
                      "message"=>$e->getMessage(),
                      "data" => "" 
                    ]
                );
            }else{
                echo "This Route Not define";
            } 
            exit(); 
        }    
        if ($e instanceof ModelNotFoundException) { 
          $data['url']        = URL::previous();
          $data['message']    = $e->getMessage();
          $data['error_type'] = 'ModelNotFoundException';

          $this->errorLog($data,$e);

          $page_title = "404 Error";
          $page_action = "Page";
          $viewPage = "404 Error";
          $msg = "page not found";
          $error_msg = $e->getMessage(); //"Oops! Server is busy please try later."; 

          return  Redirect::to(URL::previous())->with('flash_alert_notice', $error_msg); 

        }
        $error_from_route =0;
        if($e instanceof NotFoundHttpException)
        {   
          $data['url']        = URL::previous();
          $data['message']    = $e->getMessage();
          $data['error_type'] = 'NotFoundHttpException';

          $this->errorLog($data,$e);

            $error_from_route =1;
            if($api_url)
            {
                echo json_encode(
                    [ "status"=>0,
                      "code"=>500,
                      "message"=>"Request URL not available" ,
                      "data" => "" 
                    ]
                );
            }else{
               
              //$url =  URL::previous().'?error=InvalidURL'; 
              return Redirect::to('admin/404');
            } 
            exit();
        }
        if($e instanceof QueryException)
        {    
          $data['url']        = URL::previous();
          $data['message']    = $e->getMessage();
          $data['error_type'] = 'QueryException';

          $this->errorLog($data,$e);

            $error_from_route =1;
            if($api_url)
            {
                echo json_encode(
                    [ "status"=>0,
                      "code"=>500,
                      "message"=>"Request URL not available" ,
                      "data" => "" 
                    ]
                );
            }else{
               
              //$url =  URL::previous().'?error=InvalidURL'; 
              return Redirect::to('admin/404');
            } 
            exit();
        }

        if($e instanceof MethodNotAllowedHttpException){
          $data['url']        = URL::previous();
          $data['message']    = $e->getMessage();
          $data['error_type'] = 'MethodNotAllowedHttpException';

          $this->errorLog($data,$e);
            
            if($api_url)
            {
                echo json_encode(
                    [ "status"=>0,
                      "code"=>500,
                      "message"=>"Request method not found!" ,
                      "data" => "" 
                    ]
                );
            }else{
                echo "Method Not Allowed"; 
            } 
            exit();
           
        } 
        if($e instanceof ErrorException){ 

          $data['url']        = URL::previous();
          $data['message']    = $e->getMessage();
          $data['error_type'] = 'ErrorException';

          $this->errorLog($data,$e);

           if($api_url)
            {
                echo json_encode(
                    [ "status"=>1,
                      "code"=>500,
                      "message"=>[
                                    'error_message'=>$e->getmessage(),
                                    'file_path'=>$e->getfile(),
                                    'line_number'=>$e->getline()],    
                      "data" => "" 
                    ]
                );
            }else{
                 return  Redirect::to('admin/404')->with('flash_alert_notice', $e->getmessage()); 

            } 
            exit(); 
        } 
        return parent::render($request, $e);
    }

    public function errorLog($data,$e){

      $data['message'] = $e->getMessage();
      $data['file'] = $e->getFile();
      $data['statusCode'] = $e->getStatusCode();
     
      \DB::table('error_logs')->insert($data);

    }
}
