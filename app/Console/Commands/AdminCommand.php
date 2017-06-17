<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Hash;
use DB;
use Input;
use Request;
use app\admin;
class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command use to create user to access admin panel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    { 
        $input['name'] = $this->ask('What is your name?');
        $input['email'] = $this->ask('What is your email?');
        $input['password'] = $this->secret('What is the password?');
        $input['password'] = Hash::make($input['password']); 
        DB::table('admin')->insert($input);
        $this->info('New Admin Created Successfully.'); 
    }
}
