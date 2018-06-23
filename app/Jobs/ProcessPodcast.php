<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;

class ProcessPodcast extends Job implements ShouldQueue
{
   // use \Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    public $timeout = 120;
    /**
     * Create a new job instance.
     *
     * @param  Podcast  $podcast
     * @return void
     */
    public function __construct()
    {
       // $this->podcast = $podcast;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        
        $mailer->send('emails.welcome', ['data'=>'data'], function ($message) {

          //  $message->from('kroy.iips@gmail.com', 'Christian Nwmaba');

            $message->to('kroy@mailinator.com');

        });
    }
}
