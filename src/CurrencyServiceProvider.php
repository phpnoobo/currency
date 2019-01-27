<?php

namespace Phpnoob\Currency;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Phpnoob\Currency\Console\Commands\CurrencyCommand;

/**
 * Class CurrencyServiceProvider
 * @package Phpnoob\Currency
 */
class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__ . '/Support/helper.php';

        if ($this->app->runningInConsole()) {
            $this->registrConsole();
            $this->registerPublishing();
            $this->loadMigrationsFrom(
                __DIR__.'/../database/migrations'
            );
        }

        $this->registerRoutes();
        $this->mergeConfigFrom(
            __DIR__ . '/../config/currency.php', 'currency'
        );
    }

    /**
     * @return void
     */
    private function registrConsole()
    {
        $this->commands([
            CurrencyCommand::class,
        ]);
    }

    /**
     * @return void
     */
    private function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/currency.php' => config_path('currency.php')
        ], 'currency-config');
    }

    /**
     * Register the package routes
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function (){
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
    }

    /**
     *  Get the KeyHunter route group configuration array.
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'namespace' => 'Phpnoob\Currency\Http\Controllers',
            'as' => 'currency.api',
            'prefix' => 'currency-api',
            //'middleware' => 'auth:api'
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->alias(Currency::class, 'currency');
    }
}
