<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers\Frontend';
    protected $admin_namespace = 'App\Http\Controllers\Backend';
    protected $api_namespace = 'App\Http\Controllers\Api';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        if(isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])){
            $sld_prefix = explode('.',$_SERVER['HTTP_HOST'])[0];
        }else{
            $sld_prefix = '';
        }

        if (config('route.api_domain') == $sld_prefix){
            $this->mapApiRoutes();
        }elseif (config('route.admin_domain') == $sld_prefix){
            $this->mapAdminRoutes();
        }else{
            $this->mapWebRoutes();
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware(['api','force-json'])
            ->namespace($this->api_namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware(['admin'])
            ->namespace($this->admin_namespace)
            ->group(base_path('routes/admin.php'));
    }
}
