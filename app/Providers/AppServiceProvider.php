<?php
declare(strict_types=1);

namespace App\Providers;

use App\Repositories\BankLVCurrencyRatesRepository;
use App\Repositories\CurrencyRatesRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\StockExchangeRepository;
use App\Repositories\FinnhubStockExchangeRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StockExchangeRepository::class, FinnhubStockExchangeRepository::class);
        $this->app->bind(CurrencyRatesRepository::class, BankLVCurrencyRatesRepository::class);
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
