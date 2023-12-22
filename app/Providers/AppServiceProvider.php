<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// DI CODE - Start
use App\Models\Brand;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
// DI CODE - End
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		// DI CODE - Start
        Schema::defaultStringLength(191);

        $currentUri = explode('/', $this->app->request->getRequestUri());

        //Share Settings Details
       	$settingsDetails = Setting::find(1);
        //$brands = Brand::limit(6)->get();

        view()->share(
            [
                'settingsDetail' => $settingsDetails,
                //'brands' => $brands,
                'name' => 'name_' . app()->getLocale(),
                'azname' => 'name_' . app()->getLocale(),
                'aztitle' => 'title_' . app()->getLocale(),
                'description' => 'description_' . app()->getLocale(),
            ]
        );

        if ($currentUri['1'] == 'admin') {
            view()->composer('*', function ($view) {
                $current_route_name = \Request::route()->getName() ?? 'default';
                if (!empty($current_route_name)) {
                    $view->with('current_route_name', $current_route_name);
                }
            });
        }
		
		//$front_current_route_name = \Request::route()->getName() ?? 'default';
		
        /*view()->composer('*', function ($view) {
            $current_route_name = \Request::route()->getName() ?? 'default';
            if (!empty($current_route_name)) {
                $view->with('current_route_name', $current_route_name);
            }
        });*/
		// DI CODE - End
    }
}
