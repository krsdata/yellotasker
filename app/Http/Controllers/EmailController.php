<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPodcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Traits\SearchResponder;

class EmailController extends Controller
{
  //  use DispatchesJobs, SearchResponder;
    
    	 
    public function sendMail()
    {
        
        $user = [];
        Log::info("Request Cycle with Queues Begins");
        $this->dispatch(new ProcessPodcast($user));
        Log::info("Request Cycle with Queues Ends");

        //$this->dispatch((new SendWelcomeEmail())->delay(60 * 5));
    }
}
