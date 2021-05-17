<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\StockExchangeRepository;
use App\Repositories\FinnhubRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StockExchangeRepository::class, FinnhubRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
