<?php
declare(strict_types=1);

namespace App\Repositories;

interface StockExchangeRepository
{
    public function currentPrice(string $symbol);

    public function info(string $symbol);
}