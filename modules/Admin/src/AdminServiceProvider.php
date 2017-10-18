<?php 
namespace Modules\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class AdminServiceProvider extends ServiceProvider {

      /**
     * Inventory version.
     *
     * @var string
     */
    const VERSION = '1.7.5';

    /**
     * Stores the package configuration separator
     * for Laravel 5 compatibility.
     *
     * @var string
     */
    public static $packageConfigSeparator = '::';

    /**
     * The laravel version number. This is
     * used for the install commands.
     *
     * @var int
     */
    public static $laravelVersion = 5.2;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the service provider.
     */
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {   
       
        /*
         * If the package method exists, we're using Laravel 4, if not, we're on 5
         */
        $this->loadViewsFrom(realpath(__DIR__.'/../views'), 'packages');

       // $modules = config("module.modules");
        if (method_exists($this, 'package')) {
          
            $this->package('modules/admin', 'modules/admin', __DIR__.'/..');
        } else {
            /*
             * Set the proper configuration separator since
             * retrieving configuration values in packages
             * changed from '::' to '.'
             */
            $this::$packageConfigSeparator = '.';

            /*
             * Set the local inventory laravel version for easy checking
             */
            $this::$laravelVersion = 5.2;

            /*
             * Load the inventory translations from the inventory lang folder
             */
            $this->loadTranslationsFrom(__DIR__.'/lang', 'modules');

            /*
             * Assign the configuration as publishable, and tag it as 'config'
             */
            $this->publishes([
                __DIR__.'/config/config.php' => config_path('modules.php'),
            ], 'config');

            /*
             * Assign the migrations as publishable, and tag it as 'migrations'
             */
            $this->publishes([
                __DIR__.'/migrations/' => base_path(__DIR__.'/database/migrations'),
            ], 'migrations');
        } 
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        
        $router->group(['namespace' => 'Modules\Admin\Http\Controllers'], function($router)
        {   
            require __DIR__.'/Http/routes.php';
        });
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    /*public function register()
    {
        include __DIR__.'/Http/routes.php';
    }*/
    private function registerModules()
    {
        $this->app->bind('modules',function($app){
            return new Modules($app);
        });
         
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
      
        include __DIR__.'/Http/routes.php'; 
        /*
         * Bind the install command
         */
        $this->app->bind('modules:install', function () {
            return new Commands\InstallCommand();
        });

        
        /*
         * Bind the check-schema command
         */
        $this->app->bind('modules:check-schema', function () {
            return new Commands\SchemaCheckCommand();
        });

        /*
         * Bind the run migrations command
         */
        $this->app->bind('modules:run-migrations', function () {
            return new Commands\RunMigrationsCommand();
        });

        /*
         * Register the commands
         */
        $this->commands([
            'modules:install',
            'modules:check-schema',
            'modules:run-migrations',
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['modules'];
    }

}
