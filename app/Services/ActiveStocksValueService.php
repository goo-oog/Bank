<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Account;
use App\Repositories\StockExchangeRepository;

class ActiveStocksValueService
{
    private StockExchangeRepository $stockExchange;

    public function __construct(StockExchangeRepository $stockExchange)
    {
        $this->stockExchange = $stockExchange;
    }

    public function get(Account $account)
    {
        $activeStocksValue = 0;
        foreach ($account->stocks()->where('is_active', true)->get() as $stock) {
            $activeStocksValue += ($this->stockExchange->currentPrice($stock->symbol) * $stock->amount);
        }
        return $activeStocksValue * 100;
    }
}