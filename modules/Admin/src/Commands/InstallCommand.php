<?php

namespace Modules\Admin\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'modules:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the modules migrations';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info('Checking Database Schema');

        $this->call('modules:check-schema');

        $this->info('Running migrations');

        $this->call('modules:run-migrations');

        $this->info('modules has been successfully installed');
    }
}
